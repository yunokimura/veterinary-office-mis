<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pet;
use App\Models\Client;

/**
 * AdminStaffController - Administrative Staff Module
 *
 * THESIS ROLE MAPPING:
 * - Primary Role: admin_staff (Administrative Assistant IV / Book Binder 4)
 * - Legacy Alias: admin_asst (for backward compatibility)
 *
 * MODULE ASSIGNMENTS:
 * - Pet Registration (Portal Admin Assistant)
 * - Owner Records Management
 * - Vaccination Encoding
 * - Records Search
 * - Inventory Control
 *
 * ACCESSIBLE ROUTES:
 * - admin-staff.dashboard
 * - admin-staff.pets.*
 * - admin-staff.owners.*
 * - admin-staff.vaccinations.*
 * - admin-staff.search
 * - admin-staff.announcements.index
 */
class AdminStaffController extends Controller
{
    /**
     * Show admin staff dashboard.
     *
     * Module: Dashboard
     * Role: admin_staff
     */
    public function dashboard()
    {
        $user = Auth::user();

        $stats = [
            'total_animals' => Pet::count(),
            'total_owners' => Client::count(),
            'pending_adoptions' => 0,
        ];

        return view('dashboard.admin-staff', compact('user', 'stats'));
    }
}
