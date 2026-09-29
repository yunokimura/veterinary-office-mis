<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class AdoptionPetController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'description' => 'nullable|string',
            'traits' => 'nullable|array|min:1|max:5',
            'traits.*' => 'exists:traits,id',
            'weight' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'date_of_birth' => 'nullable|date',
            'is_age_estimated' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('adoption-pets', 'public');
        }

        // Convert age to exact pet_age string format or compute from DOB
        $petAge = $validated['age'].' years';
        if (! empty($validated['date_of_birth'])) {
            // Optionally compute from date_of_birth but store as pet_age based on provided age
            $petAge = $validated['age'].' years';
        }

        $now = now();
        $pet = Pet::create([
            'pet_name' => $validated['pet_name'],
            'species' => $validated['species'],
            'breed' => $validated['breed'] ?? null,
            'gender' => $validated['gender'],
            'birthdate' => $validated['date_of_birth'] ?? null,
            'notes' => $validated['description'] ?? null,
            'pet_image' => $imagePath,
            'source_module' => 'adoption_pets',
            'source_module_id' => null,
            'is_approved' => false,
            'pet_status' => 'for adoption',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $pet->petInfo()->create([
            'pet_weight' => $validated['weight'] ?? null,
            'pet_age' => $petAge,
            'is_neutered' => false,
        ]);

        // Link source_module_id to self
        Pet::where('pet_id', $pet->pet_id)->update(['source_module_id' => $pet->pet_id]);

        if (! empty($validated['traits'])) {
            $pet->traits()->attach($validated['traits']);
        }

        return redirect()->route('adoption.index')
            ->with('success', 'Pet added successfully for adoption!');
    }
}
