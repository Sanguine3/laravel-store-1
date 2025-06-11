<x-layouts.app> {{-- Add main app layout wrapper --}}
    <section class="w-full">
        @include('partials.settings-heading')

        <x-settings.layout :heading="__('Appearance')" :subheading=" __('Update the appearance settings for your account')">
            {{-- Use Alpine.js for client-side theme switching as per Flux docs --}}
            <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class="mt-6">
                <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
                <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
                <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
            </flux:radio.group>
        </x-settings.layout>
    </section>
</x-layouts.app> {{-- Close main app layout wrapper --}}
