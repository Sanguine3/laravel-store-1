<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DeleteUserController extends Controller
{
    /**
     * Delete the authenticated user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // 1. Validate the password confirmation
        $request->validateWithBag('userDeletion', [ // Use specific error bag from the view
            'password' => ['required', 'current_password'],
        ]);

        // 2. Get the authenticated user
        $user = $request->user();

        // 3. Log the user out before deleting
        Auth::logout();

        // 4. Delete the user record
        $user->delete();

        // 5. Invalidate session and regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 6. Redirect to homepage
        return redirect('/')->with('status', 'Account deleted successfully.');
    }
}
