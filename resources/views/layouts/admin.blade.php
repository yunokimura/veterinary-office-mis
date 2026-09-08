<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Dasmariñas City Veterinary Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#eef2ff',100:'#e0e7ff',200:'#c7d2fe',300:'#a5b4fc',400:'#818cf8',500:'#6366f1',600:'#4f46e5',700:'#4338ca',800:'#3730a3',900:'#312e81',950:'#1e1b4b' },
                        sidebar: { DEFAULT:'#0f172a',light:'#1e293b',hover:'#334155',active:'#1e40af' },
                        success: { DEFAULT:'#B2FBA5', hover:'#A2EFA0' },
                        green: { 70: '#86efac' }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }

        .sidebar {
            width: 220px;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 50;
            transition: transform 0.25s ease;
        }

        main {
            margin-left: 220px;
            min-height: 100vh;
        }

        .main-header {
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            border-radius: 8px;
            color: #fff;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.15s ease;
            text-decoration: none;
        }
        .nav-item:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .nav-item.active-nav {
            background: #15803d;
            color: #fff;
            box-shadow: 0 2px 8px rgba(21,128,61,0.35);
        }
        .nav-item i { width: 20px; text-align: center; font-size: 16px; flex-shrink: 0; }

        .sidebar-divider { height: 1px; background: rgba(255,255,255,0.1); margin: 12px 16px; }
        .sidebar-section-label {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #86efac;
            padding: 12px 16px 6px;
        }

        /* Custom Scrollbar Styling */
        nav::-webkit-scrollbar {
            width: 6px;
        }

        nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Firefox scrollbar */
        nav {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.05);
        }

        @media (max-width: 767px) {
            .sidebar { transform: translateX(-220px); }
            .sidebar.open { transform: translateX(0); }
            main { margin-left: 0; }
            .sidebar-overlay.active { display: block !important; }
        }
         .content-wrapper {
             padding: 1.5rem;
             background-color: #f8fafc;
             min-height: 100vh;
             display: flex;
             flex-direction: column;
         }
         @media (max-width: 767px) {
             .content-wrapper {
                 padding-top: calc(1.5rem + 56px);
             }
         }
    </style>
</head>

<body class="bg-slate-50 m-0 p-0 min-h-screen">
@php
    $role = auth()->check() ? auth()->user()->getRoleAttribute() : null;
