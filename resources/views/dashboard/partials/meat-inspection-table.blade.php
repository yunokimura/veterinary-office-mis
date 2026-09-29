<table class="w-full text-sm">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Establishment Name</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barangay</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($establishments as $establishment)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-shop text-orange-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $establishment->establishment_name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">{{ $establishment->address_text ?? '' }}</p>
                    </div>
                </div>
            </td>
            <td class="px-4 py-3 text-gray-600">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 capitalize whitespace-nowrap">
                    {{ str_replace('_', ' ', $establishment->establishment_type ?? 'N/A') }}
                </span>
            </td>
            <td class="px-4 py-3 text-gray-600">
                <span class="font-medium text-gray-800">{{ $establishment->owner_name ?? 'N/A' }}</span>
            </td>
            <td class="px-4 py-3 text-gray-600">
                <span class="text-gray-700">{{ $establishment->barangay->barangay_name ?? 'N/A' }}</span>
            </td>
            <td class="px-4 py-3">
                @php
                    $statusColors = [
                        'Active' => 'bg-green-100 text-green-800',
                        'Expired' => 'bg-red-100 text-red-800',
                        'Pending Inspection' => 'bg-yellow-100 text-yellow-800',
                    ];
                @endphp
                <span class="px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap {{ $statusColors[$establishment->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $establishment->status ?? 'Unknown' }}
                </span>
            </td>
            <td class="px-4 py-3 text-center">
                <button type="button" class="p-1.5 text-blue-700 hover:bg-gray-100 rounded-full transition" title="View" onclick="openEstablishmentModal({{ $establishment->establishment_id }})">
                    <i class="bi bi-eye text-lg"></i>
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                <i class="bi bi-search text-4xl mb-2 block"></i>
                No meat establishments found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
