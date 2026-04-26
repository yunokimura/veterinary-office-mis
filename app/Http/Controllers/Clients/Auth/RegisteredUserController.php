<?php

namespace App\Http\Controllers\Clients\Auth;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Barangay;
use App\Models\PetOwner;
use App\Models\SystemLog;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('Client.auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Phone fields
            'phone_number' => ['required', 'string', 'max:20'],
            'alternate_phone_number' => ['nullable', 'string', 'max:20'],
            // Address fields
            'block_lot_phase_house_no_1' => ['nullable', 'string', 'max:10'],
            'block_lot_phase_house_no_2' => ['nullable', 'string', 'max:10'],
            'block_lot_phase_house_no_3' => ['nullable', 'string', 'max:5'],
            'block_lot_phase_house_no_4' => ['nullable', 'string', 'max:10'],
            'street_name' => ['nullable', 'string', 'max:255'],
            'subdivision' => ['nullable', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
        ]);

        // Create user with 'pet_owner' role for client portal
        // Only citizen role is allowed to register through client portal
        $nameParts = explode(' ', $request->name, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'active',
        ]);

        event(new Registered($user));

        // Create pet owner record
        $petOwner = PetOwner::create([
            'user_id' => $user->id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'phone_number' => $request->input('phone_number'),
            'alternate_phone_number' => $request->input('alternate_phone_number'),
        ]);

        // Create and link address record
        $this->createPetOwnerAddress($request, $petOwner);

        // System log for registration
        SystemLog::create([
            'user_id' => $user->id,
            'action' => 'register',
            'event' => 'create',
            'module' => 'Authentication',
            'description' => 'New user registered via client portal',
            'ip_address' => request()->ip(),
            'status' => 'success',
        ]);

        Auth::login($user);

        return redirect()->to('/client');
    }

    /**
     * Create and link address record for pet owner.
     */
    private function createPetOwnerAddress(Request $request, PetOwner $petOwner)
    {
        // Combine block/lot/phase/house number fields
        $blockLotPhase = trim(
            implode('-', array_filter([
                $request->input('block_lot_phase_house_no_1'),
                $request->input('block_lot_phase_house_no_2'),
                $request->input('block_lot_phase_house_no_3'),
                $request->input('block_lot_phase_house_no_4'),
            ]))
        );
        if ($blockLotPhase === '') {
            $blockLotPhase = null;
        }

        // Look up barangay ID
        $barangayName = $request->input('barangay');
        $barangay = Barangay::where('barangay_name', $barangayName)->first();

        // If barangay not found, use first available barangay as fallback
        if (! $barangay) {
            $barangay = Barangay::first();
            // Log this occurrence for monitoring
            SystemLog::create([
                'user_id' => $petOwner->user_id,
                'action' => 'address_fallback',
                'event' => 'warning',
                'module' => 'Authentication',
                'description' => "Barangay '$barangayName' not found, using fallback barangay ID: ".($barangay ? $barangay->barangay_id : 'null'),
                'ip_address' => request()->ip(),
                'status' => 'warning',
            ]);
        }

        // Create address record
        $address = Address::create([
            'addressable_type' => PetOwner::class,
            'addressable_id' => $petOwner->owner_id,
            'block_lot_phase' => $blockLotPhase,
            'street' => $request->input('street_name'),
            'subdivision' => $request->input('subdivision'),
            'barangay_id' => $barangay ? $barangay->barangay_id : null,
            'city' => $barangay ? $barangay->city.' City' : null,
            'province' => $barangay ? $barangay->province : null,
            'postal_code' => null, // Using null as postal code is optional
            'is_primary' => true,
        ]);

        // Update pet owner with address_id
        $petOwner->update([
            'address_id' => $address->id,
        ]);
    }
}
