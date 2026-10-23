<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\MissingPetsReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class GuestMissingPetReportController extends Controller
{
    public function create(Request $request)
    {
        $reportType = $request->query('type', 'missing');

        if (! in_array($reportType, ['missing', 'found'])) {
            $reportType = 'missing';
        }

        $loadedAt = now()->timestamp;
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('Client.guest_missing_pet_form', [
            'reportType' => $reportType,
            'loadedAt' => $loadedAt,
            'barangays' => $barangays,
        ]);
    }

    public function store(Request $request)
    {
        $reportType = $request->query('type', $request->input('report_type', 'missing'));

        if (! in_array($reportType, ['missing', 'found'])) {
            $reportType = 'missing';
        }

        $rateKey = 'guest-missing-pet-report|'.($request->ip() ?? 'unknown').'|'.($request->input('reporter_contact') ?? 'no-phone');

        if (RateLimiter::tooManyAttempts($rateKey, 3)) {
            return back()->with('error', 'Too many submissions. Please try again later.')->withInput();
        }

        $loadedAt = (int) $request->input('loaded_at', 0);
        $submittedAt = now()->timestamp;
        if ($loadedAt > 0 && ($submittedAt - $loadedAt) < 5) {
            return back()->with('error', 'Form submitted too quickly. Please try again.')->withInput();
        }

        if (! empty($request->input('website')) || ! empty($request->input('fax_number'))) {
            return back()->with('error', 'Invalid submission.')->withInput();
        }

        RateLimiter::hit($rateKey, 3600);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('missing-pets', 'public');
        }

        $validated = $request->validate([
            'reporter_name' => 'nullable|string|max:255',
            'reporter_contact' => 'required|string|max:255',
            'reporter_email' => 'nullable|email|max:255',
            'loaded_at' => 'nullable|integer',

            'pet_name' => 'required_if:report_type,missing|nullable|string|max:255',
            'species' => 'required_if:report_type,missing|nullable|string|in:dog,cat,other',
            'breed' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female,unknown',

            'last_seen_date' => 'required_if:report_type,missing|nullable|date',
            'last_seen_time' => 'required_if:report_type,missing|nullable|string',
            'barangay_id' => 'required|integer|exists:barangays,barangay_id',
            'location_description' => 'nullable|string|max:2000',
            'body_marks' => 'nullable|string|max:2000',
            'eye_color' => 'nullable|string|max:255',
            'collar_harness' => 'nullable|string|max:255',
            'is_crossbreed' => 'nullable|string|in:yes,no',

            'found_description' => 'required_if:report_type,found|nullable|string|max:2000',
            'date_found' => 'required_if:report_type,found|nullable|date',
            'photo' => 'nullable|image|max:8192',
            'fax_number' => 'nullable|string',
        ]);

        $reportData = [
            'user_id' => null,
            'report_type' => $reportType,
            'reported_by_name' => $validated['reporter_name'] ?? null,
            'reporter_contact' => $validated['reporter_contact'],
            'reporter_email' => $validated['reporter_email'] ?? null,
            'photo_path' => $photoPath,
            'status' => 'pending review',
        ];

        if ($reportType === 'missing') {
            $lastSeenAt = null;
            if (! empty($validated['last_seen_date'])) {
                $time = ! empty($validated['last_seen_time']) ? $validated['last_seen_time'] : '00:00';
                $lastSeenAt = Carbon::createFromFormat('Y-m-d H:i', $validated['last_seen_date'].' '.$time);
            }

            $reportData = array_merge($reportData, [
                'pet_id' => null,
                'body_marks' => $validated['body_marks'] ?? null,
                'collar_harness' => $validated['collar_harness'] ?? null,
                'last_seen_at' => $lastSeenAt,
                'barangay_id' => $validated['barangay_id'],
                'location_description' => $validated['location_description'] ?? null,
                'emergency_contact' => $validated['reporter_contact'],
            ]);
        } else {
            $reportData = array_merge($reportData, [
                'pet_id' => null,
                'body_marks' => $validated['found_description'] ?? null,
                'collar_harness' => null,
                'last_seen_at' => ! empty($validated['date_found'])
                    ? Carbon::parse($validated['date_found'])
                    : now(),
                'barangay_id' => $validated['barangay_id'],
                'location_description' => $validated['location_description'] ?? null,
                'emergency_contact' => $validated['reporter_contact'],
            ]);
        }

        MissingPetsReport::create($reportData);

        // ✅ OPTIONAL: Save info for later registration (Option C hybrid)
        if ($request->boolean('save_for_registration')) {
            $token = Str::random(32); // 32-char cryptographically secure random string
            $expiresAt = now()->addDays(7);

            DB::table('guest_report_tokens')->insert([
                'token' => $token,
                'pet_name' => $validated['pet_name'] ?? null,
                'species' => $validated['species'] ?? null,
                'is_crossbreed' => $request->input('is_crossbreed'),
                'reporter_contact' => $validated['reporter_contact'],
                'reporter_email' => $validated['reporter_email'],
                'expires_at' => $expiresAt,
            ]);

            return redirect()->route('missing-pets.report.guest.success')
                ->with('token', $token)
                ->with('saveInfo', true);
        }

        return redirect()->route('missing-pets.report-landing')
            ->with('success', 'Your '.($reportType === 'found' ? 'found pet' : 'missing pet').' report has been submitted successfully!');
    }

    /**
     * Handle the return-to-register link (one-time use token consumption)
     *
     * @param string $token The token from the bookmarked link
     * @return \Illuminate\Http\Response
     */
    public function returnToRegister(string $token, Request $request)
    {
        // 1. Validate token exists and has not expired
        $tokenRecord = DB::table('guest_report_tokens')
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (! $tokenRecord) {
            return redirect()->route('missing-pets.report.guest.create')
                ->with('error', 'Invalid or expired token.');
        }

        // 2. LOAD INTO SESSION FIRST (before deleting token) - prevents data loss on refresh
        $preFillData = [
            'pet_name' => $tokenRecord->pet_name,
            'species' => $tokenRecord->species,
            'is_crossbreed' => $tokenRecord->is_crossbreed,
        ];
        session()->put('guest_prefill_data', $preFillData);

        // 3. THEN DELETE TOKEN FROM DB (one-time use)
        DB::table('guest_report_tokens')->where('id', $tokenRecord->id)->delete();

        // 4. Email Verification Check
        $storedEmail = $tokenRecord->reporter_email;
        $verificationResult = null;

        if ($storedEmail) {
            // Email exists - show verification flow
            session(['guest_stored_email' => $storedEmail]);

            // If this is a POST (user clicked Yes/No on verification):
            if ($request->isMethod('post') && $request->has('email_verified')) {
                $verified = $request->input('email_verified');

                if ($verified === 'yes') {
                    $verificationResult = 'verified';
                } elseif ($verified === 'no') {
                    $verificationResult = 'failed';
                }
            }

            session(['guest_email_verification' => $verificationResult]);
        } else {
            // No email stored - skip verification, still pre-fill form
            session(['guest_email_verification' => '']);
            session(['guest_no_email_from_token' => true]);
        }

        // 5. Redirect to pet registration form
        return redirect()->route('pet.registration.form')
            ->with('guest_prefill', true)
            ->with('token', $token);
    }
}
