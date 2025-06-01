<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getPaginated(int $perPage = 15)
    {
        return User::withTrashed()->paginate($perPage);
    }

    public function get(int $id)
    {
        return User::withTrashed()->findOrFail($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function restore(int $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return $user;
    }
} 