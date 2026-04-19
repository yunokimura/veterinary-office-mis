<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\PetOwner;
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
                'pet_breed' => 'required|string|max:255',
                'pet_birthdate' => 'nullable|date',
                'estimated_age' => 'nullable|string',
                'pet_weight' => 'nullable|string|max:50',
                'body_mark_details' => 'nullable|string',
            ]);

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

            // Calculate birthdate from estimated age if birthdate not provided
            $birthdate = null;

            if ($request->filled('pet_birthdate')) {
                // Known birthdate provided
                $birthdate = $request->input('pet_birthdate');
            } elseif ($request->filled('estimated_age')) {
                // Calculate birthdate from estimated age
                $estimatedAge = $request->input('estimated_age');
                $years = 0;
                $months = 0;

                if ($estimatedAge === 'less_than_3_months') {
                    $months = 2; // approx 2 months
                } elseif ($estimatedAge === '3_to_12_months') {
                    $months = 7; // approx 7 months
                } elseif (preg_match('/^(\d+)_years$/', $estimatedAge, $matches)) {
                    $years = (int) $matches[1];
                }

                if ($months > 0) {
                    $birthdate = now()->subMonths($months)->format('Y-m-d');
                } elseif ($years > 0) {
                    $birthdate = now()->subYears($years)->format('Y-m-d');
                }
            }

            // Create the pet - use correct field names matching Pet model
            Log::info('Saving pet_image: '.($petImagePath ?? 'null'));

            $pet = Pet::create([
                'owner_id' => $petOwner ? $petOwner->owner_id : null,
                'pet_name' => $validated['pet_name'],
                'species' => $validated['pet_type'],
                'breed' => $validated['pet_breed'],
                'gender' => $validated['gender'],
                'birthdate' => $birthdate,
                'estimated_age' => $validated['estimated_age'] ?? null,
                'pet_weight' => $validated['pet_weight'] ?? null,
                'body_mark_details' => $validated['body_mark_details'] ?? null,
                'pet_image' => $petImagePath,
                'body_mark_image' => $bodyMarkImagePath,
                'is_neutered' => $request->has('is_neutered') ? 'yes' : 'no',
                'is_crossbreed' => $request->has('is_crossbreed') ? 'yes' : 'no',
                // JSON fields - encode arrays
                'training' => json_encode($request->input('training', [])),
                'insurance' => json_encode($request->input('insurance', [])),
                'behavior' => json_encode($request->input('behavior', [])),
                'likes' => json_encode($request->input('likes', [])),
                'dislikes' => json_encode($request->input('dislikes', [])),
                'diet' => json_encode($request->input('diet', [])),
                'allergy' => json_encode($request->input('allergy', [])),
            ]);

            Log::info('Pet created successfully with ID: '.$pet->pet_id);

            return redirect()->route('owner.dashboard')->with('success', $pet->pet_name.' is registered successfully!');
        } catch (\Exception $e) {
            Log::error('Pet Registration Error: '.$e->getMessage());
            Log::error('Stack trace: '.$e->getTraceAsString());

            return back()->with('error', 'Failed to register pet: '.$e->getMessage())->withInput();
        }
    }
}
