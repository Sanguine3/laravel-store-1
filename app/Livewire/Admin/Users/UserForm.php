<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.app')]
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

    #[Rule('required|string|in:admin,customer')] // Add role property and rule
    public string $role = 'customer'; // Default to customer

    #[Rule('required|string|in:active,inactive')] // Add status property and rule
    public string $status = 'active'; // Default to active

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->user = User::findOrFail($id);
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->role = $this->user->role ?? 'customer'; // Load existing role
            $this->status = $this->user->status ?? 'active'; // Load existing status
        }
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($this->user?->id ?? 'NULL') . ',id',
            'password' => $this->user ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,customer', // Add role validation
            'status' => 'required|string|in:active,inactive', // Add status validation
        ];

        $validated = $this->validate($rules);

        if ($this->user) {
            // Update existing user
            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']); // Don't update password if empty
            }
            // Ensure role is included in the update data
            $updateData = $validated;
            // $updateData['role'] = $validated['role']; // Role is already in $validated due to rules array
            $updateData['status'] = $validated['status']; // Add status to update data
            $this->user->update($updateData);
            // Add success feedback (e.g., session flash)
            session()->flash('status', 'User updated successfully.');
        } else {
            // Create new user
            $validated['password'] = bcrypt($validated['password']);
            // Ensure role is included in the create data
            $createData = $validated;
            // $createData['role'] = $validated['role']; // Role is already in $validated due to rules array
            $createData['status'] = $validated['status']; // Add status to create data
            User::create($createData);
            // Add success feedback
            session()->flash('status', 'User created successfully.');
        }

        return $this->redirect(UserList::class, navigate: true); // Redirect to user list after save
    }

    public function render()
    {
        return view('livewire.admin.users.form');
    }
}
