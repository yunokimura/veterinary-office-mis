<table class="w-full text-sm">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applied Date</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($reports as $report)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">
                <div>
                    <p class="font-medium text-gray-800">{{ $report->pet->pet_name ?? 'N/A' }}</p>
                    <p class="text-xs text-gray-500">{{ ucfirst($report->pet->species ?? 'N/A') }} • {{ $report->pet->breed ?? 'N/A' }}</p>
                </div>
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
            <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                <p class="text-gray-800">{{ $report->created_at ? \Carbon\Carbon::parse($report->created_at)->format('M d, Y') : 'N/A' }}</p>
                <p class="text-xs text-gray-500">{{ $report->created_at ? \Carbon\Carbon::parse($report->created_at)->format('h:i A') : '' }}</p>
            </td>
            <td class="px-4 py-3">
                @if($report->status == 'pending_review')
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-800">Pending Review</span>
                @elseif($report->status == 'approved')
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Approved</span>
                @elseif($report->status == 'adopted')
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800">Adopted</span>
                @elseif($report->status == 'rejected')
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Rejected</span>
                @else
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">{{ ucfirst($report->status) }}</span>
                @endif
            </td>
            <td class="px-4 py-3 text-center">
                <button type="button" class="p-1.5 text-blue-700 hover:bg-gray-100 rounded-full transition" title="View" onclick="openReportModal({{ $report->id }})">
                    <i class="bi bi-eye text-lg"></i>
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                <i class="bi bi-calendar-x text-4xl mb-2 block"></i>
                No adoption applications found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
