<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class UserList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
    ];

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn ($query, $search) =>
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
            )
            ->when($this->roleFilter, fn($query, $role) => $query->where('role', $role))
            ->paginate(10);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function delete(int $id): void
    {
        User::findOrFail($id)->delete();
        session()->flash('status', 'User deleted successfully.');
    }
} 