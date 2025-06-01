<?php

namespace App\Services;

use App\Models\User;

class ProfileService
{
    public function updateProfile(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }
} 