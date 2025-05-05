<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException; // Import ValidationException

class ResetPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request)
    {
        // Pass the token and email to the view
        return view('auth.passwords.reset')->with(
            ['token' => $request->route('token'), 'email' => $request->query('email')]
        );
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reset(Request $request)
    {
        // 1. Validate the incoming request data
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Attempt to reset the password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                // Update user's password and remember token
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Fire the PasswordReset event
                event(new PasswordReset($user));
            }
        );

        // 3. Handle the response based on the status
        if ($status == Password::PASSWORD_RESET) {
            // Redirect to login with success message
            return redirect()->route('login')->with('status', __($status));
        }

        // If reset failed, throw validation exception with the status message
        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
