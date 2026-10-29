<table class="w-full text-sm">
    <thead>
        <tr class="border-b border-gray-100">
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Owner</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Contact</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Pets</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Registered</th>
            <th class="px-4 py-4 text-right text-xs font-medium text-slate-400 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @forelse($owners as $owner)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-4 text-gray-600">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-person-fill text-blue-500"></i>
                    </div>
                    <div>
                        <span class="font-medium text-gray-900">{{ $owner->name }}</span>
                        <div class="text-xs text-gray-400">{{ $owner->email ?? 'N/A' }}</div>
                    </div>
                </div>
            </td>
            <td class="px-4 py-4 text-sm {{ $owner->contact_number ? 'text-gray-900' : 'text-gray-400' }}">{{ $owner->contact_number ?? 'N/A' }}</td>
            <td class="px-4 py-4">
                <span class="inline-flex items-center gap-1.5 text-xs text-gray-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    {{ $owner->pets_count }} pet(s)
                </span>
            </td>
            <td class="px-4 py-4 text-sm text-gray-400">{{ optional($owner->created_at)->format('M d, Y') ?? 'N/A' }}</td>
            <td class="px-4 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin-asst.owners.show', $owner) }}" 
                       class="p-1.5 text-gray-500 hover:text-cyan-600 hover:bg-cyan-50 rounded-full transition" title="View">
                        <i class="bi bi-eye text-sm"></i>
                    </a>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                <i class="bi bi-inbox text-4xl mb-2 block"></i>
                No pet owners found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
