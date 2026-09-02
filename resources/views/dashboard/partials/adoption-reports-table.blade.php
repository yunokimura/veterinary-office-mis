@foreach($reports as $report)
<tr class="hover:bg-gray-50 transition">
    <td class="px-6 py-4">
        <span class="font-medium text-gray-800">AD-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
    </td>
    <td class="px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="bi bi-person text-purple-600"></i>
            </div>
            <div>
                <p class="font-medium text-gray-800">{{ $report->user->name ?? 'Unknown' }}</p>
                <p class="text-sm text-gray-500">{{ $report->user->email ?? 'N/A' }}</p>
            </div>
        </div>
    </td>
    <td class="px-6 py-4">
        <p class="font-medium text-gray-800">{{ $report->pet->pet_name ?? 'N/A' }}</p>
    </td>
    <td class="px-6 py-4">
        <p class="text-gray-800">{{ ucfirst($report->pet->species ?? 'N/A') }}</p>
    </td>
    <td class="px-6 py-4">
        @if($report->status == 'pending')
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pending</span>
        @elseif($report->status == 'approved')
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Approved</span>
        @elseif($report->status == 'completed')
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Completed</span>
        @elseif($report->status == 'rejected')
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Rejected</span>
        @else
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">{{ ucfirst($report->status) }}</span>
        @endif
    </td>
    <td class="px-6 py-4">
        <p class="text-gray-600">{{ \Carbon\Carbon::parse($report->created_at)->format('M dd, Y') }}</p>
    </td>
    <td class="px-6 py-4">
        <button onclick="openReportModal({{ $report->id }})"
                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition">
            <i class="bi bi-eye"></i>View
        </button>
    </td>
</tr>
@endforeach
