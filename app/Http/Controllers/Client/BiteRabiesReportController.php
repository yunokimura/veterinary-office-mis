<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BiteRabiesReport;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BiteRabiesReportController extends Controller
{
    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('Client.bite_rabies_report_form', compact('barangays'));
    }

    public function store(Request $request)
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $report = $this->createReport($request);

        \App\Services\NotificationService::biteReportCreated($report->id);

        return redirect()->route('bite-rabies-report.success', ['report_number' => $report->report_number]);
    }

    public function success(Request $request)
    {
        $reportNumber = $request->query('report_number', 'Unknown');

        return view('Client.bite_rabies_report_success', compact('reportNumber'));
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'incident_date' => 'required|date',
            'exact_location' => 'nullable|string|max:500',
            'barangay_id' => 'required|exists:barangays,barangay_id',
            'animal_type' => 'required|in:Dog,Cat',
            'animal_gender' => 'nullable|in:Male,Female',
            'animal_status' => 'required|in:Stray,Owned,Wild',
            'vaccination_status' => 'required|in:Vaccinated,Unvaccinated,Unknown',
            'bite_site' => 'required|in:Head/Neck,Upper Extremities,Trunk,Lower Extremities',
            'category' => 'required|in:I,II,III',
            'animal_owner_name' => 'nullable|string|max:200',
            'notes' => 'nullable|string|max:1000',
        ];

        return Validator::make($request->all(), $rules);
    }

    private function createReport(Request $request): BiteRabiesReport
    {
        $reportNumber = BiteRabiesReport::generateReportNumber();

        $barangayId = $request->input('barangay_id');

        $animalTypeMap = [
            'Dog' => 'dog',
            'Cat' => 'cat',
        ];

        $animalStatusMap = [
            'Stray' => 'stray',
            'Owned' => 'owned',
        ];

        $animalGenderMap = [
            'Male' => 'male',
            'Female' => 'female',
        ];

        $vaccinationStatusMap = [
            'Vaccinated' => 'vaccinated',
            'Unvaccinated' => 'unvaccinated',
            'Unknown' => 'unknown',
        ];

        return BiteRabiesReport::create([
            'report_number' => $reportNumber,
            'barangay_id' => $barangayId,
            'incident_date' => $request->input('incident_date'),
            'exact_location' => $request->input('exact_location') ?? null,
            'exposure_type' => 'bite',
            'bite_site' => $request->input('bite_site'),
            'category' => $request->input('category'),
            'animal_type' => $animalTypeMap[$request->input('animal_type')] ?? 'dog',
            'animal_gender' => $animalGenderMap[$request->input('animal_gender')] ?? null,
            'animal_status' => $animalStatusMap[$request->input('animal_status')] ?? 'stray',
            'animal_name' => $request->input('animal_name'),
            'vaccination_status' => $vaccinationStatusMap[$request->input('vaccination_status')] ?? 'unknown',
            'animal_owner_name' => $request->input('animal_owner_name'),
            'notes' => $request->input('notes') ?? '',
        ]);
    }
}
