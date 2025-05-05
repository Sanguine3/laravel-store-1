<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password; // Add Password facade import

class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email'); // Placeholder, view needs creation
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendResetLinkEmail(Request $request)
    {
        // 1. Validate the email address
        $request->validate(['email' => ['required', 'string', 'email']]);

        // 2. Attempt to send the reset link
        $status = Password::sendResetLink($request->only('email'));

        // 3. Check the status and redirect
        // Using the generic message from the original Livewire component
        // You might want to customize messages based on $status (Password::RESET_LINK_SENT, etc.)
        return back()->with('status', __('A reset link will be sent if the account exists.'));

        /* Alternative based on status:
        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
        */
    }
}
