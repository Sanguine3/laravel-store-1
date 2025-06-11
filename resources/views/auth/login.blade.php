<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        {{-- Display general validation errors if any --}}
        @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
            <div class="mb-4 rounded-md bg-red-50 p-4 dark:bg-red-900/30">
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
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <x-input
                name="email"
                label="{{ __('Email address') }}"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
                value="{{ old('email') }}"
            />

            <!-- Password -->
            <div class="relative">
                <x-input
                    name="password"
                    label="{{ __('Password') }}"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="{{ __('Password') }}"
                />

                @if (Route::has('password.request'))
                    <x-link class="absolute end-0 top-0 text-sm" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </x-link>
                @endif
            </div>

            <!-- Remember Me -->
            <x-checkbox
                name="remember"
                label="{{ __('Remember me') }}"
                checked="{{ old('remember') }}"
            />

            <div class="flex items-center justify-end">
                <x-button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</x-button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
                {{ __('Don\'t have an account?') }}
                <x-link :href="route('register.form')">{{ __('Sign up') }}</x-link>
            </div>
        @endif
    </div>
</x-layouts.auth>
