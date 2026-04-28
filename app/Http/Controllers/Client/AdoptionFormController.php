<?php

namespace App\Http\Controllers\Client;

use App\Exceptions\AppointmentSlotTakenException;
use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\Appointment;
use App\Services\AppointmentBookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdoptionFormController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'occupation' => 'nullable|string|max:255',
            'company' => 'required|string|max:255',
            'social_media' => 'nullable|string|max:255',
            'adopted_before' => 'required|in:yes,no',
            'zoom_interview' => 'required|in:Yes,No',
            'interview_date' => 'required|date|after_or_equal:today',
            'interview_time' => 'required',
            'shelter_visit' => 'nullable|in:Yes,No',
            'selected_adoption_pets' => 'nullable|array',
            'selected_adoption_pets.*' => 'integer|exists:pets,pet_id',
            'questionnaire' => 'nullable|array',
            'zoom_time_ampm' => 'nullable|string|max:10',
        ]);

        $user = Auth::user();
        $petOwner = $user->petOwner()->with('address')->first();

        if (! $petOwner) {
            return redirect()->back()->with('error', 'Please complete your pet owner profile first.')->withInput();
        }

        $addressId = $petOwner->address?->id;

        $interviewDate = $validated['interview_date'];
        $interviewTime = $validated['interview_time'];

        try {
            $bookingService = new AppointmentBookingService;
            $bookingService->checkAndBookAdoptionSlot($interviewDate, $interviewTime);
        } catch (AppointmentSlotTakenException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        // Get selected pet ID (take first if multiple)
        $selectedPetId = null;
        if ($request->has('selected_adoption_pets') && is_array($request->input('selected_adoption_pets'))) {
            $selectedPetId = $request->input('selected_adoption_pets')[0] ?? null;
        } elseif ($request->filled('selected_pet_id')) {
            $selectedPetId = $request->input('selected_pet_id');
        }

        // Create adoption application using relational references only
        $adoptionApplication = AdoptionApplication::create([
            'user_id' => $user->id,
            'owner_id' => $petOwner->owner_id,
            'address_id' => $addressId,
            'selected_pet_id' => $selectedPetId,
            'occupation' => $validated['occupation'] ?? null,
            'company' => $validated['company'],
            'social_media' => $validated['social_media'] ?? null,
            'adopted_before' => $validated['adopted_before'],
            'status' => 'pending',
            'questionnaire' => $validated['questionnaire'] ?? null,
            'zoom_interview' => $validated['zoom_interview'],
            'zoom_date' => $interviewDate,
            'zoom_time' => $interviewTime,
            'zoom_time_ampm' => $validated['zoom_time_ampm'] ?? null,
            'shelter_visit' => $validated['shelter_visit'] ?? 'No',
        ]);

        // Create appointment for the interview
        Appointment::create([
            'appointment_date' => $interviewDate,
            'appointment_time' => $interviewTime,
            'service_type' => 'adoption_interview',
            'service_id' => $adoptionApplication->id,
            'status' => 'pending',
            'total_weight' => 1,
            'metadata' => [
                'adopter_name' => $petOwner->full_name,
                'adopter_email' => $user->email,
                'adopter_contact' => $petOwner->phone_number,
            ],
        ]);

        return redirect()->back()->with('success', 'Adoption application submitted successfully! We will contact you soon for the interview.');
    }
}
