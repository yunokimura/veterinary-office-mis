<?php

namespace App\Http\Controllers\Client;

use App\Models\Pet;
use App\Models\PetOwner;
use App\Http\Controllers\Controller;
use App\Support\PetAge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    /**
     * API: Display a listing of the user's pets.
     */
    public function index()
    {
        $user = Auth::user();
        $petOwner = $user->petOwner;

        if (!$petOwner) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        $pets = Pet::where('owner_id', $petOwner->owner_id)->get();

        return response()->json([
            'success' => true,
            'data' => $pets
        ]);
    }

    /**
     * API: Display the specified pet.
     */
    public function show($id)
    {
        $user = Auth::user();
        $petOwner = $user->petOwner;

        if (!$petOwner) {
            return response()->json([
                'success' => false,
                'message' => 'Pet owner not found.'
            ], 404);
        }

        $pet = Pet::where('pet_id', $id)
            ->where('owner_id', $petOwner->owner_id)
            ->first();

        if (!$pet) {
            return response()->json([
                'success' => false,
                'message' => 'Pet not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pet
        ]);
    }

    /**
     * Show the edit form for a pet.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $petOwner = $user->petOwner;

        if (!$petOwner) {
            return redirect()->route('owner.pets')->with('error', 'Pet owner not found.');
        }

        $pet = Pet::where('pet_id', $id)
            ->where('owner_id', $petOwner->owner_id)
            ->first();

        if (!$pet) {
            return redirect()->route('owner.pets')->with('error', 'Pet not found.');
        }

        return view('Client.edit_pet', compact('pet'));
    }

    /**
     * Update the pet.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $petOwner = $user->petOwner;

        if (!$petOwner) {
            return redirect()->route('owner.pets')->with('error', 'Pet owner not found.');
        }

        $pet = Pet::where('pet_id', $id)
            ->where('owner_id', $petOwner->owner_id)
            ->first();

        if (!$pet) {
            return redirect()->route('owner.pets')->with('error', 'Pet not found.');
        }

        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'pet_type' => 'required|in:dog,cat',
            'gender' => 'required|in:male,female',
            'pet_breed' => 'required|string|max:255',
            'pet_birthdate' => 'nullable|date',
            'pet_age' => 'nullable|string',
            'pet_weight' => 'nullable|string|max:50',
            'body_mark_details' => 'nullable|string',
        ]);

        // Handle file uploads with error handling
        try {
            if ($request->hasFile('pet_photo') && $request->file('pet_photo')->isValid()) {
                $pet->pet_image = $request->file('pet_photo')->store('pets', 'public');
            }
        } catch (\Exception $e) {
            \Log::warning('Pet image upload failed: ' . $e->getMessage());
        }

        try {
            if ($request->hasFile('body_mark_image') && $request->file('body_mark_image')->isValid()) {
                $pet->body_mark_image = $request->file('body_mark_image')->store('pets/body-marks', 'public');
            }
        } catch (\Exception $e) {
            \Log::warning('Body mark image upload failed: ' . $e->getMessage());
        }

        $pet->update([
            'pet_name' => $validated['pet_name'],
            'species' => $validated['pet_type'],
            'breed' => $validated['pet_breed'],
            'birthdate' => $validated['pet_birthdate'] ?? null,
        ]);

        $petAge = PetAge::compute($validated['pet_birthdate'] ?? null) ?? $validated['pet_age'] ?? null;

        $petInfoData = [
            'pet_age' => $petAge,
            'pet_weight' => $validated['pet_weight'] ?? null,
            'is_neutered' => $request->has('is_neutered') ? 'yes' : 'no',
            'is_crossbreed' => $request->has('is_crossbreed') ? 'yes' : 'no',
            'training' => json_encode($request->input('training', [])),
            'insurance' => json_encode($request->input('insurance', [])),
            'behavior' => json_encode($request->input('behavior', [])),
            'likes' => json_encode($request->input('likes', [])),
            'dislikes' => json_encode($request->input('dislikes', [])),
            'diet' => json_encode($request->input('diet', [])),
            'allergy' => json_encode($request->input('allergy', [])),
        ];

        if ($pet->petInfo) {
            $pet->petInfo->update($petInfoData);
        } else {
            $pet->petInfo()->create($petInfoData);
        }

        return redirect()->route('owner.pets')->with('success', 'Pet updated successfully!');
    }

    /**
     * Delete the pet.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $petOwner = $user->petOwner;

        if (!$petOwner) {
            return redirect()->route('owner.pets')->with('error', 'Pet owner not found.');
        }

        $pet = Pet::where('pet_id', $id)
            ->where('owner_id', $petOwner->owner_id)
            ->first();

        if (!$pet) {
            return redirect()->route('owner.pets')->with('error', 'Pet not found.');
        }

        // Delete the pet image if exists
        if ($pet->pet_image) {
            \Storage::disk('public')->delete($pet->pet_image);
        }

        $pet->delete();

        return redirect()->route('owner.pets')->with('success', 'Pet deleted successfully!');
    }
}