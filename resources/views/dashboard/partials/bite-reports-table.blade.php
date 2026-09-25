<table class="w-full">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report No.</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Incident Date</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barangay</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Animal Type</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Animal Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($reports as $report)
            <tr class="hover:bg-gray-50" data-report-id="{{ $report->id }}">
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="font-medium text-gray-800">{{ $report->report_number ?? 'N/A' }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($report->incident_date)->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <p class="text-gray-800">{{ $report->barangay?->barangay_name ?? 'N/A' }}</p>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <p class="text-gray-800">{{ $report->animal_owner_name ?? 'N/A' }}</p>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div>
                        <p class="text-gray-800">{{ ucfirst($report->animal_type) }}</p>
                        <p class="text-sm text-gray-500">{{ ucfirst($report->animal_status) }}</p>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-1">
                        <span class="text-sm font-medium text-gray-900">{{ $report->animal_name ?? 'Unknown' }}</span>
                        @if($report->animal_gender)
                            @if($report->animal_gender === 'male')
                                <i class="bi bi-gender-male text-blue-500"></i>
                            @elseif($report->animal_gender === 'female')
                                <i class="bi bi-gender-female text-pink-500"></i>
                            @endif
                        @endif
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
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No reports found</td>
            </tr>
        @endforelse
    </tbody>
</table>
