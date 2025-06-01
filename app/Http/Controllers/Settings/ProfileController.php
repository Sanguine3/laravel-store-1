<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    private ProfileService $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }

    public function edit(): Response
    {
        return Inertia::render('Settings/Profile');
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->service->updateProfile($request->user(), $request->validated());
        return redirect()->route('settings.profile')->with('success', 'Profile updated.');
    }
}
