<?php

namespace App\Http\Controllers\Admin\UserActions;

use App\Http\Controllers\Controller;
use App\Models\User; // Make sure User model is imported
use Illuminate\Http\RedirectResponse;

class RestoreController extends Controller
{
    /**
     * Handle the incoming request.
     * Restore the specified soft-deleted user.
     */
    public function __invoke(User $user): RedirectResponse
    {
        // Route model binding should automatically fetch the user, including trashed ones,
        // if the route parameter is type-hinted and the model uses SoftDeletes.

        if ($user->trashed()) {
            $user->restore();
            return redirect()->route('admin.users.index')->with('status', 'User restored successfully.');
        }

        // If the user wasn't trashed (e.g., direct access attempt), redirect back.
        return redirect()->route('admin.users.index')->with('error', 'User is not deleted or cannot be restored.');
    }
}
