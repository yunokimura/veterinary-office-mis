<table class="w-full">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Procedure</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($reports as $report)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="font-medium text-gray-800">SN-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-800">
                    <span class="inline-flex items-center gap-1">
                        <i class="bi bi-paw text-gray-400"></i>
                        {{ $report->pet->pet_name ?? 'N/A' }}
                    </span>
                    @if($report->pet->gender ?? null)
                        @if(strtolower($report->pet->gender) == 'male')
                            <i class="bi bi-gender-male text-blue-500 ml-1"></i>
                        @elseif(strtolower($report->pet->gender) == 'female')
                            <i class="bi bi-gender-female text-pink-500 ml-1"></i>
                        @endif
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-800">
                    @if($report->procedure_type == 'spay')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">Spay (F)</span>
                    @elseif($report->procedure_type == 'neuter')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Neuter (M)</span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Both</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-800">
                    @if($report->status == 'completed')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Completed
                        </span>
                    @elseif($report->status == 'scheduled')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5"></span> Scheduled
                        </span>
                    @elseif($report->status == 'cancelled')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Cancelled
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span> Pending
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $report->owner_name ?? ($report->owner->name ?? 'N/A') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $report->scheduled_at ? \Carbon\Carbon::parse($report->scheduled_at)->format('M d, Y') : 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button type="button" class="p-1.5 text-blue-700 hover:bg-gray-100 rounded-full transition" title="View" onclick="openSpayModal({{ $report->id }})">
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
