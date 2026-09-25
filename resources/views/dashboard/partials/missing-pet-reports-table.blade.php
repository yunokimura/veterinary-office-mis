<table class="w-full text-sm">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Report No.</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet Name</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Animal Type</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Seen</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barangay</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($reports as $report)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">
                <span class="font-medium text-gray-800">MP-{{ str_pad($report->report_id, 5, '0', STR_PAD_LEFT) }}</span>
            </td>
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-paw text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $report->pet->pet_name ?? 'Unknown' }}</p>
                        <p class="text-sm text-gray-500">{{ $report->pet->breed ?? 'Unknown' }}</p>
                    </div>
                </div>
            </td>
            <td class="px-4 py-3 text-gray-600">
                <p class="text-gray-800">{{ ucfirst($report->pet->species ?? 'Unknown') }}</p>
            </td>
            <td class="px-4 py-3 text-gray-600">
                <p class="text-gray-800">{{ \Carbon\Carbon::parse($report->last_seen_at)->format('M d, Y') }}</p>
            </td>
            <td class="px-4 py-3 text-gray-600">
                <p class="text-gray-800">{{ $report->location_barangay ?? 'Unknown' }}</p>
            </td>
            <td class="px-4 py-3">
                @php
                    $statusClasses = [
                        'pending review' => 'bg-[#FEF3C7] text-[#92400E]',
                        'approved' => 'bg-[#DCFCE7] text-[#166534]',
                        'rejected' => 'bg-[#FEE2E2] text-[#991B1B]',
                        'resolved - reunited' => 'bg-[#E0E7FF] text-[#3730A3]',
                        'resolved - shelter intake' => 'bg-[#E0F2FE] text-[#075985]',
                        'closed - expired' => 'bg-[#F3F4F6] text-[#4B5563]',
                        'closed - cancelled' => 'bg-[#E5E7EB] text-[#374151]',
                        'closed - duplicate' => 'bg-[#F3F4F6] text-[#6B7280]',
                        'missing' => 'bg-red-100 text-red-800',
                        'found' => 'bg-blue-100 text-blue-800',
                    ];

                    $statusLabels = [
                        'pending review' => 'Pending Review',
                        'resolved - reunited' => 'Resolved - Reunited',
                        'resolved - shelter intake' => 'Resolved - Shelter Intake',
                        'closed - expired' => 'Closed - Expired',
                        'closed - cancelled' => 'Closed - Cancelled',
                        'closed - duplicate' => 'Closed - Duplicate',
                    ];
                @endphp
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses[$report->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $statusLabels[$report->status] ?? ucfirst($report->status) }}
                </span>
            </td>
            <td class="px-4 py-3 text-center">
                <button type="button" class="p-1.5 text-blue-700 hover:bg-gray-100 rounded-full transition" title="View" onclick="openReportModal({{ $report->report_id }})">
                    <i class="bi bi-eye text-lg"></i>
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                <i class="bi bi-calendar-x text-4xl mb-2 block"></i>
                No missing pet reports found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
