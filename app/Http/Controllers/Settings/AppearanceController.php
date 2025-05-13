<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppearanceController extends Controller
{
    /**
     * Show the form for editing appearance settings.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('settings.appearance');
    }
}
