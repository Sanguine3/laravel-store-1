<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class PasswordController extends Controller
{
    /**
     * Show the form for editing the user's password.
     *
     * @return View
     */
    public function edit()
    {
        return view('settings.password');
    }

    /**
     * Update the user's password.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        // 1. Validate the request data
        // Note: The 'current_password' rule automatically checks against the authenticated user
        $validated = $request->validateWithBag('updatePassword', [ // Use a specific error bag
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', PasswordRule::defaults(), 'confirmed'],
        ]);

        // 2. Update the user's password
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Redirect back with success status
        // The 'password-updated' status matches the check in the Blade view
        return back()->with('status', 'password-updated');
    }
}
