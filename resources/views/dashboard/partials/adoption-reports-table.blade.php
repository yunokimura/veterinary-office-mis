<table class="w-full text-sm">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Application No.</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Animal Type</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applied Date</th>
            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($reports as $report)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">
                <span class="font-medium text-gray-800">AD-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
            </td>
            <td class="px-4 py-3">
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
            <td class="px-4 py-3 text-gray-600">
                <p class="text-gray-800">{{ $report->pet->pet_name ?? 'N/A' }}</p>
            </td>
            <td class="px-4 py-3 text-gray-600">
                <p class="text-gray-800">{{ ucfirst($report->pet->species ?? 'N/A') }}</p>
            </td>
            <td class="px-4 py-3">
                @if($report->status == 'pending')
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                @elseif($report->status == 'approved')
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Approved</span>
                @elseif($report->status == 'completed')
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Completed</span>
                @elseif($report->status == 'rejected')
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Rejected</span>
                @else
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">{{ ucfirst($report->status) }}</span>
                @endif
            </td>
            <td class="px-4 py-3 text-gray-600">
                <p class="text-gray-800">{{ \Carbon\Carbon::parse($report->created_at)->format('M dd, Y') }}</p>
            </td>
            <td class="px-4 py-3 text-center">
                <button type="button" class="p-1.5 text-blue-700 hover:bg-gray-100 rounded-full transition" title="View" onclick="openReportModal({{ $report->id }})">
                    <i class="bi bi-eye text-lg"></i>
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                <i class="bi bi-calendar-x text-4xl mb-2 block"></i>
                No adoption applications found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
