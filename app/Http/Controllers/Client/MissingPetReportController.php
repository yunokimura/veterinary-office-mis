<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\MissingPetsReport;
use App\Models\Pet;
use Carbon\Carbon;
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
            'barangay_id' => 'required|integer|exists:barangays,barangay_id',
            'location_description' => 'nullable|string|max:2000',
            'additional_contact' => 'nullable|string|max:1000',
            'pet_photo' => 'nullable|image|max:8192',
            'physical_marks.body_marks_photo' => 'nullable|image|max:8192',
            'reported_by_name' => 'nullable|string|max:255',
            'reporter_contact' => 'nullable|string|max:255',
            'reporter_email' => 'nullable|email|max:255',
        ]);

        $selectedPetIds = $validated['selected_pets'];
        $lastSeenAt = Carbon::createFromFormat('Y-m-d H:i', $validated['last_seen_date'].' '.$validated['last_seen_time']);

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

            // Persist Unique Body Mark details + photo to the pets table
            if ($pet) {
                $petData = [];
                if ($request->filled('physical_marks.body_marks')) {
                    $petData['body_mark_details'] = $validated['physical_marks']['body_marks'];
                }
                if ($request->hasFile('physical_marks.body_marks_photo')) {
                    if ($pet->body_mark_image) {
                        Storage::disk('public')->delete($pet->body_mark_image);
                    }
                    $petData['body_mark_image'] = $request->file('physical_marks.body_marks_photo')->store('missing-pets', 'public');
                }
                if (! empty($petData)) {
                    $pet->update($petData);
                }
            }

            $reports[] = MissingPetsReport::create([
                'user_id' => $user->id,
                'pet_id' => $petId,
                'report_type' => 'missing',
                'reported_by_name' => $validated['reported_by_name'] ?? trim(($petOwner->first_name ?? '').' '.($petOwner->last_name ?? '')),
                'reporter_contact' => $validated['reporter_contact'] ?? $petOwner->phone_number ?? $user->contact_number,
                'reporter_email' => $validated['reporter_email'] ?? $user->email,
                'body_marks' => $validated['physical_marks']['body_marks'] ?? null,
                'collar_harness' => $validated['physical_marks']['collar_harness'] ?? null,
                'last_seen_at' => $lastSeenAt,
                'barangay_id' => $validated['barangay_id'],
                'location_description' => $validated['location_description'] ?? null,
                'emergency_contact' => $validated['additional_contact'] ?? null,
                'status' => 'pending review',
                'eye_color' => $validated['physical_marks']['eye_color'] ?? null,
            ]);

            if ($pet && $request->filled('physical_marks.eye_color')) {
                $eyeColor = $validated['physical_marks']['eye_color'];
                if ($pet->petInfo) {
                    $pet->petInfo->update(['eye_color' => $eyeColor]);
                } else {
                    $pet->petInfo()->create(['eye_color' => $eyeColor]);
                }
            }
        }

        return redirect()->route('missing-pets.form')->with('success', 'Missing pet report submitted successfully!');
    }

    public function storeFound(Request $request)
    {
        $user = Auth::user();
        $petOwner = $user->petOwner()->first();

        if (! $petOwner) {
            return redirect()->back()->with('error', 'Please complete your pet owner profile first.')->withInput();
        }

        $validated = $request->validate([
            'report_type' => 'required|in:found',
            'species' => 'required|in:Dog,Cat',
            'breed' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Unknown',
            'estimated_age' => 'required|in:Puppy/Kitten,Adult,Senior',
            'pet_photo' => 'required|image|max:8192',
            'eye_color' => 'nullable|string|max:255',
            'collar_harness' => 'nullable|string|max:255',
            'fur_colors' => 'nullable|string|max:255',
            'condition' => 'nullable|string|max:255',
            'date_found' => 'required|date',
            'time_found' => 'required',
            'barangay_id' => 'required|integer|exists:barangays,barangay_id',
            'location_notes' => 'nullable|string|max:2000',
            'reported_by_name' => 'nullable|string|max:255',
            'reporter_contact' => 'nullable|string|max:255',
            'reporter_email' => 'nullable|email|max:255',
            'eye_color_left' => 'nullable|string|max:255',
            'eye_color_right' => 'nullable|string|max:255',
            'eye_color_other' => 'nullable|string|max:255',
        ]);

        $dateFoundAt = Carbon::createFromFormat('Y-m-d H:i', $validated['date_found'].' '.$validated['time_found']);

        $photoPath = null;
        if ($request->hasFile('pet_photo')) {
            $photoPath = $request->file('pet_photo')->store('found-pets', 'public');
        }

        $bodyMarks = null;

        MissingPetsReport::create([
            'user_id' => $user->id,
            'pet_id' => null,
            'report_type' => 'found',
            'reported_by_name' => $validated['reported_by_name'] ?? trim(($petOwner->first_name ?? '').' '.($petOwner->last_name ?? '')),
            'reporter_contact' => $validated['reporter_contact'] ?? $petOwner->phone_number ?? $user->contact_number,
            'reporter_email' => $validated['reporter_email'] ?? $user->email,
            'body_marks' => null,
            'collar_harness' => $validated['collar_harness'] ?? null,
            'breed' => $validated['breed'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'estimated_age' => $validated['estimated_age'] ?? null,
            'fur_colors' => $validated['fur_colors'] ?? null,
            'condition' => $validated['condition'] ?? null,
            'eye_color' => $validated['eye_color'] ?? null,
            'eye_color_left' => $validated['eye_color_left'] ?? null,
            'eye_color_right' => $validated['eye_color_right'] ?? null,
            'eye_color_other' => $validated['eye_color_other'] ?? null,
            'last_seen_at' => $dateFoundAt,
            'barangay_id' => $validated['barangay_id'],
            'location_description' => $validated['location_notes'] ?? null,
            'emergency_contact' => $validated['reporter_contact'] ?? $petOwner->phone_number ?? $user->contact_number,
            'photo_path' => $photoPath,
            'status' => 'pending review',
        ]);

        return redirect('/missing-pets')->with('success', 'Found pet report submitted successfully!');
    }
}
