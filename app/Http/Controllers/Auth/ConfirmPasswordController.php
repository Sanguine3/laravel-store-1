<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmPasswordController extends Controller
{
    /**
     * Show the password confirmation view.
     *
     * @return View
     */
    public function showConfirmForm()
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function confirm(Request $request)
    {
        // 1. Validate the password input
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        // 2. Validate the password against the authenticated user
        if (!Auth::guard('web')->validate([
            'email' => $request->user()->email, // Get email from authenticated user
            'password' => $request->password,
        ])) {
            // Throw validation exception if password doesn't match
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        // 3. Store confirmation timestamp in session
        $request->session()->put('auth.password_confirmed_at', time());

        // 4. Redirect to intended destination or dashboard
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
