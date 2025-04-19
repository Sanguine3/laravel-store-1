<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-auto my-12 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Forgot password')" :description="__('Enter your email to receive a password reset link')" />

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <form wire:submit.prevent="sendPasswordResetLink" class="flex flex-col gap-6">
                <!-- Email Address -->
                <flux:input
                    wire:model.defer="email"
                    :label="__('Email Address')"
                    type="email"
                    required
                    autofocus
                    placeholder="email@example.com"
                />

                <flux:button variant="primary" type="submit" class="w-full">{{ __('Email password reset link') }}</flux:button>
            </form>

            <div class="text-center text-sm space-x-1 rtl:space-x-reverse text-zinc-400">
                {{ __('Or, return to') }}
                <flux:link :href="route('login')" wire:navigate>{{ __('log in') }}</flux:link>
            </div>
        </div>
    </div>
</div>
