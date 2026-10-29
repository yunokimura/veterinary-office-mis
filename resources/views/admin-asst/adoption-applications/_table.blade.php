<table class="w-full text-sm">
    <thead>
        <tr class="border-b border-gray-100">
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Applicant</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Contact</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Address</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Status</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Rejection Reason</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Submitted</th>
            <th class="px-4 py-4 text-right text-xs font-medium text-slate-400 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @forelse($applications as $application)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-4 text-gray-600">
                <span class="font-medium text-gray-900">{{ $application->full_name }}</span>
            </td>
            <td class="px-4 py-4 text-gray-600">
                <div class="text-sm text-gray-700">{{ $application->email }}</div>
                <div class="text-xs text-gray-400">{{ $application->mobile_number }}</div>
            </td>
            <td class="px-4 py-4">
                <span class="text-sm {{ $application->full_address !== 'N/A' ? 'text-gray-900' : 'text-gray-400' }}">{{ $application->full_address }}</span>
            </td>
            <td class="px-4 py-4">
                @php
                    $appStatusColors = [
                        'pending_review' => 'bg-amber-50 text-amber-600 border border-amber-100',
                        'approved' => 'bg-blue-50 text-blue-600 border border-blue-100',
                        'rejected' => 'bg-red-50 text-red-600 border border-red-100',
                        'adopted' => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                    ];
                @endphp
                <span class="px-2.5 py-0.5 text-xs rounded-full border whitespace-nowrap {{ $appStatusColors[strtolower($application->status ?? 'pending_review')] ?? 'bg-gray-50 text-gray-600 border border-gray-100' }}">
                    {{ ucwords(str_replace('_', ' ', $application->status ?? 'Pending Review')) }}
                </span>
            </td>
            <td class="px-4 py-4">
                @if($application->status == 'rejected' && $application->rejection_reason)
                    <span title="{{ $application->rejection_reason }}" class="text-xs text-gray-600 cursor-help">
                        <i class="bi bi-info-circle me-1"></i>Provided
                    </span>
                @else
                    <span class="text-xs text-gray-400">-</span>
                @endif
            </td>
            <td class="px-4 py-4 text-sm text-gray-400">{{ optional($application->created_at)->format('M d, Y') ?? 'N/A' }}</td>
            <td class="px-4 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin-asst.adoption-applications.show', $application) }}" 
                       class="p-1.5 text-gray-500 hover:text-cyan-600 hover:bg-cyan-50 rounded-full transition" title="View">
                        <i class="bi bi-eye text-sm"></i>
                    </a>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                <i class="bi bi-inbox text-4xl mb-2 block"></i>
                No adoption applications found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
