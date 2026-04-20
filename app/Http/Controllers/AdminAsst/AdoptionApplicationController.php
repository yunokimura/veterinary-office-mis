<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use Illuminate\Http\Request;

class AdoptionApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = AdoptionApplication::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('mobile_number', 'like', '%'.$search.'%');
            });
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(15);

        $pendingCount = AdoptionApplication::where('status', 'pending')->count();
        $approvedCount = AdoptionApplication::where('status', 'approved')->count();
        $rejectedCount = AdoptionApplication::where('status', 'rejected')->count();

        return view('admin-asst.adoption-applications.index', compact(
            'applications',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    public function show(AdoptionApplication $application)
    {
        $application->load('user');

        return view('admin-asst.adoption-applications.show', compact('application'));
    }

    public function approve(Request $request, AdoptionApplication $application)
    {
        $application->update([
            'status' => 'approved',
        ]);

        return redirect()->back()->with('success', 'Application approved successfully!');
    }

    public function reject(Request $request, AdoptionApplication $application)
    {
        $application->update([
            'status' => 'rejected',
        ]);

        return redirect()->back()->with('success', 'Application rejected.');
    }

    public function complete(Request $request, AdoptionApplication $application)
    {
        $application->update([
            'status' => 'completed',
        ]);

        return redirect()->back()->with('success', 'Application marked as completed.');
    }

    public function pending(AdoptionApplication $application)
    {
        $application->update([
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Application status reset to pending.');
    }
}
