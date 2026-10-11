<?php
$file = 'C:/Users/Admin/Laravel-MIS-dev/resources/views/Client/pet_registration_form.blade.php';
$content = file_get_contents($file);

// Find and remove the Owner's Information section in review step
$oldSection = <<<'OLD'
                                <!-- Review: Owner's Information -->
                                <div>
                                    <h5 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Owner's Information
                                    </h5>
                                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 divide-y divide-slate-100">
                                        <div class="flex items-start justify-between gap-4 py-2">
                                            <span class="text-xs text-gray-500">Pet Owner Name</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">{{ $petOwner->first_name ?? '' }} {{ $petOwner && $petOwner->middle_name ? $petOwner->middle_name . ' ' : '' }}{{ $petOwner->last_name ?? '' }}</span>
                                        </div>
                                        <div class="flex items-start justify-between gap-4 py-2">
                                            <span class="text-xs text-gray-500">Email</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right break-all">{{ $petOwner->email ?? $user->email ?? '' }}</span>
                                        </div>
                                        <div class="flex items-start justify-between gap-4 py-2">
                                            <span class="text-xs text-gray-500">Primary</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">+63 {{ $petOwner->phone_number ?? '' }}</span>
                                        </div>
                                        <div class="flex items-start justify-between gap-4 py-2">
                                            <span class="text-xs text-gray-500">Address</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">
                                                {{ $petOwner->address->block_lot_phase ?? $petOwner->blk_lot_ph ?? '' }}, {{ $petOwner->address->street ?? $petOwner->street ?? '' }}, {{ $petOwner->address->barangay->barangay_name ?? $petOwner->barangay ?? '' }}, Dasmariñas City
                                            </span>
                                        </div>
                                        <div class="flex items-start justify-between gap-4 py-2">
                                            <span class="text-xs text-gray-500">Alternate Mobile Number</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">+63 {{ $petOwner->alternate_phone_number ?? '' }}</span>
                                        </div>
                                    </div>
                                </div>
OLD;

if (strpos($content, $oldSection) !== false) {
    $content = str_replace($oldSection, '', $content);
    file_put_contents('C:/Users/Admin/Laravel-MIS-dev/resources/views/Client/pet_registration_form.blade.php', $content);
    echo "Owner's Information section removed successfully!\n";
} else {
    echo "Section not found - checking content...\n";
    // Let's find what's there
    $pos = strpos($content, "Owner's Information");
    if ($pos !== false) {
        echo "Found at position: $pos\n";
        echo substr($content, $pos, 500) . "\n";
    } else {
        echo "Not found at all\n";
    }
}