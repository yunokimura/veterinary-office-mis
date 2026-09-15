<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\MissingPetsReport;
use App\Models\Pet;
use App\Models\PetOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MissingPetReportController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $petOwner = $user->petOwner()->first();

        if (! $petOwner) {
            return redirect()->back()->with('error', 'Please complete your pet owner profile first.')->withInput();
        }

        $validated = $request->validate([
            'selected_pets' => 'required|array|min:1',
            'selected_pets.*' => 'integer|exists:pets,pet_id',
            'physical_marks' => 'nullable|array',
            'physical_marks.body_marks' => 'nullable|string|max:2000',
            'physical_marks.eye_color' => 'required|string|max:255',
            'physical_marks.collar_harness' => 'nullable|string|max:255',
            'last_seen_date' => 'required|date',
            'last_seen_time' => 'required',
            'location_barangay' => 'required|string|max:255',
            'location_description' => 'nullable|string|max:2000',
            'additional_contact' => 'nullable|string|max:1000',
            'pet_photo' => 'nullable|image|max:8192',
        ]);

        $selectedPetIds = $validated['selected_pets'];
        $lastSeenAt = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $validated['last_seen_date'] . ' ' . $validated['last_seen_time']);

        $petIds = Pet::where('owner_id', $petOwner->owner_id)
            ->whereIn('pet_id', $selectedPetIds)
            ->pluck('pet_id')
            ->toArray();

        if (empty($petIds)) {
            return redirect()->back()->with('error', 'One or more selected pets do not belong to your account.')->withInput();
        }

        $duplicateReport = MissingPetsReport::whereIn('pet_id', $petIds)
            ->whereIn('status', ['pending review', 'approved', 'resolved - reunited'])
            ->exists();

        if ($duplicateReport) {
            return redirect()->back()->with('error', 'A missing pet report already exists for one of the selected pets.')->withInput();
        }

        $reports = [];
        foreach ($petIds as $petId) {
            $pet = Pet::find($petId);

            if ($pet && $request->hasFile('pet_photo')) {
                if ($pet->pet_image) {
                    Storage::disk('public')->delete($pet->pet_image);
                }
                $photoPath = $request->file('pet_photo')->store('missing-pets', 'public');
                $pet->update(['pet_image' => $photoPath]);
            }

            $reports[] = MissingPetsReport::create([
                'user_id' => $user->id,
                'pet_id' => $petId,
                'body_marks' => $validated['physical_marks']['body_marks'] ?? null,
                'eye_color' => $validated['physical_marks']['eye_color'],
                'collar_harness' => $validated['physical_marks']['collar_harness'] ?? null,
                'last_seen_at' => $lastSeenAt,
                'location_barangay' => $validated['location_barangay'],
                'location_description' => $validated['location_description'] ?? null,
                'emergency_contact' => $validated['additional_contact'] ?? null,
                'status' => 'pending review',
            ]);
        }

        return redirect()->route('missing-pets.form')->with('success', 'Missing pet report submitted successfully!');
    }
}
