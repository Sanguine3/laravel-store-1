<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class AppearanceController extends Controller
{
    /**
     * Show the form for editing appearance settings.
     *
     * @return Response
     */
    public function edit(): Response
    {
        return Inertia::render('Settings/Appearance');
    }
}
