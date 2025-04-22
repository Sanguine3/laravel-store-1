<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.admin')]
class UserForm extends Component
{
    public ?User $user = null;

    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|email|max:255|unique:users,email')]
    public string $email = '';

    #[Rule('nullable|string|min:8|confirmed')]
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->user = User::findOrFail($id);
            $this->name = $this->user->name;
            $this->email = $this->user->email;
        }
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($this->user?->id ?? 'NULL') . ',id',
            'password' => $this->user ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
        ];

        $validated = $this->validate($rules);

        if ($this->user) {
            // Update existing user
            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']); // Don't update password if empty
            }
            $this->user->update($validated);
            // Add success feedback (e.g., session flash)
            session()->flash('status', 'User updated successfully.');
        } else {
            // Create new user
            $validated['password'] = bcrypt($validated['password']);
            User::create($validated);
            // Add success feedback
            session()->flash('status', 'User created successfully.');
        }

        return $this->redirect(UserList::class, navigate: true); // Redirect to user list after save
    }

    public function render()
    {
        return view('admin.users.form');
    }
} 