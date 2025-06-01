<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class DeleteUserService
{
    public function deleteAccount($user): void
    {
        Auth::logout();
        $user->delete();
    }
} 