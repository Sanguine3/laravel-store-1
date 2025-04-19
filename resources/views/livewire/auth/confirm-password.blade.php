<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-auto my-12 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6">
            <x-auth-header
                :title="__('Confirm password')"
                :description="__('This is a secure area of the application. Please confirm your password before continuing.')"
            />

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <form wire:submit.prevent="confirmPassword" class="flex flex-col gap-6">
                <flux:input
                    wire:model.defer="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                />
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <flux:button variant="primary" type="submit" class="w-full">
                    {{ __('Confirm') }}
                </flux:button>
            </form>
        </div>
    </div>
</div>
