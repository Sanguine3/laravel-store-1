<?php

namespace App\Http\Controllers\Admin\UserActions;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     * Show the form for editing the specified user.
     */
    public function __invoke(User $user): View // Use route model binding
    {
        // The controller passes only the user model.
        // Might want to pass roles here if needed in the form.
        // $roles = ['admin', 'customer'];
        // return view('admin.users.form', compact('user', 'roles'));
        return view('admin.users.form', compact('user'));
    }
}
