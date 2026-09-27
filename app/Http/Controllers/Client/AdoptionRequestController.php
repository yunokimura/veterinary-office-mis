<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdoptionRequestController extends Controller
{
    public function submitForAdoption(Request $request, Pet $pet)
    {
        $user = Auth::user();
        $petOwner = $user->petOwner;

        if (!$petOwner || $petOwner->owner_id !== $pet->owner_id) {
            return redirect()->back()->with('error', 'You do not own this pet.');
        }

        if ($pet->source_module === 'adoption_pets') {
            return redirect()->back()->with('error', 'This pet is already in the adoption process.');
        }

        if (in_array($pet->pet_status, ['deceased', 'missing'])) {
            return redirect()->back()->with('error', 'This pet cannot be submitted for adoption.');
        }

        $pet->update([
            'source_module' => 'adoption_pets',
            'source_module_id' => $pet->pet_id,
            'pet_status' => 'for adoption',
            'is_approved' => false,
        ]);

        return redirect()->back()->with('success', 'Pet submitted for adoption successfully! Awaiting admin approval.');
    }
}
