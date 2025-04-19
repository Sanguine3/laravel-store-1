<div>
    @php
    use App\Models\User;
    use Illuminate\Auth\Events\Registered;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\Rules;
    @endphp

    <div class="w-full max-w-md mx-auto my-12 px-4 sm:px-6 lg:px-8 flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit.prevent="register" class="flex flex-col gap-6 mt-8">
        <!-- Name -->
        <flux:input wire:model.defer="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
            :placeholder="__('Full name')" />

        <!-- Email Address -->
        <flux:input wire:model.defer="email" :label="__('Email address')" type="email" required autocomplete="email"
            placeholder="email@example.com" />

        <!-- Password -->
        <flux:input wire:model.defer="password" :label="__('Password')" type="password" required autocomplete="new-password"
            :placeholder="__('Password')" />

        <!-- Confirm Password -->
        <flux:input wire:model.defer="password_confirmation" :label="__('Confirm password')" type="password" required
            autocomplete="new-password" :placeholder="__('Confirm password')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Create account') }}</flux:button>
        </div>
    </form>

    <div class="text-center text-sm space-x-1 rtl:space-x-reverse text-zinc-600 dark:text-zinc-400 mt-4">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
    </div>
</div>

@script
<script>
    $wire.on('register', async () => {
        const validated = await $wire.validate({
            name: ['required', 'string', 'max:255'],
            email: ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            password: ['required', 'string', 'confirmed', 'min:8'],
        });

        if (validated.errors.length) {
            return;
        }

        try {
            await $wire.call('register');
            window.location.href = '{{ route('dashboard') }}';
        } catch (error) {
            console.error('Registration failed:', error);
        }
    });
</script>
@endscript
