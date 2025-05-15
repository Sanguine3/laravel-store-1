<?php

namespace App\Http\Controllers\Admin\UserActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     * Store a newly created user in storage.
     */
    public function __invoke(StoreUserRequest $request): RedirectResponse
    {
        // Validation and password hashing are handled by StoreUserRequest
        $validatedData = $request->validated();

        User::create($validatedData);

        return redirect()->route('admin.users.index')->with('status', 'User created successfully.');
    }
}