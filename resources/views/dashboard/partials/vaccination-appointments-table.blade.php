<table class="w-full text-sm">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pets</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Scheduled</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($appointments as $appointment)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">
                <div class="font-medium text-gray-900">{{ $appointment->owner_name }}</div>
                <div class="text-sm text-gray-500">{{ $appointment->user->name ?? 'N/A' }}</div>
            </td>
            <td class="px-4 py-3 text-gray-600">
                @php
                    $pets = $appointment->selected_pets ?? [];
                    $petNames = array_slice($pets, 0, 2);
                    $petCount = count($pets);
                @endphp
                @if(count($petNames) > 0)
                    <div class="text-sm">
                        {{ implode(', ', array_column($petNames, 'name')) }}
                        @if($petCount > 2)
                            <span class="text-gray-400">+{{ $petCount - 2 }} more</span>
                        @endif
                    </div>
                @else
                    <span class="text-gray-400">N/A</span>
                @endif
            </td>
            <td class="px-4 py-3 text-gray-600">
                {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('M d, Y h:i A') }}
            </td>
            <td class="px-4 py-3">
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'approved' => 'bg-green-100 text-green-700',
                        'completed' => 'bg-blue-100 text-blue-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                        'no_show' => 'bg-gray-100 text-gray-700',
                    ];
                @endphp
                <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ ucwords(str_replace('_', ' ', $appointment->status)) }}
                </span>
            </td>
            <td class="px-4 py-3 text-center">
                <div class="flex items-center justify-center gap-1">
                    <button type="button" class="p-1.5 text-blue-700 hover:bg-gray-100 rounded-full transition" title="View" onclick="viewAppointment({{ $appointment->id }})">
                        <i class="bi bi-eye text-lg"></i>
                    </button>
                    <button type="button" class="p-1.5 text-green-700 hover:bg-gray-100 rounded-full transition" title="Approve" onclick="approveAppointment({{ $appointment->id }})">
                        <i class="bi bi-check-circle text-lg"></i>
                    </button>
                    <button type="button" class="p-1.5 text-indigo-700 hover:bg-gray-100 rounded-full transition" title="Edit" onclick="editAppointment({{ $appointment->id }})">
                        <i class="bi bi-pencil text-lg"></i>
                    </button>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                <i class="bi bi-calendar-x text-4xl mb-2 block"></i>
                No vaccination appointments found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
