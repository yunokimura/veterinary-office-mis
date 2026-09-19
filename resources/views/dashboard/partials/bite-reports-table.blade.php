<table class="w-full">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report No.</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barangay</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Incident Date</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Animal Type</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($reports as $report)
            <tr class="hover:bg-gray-50" data-report-id="{{ $report->id }}">
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="font-medium text-gray-800">{{ $report->report_number ?? 'N/A' }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-person text-red-600"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ trim(($report->patient_first_name ?? '') . ' ' . ($report->patient_middle_name ?? '') . ' ' . ($report->patient_last_name ?? '') . ' ' . ($report->patient_suffix ?? '')) ?: 'Unknown' }}
                            </div>
                            <div class="text-sm text-gray-500">{{ $report->age ?? 'N/A' }} yrs old</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <p class="text-gray-800">{{ $report->barangay->barangay_name ?? ($report->patient_barangay ?? 'N/A') }}</p>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($report->incident_date)->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div>
                        <p class="text-gray-800">{{ ucfirst($report->animal_type) }}</p>
                        <p class="text-sm text-gray-500">{{ ucfirst($report->animal_status) }}</p>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button type="button" class="p-1.5 text-blue-700 hover:bg-gray-100 rounded-full transition" title="View" onclick="openReportModal({{ $report->id }})">
                        <i class="bi bi-eye text-lg"></i>
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No reports found</td>
            </tr>
        @endforelse
    </tbody>
</table>
