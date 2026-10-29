<table class="w-full text-sm">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet Name</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Species</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Breed</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registered</th>
            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($pets as $pet)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 text-gray-600">
                <span class="font-medium text-gray-900">{{ $pet->name }}</span>
            </td>
            <td class="px-4 py-3 text-gray-600">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800">
                    {{ ucfirst($pet->species) }}
                </span>
            </td>
            <td class="px-4 py-3 text-gray-600">
                @if($pet->gender == 'male')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <i class="bi bi-gender-male me-1"></i>Male
                    </span>
                @elseif($pet->gender == 'female')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                        <i class="bi bi-gender-female me-1"></i>Female
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Unknown
                    </span>
                @endif
            </td>
            <td class="px-4 py-3 text-sm text-gray-700">{{ $pet->breed }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">{{ $pet->userOwner ? $pet->userOwner->name : 'N/A' }}</td>
            <td class="px-4 py-3">
                @php
                    $petStatusColors = [
                        'owned' => 'bg-emerald-100 text-emerald-800',
                        'pending' => 'bg-amber-100 text-amber-800',
                        'for adoption' => 'bg-blue-100 text-blue-800',
                        'registered' => 'bg-emerald-100 text-emerald-800',
                    ];
                @endphp
                <span class="px-2 py-1 text-xs rounded-full {{ $petStatusColors[strtolower($pet->pet_status ?? 'registered')] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ ucwords(str_replace('_', ' ', $pet->pet_status ?? 'Registered')) }}
                </span>
            </td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $pet->created_at->format('M d, Y') }}</td>
            <td class="px-4 py-3 text-right">
                <div class="flex items-center justify-end gap-1">
                    <a href="{{ route('admin-asst.pet-registrations.show', $pet) }}" 
                       class="p-1.5 text-cyan-700 hover:bg-gray-100 rounded-full transition" title="View">
                        <i class="bi bi-eye text-sm"></i>
                    </a>
                    <a href="{{ route('admin-asst.pet-registrations.edit', $pet) }}" 
                       class="p-1.5 text-amber-700 hover:bg-gray-100 rounded-full transition" title="Edit">
                        <i class="bi bi-pencil text-sm"></i>
                    </a>
                    <form action="{{ route('admin-asst.pet-registrations.destroy', $pet) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-red-700 hover:bg-gray-100 rounded-full transition" title="Delete">
                            <i class="bi bi-trash text-sm"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                <i class="bi bi-inbox text-4xl mb-2 block"></i>
                No pet registrations found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
