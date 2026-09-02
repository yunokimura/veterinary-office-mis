@foreach($reports as $report)
<tr class="hover:bg-gray-50 transition">
    <td class="px-6 py-4">
        <span class="font-medium text-gray-800">MP-{{ str_pad($report->report_id, 5, '0', STR_PAD_LEFT) }}</span>
    </td>
    <td class="px-6 py-4">
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
    <td class="px-6 py-4">
        <p class="text-gray-800">{{ ucfirst($report->pet->species ?? 'Unknown') }}</p>
    </td>
    <td class="px-6 py-4">
        <p class="text-gray-600">{{ \Carbon\Carbon::parse($report->last_seen_at)->format('M d, Y') }}</p>
    </td>
    <td class="px-6 py-4">
        <p class="text-gray-800">{{ $report->location_barangay ?? 'Unknown' }}</p>
    </td>
    <td class="px-6 py-4">
        <p class="text-gray-800">{{ $report->location_description ?? 'Unknown' }}</p>
    </td>
    <td class="px-6 py-4">
        @if($report->status == 'missing')
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Missing</span>
        @elseif($report->status == 'found')
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Found</span>
        @elseif($report->status == 'reunited')
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Reunited</span>
        @else
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">{{ ucfirst($report->status) }}</span>
        @endif
    </td>
    <td class="px-6 py-4">
        <button onclick="openReportModal({{ $report->report_id }})"
                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition">
            <i class="bi bi-eye"></i>View
        </button>
    </td>
</tr>
@endforeach
