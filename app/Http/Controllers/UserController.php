<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Facility;
use App\Models\PetOwner;
use App\Models\SystemLog;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Apply middleware for all methods except index/show
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     * Permission: Any authenticated user (except citizens) can view users list
     */
    public function index(Request $request)
    {
        // Check if user can access admin panel
        if (! auth()->user()->canAccessAdminPanel()) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this area.');
        }

        $search = $request->get('search', '');
        $role = $request->get('role', '');

        $users = User::with(['adminProfile', 'petOwnerProfile', 'organizationProfile', 'barangay'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    // Search in users table
                    $q->where('email', 'like', "%{$search}%")
                      // Search in admin profiles
                        ->orWhereHas('adminProfile', function ($sq) use ($search) {
                            $sq->where('first_name', 'like', "%{$search}%")
                                ->orWhere('middle_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        })
                      // Search in pet owner profiles
                        ->orWhereHas('petOwnerProfile', function ($sq) use ($search) {
                            $sq->where('first_name', 'like', "%{$search}%")
                                ->orWhere('middle_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        })
                      // Search in organization profiles
                        ->orWhereHas('organizationProfile', function ($sq) use ($search) {
                            $sq->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($role, function ($query) use ($role) {
                $query->whereHas('roles', function ($q) use ($role) {
                    $q->where('name', $role);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $roles = Role::where('guard_name', 'web')->orderBy('name')->pluck('name')->toArray();

        return view('admin.users.index', compact('users', 'search', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     * Permission: Must have level >= 3 to create users
     */
    public function create()
    {
        // Gate check using policy
        if (Gate::denies('create', User::class)) {
            return back()->with('error', 'You do not have permission to create users.');
        }

        // Get assignable roles based on current user's hierarchy
        $assignableRoles = auth()->user()->getAssignableRoles();

        // Get facilities for dropdown (only Super Admin sees this)
        $facilities = auth()->user()->hasRole('super_admin')
            ? Facility::orderBy('name')->get()
            : collect();

        return view('admin.users.create', compact('assignableRoles', 'facilities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Gate check using policy
        if (Gate::denies('create', User::class)) {
            return back()->with('error', 'You do not have permission to create users.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'suffix' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'contact_number' => 'nullable|string|max:20',
        ]);

        // Check if user can assign the requested role
        if (! auth()->user()->canAssignRole($validated['role'])) {
            return back()->with('error', 'You cannot assign the role "'.$validated['role'].'".');
        }

        // Prevent creating super_admin by non-super_admin
        if ($validated['role'] === User::ROLE_SUPER_ADMIN && ! auth()->user()->hasRole(User::ROLE_SUPER_ADMIN)) {
            return back()->with('error', 'You cannot create Super Administrator accounts.');
        }

        // Create user with only auth fields
        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status' => 'active',
        ]);

        // Assign Spatie role
        $user->assignRole($validated['role']);
        // Sync role column for backward compatibility
        $user->update(['role' => $validated['role']]);

        // Create profile based on role type
        $adminRoles = ['super_admin', 'city_vet', 'admin_staff', 'admin_asst', 'assistant_vet', 'livestock_inspector', 'meat_inspector'];

        if (in_array($validated['role'], $adminRoles)) {
            // Create admin profile
            Admin::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'suffix' => $validated['suffix'] ?? null,
                'role_type' => $validated['role'],
                'barangay_id' => $validated['barangay_id'] ?? null,
                'contact_number' => $validated['contact_number'] ?? null,
                'date_of_birth' => null,
            ]);
        } elseif ($validated['role'] === 'pet_owner') {
            // Create pet owner profile
            PetOwner::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'suffix' => $validated['suffix'] ?? null,
                'phone_number' => $validated['contact_number'] ?? null,
                'date_of_birth' => null,
            ]);
        }

        SystemLog::create([
            'user_id' => auth()->id(),
            'action' => 'create_user',
            'event' => 'create',
            'module' => 'User Management',
            'description' => "Created new user: {$validated['name']} with role: {$validated['role']}",
            'ip_address' => request()->ip(),
            'status' => 'success',
        ]);

        NotificationService::userCreated($user);

        $redirectRoute = request()->routeIs('super-admin.*') ? 'super-admin.users.index' : 'admin.users.index';

        return redirect()->route($redirectRoute)->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Gate check using policy
        if (Gate::denies('view', $user)) {
            return back()->with('error', 'You do not have permission to view this user.');
        }

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Gate check using policy
        if (Gate::denies('update', $user)) {
            return back()->with('error', 'You do not have permission to edit this user.');
        }

        // Get assignable roles
        $assignableRoles = auth()->user()->getAssignableRoles();

        // Get facilities for dropdown (only Super Admin can modify)
        $facilities = auth()->user()->hasRole('super_admin')
            ? Facility::orderBy('name')->get()
            : collect();

        return view('admin.users.edit', compact('user', 'assignableRoles', 'facilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Gate check using policy
        if (Gate::denies('update', $user)) {
            return back()->with('error', 'You do not have permission to update this user.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'suffix' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'contact_number' => 'nullable|string|max:20',
        ]);

        // ============================================
        // SUPER ADMIN SELF-PROTECTION VALIDATION RULES
        // ============================================

        $currentRole = $user->getRoleAttribute();

        // 1. If user is super_admin trying to change their own role -> BLOCK
        if (auth()->user()->hasRole(User::ROLE_SUPER_ADMIN) && $user->isSelf() && $validated['role'] !== $currentRole) {
            return back()->with('error', 'You cannot change your own role as Super Administrator.');
        }

        // 2. Check role change permissions
        if ($validated['role'] !== $currentRole) {
            // Check if user can assign the new role
            if (! auth()->user()->canAssignRole($validated['role'])) {
                return back()->with('error', 'You cannot assign the role "'.$validated['role'].'".');
            }

            // Prevent changing to super_admin by non-super_admin
            if ($validated['role'] === User::ROLE_SUPER_ADMIN && ! auth()->user()->hasRole(User::ROLE_SUPER_ADMIN)) {
                return back()->with('error', 'You cannot change a user to Super Administrator.');
            }

            // Prevent non-super_admin from modifying super_admin
            if ($user->hasRole(User::ROLE_SUPER_ADMIN) && ! auth()->user()->hasRole(User::ROLE_SUPER_ADMIN)) {
                return back()->with('error', 'You cannot modify Super Administrator accounts.');
            }
        }

        // Update user auth fields only
        $updateData = [
            'email' => $validated['email'],
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        // Update Spatie role if changed
        if ($validated['role'] !== $currentRole) {
            $user->syncRoles($validated['role']);
            $user->update(['role' => $validated['role']]); // Sync column

            // Handle role change: delete old profile, create new one
            $adminRoles = ['super_admin', 'city_vet', 'admin_staff', 'admin_asst', 'assistant_vet', 'livestock_inspector', 'meat_inspector'];

            // Remove old profile
            if ($user->adminProfile) {
                $user->adminProfile->delete();
            }
            if ($user->petOwnerProfile) {
                $user->petOwnerProfile->delete();
            }
            if ($user->organizationProfile) {
                $user->organizationProfile->delete();
            }

            // Create new profile based on new role
            if (in_array($validated['role'], $adminRoles)) {
                Admin::create([
                    'user_id' => $user->id,
                    'first_name' => $validated['first_name'],
                    'middle_name' => $validated['middle_name'] ?? null,
                    'last_name' => $validated['last_name'],
                    'suffix' => $validated['suffix'] ?? null,
                    'role_type' => $validated['role'],
                    'barangay_id' => $validated['barangay_id'] ?? null,
                    'contact_number' => $validated['contact_number'] ?? null,
                    'date_of_birth' => null,
                ]);
            } elseif ($validated['role'] === 'pet_owner') {
                PetOwner::create([
                    'user_id' => $user->id,
                    'first_name' => $validated['first_name'],
                    'middle_name' => $validated['middle_name'] ?? null,
                    'last_name' => $validated['last_name'],
                    'suffix' => $validated['suffix'] ?? null,
                    'phone_number' => $validated['contact_number'] ?? null,
                    'date_of_birth' => null,
                ]);
            }
        } else {
            // Role unchanged, just update existing profile
            $adminRoles = ['super_admin', 'city_vet', 'admin_staff', 'admin_asst', 'assistant_vet', 'livestock_inspector', 'meat_inspector'];

            if (in_array($validated['role'], $adminRoles) && $user->adminProfile) {
                $user->adminProfile->update([
                    'first_name' => $validated['first_name'],
                    'middle_name' => $validated['middle_name'] ?? null,
                    'last_name' => $validated['last_name'],
                    'suffix' => $validated['suffix'] ?? null,
                    'barangay_id' => $validated['barangay_id'] ?? null,
                    'contact_number' => $validated['contact_number'] ?? null,
                ]);
            } elseif ($validated['role'] === 'pet_owner' && $user->petOwnerProfile) {
                $user->petOwnerProfile->update([
                    'first_name' => $validated['first_name'],
                    'middle_name' => $validated['middle_name'] ?? null,
                    'last_name' => $validated['last_name'],
                    'suffix' => $validated['suffix'] ?? null,
                    'phone_number' => $validated['contact_number'] ?? null,
                ]);
            }
        }

        SystemLog::create([
            'user_id' => auth()->id(),
            'action' => 'update_user',
            'event' => 'update',
            'module' => 'User Management',
            'description' => "Updated user: {$user->name} (ID: {$user->id})",
            'ip_address' => request()->ip(),
            'status' => 'success',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * VALIDATION RULES:
     * - Cannot delete your own account
     * - Super admin cannot delete their own account
     * - Cannot delete super_admin unless you are also super_admin
     */
    public function destroy(User $user)
    {
        // Gate check using policy
        if (Gate::denies('delete', $user)) {
            return back()->with('error', 'You do not have permission to delete this user.');
        }

        // Additional validation: Cannot delete self
        if ($user->isSelf()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Super admin self-protection: Cannot delete self
        if ($user->isSuperAdmin() && $user->isSelf()) {
            return back()->with('error', 'You cannot delete your own Super Administrator account.');
        }

        // Cannot delete super_admin unless you are super_admin
        if ($user->isSuperAdmin() && ! auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'You cannot delete Super Administrator accounts.');
        }

        $user->delete();

        SystemLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete_user',
            'event' => 'delete',
            'module' => 'User Management',
            'description' => "Deleted user: {$user->name} (ID: {$user->id})",
            'ip_address' => request()->ip(),
            'status' => 'success',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user status (activate/deactivate).
     */
    public function toggleStatus(Request $request, User $user)
    {
        // Gate check using policy
        if (Gate::denies('toggleStatus', $user)) {
            return back()->with('error', 'You do not have permission to change this user\'s status.');
        }

        // Cannot toggle own status
        if ($user->isSelf()) {
            return back()->with('error', 'You cannot change your own status.');
        }

        // Super admin self-protection: Cannot deactivate self
        if ($user->isSuperAdmin() && $user->isSelf()) {
            return back()->with('error', 'You cannot deactivate your own Super Administrator account.');
        }

        // Toggle status
        $newStatus = $user->status === 'active' ? 'deactivated' : 'active';
        $user->update(['status' => $newStatus]);

        SystemLog::create([
            'user_id' => auth()->id(),
            'action' => 'toggle_user_status',
            'event' => 'update',
            'module' => 'User Management',
            'description' => "Changed status of user {$user->name} to {$newStatus}",
            'ip_address' => request()->ip(),
            'status' => 'success',
        ]);

        $statusText = $newStatus === 'active' ? 'activated' : 'deactivated';

        return back()->with('success', "User {$statusText} successfully.");
    }
}
