<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteAccountRequest;
use App\Services\DeleteUserService;
use Illuminate\Http\RedirectResponse;

class DeleteUserController extends Controller
{
    /**
     * Delete the authenticated user's account.
     *
     * @param DeleteAccountRequest $request
     * @param DeleteUserService $service
     * @return RedirectResponse
     */
    public function destroy(DeleteAccountRequest $request, DeleteUserService $service): RedirectResponse
    {
        // 1. Delete the user's account
        $service->deleteAccount($request->user());

        // 2. Get the authenticated user
        $user = $request->user();

        // 3. Invalidate session and regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 6. Redirect to homepage
        return redirect('/')->with('success', 'Account deleted successfully.');
    }
}
