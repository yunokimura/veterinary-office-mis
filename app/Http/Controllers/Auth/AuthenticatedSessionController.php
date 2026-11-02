<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Check if user has verified their email
        if (!$user->is_verified && $user->hasRole('pet_owner')) {
            // Store email in session and redirect to OTP verification
            session(['email' => $user->email]);
            Auth::logout();
            return redirect()->route('otp.verify.form')->with('info', 'Please verify your email first. An OTP has been sent to your email.');
        }

        // Redirect based on user role
        return $this->redirectToDashboard($user);
    }

    /**
     * Redirect user to their role-based dashboard.
     * Checks roles in priority order using hasRole() so a user with multiple
     * roles is always routed to the highest-privilege dashboard, regardless of
     * the non-deterministic order of Spatie's getRoleNames().
     */
    protected function redirectToDashboard($user): RedirectResponse
    {
        if ($user->hasRole('super_admin')) {
            return redirect()->intended('/super-admin/dashboard')
                ->with('success', 'Welcome back, Super Administrator ' . $user->name . '!');
        }

        if ($user->hasRole('city_vet')) {
            return redirect()->intended('/city-vet/dashboard')
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        if ($user->hasRole('admin_asst')) {
            return redirect()->intended('/admin-asst/dashboard')
                ->with('success', 'Welcome back, Administrative Assistant ' . $user->name . '!');
        }

        if ($user->hasRole('assistant_vet')) {
            return redirect()->intended('/assistant-vet/dashboard')
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        if ($user->hasRole('meat_inspector')) {
            return redirect()->intended(route('meat-inspection.dashboard'))
                ->with('success', 'Welcome back, Meat Inspector ' . $user->name . '!');
        }

        if ($user->hasRole('pet_owner')) {
            return redirect()->intended(route('owner.dashboard'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        Auth::logout();
        return redirect()->route('login')->with('error', 'Invalid role. Please contact the system administrator.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/home');
    }
}
