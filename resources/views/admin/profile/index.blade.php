<x-layouts.admin :title="__('Profile Settings')">
    <div class="flex flex-col gap-6">

        <!-- Session Status Message -->
        @if (session('status'))
            <div class="rounded-md bg-green-50 dark:bg-green-900/20 p-4 border border-green-200 dark:border-green-700">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <flux:icon name="check-circle" class="h-5 w-5 text-green-400 dark:text-green-300" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <flux:card>
            <form wire:submit="updateProfile">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        {{ __('Profile Information') }}
                    </h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ __('Update your account\'s profile information and email address.') }}
                    </p>
                </div>

                <div class="p-6 space-y-6">
                    <flux:field class="col-span-1 md:col-span-2">
                        <flux:label for="name">Name</flux:label>
                        <flux:input wire:model="name" id="name" required />
                        <flux:error name="name" />
                    </flux:field>

                    <flux:field class="col-span-1 md:col-span-2">
                        <flux:label for="email">Email</flux:label>
                        <flux:input wire:model="email" type="email" id="email" required />
                        <flux:error name="email" />
                    </flux:field>
                </div>

                <div class="p-6 border-t border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        {{ __('Update Password') }}
                    </h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ __('Ensure your account is using a long, random password to stay secure. Leave blank if you don\'t want to change it.') }}
                    </p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label for="password">New Password</flux:label>
                            <flux:input wire:model="password" type="password" id="password" />
                             <flux:error name="password" />
                        </flux:field>

                        <flux:field>
                             <flux:label for="password_confirmation">Confirm Password</flux:label>
                             <flux:input wire:model="password_confirmation" type="password" id="password_confirmation" />
                        </flux:field>
                    </div>
                </div>

                <div class="p-6 flex items-center justify-end bg-zinc-50 dark:bg-zinc-800 rounded-b-xl border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button type="submit" variant="primary">Save Profile</flux:button>
                </div>
            </form>
        </flux:card>

        <!-- Profile Photo Section (Static - requires separate logic) -->
        <flux:card>
             <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                 <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                     {{ __('Profile Photo') }}
                 </h2>
                 <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ __('Manage your profile photo.') }}
                 </p>
             </div>
             <div class="p-6">
                 <div class="flex items-center">
                     <flux:avatar size="xl">
                        {{-- Placeholder for actual photo or initials --}}
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                     </flux:avatar>
                     <div class="ml-5">
                         <flux:button type="button" variant="outline">Change Photo</flux:button>
                         <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                             {{ __('JPG, GIF or PNG. Max size of 2MB. (Upload logic not implemented)') }}
                         </p>
                     </div>
                 </div>
             </div>
        </flux:card>

        <!-- Two Factor Authentication Section (Static - requires separate logic) -->
        <flux:card>
             <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                 <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                     {{ __('Two Factor Authentication') }}
                 </h2>
                 <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                     {{ __('Add additional security to your account using two factor authentication.') }}
                 </p>
             </div>
             <div class="p-6">
                 <h3 class="text-md font-medium text-zinc-900 dark:text-white">
                     {{ __('You have not enabled two factor authentication.') }}
                 </h3>
                 <div class="mt-3 max-w-xl text-sm text-zinc-600 dark:text-zinc-400">
                     <p>
                         {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
                     </p>
                 </div>
                 <div class="mt-5">
                    <flux:button type="button" variant="primary" disabled>{{ __('Enable Two-Factor Authentication (Not Implemented)') }}</flux:button>
                 </div>
             </div>
        </flux:card>
    </div>
</x-layouts.admin>
