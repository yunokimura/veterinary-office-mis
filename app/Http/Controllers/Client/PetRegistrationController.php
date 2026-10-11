<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\PetOwner;
use App\Models\VaccinationReport;
use App\Support\PetAge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PetRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created pet in storage.
     */
    public function store(Request $request)
    {
        try {
            // Debug: Log all input data
            Log::info('Pet Registration Input:', $request->all());

            $validated = $request->validate([
                'pet_name' => 'required|string|max:255',
                'pet_type' => 'required|in:dog,cat',
                'gender' => 'required|in:male,female',
                'is_neutered' => 'required|in:yes,no',
                'is_crossbreed' => 'required|in:yes,no',
                'know_birthdate' => 'required|in:yes,no',
                'pet_breed' => 'required|string|max:255',
                'pet_birthdate' => 'nullable|date',
                'pet_age_years' => 'nullable|integer|min:0|max:40',
                'pet_age_months' => 'nullable|integer|min:0|max:11',
                'pet_weight' => 'nullable|string|max:50',
                'additional_photos.front' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'additional_photos.side' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'additional_photos.top' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'body_mark_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'body_mark_details' => 'nullable|string|max:1000',
                'not_vaccinated' => 'boolean',
                'vaccination_core' => 'array',
                'vaccination_core.*' => 'string',
                'vaccination_optional' => 'array',
                'vaccination_optional.*' => 'string',
                'vaccination_other' => 'nullable|string|max:255',
                'anti_rabies' => 'nullable|array',
                'anti_rabies.date_administered' => 'required_if:vaccination_core.*,Anti-Rabies|nullable|date_format:d/m/Y',
                'anti_rabies.lot_no' => 'nullable|string|max:30',
                'anti_rabies.tag_no' => 'nullable|string|max:30|regex:/^[A-Za-z0-9\-\s]+$/',
                'vaccination_card' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'vaccination_optional' => 'array',
                'vaccination_optional.*' => 'string',
                'vaccination_other' => 'nullable|string|max:255',
            ]);

            // A pet's age must be known one way or the other
            $yearsInput = (int) $request->input('pet_age_years');
            $monthsInput = (int) $request->input('pet_age_months');

            if ($request->input('know_birthdate') !== 'yes' && $yearsInput === 0 && $monthsInput === 0) {
                return back()->withErrors([
                    'pet_age_years' => "Please specify your pet's age in years or months.",
                ])->withInput();
            }

            // Get the authenticated user
            $user = Auth::user();

            Log::info('User ID: '.$user->id);
            Log::info('User email: '.$user->email);

            // Look up or create pet owner based on user_id (more reliable than email)
            $petOwner = PetOwner::where('user_id', $user->id)->first();

            if (! $petOwner) {
                // Parse name properly - handle Filipino names like "Juan Kun Dela Cruz"
                $nameParts = explode(' ', $user->name);
                $firstName = $nameParts[0] ?? '';
                $lastName = array_pop($nameParts); // Last part is last name (e.g., "Cruz")
                $middleName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : null; // Middle parts (e.g., "Kun Dela")

                // Get phone from user contact_number, require if registered user should have one
                $phoneNumber = $user->contact_number ?? 'N/A';

                try {
                    $petOwner = PetOwner::create([
                        'user_id' => $user->id,
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'email' => $user->email,
                        'phone_number' => $phoneNumber,
                        'blk_lot_ph' => '',
                        'street' => '',
                        'subdivision' => '',
                        'barangay' => '',
                    ]);
                    Log::info('Created new pet owner with ID: '.$petOwner->owner_id);
                } catch (\Exception $e) {
                    Log::warning('Could not create pet owner: '.$e->getMessage());
                }
            }

            Log::info('Using owner_id: '.($petOwner->owner_id ?? 'null'));

            // Validate that pet owner exists before creating pet
            if (! $petOwner) {
                return back()->with('error', 'Unable to create pet owner record. Please contact support.')->withInput();
            }

            // Handle file uploads
            $petImagePath = null;
            $bodyMarkImagePath = null;

            Log::info('Form all inputs: ', $request->all());

            // Handle file uploads - save to public/images folder
            $petImagePath = null;
            $bodyMarkImagePath = null;

            Log::info('Has pet_image file: '.($request->hasFile('pet_image') ? 'yes' : 'no'));
            Log::info('pet_image file info: ', $request->file('pet_image') ? [$request->file('pet_image')->getClientOriginalName()] : ['no file']);

            if ($request->hasFile('pet_image')) {
                $file = $request->file('pet_image');
                $filename = time().'_'.$file->getClientOriginalName();
                $uploadPath = public_path('images/pets');
                if (! file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $file->move($uploadPath, $filename);
                $petImagePath = 'images/pets/'.$filename;
                Log::info('Pet image stored at: '.$petImagePath);
            }

            if ($request->hasFile('body_mark_image')) {
                $file = $request->file('body_mark_image');
                $filename = time().'_body_'.$file->getClientOriginalName();
                $uploadPath = public_path('images/pets');
                if (! file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $file->move($uploadPath, $filename);
                $bodyMarkImagePath = 'images/pets/'.$filename;
            }

            // Resolve the birthdate: use the date picker, or derive it from the
            // structured years / months selectors.
            $birthdate = null;
            $ageInput = null;

            if ($request->input('know_birthdate') === 'yes' && $request->filled('pet_birthdate')) {
                $birthdate = $request->input('pet_birthdate');
            } else {
                $years = (int) $request->input('pet_age_years');
                $months = (int) $request->input('pet_age_months');

                if ($years > 0 || $months > 0) {
                    $ageParts = [];

                    if ($years > 0) {
                        $ageParts[] = $years.' '.($years === 1 ? 'year' : 'years');
                    }
                    if ($months > 0) {
                        $ageParts[] = $months.' '.($months === 1 ? 'month' : 'months');
                    }

                    $ageInput = implode(' ', $ageParts);
                    $birthdate = $this->calculateBirthdateFromExactAge($ageInput);
                }
            }

            $pet = Pet::create([
                'owner_id' => $petOwner ? $petOwner->owner_id : null,
                'pet_name' => $validated['pet_name'],
                'species' => $validated['pet_type'],
                'breed' => $validated['pet_breed'],
                'gender' => $validated['gender'],
                'birthdate' => $birthdate,
                'body_mark_details' => $validated['body_mark_details'] ?? null,
                'pet_image' => $petImagePath,
                'body_mark_image' => $bodyMarkImagePath,
            ]);

            $petAge = PetAge::compute($birthdate) ?? $ageInput;

            $pet->petInfo()->create([
                'is_neutered' => $request->input('is_neutered'),
                'is_crossbreed' => $request->input('is_crossbreed'),
                'pet_age' => $petAge,
                'pet_weight' => $validated['pet_weight'] ?? null,
                'training' => json_encode($request->input('training', [])),
                'insurance' => json_encode($request->input('insurance', [])),
                'behavior' => json_encode($request->input('behavior', [])),
                'likes' => json_encode($request->input('likes', [])),
                'dislikes' => json_encode($request->input('dislikes', [])),
                'diet' => json_encode($request->input('diet', [])),
                'allergy' => json_encode($request->input('allergy', [])),
            ]);

            // Handle additional view photos
            $additionalPhotos = [];
            if ($request->hasFile('additional_photos')) {
                $uploadPath = public_path('images/pets/'.$pet->pet_id);
                if (! file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                foreach ($request->file('additional_photos') as $view => $file) {
                    if ($file->isValid()) {
                        $filename = $view.'_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                        $file->move($uploadPath, $filename);
                        $additionalPhotos[$view] = 'images/pets/'.$pet->pet_id.'/'.$filename;
                    }
                }
            }

            $pet->update([
                'additional_photos' => json_encode($additionalPhotos),
            ]);

            // Handle vaccination card upload
            $vaccinationCardPath = null;
            if ($request->hasFile('vaccination_card')) {
                $file = $request->file('vaccination_card');
                $filename = 'vaccination_card_' . $pet->pet_id . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = public_path('images/vaccination_cards');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $file->move($uploadPath, $filename);
                $vaccinationCardPath = 'images/vaccination_cards/' . $filename;
            }

            // Build vaccination records
            $notVaccinated = $request->boolean('not_vaccinated');
            $vaccinationRecords = [];
            $antiRabiesDetails = null;

            if (!$request->boolean('not_vaccinated')) {
                $coreVaccines = $request->input('vaccination_core', []);
                $optionalVaccines = $request->input('vaccination_optional', []);
                $otherVaccine = $request->input('vaccination_other');

                foreach ($coreVaccines as $vaccine) {
                    $record = ['name' => $vaccine, 'type' => 'core'];
                    if ($vaccine === 'Anti-Rabies') {
                        $antiRabiesDate = $request->input('anti_rabies.date_administered');
                        $antiRabiesLot = $request->input('anti_rabies.lot_no');
                        $antiRabiesTag = $request->input('anti_rabies.tag_no');
                        
                        $record['date_administered'] = $antiRabiesDate;
                        $record['lot_no'] = $antiRabiesLot;
                        $record['tag_no'] = $antiRabiesTag;

                        $antiRabiesDetails = [
                            'date_administered' => $antiRabiesDate,
                            'lot_no' => $antiRabiesLot,
                            'tag_no' => $antiRabiesTag,
                        ];
                    }
                    $vaccinationRecords[] = $record;
                }

                $optionalVaccines = $request->input('vaccination_optional', []);
                $otherVaccine = $request->input('vaccination_other');
                foreach ($optionalVaccines as $vaccine) {
                    if ($vaccine === 'Other' && $request->input('vaccination_other')) {
                        $vaccinationRecords[] = [
                            'name' => $request->input('vaccination_other'),
                            'type' => 'optional',
                        ];
                    } else {
                        $vaccinationRecords[] = [
                            'name' => $vaccine,
                            'type' => 'optional',
                        ];
                    }
                }
            }

            // Handle vaccination card upload
            $vaccinationCardPath = null;
            if ($request->hasFile('vaccination_card')) {
                $file = $request->file('vaccination_card');
                $filename = 'vaccination_card_' . $pet->pet_id . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = public_path('images/vaccination_cards');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $file->move($uploadPath, $filename);
                $vaccinationCardPath = 'images/vaccination_cards/' . $filename;
            }

            // Create vaccination report
            $vaccinationReport = \App\Models\VaccinationReport::create([
                'user_id' => $user->id,
                'pet_id' => $pet->pet_id,
                'not_vaccinated' => $request->boolean('not_vaccinated'),
                'vaccination_records' => $vaccinationRecords,
                'anti_rabies_details' => $antiRabiesDetails,
                'vaccination_card_path' => $vaccinationCardPath,
                'status' => 'completed',
                'scheduled_at' => now(),
            ]);

            Log::info('Vaccination report created for pet ID: ' . $pet->pet_id);

            // Prepare pet data for success modal
            $refId = '2026-' . str_pad($pet->pet_id, 5, '0', STR_PAD_LEFT);
            $petData = [
                'pet_id' => $pet->pet_id,
                'ref_id' => $refId,
                'pet_name' => $pet->pet_name,
                'species' => $pet->species,
                'breed' => $pet->breed,
                'pet_image' => $pet->pet_image,
            ];

            return redirect()->route('owner.dashboard')->with('success_pet', $petData);
        } catch (\Exception $e) {
            Log::error('Pet Registration Error: '.$e->getMessage());
            Log::error('Stack trace: '.$e->getTraceAsString());

            return back()->with('error', 'Failed to register pet: '.$e->getMessage())->withInput();
        }
    }

    private function calculateBirthdateFromExactAge(string $petAge): ?string
    {
        $years = 0;
        $months = 0;

        if (preg_match('/(\d+)\s*year/', $petAge, $matches)) {
            $years = (int) $matches[1];
        }
        if (preg_match('/(\d+)\s*month/', $petAge, $matches)) {
            $months = (int) $matches[1];
        }

        if ($years > 0 || $months > 0) {
            return now()->subYears($years)->subMonths($months)->format('Y-m-d');
        }

        return null;
    }
}
