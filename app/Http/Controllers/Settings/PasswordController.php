<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\PasswordService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PasswordController extends Controller
{
    /**
     * Show the form for editing the user's password.
     *
     * @return Response
     */
    public function edit(): Response
    {
        return Inertia::render('Settings/Password');
    }

    /**
     * Update the user's password.
     *
     * @param UpdatePasswordRequest $request
     * @param PasswordService $service
     * @return RedirectResponse
     */
    public function update(UpdatePasswordRequest $request, PasswordService $service): RedirectResponse
    {
        $data = $request->validated();
        $service->updatePassword($request->user(), $data['password']);
        return redirect()->route('settings.password')->with('success', 'Password updated.');
    }
}
