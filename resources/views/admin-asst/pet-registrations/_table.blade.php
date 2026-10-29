<table class="w-full text-sm">
    <thead>
        <tr class="border-b border-gray-100">
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Pet Name</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Species</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Gender</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Breed</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Owner</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Status</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Registered</th>
            <th class="px-4 py-4 text-right text-xs font-medium text-slate-400 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @forelse($pets as $pet)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-4 text-gray-600">
                <span class="font-medium text-gray-900">{{ $pet->name }}</span>
            </td>
            <td class="px-4 py-4 text-gray-600">
                <span class="inline-flex items-center gap-1.5 text-xs text-gray-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    {{ ucfirst($pet->species) }}
                </span>
            </td>
            <td class="px-4 py-4 text-gray-600">
                @if($pet->gender == 'male')
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                        Male
                    </span>
                @elseif($pet->gender == 'female')
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-pink-400"></span>
                        Female
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                        Unknown
                    </span>
                @endif
            </td>
            <td class="px-4 py-4 text-sm text-gray-700">{{ $pet->breed }}</td>
            <td class="px-4 py-4">
                <span class="text-sm {{ $pet->userOwner ? 'text-gray-900' : 'text-gray-400' }}">{{ $pet->userOwner ? $pet->userOwner->name : 'N/A' }}</span>
            </td>
            <td class="px-4 py-4">
                @php
                    $petStatusColors = [
                        'owned' => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                        'pending' => 'bg-amber-50 text-amber-600 border border-amber-100',
                        'for adoption' => 'bg-blue-50 text-blue-600 border border-blue-100',
                        'registered' => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                    ];
                @endphp
                <span class="px-2.5 py-0.5 text-xs rounded-full border {{ $petStatusColors[strtolower($pet->pet_status ?? 'registered')] ?? 'bg-gray-50 text-gray-600 border border-gray-100' }}">
                    {{ ucwords(str_replace('_', ' ', $pet->pet_status ?? 'Registered')) }}
                </span>
            </td>
            <td class="px-4 py-4 text-sm text-gray-400">{{ $pet->created_at->format('M d, Y') }}</td>
            <td class="px-4 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin-asst.pet-registrations.show', $pet) }}" 
                       class="p-1.5 text-gray-500 hover:text-cyan-600 hover:bg-cyan-50 rounded-full transition" title="View">
                        <i class="bi bi-eye text-sm"></i>
                    </a>
                    <a href="{{ route('admin-asst.pet-registrations.edit', $pet) }}" 
                       class="p-1.5 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-full transition" title="Edit">
                        <i class="bi bi-pencil text-sm"></i>
                    </a>
                    <form action="{{ route('admin-asst.pet-registrations.destroy', $pet) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-full transition" title="Delete">
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