@endphp

    <!-- Mobile Header -->
    <header class="md:hidden bg-white border-b border-slate-200 fixed w-full z-40">
        <div class="flex items-center justify-between px-4 h-14">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="p-1.5 rounded-lg hover:bg-slate-100">
                    <i class="bi bi-list text-xl text-slate-600"></i>
                </button>
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/Dasmalogof.png') }}" alt="Logo" class="w-7 h-7 rounded object-contain">
                    <span class="font-bold text-slate-800 text-sm">City Vet MIS</span>
                </div>
            </div>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="w-8 h-8 bg-brand-600 rounded-full flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-brand-400">
                    <span class="text-white text-xs font-bold">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                </button>
                <div x-show="open" @click.away="open = false"
                     class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border border-slate-200 z-50 py-1"
                     style="display: none;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-green-800 text-white">
        <!-- Brand -->
        <div class="flex items-center justify-start gap-3 px-3 h-16 border-b border-green-700">
            <img src="{{ asset('images/Dasmalogof.png') }}" alt="Logo" class="w-9 h-9 rounded-full object-contain ring-1 ring-white">
            <div class="min-w-0">
                <h1 class="font-bold text-[14px] leading-tight truncate">Dasmariñas City Vet</h1>
                <p class="text-[10px] text-green-200 leading-tight">Veterinary Office MIS</p>
            </div>
        </div>

        @php
            $role = auth()->check() ? auth()->user()->getRoleAttribute() : null;
            $routeMap = [
                'super_admin'      => 'super-admin',
                'city_vet'         => 'city-vet',
                'admin_asst'       => 'admin-asst',
                'assistant_vet'    => 'assistant-vet',
                'meat_inspector'   => 'meat-inspection',
                'pet_owner'          => 'owner',
            ];
            $prefix = $routeMap[$role] ?? 'admin';
            $dashboardRoute = $prefix . '.dashboard';
        @endphp

        <!-- Navigation -->
        <nav class="px-3 py-2 overflow-y-auto space-y-2" style="height: calc(100vh - 140px);">
            <a href="{{ route($dashboardRoute) }}"
               class="nav-item {{ request()->routeIs($prefix.'.dashboard') ? 'active-nav' : '' }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>

            @if(auth()->check() && auth()->user()->hasRole('super_admin'))

            <div x-data="{ open: @json(request()->routeIs('super-admin.users.*') || request()->routeIs('admin.users.*') || request()->routeIs('super-admin.roles.*')) }">
                <button @click="open = !open"
                        class="nav-item w-full justify-between {{ request()->routeIs('super-admin.users.*') || request()->routeIs('super-admin.roles.*') ? 'active-nav' : '' }}">
                    <span class="flex items-center gap-2 whitespace-nowrap">
                        <i class="bi bi-people"></i><span>User Management</span>
                    </span>
                    <i class="bi text-xs transition-transform duration-200"
                       :class="open ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-4 mt-1 mb-3 space-y-3">
                    <a href="{{ route('super-admin.users.index') }}" class="block text-sm rounded-md px-2 py-1 transition-colors {{ request()->routeIs('super-admin.users.*') || request()->routeIs('admin.users.*') ? 'text-white bg-white/10' : 'text-white hover:bg-white/10 hover:text-white' }}">
                        <i class="bi bi-person-lines-fill mr-2 text-xs"></i>All Users
                    </a>
                    <a href="javascript:void(0)" @click="openGlobalCreateUserModal()" class="block text-sm text-white hover:bg-white/10 hover:text-white rounded-md px-2 py-1 transition-colors">
                        <i class="bi bi-person-plus mr-2 text-xs"></i>Add New User
                    </a>
                    <a href="{{ route('super-admin.roles.index') }}" class="block text-sm rounded-md px-2 py-1 transition-colors {{ request()->routeIs('super-admin.roles.*') ? 'text-white bg-white/10' : 'text-white hover:bg-white/10 hover:text-white' }}">
                        <i class="bi bi-shield-lock mr-2 text-xs"></i>Roles & Permissions
                    </a>
                </div>
            </div>

            <a href="{{ route('super-admin.announcements.index') }}" class="nav-item {{ request()->routeIs('super-admin.announcements.*') ? 'active-nav' : '' }}">
                <i class="bi bi-megaphone"></i><span>Announcements</span>
            </a>
            <a href="{{ route('super-admin.system-logs.index') }}" class="nav-item {{ request()->routeIs('super-admin.system-logs.*') ? 'active-nav' : '' }}">
                <i class="bi bi-journal-text"></i><span>System Logs</span>
            </a>

            @elseif(auth()->check() && auth()->user()->hasRole('city_vet'))
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Rabies Control</div>

            <a href="{{ route('city-vet.rabies-geomap') }}" class="nav-item {{ request()->routeIs('city-vet.rabies-geomap') ? 'active-nav' : '' }}">
                <i class="bi bi-map"></i><span>Rabies Geomap</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Appointments</div>

            <a href="{{ route('admin.vaccination-appointments.index') }}" class="nav-item {{ request()->routeIs('admin.vaccination-appointments.*') ? 'active-nav' : '' }}">
                <i class="bi bi-calendar-check"></i><span>Anti-Rabies Vaccination Appointment</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Reports</div>

            <a href="{{ route('admin.bite-reports.index') }}" class="nav-item {{ request()->routeIs('admin.bite-reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-exclamation-triangle"></i><span>Confirmed Rabies Reports</span>
            </a>
            <a href="{{ route('admin.vaccination-reports.index') }}" class="nav-item {{ request()->routeIs('admin.vaccination-reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-shield-check"></i><span>Anti-Rabies Vaccination</span>
            </a>
            <a href="{{ route('admin.missing-pet-reports.index') }}" class="nav-item {{ request()->routeIs('admin.missing-pet-reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-search"></i><span>Missing Pet Reports</span>
            </a>
            <a href="{{ route('admin.adoption-reports.index') }}" class="nav-item {{ request()->routeIs('admin.adoption-reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-heart-fill"></i><span>Adoption Reports</span>
            </a>
            <a href="{{ route('admin.meat-inspection-reports.index') }}" class="nav-item {{ request()->routeIs('admin.meat-inspection-reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-clipboard-check"></i><span>Meat Inspection</span>
            </a>
            <a href="{{ route('admin.all-reports') }}" class="nav-item {{ request()->routeIs('admin.all-reports') ? 'active-nav' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i><span>All Reports</span>
            </a>

            @elseif(auth()->check() && auth()->user()->hasRole('assistant_vet'))
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Rabies & Anti-Rabies Control</div>

            <a href="{{ route('rabies.geomap') }}" class="nav-item {{ request()->routeIs('rabies.geomap') ? 'active-nav' : '' }}">
                <i class="bi bi-map"></i><span>Rabies & Anti-Rabies Heatmap</span>
            </a>

            <div class="sidebar-section-label">Spay & Neuter</div>

            <a href="{{ route('spay-neuter.reports.index') }}" class="nav-item {{ request()->routeIs('spay-neuter.reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-heart"></i><span>Kapon Appointments</span>
            </a>

            @elseif(auth()->check() && auth()->user()->hasRole('admin_asst'))
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Admin Assistant</div>

            <a href="{{ route('admin-asst.pet-registrations.index') }}" class="nav-item {{ request()->routeIs('admin-asst.pet-registrations.*') ? 'active-nav' : '' }}">
                <i class="bi bi-paw"></i><span>Pet Registrations</span>
            </a>
            <a href="{{ route('admin-asst.adoption-applications.index') }}" class="nav-item {{ request()->routeIs('admin-asst.adoption-applications.*') ? 'active-nav' : '' }}">
                <i class="bi bi-heart-fill"></i><span>Adoption Applications</span>
            </a>
            <a href="{{ route('admin-asst.missing-pets.index') }}" class="nav-item {{ request()->routeIs('admin-asst.missing-pets.*') ? 'active-nav' : '' }}">
                <i class="bi bi-search"></i><span>Missing Pets</span>
            </a>
            <a href="{{ route('admin-asst.owners.index') }}" class="nav-item {{ request()->routeIs('admin-asst.owners.*') ? 'active-nav' : '' }}">
                <i class="bi bi-people"></i><span>Pet Owners</span>
            </a>

            @elseif(auth()->check() && auth()->user()->hasRole('meat_inspector'))
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Meat Inspection</div>

            <a href="{{ route('meat-inspection.dashboard') }}" class="nav-item {{ request()->routeIs('meat-inspection.dashboard') ? 'active-nav' : '' }}">
                <i class="bi bi-speedometer2"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('meat-inspection.meat-shop.index') }}" class="nav-item {{ request()->routeIs('meat-inspection.meat-shop.*') ? 'active-nav' : '' }}">
                <i class="bi bi-shop"></i><span>Shop Inspections</span>
            </a>
            <a href="{{ route('meat-inspection.establishments.index') }}" class="nav-item {{ request()->routeIs('meat-inspection.establishments.*') ? 'active-nav' : '' }}">
                <i class="bi bi-plus-circle"></i><span>Register Shop</span>
            </a>

            @else
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Information</div>
            @endif
        </nav>
    </aside>

    <!-- Main Content -->
    <main>
        <!-- Top Bar -->
        <header class="main-header bg-white border-b border-slate-200 hidden md:block">
            <div class="flex items-center justify-between px-6 h-16">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">@yield('header', 'Dashboard')</h2>
                    <p class="text-xs text-slate-400 mt-0.5">@yield('subheader', 'Welcome back')</p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Notifications -->
                    @php
                        $unreadNotifications = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->latest()->take(10)->get();
                        $unreadCount = $unreadNotifications->count();
                    @endphp
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="relative p-2 rounded-lg hover:bg-slate-100 transition">
                            <i class="bi bi-bell text-xl text-slate-600"></i>
                            @if($unreadCount > 0)
                                <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            @endif
                        </button>
                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-slate-200 z-50 hidden" style="display: none;">
                            <div class="p-3 border-b border-slate-100">
                                <h3 class="font-semibold text-slate-800">Notifications</h3>
                            </div>
                            <div class="max-h-80 overflow-y-auto">
                                @forelse($unreadNotifications as $notification)
                                    <a href="{{ route('notifications.index') }}" class="block p-3 hover:bg-slate-50 border-b border-slate-50 last:border-0">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 {{ $notification->priority === 'high' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                                                <i class="bi bi-bell-fill text-sm"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-slate-800 truncate">{{ $notification->title }}</p>
                                                <p class="text-xs text-slate-500 truncate">{{ $notification->message }}</p>
                                                <p class="text-[10px] text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-4 text-center text-slate-500">
                                        <i class="bi bi-bell-slash text-2xl mb-2"></i>
                                        <p class="text-sm">No new notifications</p>
                                    </div>
                                @endforelse
                            </div>
                            @if($unreadCount > 0)
                                <div class="p-2 border-t border-slate-100">
                                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-center text-sm text-blue-600 hover:text-blue-800 py-1">
                                            Mark all as read
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-2 pl-3 border-l border-slate-200 focus:outline-none rounded-md py-1 pr-2 hover:bg-slate-50">
                            <div class="w-8 h-8 bg-brand-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-bold">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                            </div>
                            <span class="text-sm font-medium text-slate-600 hidden md:block">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <i class="bi text-xs text-slate-400 hidden md:block"
                               :class="open ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                        </button>
                        <div x-show="open" @click.away="open = false"
                             class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border border-slate-200 z-50 py-1"
                             style="display: none;">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="bi bi-box-arrow-right"></i><span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 md:hidden hidden" onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('sidebar-overlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('hidden');
                overlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : 'auto';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="modal fade" id="globalCreateUserModal" tabindex="-1" aria-labelledby="globalCreateUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="globalCreateUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="globalCreateModalBody">
                    <div class="text-center py-12">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-green-600"></div>
                        <p class="mt-4 text-gray-600">Loading form...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let globalCreateModal;
        let globalCreateFormInjected = false;

        function openGlobalCreateUserModal() {
            if (!globalCreateModal) {
                globalCreateModal = new bootstrap.Modal(document.getElementById('globalCreateUserModal'));
            }

            if (!globalCreateFormInjected) {
                const modalBody = document.getElementById('globalCreateModalBody');
                fetch('{{ route('super-admin.users.create') }}', {
                    headers: {
                        'Accept': 'text/html',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    modalBody.innerHTML = html;
                    globalCreateFormInjected = true;
                    globalCreateModal.show();
                })
                .catch(() => {
                    modalBody.innerHTML = '<p class="text-red-600 text-center py-8">Error loading form. Please try again.</p>';
                    globalCreateModal.show();
                });
            } else {
                globalCreateModal.show();
            }
        }

        function refreshUsersTableIfAvailable() {
            const path = window.location.pathname;
            const isUsersPage = path.includes('/super-admin/users') || path.includes('/admin/users');
            if (!isUsersPage) return;
            location.reload();
        }

        function showGlobalToast(type, message) {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        document.addEventListener('change', function(e) {
            if (e.target.name === 'role' && e.target.closest('#globalCreateModalBody')) {
                const alternatePhoneContainer = document.getElementById('alternate_phone_number_container');
                const facilitySection = document.getElementById('section-facility');
                if (e.target.value === 'pet_owner') {
                    if (alternatePhoneContainer) alternatePhoneContainer.style.display = 'block';
                    if (facilitySection) facilitySection.style.display = 'none';
                } else {
                    if (alternatePhoneContainer) alternatePhoneContainer.style.display = 'none';
                    if (facilitySection) facilitySection.style.display = 'block';
                }
            }
        });

        document.addEventListener('submit', function(e) {
            if (e.target && e.target.id === 'globalCreateUserModalForm') {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent mr-2"></span> Creating...';

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        throw data;
                    }
                    return data;
                })
                .then(data => {
                    if (data.success) {
                        globalCreateModal.hide();
                        showGlobalToast('success', data.message);
                        refreshUsersTableIfAvailable();
                    }
                })
                .catch(error => {
                    if (error.errors) {
                        const modalBody = document.getElementById('globalCreateModalBody');
                        modalBody.querySelectorAll('.text-red-600').forEach(el => el.remove());
                        modalBody.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
                        for (const [field, messages] of Object.entries(error.errors)) {
                            const input = document.getElementById(field);
                            if (input) {
                                input.classList.add('border-red-500');
                                const errorEl = document.createElement('p');
                                errorEl.className = 'mt-1 text-sm text-red-600';
                                errorEl.textContent = messages[0];
                                input.parentNode.appendChild(errorEl);
                            }
                        }
                    }
                    showGlobalToast('error', error.message || 'Please check the form for errors.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
