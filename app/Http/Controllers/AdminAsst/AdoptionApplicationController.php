<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use Illuminate\Http\Request;

class AdoptionApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = AdoptionApplication::with(['owner', 'address', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('owner', function ($q2) use ($search) {
                    $q2->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('phone_number', 'like', "%$search%");
                })
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('email', 'like', "%$search%");
                    });
            });
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(15);

        $pendingReviewCount = AdoptionApplication::where('status', 'pending_review')->count();
        $approvedCount = AdoptionApplication::where('status', 'approved')->count();
        $rejectedCount = AdoptionApplication::where('status', 'rejected')->count();

        return view('admin-asst.adoption-applications.index', compact(
            'applications',
            'pendingReviewCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    public function show(AdoptionApplication $application)
    {
        $application->load(['owner', 'address', 'user']);

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

    public function pending(AdoptionApplication $application)
    {
        $application->update([
            'status' => 'pending_review',
        ]);

        return redirect()->back()->with('success', 'Application status reset to pending review.');
    }
}
