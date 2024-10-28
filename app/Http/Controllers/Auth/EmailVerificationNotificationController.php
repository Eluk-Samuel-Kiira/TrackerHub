<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // return redirect()->intended(route('dashboard', absolute: false));
            return response()->json([
                'success' => true,
                'message' => __('You have been verified already')
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        // return back()->with('status', 'verification-link-sent');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('verification-link-sent')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => __('Something Went Wrong!')
            ]);
        }
    }
}
