<x-layouts.app> {{-- Add main app layout wrapper --}}
    <section class="w-full">
        @include('partials.settings-heading')

        <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">

            {{-- Display Success Message --}}
            @if (session('status') === 'password-updated')
                <div class="mb-4 rounded-md bg-green-50 p-4 dark:bg-green-900/30">
                    <p class="text-sm font-medium text-green-800 dark:text-green-400">{{ __('Password updated successfully.') }}</p>
                </div>
            @endif

            {{-- Display General Errors --}}
            @if ($errors->updatePassword->any()) {{-- Use specific error bag --}}
                <div class="mb-4 rounded-md bg-red-50 p-4 dark:bg-red-900/30">
                     {{-- Error display structure (similar to other forms) --}}
                     <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400 dark:text-red-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-400">{{ __('Something went wrong.') }}</h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-400/80">
                                <ul role="list" class="list-disc space-y-1 pl-5">
                                    @foreach ($errors->updatePassword->all() as $error) {{-- Use specific error bag --}}
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('settings.password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('PUT') {{-- Use PUT for password updates --}}

                {{-- Current Password --}}
                <div>
                    <flux:input
                        name="current_password"
                        :label="__('Current password')"
                        type="password"
                        required
                        autocomplete="current-password"
                    />
                    @error('current_password', 'updatePassword') {{-- Use specific error bag --}}
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password --}}
                 <div>
                    <flux:input
                        name="password"
                        :label="__('New password')"
                        type="password"
                        required
                        autocomplete="new-password"
                    />
                    @error('password', 'updatePassword') {{-- Use specific error bag --}}
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm New Password --}}
                <div>
                    <flux:input
                        name="password_confirmation"
                        :label="__('Confirm Password')"
                        type="password"
                        required
                        autocomplete="new-password"
                    />
                     {{-- Error for password_confirmation is usually covered by the 'confirmed' rule on 'password' --}}
                </div>


                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                    </div>
                    {{-- Action message replaced by session status check --}}
                </div>
            </form>
        </x-settings.layout>
    </section>
</x-layouts.app> {{-- Close main app layout wrapper --}}