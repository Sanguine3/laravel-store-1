<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ResetPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param Request $request
     * @return Response
     */
    public function showResetForm(Request $request): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'token' => $request->route('token'),
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function reset(Request $request): RedirectResponse
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
            // Redirect to log in with success message
            return redirect()->route('login')->with('status', __($status));
        }

        // If reset failed, throw validation exception with the status message
        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
