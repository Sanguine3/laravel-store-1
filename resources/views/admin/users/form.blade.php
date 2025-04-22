<x-layouts.admin :title="$user ? 'Edit User' : 'Create User'">
    <div class="flex flex-col gap-6">
        <flux:card>
            <form wire:submit="save">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        {{ $user ? 'Edit User' : 'Create User' }}
                    </h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $user ? 'Update user information and password.' : 'Add a new user to the system.' }}
                    </p>
                </div>

                 <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <!-- Profile Photo (Static - Requires separate Livewire logic) -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Profile Photo</label>
                            <div class="flex items-center">
                                 <flux:avatar size="xl">
                                    @if($user?->avatar_url) {{-- Assuming an avatar_url property --}}
                                         <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" >
                                    @else
                                        {{ $user ? strtoupper(substr($user->name, 0, 2)) : '?' }}
                                    @endif
                                 </flux:avatar>
                                <div class="ml-5">
                                    <flux:button type="button" variant="outline" disabled>Upload Photo (Not Implemented)</flux:button>
                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ __('JPG, GIF or PNG. Max size of 2MB.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <flux:field>
                            <flux:label for="name">Name</flux:label>
                            <flux:input wire:model="name" id="name" placeholder="Enter full name" required />
                            <flux:error name="name" />
                        </flux:field>

                        <flux:field>
                             <flux:label for="email">Email</flux:label>
                             <flux:input wire:model="email" type="email" id="email" placeholder="user@example.com" required />
                             <flux:error name="email" />
                        </flux:field>

                        <flux:field>
                             <flux:label for="role">Role</flux:label>
                            <flux:select id="role" disabled>
                                <option value="admin" {{ ($user?->role == 'admin') ? 'selected' : '' }}>Admin</option>
                                <option value="customer" selected>Customer (Default)</option>
                            </flux:select>
                             <flux:description>Role assignment not implemented in this form.</flux:description>
                        </flux:field>

                        <flux:field>
                            <flux:label for="status">Status</flux:label>
                            <flux:select id="status" disabled>
                                <option value="active" selected>Active (Default)</option>
                                <option value="inactive">Inactive</option>
                            </flux:select>
                             <flux:description>Status assignment not implemented in this form.</flux:description>
                        </flux:field>
                    </div>
                 </div>

                <!-- Password Section -->
                 <div class="p-6 border-t border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white">
                        {{ $user ? 'Change Password' : 'Set Password' }}
                    </h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $user ? 'Leave blank to keep the current password.' : 'Create a secure password for this user.' }}
                    </p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label for="password">Password</flux:label>
                            <flux:input wire:model="password" type="password" id="password" :required="!$user" />
                             <flux:error name="password" />
                        </flux:field>

                        <flux:field>
                            <flux:label for="password_confirmation">Confirm Password</flux:label>
                            <flux:input wire:model="password_confirmation" type="password" id="password_confirmation" :required="!$user || $password"/>
                        </flux:field>
                    </div>
                </div>

                <!-- Additional Settings (Static - Requires separate Livewire logic) -->
                 <div class="p-6 border-t border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white">{{ __('Additional Settings (Not Implemented)') }}</h3>
                 </div>
                 <div class="p-6">
                    <div class="space-y-4 opacity-50">
                        <flux:field variant="inline">
                            <flux:checkbox id="send_welcome_email" disabled />
                            <flux:label for="send_welcome_email">Send welcome email</flux:label>
                            <flux:description>Send an email with login instructions to this user.</flux:description>
                        </flux:field>

                        <flux:field variant="inline">
                             <flux:checkbox id="require_password_change" disabled />
                             <flux:label for="require_password_change">Require password change</flux:label>
                             <flux:description>User will be prompted to change their password on first login.</flux:description>
                        </flux:field>
                    </div>
                </div>

                <!-- Form Actions -->
                 <div class="p-6 flex items-center justify-end space-x-3 bg-zinc-50 dark:bg-zinc-800 rounded-b-xl border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button :href="route('admin.users')" wire:navigate variant="subtle">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">{{ $user ? 'Update User' : 'Create User' }}</flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-layouts.admin>
