<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\MissingPetsReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        return redirect()->route('missing-pets.report-landing')
            ->with('success', 'Your '.($reportType === 'found' ? 'found pet' : 'missing pet').' report has been submitted successfully!');
    }
}
