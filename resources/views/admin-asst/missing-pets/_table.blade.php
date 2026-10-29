<table class="w-full text-sm">
    <thead>
        <tr class="border-b border-gray-100">
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Pet Name</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Species</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Status</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Last Seen</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Barangay</th>
            <th class="px-4 py-4 text-right text-xs font-medium text-slate-400 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @forelse($missingPets as $report)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-4 text-gray-600">
                <span class="font-medium text-gray-900">{{ $report->pet ? $report->pet->pet_name : 'Unknown Pet' }}</span>
            </td>
            <td class="px-4 py-4 text-gray-600">
                <span class="text-sm {{ $report->pet ? 'text-gray-900' : 'text-gray-400' }}">{{ $report->pet ? ucfirst($report->pet->species ?? 'Unknown') : 'Unknown' }}</span>
            </td>
            <td class="px-4 py-4">
                @php
                    $reportStatusColors = [
                        'pending review' => 'bg-amber-50 text-amber-600 border border-amber-100',
                        'approved' => 'bg-blue-50 text-blue-600 border border-blue-100',
                        'rejected' => 'bg-red-50 text-red-600 border border-red-100',
                        'resolved - reunited' => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                        'resolved - shelter intake' => 'bg-blue-50 text-blue-600 border border-blue-100',
                        'closed - expired' => 'bg-gray-50 text-gray-600 border border-gray-100',
                        'closed - cancelled' => 'bg-red-50 text-red-600 border border-red-100',
                        'closed - duplicate' => 'bg-gray-50 text-gray-600 border border-gray-100',
                    ];
                @endphp
                <span class="px-2.5 py-0.5 text-xs rounded-full border whitespace-nowrap {{ $reportStatusColors[strtolower($report->status ?? 'pending review')] ?? 'bg-gray-50 text-gray-600 border border-gray-100' }}">
                    {{ ucwords(str_replace('_', ' ', $report->status ?? 'Pending Review')) }}
                </span>
            </td>
            <td class="px-4 py-4 text-sm text-gray-400">{{ optional($report->last_seen_at)->format('M d, Y') ?? 'N/A' }}</td>
            <td class="px-4 py-4 text-sm text-gray-600">{{ $report->barangay ? $report->barangay->barangay_name : 'Unknown' }}</td>
            <td class="px-4 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin-asst.missing-pets.show', $report->report_id) }}" 
                       class="p-1.5 text-gray-500 hover:text-cyan-600 hover:bg-cyan-50 rounded-full transition" title="View">
                        <i class="bi bi-eye text-sm"></i>
                    </a>
                    @if($report->status == 'pending review')
                        <form action="{{ route('admin-asst.missing-pets.approve', $report->report_id) }}" method="POST" class="inline" onsubmit="return confirm('Approve this missing pet report?')">
                            @csrf
                            <button type="submit" class="p-1.5 text-green-600 hover:bg-green-50 rounded-full transition" title="Approve">
                                <i class="bi bi-check-circle text-sm"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin-asst.missing-pets.reject', $report->report_id) }}" method="POST" class="inline" onsubmit="return confirm('Reject this missing pet report?')">
                            @csrf
                            <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-full transition" title="Reject">
                                <i class="bi bi-x-circle text-sm"></i>
                            </button>
                        </form>
                    @endif
                    @if(in_array($report->status, ['approved', 'pending review']))
                        <form action="{{ route('admin-asst.missing-pets.mark-found', $report->report_id) }}" method="POST" class="inline" onsubmit="return confirm('Mark this pet as found/reunited?')">
                            @csrf
                            <button type="submit" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-full transition" title="Found">
                                <i class="bi bi-search text-sm"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin-asst.missing-pets.shelter-intake', $report->report_id) }}" method="POST" class="inline" onsubmit="return confirm('Mark this pet as shelter intake?')">
                            @csrf
                            <button type="submit" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-full transition" title="Shelter">
                                <i class="bi bi-house text-sm"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin-asst.missing-pets.duplicate', $report->report_id) }}" method="POST" class="inline" onsubmit="return confirm('Mark this report as duplicate?')">
                            @csrf
                            <button type="submit" class="p-1.5 text-gray-600 hover:bg-gray-50 rounded-full transition" title="Duplicate">
                                <i class="bi bi-copy text-sm"></i>
                            </button>
                        </form>
                    @endif
                    @if(in_array($report->status, ['approved']))
                        <form action="{{ route('admin-asst.missing-pets.close-expired', $report->report_id) }}" method="POST" class="inline" onsubmit="return confirm('Close this report as expired?')">
                            @csrf
                            <button type="submit" class="p-1.5 text-gray-600 hover:bg-gray-50 rounded-full transition" title="Expired">
                                <i class="bi bi-clock text-sm"></i>
                            </button>
                        </form>
                    @endif
                    @if(in_array($report->status, ['approved', 'pending review']))
                        <form action="{{ route('admin-asst.missing-pets.cancel', $report->report_id) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this missing pet report?')">
                            @csrf
                            <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-full transition" title="Cancel">
                                <i class="bi bi-x text-sm"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                <i class="bi bi-inbox text-4xl mb-2 block"></i>
                No missing pet reports found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
