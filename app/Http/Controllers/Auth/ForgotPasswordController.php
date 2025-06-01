<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;
use Inertia\Response;

// Add Password facade import

class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     *
     * @return Response
     */
    public function showLinkRequestForm(): Response
    {
        return Inertia::render('Auth/ForgotPassword', ['status' => session('status')]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        // 1. Validate the email address
        $request->validate(['email' => ['required', 'string', 'email']]);

        // 2. Attempt to send the reset link
        $status = Password::sendResetLink($request->only('email'));

        // 3. Check the status and redirect
        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status)) // This will show "passwords.sent" (e.g., "We have emailed your password reset link!")
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]); // This will show "passwords.user" (e.g., "We can't find a user with that email address.") or "passwords.throttled"
    }
}
