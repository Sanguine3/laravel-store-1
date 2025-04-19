<div>
    @php
    use Illuminate\Support\Facades\Route;
    @endphp

<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-auto my-12 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6">
    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit.prevent="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model.defer="email"
            :label="__('Email address')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div>
            <flux:input
                wire:model.defer="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
            />
        </div>

        @if (Route::has('password.request'))
            <div class="mb-2">
                <flux:link class="text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            </div>
        @endif

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="text-center text-sm space-x-1 rtl:space-x-reverse text-zinc-600 dark:text-zinc-400 mt-4">
            {{ __('Don\'t have an account?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
        </div>
    </div>
</div>
