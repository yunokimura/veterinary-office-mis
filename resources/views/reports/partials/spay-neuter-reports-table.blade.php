<table class="w-full text-sm">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Scheduled</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned Vet</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($reports as $report)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 text-gray-600">
                @php
                    $scheduled = $report->scheduled_at ? \Carbon\Carbon::parse($report->scheduled_at) : null;
                @endphp
                <div class="text-sm font-medium text-gray-900 whitespace-nowrap">{{ $scheduled ? $scheduled->format('M d, Y') : 'N/A' }}</div>
                <div class="text-xs text-gray-500 whitespace-nowrap">{{ $scheduled ? $scheduled->format('h:i A') : 'N/A' }}</div>
            </td>
            <td class="px-4 py-3 text-gray-600">
                <div>
                    <div class="text-sm font-medium text-gray-900 whitespace-nowrap">{{ $report->pet_name }}</div>
                    <div class="text-xs text-gray-500 whitespace-nowrap">{{ ucfirst($report->pet_species ?? '') }} • {{ $report->pet_breed ?? 'N/A' }}</div>
                </div>
            </td>
            <td class="px-4 py-3">
                <div class="text-sm font-medium text-gray-900 whitespace-nowrap">{{ $report->owner_name }}</div>
                <div class="text-xs text-gray-500 whitespace-nowrap">{{ $report->owner_contact ?? 'N/A' }}</div>
            </td>
            <td class="px-4 py-3 text-sm text-gray-600">
                <button type="button" class="inline-flex items-center gap-1 hover:text-green-700 transition" onclick="editSpayNeuter({{ $report->id }})">
                    <span>{{ $report->veterinarian ?? 'N/A' }}</span>
                    <i class="bi bi-chevron-down text-xs"></i>
                </button>
            </td>
            <td class="px-4 py-3">
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'scheduled' => 'bg-blue-100 text-blue-700',
                        'completed' => 'bg-green-100 text-green-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                    ];
                @endphp
                <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$report->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ ucwords(str_replace('_', ' ', $report->status)) }}
                </span>
            </td>
            <td class="px-4 py-3 text-center">
                <div class="flex items-center justify-center gap-1">
                    <button type="button" class="p-1.5 text-blue-700 hover:bg-gray-100 rounded-full transition" title="View" onclick="openSpayNeuterModal({{ $report->id }})">
                        <i class="bi bi-eye text-lg"></i>
                    </button>
                    <button type="button" class="p-1.5 text-indigo-700 hover:bg-gray-100 rounded-full transition" title="Edit" onclick="editSpayNeuter({{ $report->id }})">
                        <i class="bi bi-pencil text-lg"></i>
                    </button>
                    <form action="{{ route('spay-neuter.reports.destroy', $report->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this report?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-red-600 hover:bg-gray-100 rounded-full transition" title="Delete">
                            <i class="bi bi-trash text-lg"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                <i class="bi bi-calendar-x text-4xl mb-2 block"></i>
                No spay/neuter reports found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
