<?php

namespace App\Http\Controllers\Admin\UserActions;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DestroyController extends Controller
{
    /**
     * Handle the incoming request.
     * Remove the specified user from storage (soft delete).
     */
    public function __invoke(User $user): RedirectResponse // Use route model binding
    {
        // Prevent deleting the currently authenticated user
        if ($user->id === Auth::id()) {
             return redirect()->route('admin.users.index')->with('error', 'You cannot delete yourself.');
        }

        // Prevent deleting the last admin user
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
             return redirect()->route('admin.users.index')->with('error', 'Cannot delete the last admin user.');
        }

        $user->delete(); // Soft delete
        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully.');
    }
}