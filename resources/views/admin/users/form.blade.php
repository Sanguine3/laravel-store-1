<x-layouts.admin :title="isset($user) ? __('Edit User') : __('Create User')">
    <div class="flex flex-col gap-6">
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    {{ isset($user) ? __('Edit User') : __('Create User') }}
                </h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ isset($user) ? __('Update user information and permissions.') : __('Add a new user to the system.') }}
                </p>
            </div>

            <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST" class="p-6">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Profile Photo -->
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-20 w-20 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center">
                                @if(isset($user))
                                    <span class="text-2xl font-medium text-zinc-900 dark:text-white">{{ $user->initials ?? 'JD' }}</span>
                                @else
                                    <span class="text-2xl font-medium text-zinc-900 dark:text-white">?</span>
                                @endif
                            </div>
                            <div class="ml-5">
                                <div class="relative rounded-md shadow-sm">
                                    <input type="file" id="photo" name="photo" class="sr-only">
                                    <label for="photo" class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-md font-semibold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">
                                        {{ __('Upload Photo') }}
                                    </label>
                                </div>
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ __('JPG, GIF or PNG. Max size of 2MB.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" value="{{ $user->name ?? old('name') }}" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400" placeholder="Enter full name" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" value="{{ $user->email ?? old('email') }}" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400" placeholder="user@example.com" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Role') }}</label>
                        <select id="role" name="role" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                            <option value="admin" {{ (isset($user) && $user->role == 'admin') ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ (isset($user) && $user->role == 'manager') ? 'selected' : '' }}>Manager</option>
                            <option value="customer" {{ (isset($user) && $user->role == 'customer') ? 'selected' : '' }}>Customer</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Status') }}</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                            <option value="active" {{ (isset($user) && $user->status == 'active') ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ (isset($user) && $user->status == 'inactive') ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password Section -->
                <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white">
                        {{ isset($user) ? __('Change Password') : __('Set Password') }}
                    </h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ isset($user) ? __('Leave blank to keep the current password.') : __('Create a secure password for this user.') }}
                    </p>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Password') }}</label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400" {{ isset($user) ? '' : 'required' }}>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400" {{ isset($user) ? '' : 'required' }}>
                        </div>
                    </div>
                </div>

                <!-- Additional Settings -->
                <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white">{{ __('Additional Settings') }}</h3>

                    <div class="mt-4 space-y-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="send_welcome_email" name="send_welcome_email" type="checkbox" class="h-4 w-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800" {{ !isset($user) ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="send_welcome_email" class="font-medium text-zinc-700 dark:text-zinc-300">{{ __('Send welcome email') }}</label>
                                <p class="text-zinc-500 dark:text-zinc-400">{{ __('Send an email with login instructions to this user.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="require_password_change" name="require_password_change" type="checkbox" class="h-4 w-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800" {{ !isset($user) ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="require_password_change" class="font-medium text-zinc-700 dark:text-zinc-300">{{ __('Require password change') }}</label>
                                <p class="text-zinc-500 dark:text-zinc-400">{{ __('User will be prompted to change their password on first login.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end space-x-3 pt-5 border-t border-zinc-200 dark:border-zinc-700">
                    <a href="{{ route('admin.users') }}" class="inline-flex justify-center rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 py-2 px-4 text-sm font-medium text-zinc-700 dark:text-zinc-300 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        {{ isset($user) ? __('Update User') : __('Create User') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
