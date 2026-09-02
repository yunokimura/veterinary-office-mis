@foreach($reports as $report)
<tr>
    <td class="px-6 py-4">
        <span class="font-medium text-gray-800">RV-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
    </td>
    <td class="px-6 py-4 text-gray-800">{{ $report->clinic_name ?? 'N/A' }}</td>
    <td class="px-6 py-4 text-gray-800">{{ $report->vaccine_brand ?? 'N/A' }}</td>
    <td class="px-6 py-4 text-gray-800">{{ $report->pet_species ?? 'N/A' }}</td>
    <td class="px-6 py-4 text-gray-600">{{ $report->vaccination_date ? \Carbon\Carbon::parse($report->vaccination_date)->format('M d, Y') : 'N/A' }}</td>
    <td class="px-6 py-4">
        <button onclick="openVaccinationModal({{ $report->id }})"
                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition">
            <i class="bi bi-eye"></i>View
        </button>
    </td>
</tr>
@endforeach
