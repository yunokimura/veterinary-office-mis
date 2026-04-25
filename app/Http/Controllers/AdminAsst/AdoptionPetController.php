<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\AdoptionTrait;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdoptionPetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::query()->where('source_module', 'adoption_pets'); // Only pets from adoption listings

        if ($request->filled('species')) {
            $query->where('species', $request->species);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pet_name', 'like', '%'.$search.'%')
                    ->orWhere('breed', 'like', '%'.$search.'%')
                    ->orWhere('notes', 'like', '%'.$search.'%');
            });
        }

        $adoptionPets = $query->with('traits')->orderBy('created_at', 'desc')->paginate(12);
        $traits = AdoptionTrait::orderBy('name')->get();

        return view('admin-staff.adoption-pets.index', compact('adoptionPets', 'traits'));
    }

    public function create()
    {
        $traits = AdoptionTrait::orderBy('name')->get();

        return view('admin-staff.adoption-pets.create', compact('traits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|in:Dog,Cat',
            'breed' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date',
            'weight' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'traits' => 'nullable|array',
            'traits.*' => 'exists:adoption_traits,trait_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('adoption-pets', 'public');
        }

        // Create pet with adoption source tracking
        $now = now();
        $pet = Pet::create([
            'pet_name' => $validated['pet_name'],
            'species' => $validated['species'],
            'breed' => $validated['breed'] ?? null,
            'gender' => $validated['gender'],
            'birthdate' => $validated['date_of_birth'] ?? null,
            'pet_weight' => $validated['weight'] ?? null,
            'notes' => $validated['description'] ?? null,
            'pet_image' => $imagePath,
            'source_module' => 'adoption_pets',
            'source_module_id' => null, // will be set after pet is created via pet_id
            'is_approved' => false,
            'pet_status' => 'pending', // pending approval
            'is_neutered' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Link source_module_id to self (pet_id)
        Pet::where('pet_id', $pet->pet_id)->update(['source_module_id' => $pet->pet_id]);

        if (! empty($validated['traits'])) {
            $pet->traits()->attach($validated['traits']);
        }

        return redirect()->route('admin-staff.adoption-pets.index')
            ->with('success', 'Pet added to adoption successfully!');
    }

    public function show(Pet $pet)
    {
        // Ensure this pet is from adoption module
        if ($pet->source_module !== 'adoption_pets') {
            abort(404);
        }
        $pet->load('traits');

        return view('admin-staff.adoption-pets.show', compact('pet'));
    }

    public function edit(Pet $pet)
    {
        if ($pet->source_module !== 'adoption_pets') {
            abort(404);
        }
        $pet->load('traits');
        $traits = AdoptionTrait::orderBy('name')->get();
        $selectedTraits = $pet->traits->pluck('trait_id')->toArray();

        return view('admin-staff.adoption-pets.edit', compact('pet', 'traits', 'selectedTraits'));
    }

    public function update(Request $request, Pet $pet)
    {
        if ($pet->source_module !== 'adoption_pets') {
            abort(404);
        }

        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|in:Dog,Cat',
            'breed' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date',
            'weight' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'traits' => 'nullable|array',
            'traits.*' => 'exists:adoption_traits,trait_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $updateData = [
            'pet_name' => $validated['pet_name'],
            'species' => $validated['species'],
            'breed' => $validated['breed'] ?? null,
            'gender' => $validated['gender'],
            'birthdate' => $validated['date_of_birth'] ?? null,
            'pet_weight' => $validated['weight'] ?? null,
            'notes' => $validated['description'] ?? null,
        ];

        if ($request->hasFile('image')) {
            if ($pet->pet_image) {
                Storage::disk('public')->delete($pet->pet_image);
            }
            $updateData['pet_image'] = $request->file('image')->store('adoption-pets', 'public');
        }

        $updateData['updated_at'] = now();
        $pet->update($updateData);

        if (isset($validated['traits'])) {
            $pet->traits()->sync($validated['traits']);
        }

        return redirect()->route('admin-staff.adoption-pets.show', $pet)
            ->with('success', 'Adoption pet updated successfully!');
    }

    public function destroy(Pet $pet)
    {
        if ($pet->source_module !== 'adoption_pets') {
            abort(404);
        }

        if ($pet->pet_image) {
            Storage::disk('public')->delete($pet->pet_image);
        }

        $pet->traits()->detach();
        $pet->delete();

        return redirect()->route('admin-staff.adoption-pets.index')
            ->with('success', 'Adoption pet removed successfully!');
    }

    public function approve(Pet $pet)
    {
        if ($pet->source_module !== 'adoption_pets') {
            abort(404);
        }

        $pet->update(['is_approved' => true, 'pet_status' => 'available']);

        return redirect()->back()->with('success', 'Adoption pet approved successfully!');
    }
}
