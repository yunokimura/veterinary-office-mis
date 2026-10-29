<table class="w-full text-sm">
    <thead>
        <tr class="border-b border-gray-100">
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Item Name</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Category</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Quantity</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Unit Cost</th>
            <th class="px-4 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Status</th>
            <th class="px-4 py-4 text-right text-xs font-medium text-slate-400 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @forelse($items as $item)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-4 text-gray-600">
                <span class="font-medium text-gray-900">{{ $item->item_name }}</span>
            </td>
            <td class="px-4 py-4 text-sm text-gray-700">{{ ucfirst($item->category) }}</td>
            <td class="px-4 py-4">
                <span class="{{ $item->isLowStock() ? 'font-medium text-red-600' : 'text-sm text-gray-600' }}">
                    {{ $item->quantity }}
                </span>
            </td>
            <td class="px-4 py-4 text-sm text-gray-600">
                ₱{{ number_format($item->unit_cost ?? 0, 2) }}
            </td>
            <td class="px-4 py-4">
                @php
                    $rawStatus = strtolower($item->status ?? 'active');
                    $statusColors = [
                        'active' => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                        'inactive' => 'bg-gray-50 text-gray-600 border border-gray-100',
                        'out_of_stock' => 'bg-red-50 text-red-600 border border-red-100',
                        'out of stock' => 'bg-red-50 text-red-600 border border-red-100',
                    ];
                @endphp
                <span class="px-2.5 py-0.5 text-xs rounded-full border whitespace-nowrap {{ $statusColors[$rawStatus] ?? 'bg-gray-50 text-gray-600 border border-gray-100' }}">
                    {{ ucwords(str_replace('_', ' ', $item->status ?? 'Active')) }}
                </span>
            </td>
            <td class="px-4 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin-asst.inventory.show', $item) }}" 
                       class="p-1.5 text-gray-500 hover:text-cyan-600 hover:bg-cyan-50 rounded-full transition" title="View">
                        <i class="bi bi-eye text-sm"></i>
                    </a>
                    <a href="{{ route('admin-asst.inventory.edit', $item) }}" 
                       class="p-1.5 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-full transition" title="Edit">
                        <i class="bi bi-pencil text-sm"></i>
                    </a>
                    <form action="{{ route('admin-asst.inventory.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this item?')">
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
            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                <i class="bi bi-box text-4xl mb-2 block"></i>
                No inventory items found
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
