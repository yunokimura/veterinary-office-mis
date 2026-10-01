<table class="w-full text-sm">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Scheduled</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient (Pet)</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned Vet</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($appointments as $appointment)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 text-gray-600">
                @php
                    $scheduled = \Carbon\Carbon::parse($appointment->scheduled_at);
                @endphp
                <div class="text-sm font-medium text-gray-900">{{ $scheduled->format('M d, Y') }}</div>
                <div class="text-xs text-gray-500">{{ $scheduled->format('h:i A') }}</div>
            </td>
            <td class="px-4 py-3 text-gray-600">
                @if($appointment->pet)
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $appointment->pet->pet_name }}</div>
                        <div class="text-xs text-gray-500">{{ $appointment->pet->species }} • {{ $appointment->pet->breed }}</div>
                    </div>
                @else
                    <span class="text-gray-400">N/A</span>
                @endif
            </td>
            <td class="px-4 py-3">
                <div class="text-sm font-medium text-gray-900">{{ $appointment->owner_name }}</div>
                <div class="text-xs text-gray-500">{{ $appointment->user->contact_number ?? 'N/A' }}</div>
            </td>
            <td class="px-4 py-3 text-sm text-gray-600">
                <button type="button" class="inline-flex items-center gap-1 hover:text-green-700 transition" onclick="editAppointment({{ $appointment->id }})">
                    <span>{{ $appointment->assigned_vet_name }}</span>
                    <i class="bi bi-chevron-down text-xs"></i>
                </button>
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
            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                <i class="bi bi-calendar-x text-4xl mb-2 block"></i>
                No vaccination appointments found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
