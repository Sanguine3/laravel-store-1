<?php

namespace App\Http\Controllers\Admin\UserActions;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     * Show the form for creating a new user.
     */
    public function __invoke(): View
    {
        // The controller returns the view.
        // Might want to pass roles here if needed in the form.
        // $roles = ['admin', 'customer'];
        // return view('admin.users.form', compact('roles'));
        return view('admin.users.form');
    }
}
