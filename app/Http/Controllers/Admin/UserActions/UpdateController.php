<?php

namespace App\Http\Controllers\Admin\UserActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     * Update the specified user in storage.
     */
    public function __invoke(UpdateUserRequest $request, User $user): RedirectResponse // Use route model binding
    {
        // Validation and optional password hashing are handled by UpdateUserRequest
        $validatedData = $request->validated();

        $user->update($validatedData);

        // Redirect back to the edit form
        return redirect()->route('admin.users.edit', $user->id)->with('status', 'User updated successfully.');
    }
}