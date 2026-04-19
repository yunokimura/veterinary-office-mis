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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile_number' => 'required|string|max:20',
            'blk_lot_ph' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'occupation' => 'nullable|string|max:255',
            'company' => 'required|string|max:255',
            'social_media' => 'nullable|string|max:255',
            'adopted_before' => 'required|in:yes,no',
            'zoom_interview' => 'required|in:Yes,No',
            'interview_date' => 'required|date|after_or_equal:today',
            'interview_time' => 'required',
            'shelter_visit' => 'nullable|in:Yes,No',
            'selected_pet_id' => 'nullable|integer',
            'questionnaire' => 'nullable|array',
        ]);

        $user = Auth::user();

        $interviewDate = $validated['interview_date'];
        $interviewTime = $validated['interview_time'];

        try {
            $bookingService = new AppointmentBookingService;
            $bookingService->checkAndBookAdoptionSlot($interviewDate, $interviewTime);
        } catch (AppointmentSlotTakenException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        $adoptionApplication = AdoptionApplication::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'mobile_number' => $validated['mobile_number'],
            'alt_mobile_number' => $validated['alt_mobile_number'] ?? null,
            'blk_lot_ph' => $validated['blk_lot_ph'],
            'street' => $validated['street'],
            'barangay' => $validated['barangay'],
            'birth_date' => $validated['birth_date'] ?? null,
            'occupation' => $validated['occupation'] ?? null,
            'company' => $validated['company'],
            'social_media' => $validated['social_media'] ?? null,
            'adopted_before' => $validated['adopted_before'],
            'status' => 'pending',
            'questionnaire' => $validated['questionnaire'] ?? null,
            'zoom_interview' => $validated['zoom_interview'],
            'zoom_date' => $interviewDate,
            'zoom_time' => $interviewTime,
            'shelter_visit' => $validated['shelter_visit'] ?? 'No',
        ]);

        Appointment::create([
            'appointment_date' => $interviewDate,
            'appointment_time' => $interviewTime,
            'service_type' => 'adoption_interview',
            'service_id' => $adoptionApplication->id,
            'status' => 'pending',
            'total_weight' => 1,
            'metadata' => [
                'adopter_name' => $validated['first_name'].' '.$validated['last_name'],
                'adopter_email' => $validated['email'],
                'adopter_contact' => $validated['mobile_number'],
            ],
        ]);

        return redirect()->back()->with('success', 'Adoption application submitted successfully! We will contact you soon for the interview.');
    }
}
