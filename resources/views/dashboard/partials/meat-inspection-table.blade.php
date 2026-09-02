@foreach($establishments as $establishment)
<tr>
    <td class="px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="bi bi-shop text-orange-600"></i>
            </div>
            <div>
                <p class="font-medium text-gray-800">{{ $establishment->establishment_name }}</p>
                <p class="text-sm text-gray-500">{{ $establishment->address_text }}</p>
            </div>
        </div>
    </td>
    <td class="px-6 py-4">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 capitalize">
            {{ str_replace('_', ' ', $establishment->establishment_type ?? 'N/A') }}
        </span>
    </td>
    <td class="px-6 py-4">
        <span class="font-medium text-gray-800">{{ $establishment->owner_name ?? 'N/A' }}</span>
    </td>
    <td class="px-6 py-4">
        <span class="text-gray-700">{{ $establishment->barangay->barangay_name ?? 'N/A' }}</span>
    </td>
    <td class="px-6 py-4">
        @php
            $statusColors = [
                'Active' => 'bg-green-100 text-green-700 border-green-200',
                'Expired' => 'bg-red-100 text-red-700 border-red-200',
                'Pending Inspection' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            ];
        @endphp
        <span class="px-3 py-1 rounded-full text-xs font-medium border whitespace-nowrap {{ $statusColors[$establishment->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
            {{ $establishment->status ?? 'Unknown' }}
        </span>
    </td>
    <td class="px-6 py-4">
        <button onclick="openEstablishmentModal({{ $establishment->establishment_id }})"
                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition">
            <i class="bi bi-eye"></i>View
        </button>
    </td>
</tr>
@endforeach
