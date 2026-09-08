<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Barangay;
use App\Models\BiteRabiesReport;
use App\Models\Facility;
use App\Models\Pet;
use App\Models\RabiesVaccinationReport;
use App\Models\Role;
use App\Models\SystemLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SuperAdminController extends Controller
{
    /**
     * Show super admin dashboard.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $year = $request->year ?? date('Y');

        // Get comprehensive statistics
        $stats = [
            // User statistics
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'deactivated_users' => User::where('status', 'deactivated')->count(),

            // Role breakdown - Clean structure (6 active roles)
            'super_admins' => User::where('role', 'super_admin')->count(),
            'city_vets' => User::where('role', 'city_vet')->count(),
            'admin_assistants' => User::where('role', 'admin_asst')->count(),
            'assistant_vets' => User::where('role', 'assistant_vet')->count(),
            'meat_inspectors' => User::where('role', 'meat_inspector')->count(),

            'admin_staff_total' => User::whereIn('role', ['super_admin', 'city_vet', 'admin_asst', 'assistant_vet', 'meat_inspector'])->count(),

            // Client & Animal statistics
            'total_clients' => User::where('role', 'pet_owner')->count(),
            'total_animals' => Pet::count(),

            // Case statistics
            'total_rabies_cases' => BiteRabiesReport::whereYear('incident_date', $year)->count(),
            'total_vaccinations' => RabiesVaccinationReport::whereYear('vaccination_date', $year)->count(),
            'total_bite_reports' => BiteRabiesReport::whereYear('incident_date', $year)->count(),

            // System statistics
            'total_barangays' => Barangay::count(),
            'total_announcements' => Announcement::count(),
            'active_announcements' => Announcement::where('is_active', true)->count(),
        ];

        // Get recent users
        $recentUsers = User::latest()->take(10)->get();

        // Get recent system logs
        $recentLogs = SystemLog::with('user')->latest()->take(10)->get();

        // Get recent announcements
        $recentAnnouncements = Announcement::latest()->take(5)->get();

        // Get monthly user registration trend
        $monthlyUserRegistrations = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Get monthly rabies cases trend
        $monthlyRabiesCases = BiteRabiesReport::selectRaw('MONTH(incident_date) as month, COUNT(*) as count')
            ->whereYear('incident_date', $year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Get system activity trend for last 7 days
        $systemActivityLabels = [];
        $systemActivitySuccess = [];
        $systemActivityFailed = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $systemActivityLabels[] = $date->format('M d');
            $systemActivitySuccess[] = SystemLog::whereDate('created_at', $date)->where('status', 'success')->count();
            $systemActivityFailed[] = SystemLog::whereDate('created_at', $date)->where('status', 'failed')->count();
        }

        // Get user accounts by role (6 display roles)
        $userRoleCounts = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        $displayRoles = [
            'super_admin'    => 'Super Administrator',
            'city_vet'       => 'City Veterinarian',
            'assistant_vet'  => 'Assistant Veterinarian',
            'admin_asst'     => 'Administrative Assistant',
            'meat_inspector' => 'Meat Inspector',
            'pet_owner'      => 'Pet Owner',
        ];

        $userRoleLabels = [];
        $userRoleData = [];
        $userRoleColors = [];

        $roleColorMap = [
            'super_admin'    => '#7c3aed',
            'city_vet'       => '#2563eb',
            'assistant_vet'  => '#16a34a',
            'admin_asst'     => '#0891b2',
            'meat_inspector' => '#dc2626',
            'pet_owner'      => '#6366f1',
        ];

        arsort($userRoleCounts);
        foreach ($userRoleCounts as $roleKey => $count) {
            if (array_key_exists($roleKey, $displayRoles)) {
                $userRoleLabels[] = $displayRoles[$roleKey];
                $userRoleData[] = $count;
                $userRoleColors[] = $roleColorMap[$roleKey] ?? '#94a3b8';
            }
        }

        return view('dashboard.super-admin', compact(
            'user',
            'stats',
            'recentUsers',
            'recentLogs',
            'recentAnnouncements',
            'monthlyUserRegistrations',
            'monthlyRabiesCases',
            'year',
            'systemActivityLabels',
            'systemActivitySuccess',
            'systemActivityFailed',
            'userRoleLabels',
            'userRoleData',
            'userRoleColors'
        ));
    }

    /**
     * Show roles management page.
     */
    public function roles()
    {
        $roles = Role::orderBy('hierarchy_level', 'desc')->get();
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $totalPermissions = \Spatie\Permission\Models\Permission::count();

        $roleUserCounts = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        return view('super-admin.roles', compact('roles', 'totalUsers', 'activeUsers', 'inactiveUsers', 'roleUserCounts', 'totalPermissions'));
    }

    /**
     * Show edit form for a role via AJAX.
     */
    public function editRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $viewMode = $request->boolean('view');

        if ($request->ajax() || $request->wantsJson()) {
            if ($viewMode) {
                return view('super-admin.roles._view', compact('role', 'viewMode'));
            }

            return view('super-admin.roles._form', compact('role'));
        }

        return view('super-admin.roles.edit', compact('role'));
    }

    /**
     * Update a role.
     */
    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'display_name' => 'nullable|string|max:255',
            'hierarchy_level' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        $role->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully',
                'role' => $role,
            ]);
        }

        return back()->with('success', 'Role updated successfully');
    }

    /**
     * Show create role form via AJAX.
     */
    public function createRole(Request $request)
    {
        $role = new Role();
        $viewMode = false;
        $allRoles = Role::where('id', '!=', $role->id)->orderBy('hierarchy_level', 'desc')->get();

        if ($request->ajax() || $request->wantsJson()) {
            return view('super-admin.roles._form', compact('role', 'viewMode', 'allRoles'));
        }

        return view('super-admin.roles.create', compact('role', 'allRoles'));
    }

    /**
     * Store a new role.
     */
    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'nullable|string|max:255',
            'hierarchy_level' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['guard_name'] = 'web';

        $role = Role::create($validated);

        if ($request->has('permissions') && is_array($request->input('permissions'))) {
            $permissions = $request->input('permissions');
            $validPermissions = app()->make(\Spatie\Permission\Models\Permission::class)
                ->whereIn('name', $permissions)
                ->pluck('name')
                ->toArray();
            $role->syncPermissions($validPermissions);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role created successfully',
                'role' => $role,
            ]);
        }

        return redirect()->route('super-admin.roles.index')->with('success', 'Role created successfully');
    }

    /**
     * Get system statistics API endpoint.
     */
    public function systemStats(Request $request)
    {
        $year = $request->year ?? date('Y');

        $stats = [
            'total_users' => User::count(),
            'total_clients' => User::where('role', 'pet_owner')->count(),
            'total_animals' => Pet::count(),
            'total_rabies_cases' => BiteRabiesReport::whereYear('incident_date', $year)->count(),
            'total_vaccinations' => RabiesVaccinationReport::whereYear('vaccination_date', $year)->count(),
            'total_bite_reports' => BiteRabiesReport::whereYear('incident_date', $year)->count(),
            'total_barangays' => Barangay::count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
            'year' => $year,
        ]);
    }

    /**
     * Get user statistics by role.
     */
    public function userStats()
    {
        $roles = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        $roleNames = [
            'super_admin' => 'Super Admin',
            'city_vet' => 'City Veterinarian',
            'admin_asst' => 'Administrative Assistant',
            'assistant_vet' => 'Assistant Veterinarian',
            'meat_inspector' => 'Meat Inspector',
            'pet_owner' => 'Pet Owner',
        ];

        $formattedRoles = [];
        foreach ($roles as $role => $count) {
            $formattedRoles[] = [
                'role' => $role,
                'label' => $roleNames[$role] ?? $role,
                'count' => $count,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $formattedRoles,
            'total' => array_sum($roles),
        ]);
    }

    /**
     * Get filtered system activity chart data.
     */
    public function systemActivity(Request $request)
    {
        $period = $request->period ?? 'last_7_days';
        $startDate = $request->start_date ? \Carbon\Carbon::parse($request->start_date)->startOfDay() : null;
        $endDate = $request->end_date ? \Carbon\Carbon::parse($request->end_date)->endOfDay() : null;

        switch ($period) {
            case 'today':
                $dates = [now()->startOfDay()];
                break;
            case 'last_7_days':
                $dates = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->startOfDay())->toArray();
                break;
            case 'last_30_days':
                $dates = collect(range(29, 0))->map(fn($i) => now()->subDays($i)->startOfDay())->toArray();
                break;
            case 'this_month':
                $dates = collect(range(now()->day - 1, 0))->map(fn($i) => now()->subDays($i)->startOfDay())->toArray();
                break;
            case 'custom':
                if (!$startDate || !$endDate) {
                    return response()->json(['success' => false, 'message' => 'Invalid date range'], 422);
                }
                $dates = collect(range(0, $startDate->diffInDays($endDate)))->map(fn($i) => (clone $startDate)->addDays($i))->toArray();
                break;
            default:
                $dates = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->startOfDay())->toArray();
        }

        $labels = [];
        $success = [];
        $failed = [];

        foreach ($dates as $date) {
            $labels[] = $date->format('M d');
            $query = SystemLog::whereDate('created_at', $date);
            $success[] = (clone $query)->where('status', 'success')->count();
            $failed[] = (clone $query)->where('status', 'failed')->count();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $labels,
                'success' => $success,
                'failed' => $failed,
                'period' => $period,
            ],
        ]);
    }

    /**
     * Get activity logs.
     */
    public function activityLogs(Request $request)
    {
        $perPage = $request->per_page ?? 20;
        $search = $request->search;
        $action = $request->action;

        $query = SystemLog::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($action) {
            $query->where('action', $action);
        }

        $logs = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $logs,
        ]);
    }

    /**
     * Export system report.
     */
    public function exportReport(Request $request)
    {
        $type = $request->type ?? 'summary';
        $year = $request->year ?? date('Y');
        $format = $request->format ?? 'csv';

        $data = [];
        $filename = 'system_report_'.$year.'_'.now()->format('YmdHis');

        switch ($type) {
            case 'users':
                $data = User::select(['id', 'name', 'email', 'role', 'status', 'created_at'])
                    ->get()
                    ->toArray();
                $filename = 'users_report_'.$year;
                break;

            case 'rabies':
                $data = BiteRabiesReport::with('barangay')
                    ->whereYear('incident_date', $year)
                    ->get()
                    ->toArray();
                $filename = 'rabies_cases_report_'.$year;
                break;

            case 'vaccinations':
                $data = RabiesVaccinationReport::whereYear('vaccination_date', $year)
                    ->get()
                    ->toArray();
                $filename = 'vaccinations_report_'.$year;
                break;

            case 'bite_reports':
                $data = BiteRabiesReport::whereYear('incident_date', $year)
                    ->get()
                    ->toArray();
                $filename = 'bite_reports_report_'.$year;
                break;

            case 'summary':
            default:
                $data = [
                    'generated_at' => now()->toIso8601String(),
                    'period' => $year,
                    'total_users' => User::count(),
                    'total_clients' => User::where('role', 'pet_owner')->count(),
                    'total_animals' => Pet::count(),
                    'total_rabies_cases' => BiteRabiesReport::whereYear('incident_date', $year)->count(),
                    'total_vaccinations' => RabiesVaccinationReport::whereYear('vaccination_date', $year)->count(),
                    'total_bite_reports' => BiteRabiesReport::whereYear('incident_date', $year)->count(),
                    'total_barangays' => Barangay::count(),
                    'total_announcements' => Announcement::count(),
                ];
                $filename = 'system_summary_'.$year;
                break;
        }

        // Log the export action
        SystemLog::create([
            'user_id' => auth()->id(),
            'action' => 'export_report',
            'event' => 'export',
            'description' => "Exported {$type} report for year {$year}",
            'ip_address' => request()->ip(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $data,
            'filename' => $filename,
            'format' => $format,
        ]);
    }

    /**
     * System configuration settings.
     */
    public function settings(Request $request)
    {
        $user = Auth::user();

        // Get system settings (in production, these would come from a settings table)
        $settings = [
            'system_name' => config('app.name', 'Vet MIS'),
            'system_version' => '1.0.0',
            'timezone' => config('app.timezone', 'Asia/Manila'),
            'date_format' => 'Y-m-d',
            'time_format' => 'H:i:s',
            'maintenance_mode' => false,
            'registration_enabled' => true,
            'email_verification_required' => true,
        ];

        return view('super-admin.settings', compact('user', 'settings'));
    }

    /**
     * Update system settings.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'system_name' => 'nullable|string|max:255',
            'maintenance_mode' => 'nullable|boolean',
            'registration_enabled' => 'nullable|boolean',
        ]);

        // In production, save to settings table
        // For now, log the changes
        SystemLog::create([
            'user_id' => auth()->id(),
            'action' => 'update_settings',
            'event' => 'update',
            'description' => 'Updated system settings: '.json_encode($validated),
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('super-admin.settings')
            ->with('success', 'System settings updated successfully.');
    }

    /**
     * View all users with filtering.
     */
    public function users(Request $request)
    {
        $search = $request->get('search', '');
        $role = $request->get('role', '');
        $status = $request->get('status', '');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $users = $query->latest()->paginate(20);
        $allowedRoles = ['super_admin', 'city_vet', 'assistant_vet', 'admin_asst', 'meat_inspector', 'pet_owner'];
        $roles = Role::where('guard_name', 'web')->whereIn('name', $allowedRoles)->orderBy('name')->pluck('name')->toArray();

        $totalUsers = User::count();
        $activeAccounts = User::where('status', 'active')->count();
        $cityVetStaff = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['super_admin', 'city_vet', 'assistant_vet', 'admin_asst', 'meat_inspector']);
        })->count();
        $petOwners = User::whereHas('roles', function ($q) { $q->where('name', 'pet_owner'); })->count();

        $assignableRoles = auth()->user()->getAssignableRoles();
        $facilities = auth()->user()->hasRole('super_admin')
            ? Facility::orderBy('name')->get()
            : collect();

        return view('super-admin.users', compact('users', 'roles', 'search', 'role', 'status', 'totalUsers', 'activeAccounts', 'cityVetStaff', 'petOwners', 'assignableRoles', 'facilities'));
    }

    /**
     * Toggle user status.
     */
    public function toggleUserStatus(User $user)
    {
        // Policy check using Gate
        if (Gate::denies('toggleStatus', $user)) {
            return back()->with('error', 'You do not have permission to change this user\'s status.');
        }

        // Cannot toggle own status
        if ($user->isSelf()) {
            return back()->with('error', 'You cannot change your own status.');
        }

        // Super admin self-protection
        if ($user->isSuperAdmin() && $user->isSelf()) {
            return back()->with('error', 'You cannot deactivate your own Super Administrator account.');
        }

        $newStatus = $user->status === 'active' ? 'deactivated' : 'active';

        $user->update(['status' => $newStatus]);

        SystemLog::create([
            'user_id' => auth()->id(),
            'action' => 'toggle_user_status',
            'event' => 'update',
            'description' => "Changed user {$user->name} status to {$newStatus}",
            'ip_address' => request()->ip(),
        ]);

        $statusText = $newStatus === 'active' ? 'activated' : 'deactivated';

        return back()->with('success', "User {$user->name} {$statusText} successfully.");
    }

    /**
     * Sync permissions for a role.
     */
    public function syncPermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'string',
        ]);

        $permissions = $validated['permissions'] ?? [];

        $validPermissions = app()->make(\Spatie\Permission\Models\Permission::class)
            ->whereIn('name', $permissions)
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($validPermissions);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Permissions updated successfully',
                'permission_count' => $role->permissions()->count(),
            ]);
        }

        return back()->with('success', 'Permissions updated successfully');
    }
}
