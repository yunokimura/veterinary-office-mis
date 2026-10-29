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
        $adoptedCount = AdoptionApplication::where('status', 'adopted')->count();

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('admin-asst.adoption-applications._table', compact('applications'))->render();
            $links = $applications->withQueryString()->links();
            $pagination = $links instanceof \Illuminate\Contracts\Support\Htmlable
                ? $links->toHtml()
                : (string) $links;

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination,
                'has_results' => $applications->count() > 0,
            ]);
        }

        return view('admin-asst.adoption-applications.index', compact(
            'applications',
            'pendingReviewCount',
            'approvedCount',
            'rejectedCount',
            'adoptedCount'
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
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->back()->with('success', 'Application rejected with reason.');
    }

    public function pending(AdoptionApplication $application)
    {
        $application->update([
            'status' => 'pending_review',
        ]);

        return redirect()->back()->with('success', 'Application status reset to pending review.');
    }

    public function adopt(Request $request, AdoptionApplication $application)
    {
        $application->update([
            'status' => 'adopted',
        ]);

        return redirect()->back()->with('success', 'Adoption marked as completed and pet status updated.');
    }
}
