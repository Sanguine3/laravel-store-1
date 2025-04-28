<?php

namespace App\Livewire\Admin\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.admin')]
class Index extends Component
{
    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|email|max:255')]
    public string $email = '';

    #[Rule('nullable|string|min:8|confirmed')]
    public ?string $password = '';
    public ?string $password_confirmation = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $validated = $this->validate();

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']); // Don't update password if empty
        }

        // Remove email from validated data before updating
        unset($validated['email']);

        $user->update($validated);

        $this->reset('password', 'password_confirmation');

        // Add success feedback (e.g., dispatch browser event or session flash)
        session()->flash('status', 'Profile successfully updated.');
    }

    public function render()
    {
        return view('admin.profile.index');
    }
} 