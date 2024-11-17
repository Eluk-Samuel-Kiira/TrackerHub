<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Artisan;

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
    public function store(LoginRequest $request): JsonResponse
    {
        // Authenticate the user
        $request->authenticate();

        // Check if the authenticated user's status is inactive
        if (auth()->user()->status === 'inactive') {
            // Call the destroy method to log out the user
            $this->destroy($request);

            // Return a response indicating the account is suspended
            return response()->json([
                'success' => false,
                'message' => __("Account Suspended, Contact Admin to re-establish it")
            ]);
        }

        // Clear application cache
        Artisan::call('optimize:clear');

        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        // Check if the request is an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'reload' => false,
                'redirect' => route('dashboard'),
            ]);
        } else {
            // If it's not an AJAX request, return failure
            return response()->json([
                'success' => false,
                'message' => __("Authentication Failed")
            ]);
        }
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
