<table class="w-full">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vaccine</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Animal Type</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($reports as $report)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="font-medium text-gray-800">RV-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-800">
                    {{ $report->pet_name ?? 'N/A' }}
                    @if($report->pet_gender)
                        @if(strtolower($report->pet_gender) == 'male')
                            <i class="bi bi-gender-male text-blue-500 ml-1"></i>
                        @elseif(strtolower($report->pet_gender) == 'female')
                            <i class="bi bi-gender-female text-pink-500 ml-1"></i>
                        @endif
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-800">{{ $report->vaccine_brand ?? 'N/A' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-800">{{ ucfirst($report->pet_species) ?? 'N/A' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-800">{{ $report->pet?->owner ? trim(($report->pet->owner->first_name ?? '') . ' ' . ($report->pet->owner->last_name ?? '')) : 'N/A' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $report->vaccination_date ? \Carbon\Carbon::parse($report->vaccination_date)->format('M d, Y') : 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button type="button" class="p-1.5 text-blue-700 hover:bg-gray-100 rounded-full transition" title="View" onclick="openVaccinationModal({{ $report->id }})">
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
