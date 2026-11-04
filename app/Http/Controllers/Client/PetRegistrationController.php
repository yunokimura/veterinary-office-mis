<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\PetOwner;
use App\Models\VaccinationReport;
use App\Support\PetAge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
                'weight_unknown' => 'nullable|boolean',
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
                'vaccination_core_other' => 'nullable|string|max:255',
                'vaccination_optional_other' => 'nullable|string|max:255',
                'anti_rabies' => 'nullable|array',
                // The browser date picker always submits YYYY-MM-DD
                'anti_rabies.date_administered' => 'required_if:vaccination_core.*,Anti-Rabies|nullable|date_format:Y-m-d',
                'anti_rabies.lot_no' => 'nullable|string|max:6|regex:/^[A-Za-z0-9]+$/',
                'anti_rabies.tag_no' => 'nullable|string|max:30|regex:/^[A-Za-z0-9\-\s]+$/',
                'anti_rabies.vaccine_brand' => 'required_if:vaccination_core.*,Anti-Rabies|nullable|string|max:100|in:Nobivac Rabies,Rabisin,Defensor,Canigen Rabies,Biocan R,Other',
                'anti_rabies.vaccine_brand_other' => 'required_if:anti_rabies.vaccine_brand,Other|nullable|string|max:100',
                'vaccination_card' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'book_booster' => 'nullable|boolean',
            ]);

            // A pet's age must be known one way or the other
            $yearsInput = (int) $request->input('pet_age_years');
            $monthsInput = (int) $request->input('pet_age_months');

            if ($request->input('know_birthdate') !== 'yes' && $yearsInput === 0 && $monthsInput === 0) {
                return back()->withErrors([
                    'pet_age_years' => "Please specify your pet's age in years or months.",
                ])->withInput();
            }

            // Knowing the birthdate means the birthdate itself must be supplied
            if ($request->input('know_birthdate') === 'yes' && ! $request->filled('pet_birthdate')) {
                return back()->withErrors([
                    'pet_birthdate' => "Please provide your pet's birthdate.",
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

                // Get phone from user contact_number, fall back to a placeholder
                // (pet_owners.phone_number is NOT NULL)
                $phoneNumber = $user->contact_number ?? 'N/A';

                try {
                    // Only fillable / existing columns: the legacy blk_lot_ph,
                    // street, subdivision, barangay and email pet owner columns
                    // were dropped in the 2026-04-24 restructure.
                    $petOwner = PetOwner::create([
                        'user_id' => $user->id,
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'phone_number' => $phoneNumber,
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

            $petAge = PetAge::compute($birthdate) ?? $ageInput;

            // Persist everything in one transaction so a failure never leaves
            // a half-registered pet (pet row without its info / report).
            $pet = DB::transaction(function () use ($request, $petOwner, $validated, $birthdate, $petAge, $petImagePath, $bodyMarkImagePath, &$vaccinationCardPath) {
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

                $pet->petInfo()->create([
                    'is_neutered' => $request->input('is_neutered'),
                    'is_crossbreed' => $request->input('is_crossbreed'),
                    'pet_age' => $petAge,
                    'pet_weight' => $request->boolean('weight_unknown') ? null : ($validated['pet_weight'] ?? null),
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

                // additional_photos is cast to array - let the cast encode it
                $pet->update([
                    'additional_photos' => $additionalPhotos,
                ]);

                // Handle vaccination card upload
                if ($request->hasFile('vaccination_card')) {
                    $file = $request->file('vaccination_card');
                    $filename = 'vaccination_card_' . $pet->pet_id . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $uploadPath = public_path('images/vaccination_cards');
                    if (! file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    $file->move($uploadPath, $filename);
                    $vaccinationCardPath = 'images/vaccination_cards/'.$filename;
                }

                // Build vaccination records
                $vaccinationRecords = [];
                $antiRabiesDetails = null;

                if (! $request->boolean('not_vaccinated')) {
                    $coreVaccines = $request->input('vaccination_core', []);
                    $coreOther = $request->input('vaccination_core_other');
                    $optionalOther = $request->input('vaccination_optional_other');

                    foreach ($coreVaccines as $vaccine) {
                        $name = ($vaccine === 'Other' && trim((string) $coreOther) !== '') ? trim($coreOther) : $vaccine;
                        $record = ['name' => $name, 'type' => 'core'];
                        if ($vaccine === 'Anti-Rabies') {
                            $antiRabiesDate = $request->input('anti_rabies.date_administered');
                            $antiRabiesLot = $request->input('anti_rabies.lot_no');
                            $antiRabiesTag = $request->input('anti_rabies.tag_no');
                            $antiRabiesBrand = $request->input('anti_rabies.vaccine_brand');
                            $antiRabiesBrandOther = $request->input('anti_rabies.vaccine_brand_other');

                            $record['date_administered'] = $antiRabiesDate;
                            $record['lot_no'] = $antiRabiesLot;
                            $record['tag_no'] = $antiRabiesTag;
                            $record['vaccine_brand'] = $antiRabiesBrand === 'Other' && trim((string) $antiRabiesBrandOther) !== '' ? trim($antiRabiesBrandOther) : $antiRabiesBrand;

                            $antiRabiesDetails = [
                                'date_administered' => $antiRabiesDate,
                                'lot_no' => $antiRabiesLot,
                                'tag_no' => $antiRabiesTag,
                                'vaccine_brand' => $antiRabiesBrand === 'Other' && trim((string) $antiRabiesBrandOther) !== '' ? trim($antiRabiesBrandOther) : $antiRabiesBrand,
                                'vaccine_brand_other' => $antiRabiesBrand === 'Other' ? $antiRabiesBrandOther : null,
                            ];
                        }
                        $vaccinationRecords[] = $record;
                    }

                    $optionalVaccines = $request->input('vaccination_optional', []);
                    foreach ($optionalVaccines as $vaccine) {
                        if ($vaccine === 'Other' && trim((string) $optionalOther) !== '') {
                            $vaccinationRecords[] = [
                                'name' => trim($optionalOther),
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

                // Create the vaccination report for this registration.
                // NOTE: vaccination_reports has no user_id / scheduled_at columns
                // (they were dropped in the 2026-09-22 restructure) - the
                // reporter is reachable through the pet -> owner -> user chain.
                VaccinationReport::create([
                    'pet_id' => $pet->pet_id,
                    'not_vaccinated' => $request->boolean('not_vaccinated'),
                    'vaccination_records' => $vaccinationRecords,
                    'anti_rabies_details' => $antiRabiesDetails,
                    'vaccination_card_path' => $vaccinationCardPath,
                    'status' => 'completed',
                ]);

                Log::info('Vaccination report created for pet ID: ' . $pet->pet_id);

                return $pet;
            });

            // Prepare pet data for success modal
            $refId = '2026-' . str_pad($pet->pet_id, 5, '0', STR_PAD_LEFT);
$petData = [
                'pet_id' => $pet->pet_id,
                'ref_id' => '2026-' . str_pad($pet->pet_id, 5, '0', STR_PAD_LEFT),
                'pet_name' => $pet->pet_name,
                'species' => $pet->species,
                'breed' => $pet->breed,
                'pet_image' => $pet->pet_image,
            ];

            // ✅ Clear session pre-fill data after successful registration
            session()->forget('guest_prefill_data');

            // AJAX flow (booster booking): the page shows a "pet registered" alert first,
            // then redirects to the vaccination form with this pet pre-selected
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $petData['pet_name'].' has been registered successfully!',
                    'redirect' => url('/vaccination/form?select_pet=' . $pet->pet_id),
                ]);
            }

            // Booster booking flow: send the owner straight to the vaccination form with this pet pre-selected
            if ($request->boolean('book_booster')) {
                return redirect()->to('/vaccination/form?select_pet=' . $pet->pet_id);
            }

            return redirect()->route('owner.dashboard')->with('success_pet', $petData);
        } catch (ValidationException $e) {
            // Let Laravel render it: 422 JSON (with field errors) for AJAX, redirect back otherwise
            throw $e;
        } catch (\Exception $e) {
            Log::error('Pet Registration Error: '.$e->getMessage());
            Log::error('Stack trace: '.$e->getTraceAsString());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to register pet: '.$e->getMessage(),
                ], 500);
            }

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
