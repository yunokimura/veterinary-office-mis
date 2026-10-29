<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\MissingPetsReport;
use App\Models\Pet;
use App\Models\PetOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MissingPetController extends Controller
{
    public function index(Request $request)
    {
        $query = MissingPetsReport::with('pet');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $missingPets = $query->orderBy('created_at', 'desc')->paginate(12);

        $pendingReviewCount = MissingPetsReport::where('status', 'pending review')->count();
        $approvedCount = MissingPetsReport::where('status', 'approved')->count();
        $reunitedCount = MissingPetsReport::where('status', 'resolved - reunited')->count();
        $shelterIntakeCount = MissingPetsReport::where('status', 'resolved - shelter intake')->count();
        $totalCount = MissingPetsReport::count();

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('admin-asst.missing-pets._table', compact('missingPets'))->render();
            $links = $missingPets->withQueryString()->links();
            $pagination = $links instanceof \Illuminate\Contracts\Support\Htmlable
                ? $links->toHtml()
                : (string) $links;

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination,
                'has_results' => $missingPets->count() > 0,
            ]);
        }

        return view('admin-asst.missing-pets.index', compact(
            'missingPets',
            'pendingReviewCount',
            'approvedCount',
            'reunitedCount',
            'shelterIntakeCount',
            'totalCount'
        ));
    }

    public function create()
    {
        $clients = PetOwner::active()->orderBy('last_name')->get();
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-asst.missing-pets.create', compact('clients', 'barangays'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|string|in:dog,cat,other',
            'breed' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female,unknown',
            'image' => 'nullable|image|max:2048',
            'last_seen_at' => 'required|date',
            'barangay_id' => 'required|integer|exists:barangays,barangay_id',
            'location_description' => 'nullable|string|max:2000',
            'emergency_contact' => 'nullable|string|max:255',
            'body_marks' => 'nullable|string|max:2000',
            'eye_color' => 'required|string|max:255',
            'collar_harness' => 'nullable|string|max:255',
            'owner_id' => 'nullable|exists:pet_owners,owner_id',
            'reported_by_name' => 'nullable|string|max:255',
            'reporter_contact' => 'required|string|max:255',
            'reporter_email' => 'nullable|email|max:255',
        ]);

        $pet = Pet::create([
            'owner_id' => $validated['owner_id'],
            'pet_name' => $validated['pet_name'],
            'species' => $validated['species'],
            'breed' => $validated['breed'],
            'gender' => $validated['gender'],
            'color' => $validated['color'],
            'pet_status' => 'missing',
        ]);

        if ($request->filled('eye_color')) {
            $pet->petInfo()->create(['eye_color' => $request->input('eye_color')]);
        }

        $photoPath = null;
        if ($request->hasFile('image')) {
            $photoPath = $request->file('image')->store('missing-pets', 'public');
        }

        MissingPetsReport::create([
            'user_id' => Auth::id(),
            'pet_id' => $pet->pet_id,
            'report_type' => 'missing',
            'reported_by_name' => $validated['reported_by_name'] ?? null,
            'reporter_contact' => $validated['reporter_contact'],
            'reporter_email' => $validated['reporter_email'] ?? null,
            'body_marks' => $validated['body_marks'] ?? null,
            'collar_harness' => $validated['collar_harness'] ?? null,
            'last_seen_at' => $validated['last_seen_at'],
            'barangay_id' => $validated['barangay_id'],
            'location_description' => $validated['location_description'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'status' => 'approved',
            'eye_color' => $validated['eye_color'],
        ]);

        return redirect()->route('admin-asst.missing-pets.index')
            ->with('success', 'Missing pet report created successfully!');
    }

    public function show(MissingPetsReport $missingPet)
    {
        $missingPet->load('pet');

        return view('admin-asst.missing-pets.show', compact('missingPet'));
    }

    public function edit(MissingPetsReport $missingPet)
    {
        $missingPet->load('pet');
        $clients = PetOwner::active()->orderBy('last_name')->get();
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-asst.missing-pets.edit', compact('missingPet', 'clients', 'barangays'));
    }

    public function update(Request $request, MissingPetsReport $missingPet)
    {
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|string|in:dog,cat,other',
            'breed' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female,unknown',
            'image' => 'nullable|image|max:2048',
            'last_seen_at' => 'required|date',
            'barangay_id' => 'required|integer|exists:barangays,barangay_id',
            'location_description' => 'nullable|string|max:2000',
            'emergency_contact' => 'nullable|string|max:255',
            'body_marks' => 'nullable|string|max:2000',
            'eye_color' => 'required|string|max:255',
            'collar_harness' => 'nullable|string|max:255',
            'reported_by_name' => 'nullable|string|max:255',
            'reporter_contact' => 'required|string|max:255',
            'reporter_email' => 'nullable|email|max:255',
        ]);

        $pet = $missingPet->pet;

        if ($pet) {
            $pet->update([
                'pet_name' => $validated['pet_name'],
                'species' => $validated['species'],
                'breed' => $validated['breed'],
                'gender' => $validated['gender'],
                'color' => $validated['color'],
            ]);
        }

        if ($pet && $request->filled('eye_color')) {
            if ($pet->petInfo) {
                $pet->petInfo->update(['eye_color' => $request->input('eye_color')]);
            } else {
                $pet->petInfo()->create(['eye_color' => $request->input('eye_color')]);
            }
        }

        if ($request->hasFile('image')) {
            if ($pet->pet_image) {
                Storage::disk('public')->delete($pet->pet_image);
            }
            $path = $request->file('image')->store('missing-pets', 'public');
            $pet->update(['pet_image' => $path]);
        }

        $missingPet->update([
            'body_marks' => $validated['body_marks'] ?? null,
            'collar_harness' => $validated['collar_harness'] ?? null,
            'last_seen_at' => $validated['last_seen_at'],
            'barangay_id' => $validated['barangay_id'],
            'location_description' => $validated['location_description'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'reported_by_name' => $validated['reported_by_name'] ?? null,
            'reporter_contact' => $validated['reporter_contact'],
            'reporter_email' => $validated['reporter_email'] ?? null,
            'eye_color' => $validated['eye_color'],
        ]);

        return redirect()->route('admin-asst.missing-pets.show', $missingPet->report_id)
            ->with('success', 'Missing pet report updated successfully!');
    }

    public function approve(Request $request, MissingPetsReport $missingPet)
    {
        $missingPet->update(['status' => 'approved']);

        if ($missingPet->pet) {
            $missingPet->pet->update([
                'pet_status' => 'missing',
            ]);
        }

        return redirect()->back()->with('success', 'Missing pet report approved!');
    }

    public function reject(Request $request, MissingPetsReport $missingPet)
    {
        $missingPet->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Missing pet report rejected!');
    }

    public function markFound(Request $request, MissingPetsReport $missingPet)
    {
        $missingPet->update(['status' => 'resolved - reunited']);

        if ($missingPet->pet) {
            $missingPet->pet->update([
                'pet_status' => 'owned',
            ]);
        }

        return redirect()->route('admin-asst.missing-pets.index')
            ->with('success', 'Pet marked as found/reunited!');
    }

    public function markShelterIntake(Request $request, MissingPetsReport $missingPet)
    {
        $missingPet->update(['status' => 'resolved - shelter intake']);

        if ($missingPet->pet) {
            $missingPet->pet->update([
                'pet_status' => 'in shelter/intake',
            ]);
        }

        return redirect()->route('admin-asst.missing-pets.index')
            ->with('success', 'Pet marked as shelter intake!');
    }

    public function closeExpired(Request $request, MissingPetsReport $missingPet)
    {
        $missingPet->update(['status' => 'closed - expired']);

        if ($missingPet->pet) {
            $missingPet->pet->update([
                'pet_status' => 'for adoption',
            ]);
        }

        return redirect()->route('admin-asst.missing-pets.index')
            ->with('success', 'Missing pet report closed as expired!');
    }

    public function cancel(Request $request, MissingPetsReport $missingPet)
    {
        $missingPet->update(['status' => 'closed - cancelled']);

        if ($missingPet->pet) {
            $missingPet->pet->update([
                'pet_status' => 'owned',
            ]);
        }

        return redirect()->route('admin-asst.missing-pets.index')
            ->with('success', 'Missing pet report cancelled!');
    }

    public function markDuplicate(Request $request, MissingPetsReport $missingPet)
    {
        $missingPet->update(['status' => 'closed - duplicate']);

        return redirect()->route('admin-asst.missing-pets.index')
            ->with('success', 'Missing pet report marked as duplicate!');
    }
}
