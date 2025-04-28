<x-layouts.admin :title="$user ? 'Edit User' : 'Create User'">
    <div class="flex flex-col gap-6">
        <x-card>
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
                            <flux:select wire:model="role" id="role" required> {{-- Removed disabled, added wire:model, required --}}
                                <option value="admin">Admin</option> {{-- Removed selected logic --}}
                                <option value="customer">Customer</option> {{-- Removed selected logic --}}
                            </flux:select>
                            <flux:error name="role" /> {{-- Add error display --}}
                            {{-- Removed description --}}
                        </flux:field>

                        <flux:field>
                            <flux:label for="status">Status</flux:label>
                            <flux:select wire:model="status" id="status" required> {{-- Removed disabled, added wire:model, required --}}
                                <option value="active">Active</option> {{-- Removed selected logic --}}
                                <option value="inactive">Inactive</option>
                            </flux:select>
                            <flux:error name="status" /> {{-- Add error display --}}
                            {{-- Removed description --}}
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


                <!-- Form Actions -->
                 <div class="p-6 flex items-center justify-end space-x-3 bg-zinc-50 dark:bg-zinc-800 rounded-b-xl border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button :href="route('admin.users')" wire:navigate variant="subtle">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">{{ $user ? 'Update User' : 'Create User' }}</flux:button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.admin>
