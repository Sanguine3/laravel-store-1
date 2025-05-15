<?php

namespace App\Http\Controllers\Settings\ProfileActions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // Request is used here to get the user
use Illuminate\View\View;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     * Show the form for editing the user's profile information.
     */
    public function __invoke(Request $request): View
    {
        // Pass the authenticated user to the view
        return view('settings.profile', [
            'user' => $request->user(),
        ]);
    }
}