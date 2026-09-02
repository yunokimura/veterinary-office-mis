@foreach($reports as $report)
<tr class="hover:bg-gray-50 transition">
    <td class="px-6 py-4">
        <span class="font-medium text-gray-800">{{ $report->report_number ?? 'N/A' }}</span>
    </td>
    <td class="px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="bi bi-person text-red-600"></i>
            </div>
            <div>
                <p class="font-medium text-gray-800">
                    {{ trim(($report->patient_first_name ?? '') . ' ' . ($report->patient_middle_name ?? '') . ' ' . ($report->patient_last_name ?? '') . ' ' . ($report->patient_suffix ?? '')) ?: 'Unknown' }}
                </p>
                <p class="text-sm text-gray-500">{{ $report->age ?? 'N/A' }} yrs old</p>
            </div>
        </div>
    </td>
    <td class="px-6 py-4">
        <p class="text-gray-800">{{ $report->barangay->barangay_name ?? ($report->patient_barangay ?? 'N/A') }}</p>
    </td>
    <td class="px-6 py-4">
        <p class="text-gray-600">{{ \Carbon\Carbon::parse($report->incident_date)->format('M d, Y') }}</p>
    </td>
    <td class="px-6 py-4">
        <div>
            <p class="text-gray-800">{{ ucfirst($report->animal_type) }}</p>
            <p class="text-sm text-gray-500">{{ ucfirst($report->animal_status) }}</p>
        </div>
    </td>
    <td class="px-6 py-4">
        <button onclick="openReportModal({{ $report->id }})"
                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition">
            <i class="bi bi-eye"></i>View
        </button>
    </td>
</tr>
@endforeach
