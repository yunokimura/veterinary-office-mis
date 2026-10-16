<?php

namespace App\Http\Controllers\Client;

use App\Exceptions\AppointmentSlotTakenException;
use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\Appointment;
use App\Models\Pet;
use App\Services\AppointmentBookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdoptionFormController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $petOwner = $user->petOwner()->with(['address' => function ($query) {
            $query->with('barangay');
        }])->first();

        $adoptionPets = Pet::where('source_module', 'adoption_pets')->get();

        return view('Client.adoption_form', compact('user', 'petOwner', 'adoptionPets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'adopted_before' => 'required|in:yes,no',
            'selected_adoption_pets' => 'nullable|array',
            'selected_adoption_pets.*' => 'integer|exists:pets,pet_id',
            'questionnaire' => 'nullable|array',

            'housing_type' => 'required|string|max:255',
            'housing_ownership' => 'required|string|max:255',
            'household_members' => 'nullable|array',
            'household_agreement' => 'required|in:Yes,No',
            'pet_allergies' => 'required|in:Yes,No,Unknown',
            'primary_caregiver' => 'required|string|max:255',
            'time_alone' => 'required|string|max:255',
            'relocation_plan' => 'required|string|max:255',
            'current_pets' => 'required|in:Yes,No',
            'past_pet_experience' => 'required|in:Yes,No',
            'vaccination_stance' => 'nullable|in:Yes,No',

            'alt_first_name' => 'nullable|string|max:255',
            'alt_last_name' => 'nullable|string|max:255',
            'alt_relationship' => 'nullable|string|max:255',
            'alt_phone' => 'nullable|string|max:20',
            'alt_email' => 'nullable|email|max:255',

            'photo_front_house' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_street' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_living_room' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_dining' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_kitchen' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_bedroom' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_windows' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_backyard' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'valid_id' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:8192',
            'primary_living_area' => 'nullable|array|max:3',
            'primary_living_area.*' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'outdoor_yard_gate' => 'nullable|array|max:3',
            'outdoor_yard_gate.*' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
        ]);

        $user = Auth::user();
        $petOwner = $user->petOwner()->with('address')->first();

        if (! $petOwner) {
            return redirect()->back()->with('error', 'Please complete your pet owner profile first.')->withInput();
        }

        $addressId = $petOwner->address?->id;

        $selectedPetId = null;
        if ($request->has('selected_adoption_pets') && is_array($request->input('selected_adoption_pets'))) {
            $selectedPetId = $request->input('selected_adoption_pets')[0] ?? null;
        } elseif ($request->filled('selected_pet_id')) {
            $selectedPetId = $request->input('selected_pet_id');
        }

        $alternateContact = [
            'first_name' => $validated['alt_first_name'] ?? null,
            'last_name' => $validated['alt_last_name'] ?? null,
            'relationship' => $validated['alt_relationship'] ?? null,
            'phone' => $validated['alt_phone'] ?? null,
            'email' => $validated['alt_email'] ?? null,
        ];

        $questionnaire = $validated['questionnaire'] ?? [];
        $questionnaire['housing_type'] = $validated['housing_type'] ?? null;
        $questionnaire['housing_ownership'] = $validated['housing_ownership'] ?? null;
        $questionnaire['household_members'] = $validated['household_members'] ?? [];
        $questionnaire['household_agreement'] = $validated['household_agreement'] ?? null;
        $questionnaire['pet_allergies'] = $validated['pet_allergies'] ?? null;
        $questionnaire['primary_caregiver'] = $validated['primary_caregiver'] ?? null;
        $questionnaire['time_alone'] = $validated['time_alone'] ?? null;
        $questionnaire['relocation_plan'] = $validated['relocation_plan'] ?? null;
        $questionnaire['current_pets'] = $validated['current_pets'] ?? null;
        $questionnaire['past_pet_experience'] = $validated['past_pet_experience'] ?? null;
        $questionnaire['vaccination_stance'] = $validated['vaccination_stance'] ?? null;

        $homePhotoPaths = [
            'primary_living_area' => [],
            'outdoor_yard_gate' => [],
        ];

        if ($request->hasFile('primary_living_area')) {
            foreach ($request->file('primary_living_area') as $file) {
                $homePhotoPaths['primary_living_area'][] = $file->store('adoption/home-photos', 'public');
            }
        }

        if ($request->hasFile('outdoor_yard_gate')) {
            foreach ($request->file('outdoor_yard_gate') as $file) {
                $homePhotoPaths['outdoor_yard_gate'][] = $file->store('adoption/home-photos', 'public');
            }
        }

        $questionnaire['home_photos'] = $homePhotoPaths;

        $validIdPath = null;
        if ($request->hasFile('valid_id')) {
            $validIdPath = $request->file('valid_id')->store('adoption/valid-ids', 'public');
        }

        DB::beginTransaction();
        try {
            $adoptionApplication = AdoptionApplication::create([
                'user_id' => $user->id,
                'owner_id' => $petOwner->owner_id,
                'address_id' => $addressId,
                'selected_pet_id' => $selectedPetId,
                'adopted_before' => $validated['adopted_before'],
                'alternate_contact' => $alternateContact,
                'questionnaire' => $questionnaire,
                'valid_id_path' => $validIdPath,
                'appointment_date' => $request->input('interview_date'),
                'appointment_time' => $request->input('interview_time'),
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            foreach ($homePhotoPaths['primary_living_area'] ?? [] as $path) {
                Storage::disk('public')->delete($path);
            }
            foreach ($homePhotoPaths['outdoor_yard_gate'] ?? [] as $path) {
                Storage::disk('public')->delete($path);
            }
            if ($validIdPath) {
                Storage::disk('public')->delete($validIdPath);
            }

            throw $e;
        }

        return redirect()->route('adoption.index')->with('success', 'Adoption application submitted successfully! We will contact you soon for the interview.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $application = AdoptionApplication::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $petOwner = $user->petOwner()->with(['address' => function ($query) {
            $query->with('barangay');
        }])->first();

        $isEdit = $application->status === 'pending_review';

        return view('Client.adoption_form', [
            'user' => $user,
            'petOwner' => $petOwner,
            'application' => $application,
            'isEdit' => $isEdit,
            'isView' => ! $isEdit,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $application = AdoptionApplication::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($application->status !== 'pending_review') {
            return redirect()->route('owner.dashboard')
                ->with('error', 'This application can no longer be edited.');
        }

        $validated = $request->validate([
            'adopted_before' => 'required|in:yes,no',
            'selected_adoption_pets' => 'nullable|array',
            'selected_adoption_pets.*' => 'integer|exists:pets,pet_id',
            'questionnaire' => 'nullable|array',

            'housing_type' => 'required|string|max:255',
            'housing_ownership' => 'required|string|max:255',
            'household_members' => 'nullable|array',
            'household_agreement' => 'required|in:Yes,No',
            'pet_allergies' => 'required|in:Yes,No,Unknown',
            'primary_caregiver' => 'required|string|max:255',
            'time_alone' => 'required|string|max:255',
            'relocation_plan' => 'required|string|max:255',
            'current_pets' => 'required|in:Yes,No',
            'past_pet_experience' => 'required|in:Yes,No',
            'vaccination_stance' => 'nullable|in:Yes,No',

            'alt_first_name' => 'nullable|string|max:255',
            'alt_last_name' => 'nullable|string|max:255',
            'alt_relationship' => 'nullable|string|max:255',
            'alt_phone' => 'nullable|string|max:20',
            'alt_email' => 'nullable|email|max:255',

            'photo_front_house' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_street' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_living_room' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_dining' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_kitchen' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_bedroom' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_windows' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'photo_backyard' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'valid_id' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:8192',
            'primary_living_area' => 'nullable|array|max:3',
            'primary_living_area.*' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'outdoor_yard_gate' => 'nullable|array|max:3',
            'outdoor_yard_gate.*' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
        ]);

        $selectedPetId = null;
        if ($request->has('selected_adoption_pets') && is_array($request->input('selected_adoption_pets'))) {
            $selectedPetId = $request->input('selected_adoption_pets')[0] ?? null;
        } elseif ($request->filled('selected_pet_id')) {
            $selectedPetId = $request->input('selected_pet_id');
        }

        $alternateContact = [
            'first_name' => $validated['alt_first_name'] ?? null,
            'last_name' => $validated['alt_last_name'] ?? null,
            'relationship' => $validated['alt_relationship'] ?? null,
            'phone' => $validated['alt_phone'] ?? null,
            'email' => $validated['alt_email'] ?? null,
        ];

        $questionnaire = $validated['questionnaire'] ?? [];
        $questionnaire['housing_type'] = $validated['housing_type'] ?? null;
        $questionnaire['housing_ownership'] = $validated['housing_ownership'] ?? null;
        $questionnaire['household_members'] = $validated['household_members'] ?? [];
        $questionnaire['household_agreement'] = $validated['household_agreement'] ?? null;
        $questionnaire['pet_allergies'] = $validated['pet_allergies'] ?? null;
        $questionnaire['primary_caregiver'] = $validated['primary_caregiver'] ?? null;
        $questionnaire['time_alone'] = $validated['time_alone'] ?? null;
        $questionnaire['relocation_plan'] = $validated['relocation_plan'] ?? null;
        $questionnaire['current_pets'] = $validated['current_pets'] ?? null;
        $questionnaire['past_pet_experience'] = $validated['past_pet_experience'] ?? null;
        $questionnaire['vaccination_stance'] = $validated['vaccination_stance'] ?? null;

        $homePhotoPaths = $application->questionnaire['home_photos'] ?? [];
        $homePhotoPaths = is_array($homePhotoPaths) ? $homePhotoPaths : [];

        $oldPrimaryPhotos = isset($homePhotoPaths['primary_living_area']) && is_array($homePhotoPaths['primary_living_area'])
            ? $homePhotoPaths['primary_living_area']
            : [];
        $oldOutdoorPhotos = isset($homePhotoPaths['outdoor_yard_gate']) && is_array($homePhotoPaths['outdoor_yard_gate'])
            ? $homePhotoPaths['outdoor_yard_gate']
            : [];

        $newPrimaryPhotos = [];
        if ($request->hasFile('primary_living_area')) {
            foreach ($request->file('primary_living_area') as $file) {
                $newPrimaryPhotos[] = $file->store('adoption/home-photos', 'public');
            }
        }

        $newOutdoorPhotos = [];
        if ($request->hasFile('outdoor_yard_gate')) {
            foreach ($request->file('outdoor_yard_gate') as $file) {
                $newOutdoorPhotos[] = $file->store('adoption/home-photos', 'public');
            }
        }

        $homePhotoPaths['primary_living_area'] = $newPrimaryPhotos ?: $oldPrimaryPhotos;
        $homePhotoPaths['outdoor_yard_gate'] = $newOutdoorPhotos ?: $oldOutdoorPhotos;

        $questionnaire['home_photos'] = $homePhotoPaths;

        $validIdPath = $application->valid_id_path;
        if ($request->hasFile('valid_id')) {
            if ($validIdPath) {
                Storage::disk('public')->delete($validIdPath);
            }
            $validIdPath = $request->file('valid_id')->store('adoption/valid-ids', 'public');
        }

        DB::beginTransaction();
        try {
            $application->update([
                'adopted_before' => $validated['adopted_before'],
                'alternate_contact' => $alternateContact,
                'questionnaire' => $questionnaire,
                'valid_id_path' => $validIdPath,
                'appointment_date' => $request->input('interview_date'),
                'appointment_time' => $request->input('interview_time'),
            ]);

            if (!empty($oldPrimaryPhotos) && !empty($newPrimaryPhotos)) {
                foreach ($oldPrimaryPhotos as $path) {
                    Storage::disk('public')->delete($path);
                }
            }

            if (!empty($oldOutdoorPhotos) && !empty($newOutdoorPhotos)) {
                foreach ($oldOutdoorPhotos as $path) {
                    Storage::disk('public')->delete($path);
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            foreach ($newPrimaryPhotos as $path) {
                Storage::disk('public')->delete($path);
            }
            foreach ($newOutdoorPhotos as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }

        return redirect()->route('owner.dashboard')
            ->with('success', 'Adoption application updated successfully!');
    }
}
