<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Settings\UpdatePasswordRequest;
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
     * @param UpdatePasswordRequest $request
     * @return RedirectResponse
     */
    public function update(UpdatePasswordRequest $request)
    {
        // Validation passed, get validated data
        $validated = $request->validated();

        // 2. Update the user's password
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Redirect back with success status
        // The 'password-updated' status matches the check in the Blade view
        return back()->with('status', 'password-updated');
    }
}
