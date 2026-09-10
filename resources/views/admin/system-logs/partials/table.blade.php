<div class="overflow-x-auto">
    <table class="w-full table-fixed">
        <colgroup>
            <col class="w-[4%]">
            <col class="w-[18%]">
            <col class="min-w-[220px]">
            <col class="w-[13%]">
            <col class="w-[25%]">
            <col class="w-[10%]">
            <col class="w-[10%]">
        </colgroup>
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 z-20 bg-gray-50 border-r border-gray-200">ID</th>
                <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">User</th>
                <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[220px]">Action</th>
                <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Date & Time</th>
                <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Description</th>
                <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">IP Address</th>
                <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($logs as $log)
                <tr class="log-row hover:bg-gray-50 cursor-pointer" data-log-id="{{ $log->id }}">
                    <td class="px-4 py-[18px] whitespace-nowrap text-sm text-gray-600 leading-[1.5] sticky left-0 z-10 border-r border-gray-200 bg-white hover:bg-gray-50">{{ $log->user_id ?? '-' }}</td>
                    <td class="px-4 py-[18px] whitespace-nowrap hidden md:table-cell">
                        <div class="flex items-center gap-2 whitespace-nowrap">
                            <div class="inline-flex w-8 h-8 min-w-[32px] items-center justify-center rounded-full bg-[#e8f0fe]">
                                <i class="bi bi-person text-blue-600"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-800 leading-[1.5] whitespace-nowrap overflow-hidden text-ellipsis">{{ $log->user->name ?? 'System' }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-[18px] whitespace-nowrap text-sm text-gray-700 leading-[1.5] min-w-[220px]">
                        <span class="inline-flex items-center gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $log->module_display }}
                            </span>
                            <span>{{ $log->action_display }}</span>
                        </span>
                    </td>
                    <td class="px-4 py-[18px] whitespace-nowrap text-sm text-gray-600 leading-[1.5] hidden md:table-cell">{{ $log->created_at }}</td>
                    <td class="px-4 py-[18px] hidden md:table-cell">
                        <span class="text-sm text-gray-600 whitespace-nowrap overflow-hidden text-ellipsis block leading-[1.5]" title="{{ $log->description }}">{{ Str::limit($log->description, 50) }}</span>
                    </td>
                    <td class="px-4 py-[18px] whitespace-nowrap text-sm text-gray-600 font-mono leading-[1.5] hidden md:table-cell">{{ $log->ip_address ?? 'N/A' }}</td>
                    <td class="px-4 py-[18px] whitespace-nowrap text-sm leading-[1.5]">
                        @if($log->status == 'success')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="bi bi-check-circle mr-1"></i> Success
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="bi bi-x-circle mr-1"></i> Failed
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No system logs found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
