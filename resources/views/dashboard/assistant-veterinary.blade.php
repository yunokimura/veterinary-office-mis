@extends('layouts.admin')

@section('title', 'Assistant Veterinary Dashboard')

@section('header', 'Assistant Veterinary Dashboard')
@section('subheader', 'Manage Spay/Neuter (Kapon) Appointments')

@section('content')
@php
    $hour = date('H');
    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Good morning';
    } elseif ($hour >= 12 && $hour < 18) {
        $greeting = 'Good afternoon';
    } else {
        $greeting = 'Good evening';
    }
@endphp

<!-- ==============================
     QUICK ACTIONS
     ============================== -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('spay-neuter.reports.create') }}" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-plus-circle text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">New Kapon</span>
        </a>

        <a href="{{ route('spay-neuter.reports.index') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-list-check text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Kapon Records</span>
        </a>

        <a href="{{ route('spay-neuter.reports.create') }}" class="flex flex-col items-center p-4 bg-pink-50 hover:bg-pink-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-pink-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-gender-female text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">New Spay</span>
        </a>

        <a href="{{ route('spay-neuter.reports.create') }}" class="flex flex-col items-center p-4 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-gender-male text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">New Neuter</span>
        </a>
    </div>
</div>

<!-- ==============================
     SPAY/NEUTER (KAPON) SECTION
     ============================== -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="bi bi-heart mr-2 text-purple-600"></i>Spay/Neuter (Kapon) Appointments
        </h3>
        <a href="{{ route('spay-neuter.reports.index') }}" class="text-sm text-green-600 hover:text-green-800">
            View All <i class="bi bi-arrow-right ml-1"></i>
        </a>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-purple-600 font-medium">Total ({{ $year }})</p>
                    <p class="text-2xl font-bold text-purple-700">{{ $kaponStats['total'] }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-200 rounded-lg flex items-center justify-center">
                    <i class="bi bi-heart text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-yellow-600 font-medium">Pending</p>
                    <p class="text-2xl font-bold text-yellow-700">{{ $kaponStats['pending'] }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-200 rounded-lg flex items-center justify-center">
                    <i class="bi bi-clock text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-blue-600 font-medium">Scheduled</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $kaponStats['scheduled'] }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-200 rounded-lg flex items-center justify-center">
                    <i class="bi bi-calendar-check text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-green-600 font-medium">Completed</p>
                    <p class="text-2xl font-bold text-green-700">{{ $kaponStats['completed'] }}</p>
                </div>
                <div class="w-10 h-10 bg-green-200 rounded-lg flex items-center justify-center">
                    <i class="bi bi-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Procedure Type Breakdown & Schedule Info -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Procedure Breakdown</p>
            <div class="mt-2 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600"><i class="bi bi-gender-female text-pink-500 mr-1"></i>Spay</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $kaponByType['spay'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600"><i class="bi bi-gender-male text-blue-500 mr-1"></i>Neuter</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $kaponByType['neuter'] }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Today's Schedule</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $kaponStats['today'] }}</p>
            <p class="text-xs text-gray-500">appointments today</p>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">This Week</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $kaponStats['this_week'] }}</p>
            <p class="text-xs text-gray-500">appointments this week</p>
        </div>
    </div>

    <!-- Recent Kapon Appointments -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pet Name</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Procedure</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Scheduled</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentKapon as $report)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 text-gray-900 font-medium">{{ $report->pet_name }}</td>
                    <td class="px-3 py-2 text-gray-600">{{ $report->owner_name }}</td>
                    <td class="px-3 py-2">
                        <span class="px-2 py-1 text-xs rounded-full {{ $report->procedure_type === 'spay' ? 'bg-pink-100 text-pink-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($report->procedure_type) }}
                        </span>
                    </td>
                    <td class="px-3 py-2 text-gray-600">{{ $report->scheduled_at ? \Carbon\Carbon::parse($report->scheduled_at)->format('M d, Y') : 'N/A' }}</td>
                    <td class="px-3 py-2">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'scheduled' => 'bg-blue-100 text-blue-700',
                                'completed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$report->status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($report->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-3 py-4 text-center text-gray-500">No kapon records found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ==============================
     MONTHLY TREND CHART
     ============================== -->
<div class="grid grid-cols-1 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-base font-semibold text-gray-800 mb-4">
            <i class="bi bi-graph-up mr-2 text-purple-600"></i>Kapon Monthly Trend
        </h3>
        <div class="h-64">
            <canvas id="kaponChart"></canvas>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthLabels = Array.from({length: 12}, (_, i) => {
        const date = new Date({{ date('Y') }}, i, 1);
        return date.toLocaleString('default', { month: 'short' });
    });

    // Kapon Monthly Data
    const kaponData = @json($monthlyKapon ?? []);
    const kaponChartData = monthLabels.map((_, i) => kaponData[i + 1] || 0);

    const kaponCtx = document.getElementById('kaponChart').getContext('2d');
    new Chart(kaponCtx, {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Kapon Appointments',
                data: kaponChartData,
                backgroundColor: '#8b5cf6',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endpush