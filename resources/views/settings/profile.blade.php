<x-layouts.app>
    <section class="w-full">
        @include('partials.settings-heading')

        <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">

            {{-- Alpine component for dynamic profile updates --}}
            <div x-data="{
                name: '{{ old('name', $user->name) }}',
                email: '{{ old('email', $user->email) }}',
                initialEmail: '{{ $user->email }}',
                needsReverification: {{ $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail() ? 'true' : 'false' }},
                // loading: false, // Removed loading state
                successMessage: '',
                errors: {},
                updateProfile() {
                    // this.loading = true; // Removed loading state
                    this.successMessage = '';
                    this.errors = {};

                    fetch('{{ route('settings.profile.update') }}', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            name: this.name,
                            email: this.email
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            if (response.status === 422) {
                                return response.json().then(data => { throw data; });
                            }
                            throw new Error('Network response was not ok.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        this.successMessage = data.message || 'Profile updated successfully.';
                        if (this.email !== this.initialEmail) {
                            this.needsReverification = true;
                            this.initialEmail = this.email;
                        }
                        setTimeout(() => this.successMessage = '', 3000);
                    })
                    .catch(error => {
                        if (error.errors) {
                            this.errors = error.errors;
                        } else {
                            this.errors = { general: ['Something went wrong. Please try again.'] };
                            console.error('Error updating profile:', error);
                        }
                    })
                    // .finally(() => { // Removed loading state
                    //     this.loading = false;
                    // });
                }
            }"
            class="my-6 w-full"
            >

                {{-- Display Alpine Success Message --}}
                <div x-show="successMessage" x-transition
                     class="mb-4 rounded-md bg-green-50 p-4 dark:bg-green-900/30">
                    <p class="text-sm font-medium text-green-800 dark:text-green-400" x-text="successMessage"></p>
                </div>

                {{-- Display Alpine General Errors --}}
                 <div x-show="errors.general" x-transition
                     class="mb-4 rounded-md bg-red-50 p-4 dark:bg-red-900/30">
                     <ul class="list-disc space-y-1 pl-5 text-sm text-red-700 dark:text-red-400/80">
                        <template x-for="error in errors.general" :key="error">
                            <li x-text="error"></li>
                        </template>
                     </ul>
                 </div>

                <form @submit.prevent="updateProfile" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Name Input --}}
                    <div>
                        <flux:input
                            x-model="name"
                            name="name"
                            :label="__('Name')"
                            type="text"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <template x-if="errors.name">
                             <p class="mt-2 text-sm text-red-600" x-text="errors.name[0]"></p>
                        </template>
                         @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>


                    {{-- Email Input & Verification --}}
                    <div>
                        <flux:input
                            x-model="email"
                            name="email"
                            :label="__('Email')"
                            type="email"
                            required
                            autocomplete="email"
                        />
                        <template x-if="errors.email">
                             <p class="mt-2 text-sm text-red-600" x-text="errors.email[0]"></p>
                        </template>
                         @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror

                        <div x-show="needsReverification" class="mt-4">
                            <flux:text>
                                {{ __('Your email address is unverified.') }}
                                <form method="POST" action="{{ route('verification.send') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="ml-2 cursor-pointer text-sm text-blue-600 underline hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </form>
                            </flux:text>
                            @if (session('status') === 'verification-link-sent')
                                <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </flux:text>
                            @endif
                        </div>
                    </div>

                    {{-- Save Button (Simplified) --}}
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-end">
                            {{-- Removed :disabled and conditional content --}}
                            <flux:button variant="primary" type="submit" class="w-full">
                                {{ __('Save') }}
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div> {{-- End Alpine Component --}}


            {{-- Delete Account Section (remains unchanged) --}}
            <hr class="my-6 border-zinc-200 dark:border-zinc-700">

            <div x-data="{ confirmingUserDeletion: false }" class="space-y-6">
                <flux:heading level="2">{{ __('Delete Account') }}</flux:heading>
                <flux:subheading>{{ __('Permanently delete your account.') }}</flux:subheading>

                <flux:text>
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </flux:text>

                <flux:button variant="danger" x-on:click="confirmingUserDeletion = true">
                    {{ __('Delete Account') }}
                </flux:button>

                {{-- Confirmation Modal --}}
                <flux:modal wire:model="confirmingUserDeletion" max-width="lg" x-show="confirmingUserDeletion" @close="confirmingUserDeletion = false">
                    <form method="POST" action="{{ route('settings.delete-account') }}" class="p-6">
                        @csrf
                        @method('DELETE')

                        <flux:heading level="2" class="text-lg font-medium">
                            {{ __('Are you sure you want to delete your account?') }}
                        </flux:heading>

                        <flux:text class="mt-4">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </flux:text>

                        <div class="mt-6">
                            <flux:input
                                type="password"
                                name="password"
                                :label="__('Password')"
                                class="mt-1 block w-3/4"
                                placeholder="{{ __('Password') }}"
                                required
                                autocomplete="current-password"
                            />
                             @error('password', 'userDeletion')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6 flex justify-end">
                            <flux:button type="button" variant="subtle" x-on:click="confirmingUserDeletion = false">
                                {{ __('Cancel') }}
                            </flux:button>

                            <flux:button type="submit" variant="danger" class="ms-3">
                                {{ __('Delete Account') }}
                            </flux:button>
                        </div>
                    </form>
                </flux:modal>
            </div>

        </x-settings.layout>
    </section>
</x-layouts.app>