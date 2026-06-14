<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Barangay;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->load('petOwner.address.barangay');

        $this->attachLegacyPetOwnerAddress($user);

        return view('Client.profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($request->input('edit_section') === 'email') {
            $validated = $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            ]);

            $user->forceFill([
                'email' => $validated['email'],
                'email_verified_at' => null,
            ])->save();

            return back()->with('success', 'Profile updated successfully.');
        }

        if (! $request->has('edit_section')) {
            $validated = $request->validate([
                'name' => ['nullable', 'string', 'max:255'],
                'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            ]);

            $user->forceFill($validated)->save();

            return back()->with('success', 'Profile updated successfully.');
        }

        $petOwner = $user->petOwner;

        if (! $petOwner) {
            return back()->with('error', 'Pet owner profile not found.');
        }

        if ($request->input('edit_section') === 'personal') {
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'middle_name' => ['nullable', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'dob_year' => ['required', 'integer', 'min:1900', 'max:2100'],
                'dob_month' => ['required', 'integer', 'between:1,12'],
                'dob_day' => ['required', 'integer', 'between:1,31'],
                'phone_number' => ['required', 'string', 'max:20'],
                'alternate_phone_number' => ['nullable', 'string', 'max:20'],
            ]);

            if (! checkdate((int) $validated['dob_month'], (int) $validated['dob_day'], (int) $validated['dob_year'])) {
                throw ValidationException::withMessages([
                    'dob_day' => ['The selected date of birth is invalid.'],
                ]);
            }

            $petOwner->update([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'],
                'last_name' => $validated['last_name'],
                'date_of_birth' => sprintf(
                    '%04d-%02d-%02d',
                    (int) $validated['dob_year'],
                    (int) $validated['dob_month'],
                    (int) $validated['dob_day']
                ),
                'phone_number' => $validated['phone_number'],
                'alternate_phone_number' => $validated['alternate_phone_number'],
            ]);

            return back()->with('success', 'Profile updated successfully.');
        }

        if ($request->input('edit_section') === 'address') {
            $validated = $request->validate([
                'blk_lot_ph' => ['required', 'string', 'max:255'],
                'street' => ['required', 'string', 'max:255'],
                'subdivision' => ['nullable', 'string', 'max:255'],
                'barangay' => ['required', 'string', 'max:255'],
            ]);

            $barangay = Barangay::where('barangay_name', $validated['barangay'])->first();

            if (! $barangay) {
                throw ValidationException::withMessages([
                    'barangay' => ['The selected barangay is invalid.'],
                ]);
            }

            $address = $petOwner->address;

            if (! $address) {
                $address = $petOwner->address()->create([
                    'block_lot_phase' => $validated['blk_lot_ph'],
                    'street' => $validated['street'],
                    'subdivision' => $validated['subdivision'],
                    'barangay_id' => $barangay->barangay_id,
                    'city' => $barangay->city,
                    'province' => $barangay->province,
                    'is_primary' => true,
                ]);
            } else {
                $address->update([
                    'block_lot_phase' => $validated['blk_lot_ph'],
                    'street' => $validated['street'],
                    'subdivision' => $validated['subdivision'],
                    'barangay_id' => $barangay->barangay_id,
                    'city' => $barangay->city,
                    'province' => $barangay->province,
                ]);
            }

            $petOwner->update(['address_id' => $address->id]);

            return back()->with('success', 'Profile updated successfully.');
        }

        return back()->with('error', 'Invalid profile update request.');
    }

    private function attachLegacyPetOwnerAddress($user): void
    {
        $petOwner = $user->petOwner;

        if (! $petOwner || $petOwner->address) {
            return;
        }

        $legacyAddress = Address::where('addressable_type', 'pet_owner')
            ->where('addressable_id', $user->id)
            ->first();

        if (! $legacyAddress) {
            return;
        }

        $legacyAddress->update(['addressable_id' => $petOwner->owner_id]);
        $petOwner->update(['address_id' => $legacyAddress->id]);
        $petOwner->setRelation('address', $legacyAddress->load('barangay'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
