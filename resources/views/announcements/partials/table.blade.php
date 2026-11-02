@php
    $statusColors = [
        'Published' => 'bg-green-100 text-green-800',
        'Scheduled' => 'bg-yellow-100 text-yellow-800',
        'Draft' => 'bg-gray-100 text-gray-800',
        'Archived' => 'bg-gray-100 text-gray-800'
    ];
@endphp
<div class="overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Announcement</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($announcements as $announcement)
                <tr class="hover:bg-gray-50" data-id="{{ $announcement->id }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                @if($announcement->photo_path)
                                    <img src="{{ $announcement->photo_url }}" alt="{{ $announcement->title }}" class="h-10 w-10 rounded-lg object-cover">
                                @else
                                    <i class="bi bi-image text-gray-400"></i>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $announcement->title }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                            {{ ucfirst($announcement->category) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold {{ $statusColors[$announcement->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $announcement->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="previewAnnouncement({{ $announcement->id }})" class="text-gray-600 hover:text-gray-900 p-1" title="Preview">
                                <i class="bi bi-eye"></i>
                            </button>
                            <a href="{{ route($rolePrefix . '.announcements.edit', $announcement) }}" class="text-green-600 hover:text-green-900 p-1" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button onclick="duplicateAnnouncement({{ $announcement->id }})" class="text-blue-600 hover:text-blue-900 p-1" title="Duplicate">
                                <i class="bi bi-copy"></i>
                            </button>
                            <form action="{{ route($rolePrefix . '.announcements.destroy', $announcement) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this announcement? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 p-1" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="bi bi-megaphone text-3xl text-gray-400"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-2">No Announcements Found</h4>
                            <p class="text-gray-500">No announcements match your current filters.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
