<x-layouts.admin :title="isset($user) ? 'Edit User' : 'Create User'">
    <div class="flex flex-col gap-6">
        <x-card>
            <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        {{ isset($user) ? 'Edit User' : 'Create User' }}
                    </h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ isset($user) ? 'Update user information.' : 'Add a new user to the system.' }}
                    </p>
                </div>

                 <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label for="name">Name</flux:label>
                            <flux:input name="name" id="name" placeholder="Enter full name" value="{{ old('name', $user->name ?? '') }}" required />
                            <flux:error name="name" />
                        </flux:field>

                        <flux:field>
                             <flux:label for="email">Email</flux:label>
                             <flux:input name="email" type="email" id="email" placeholder="user@example.com" value="{{ old('email', $user->email ?? '') }}" required />
                             <flux:error name="email" />
                        </flux:field>

                        <flux:field>
                             <flux:label for="role">Role</flux:label>
                            <flux:select name="role" id="role" required>
                                <option value="admin" @selected(old('role', $user->role ?? '') === 'admin')>Admin</option>
                                <option value="customer" @selected(old('role', $user->role ?? '') === 'customer')>Customer</option>
                            </flux:select>
                            <flux:error name="role" />
                        </flux:field>

                    </div>
                 </div>

                {{-- Password Section: Only show if creating a user --}}
                @if (!isset($user))
                    <!-- Password Section -->
                    <div class="p-6 border-t border-b border-zinc-200 dark:border-zinc-700">
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white">
                            Set Password
                        </h3>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            Create a secure password for this user.
                        </p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <flux:field>
                                <flux:label for="password">Password</flux:label>
                                <flux:input name="password" type="password" id="password" required />
                                <flux:error name="password" />
                            </flux:field>
                            <flux:field>
                                <flux:label for="password_confirmation">Confirm Password</flux:label>
                                <flux:input name="password_confirmation" type="password" id="password_confirmation" required />
                            </flux:field>
                        </div>
                    </div>
                @endif

                <!-- Form Actions -->
                 <div class="p-6 flex items-center justify-end space-x-3 bg-zinc-50 dark:bg-zinc-800 rounded-b-xl border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button :href="route('admin.users.index')" variant="subtle">Cancel</flux:button>
                    @if (isset($user))
                        <flux:button
                            type="submit"
                            color="warning"
                            class="!bg-yellow-400 !text-zinc-900 hover:!bg-yellow-500 focus:!ring-yellow-300"
                            icon="pencil-square">
                            Update User
                        </flux:button>
                    @else
                        <flux:button
                            type="submit"
                            color="warning"
                            class="!bg-amber-600 !text-white hover:!bg-amber-700 focus:!ring-amber-300"
                            icon="plus">
                            Create User
                        </flux:button>
                    @endif
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.admin>