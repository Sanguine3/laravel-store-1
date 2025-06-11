<x-layouts.app> {{-- Add main app layout wrapper --}}
    <section class="w-full">
        @include('partials.settings-heading')

        <x-settings.layout :heading="__('Appearance')" :subheading=" __('Update the appearance settings for your account')">
            <div x-data x-model="$flux.appearance" class="mt-6 flex space-x-4">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="appearance" value="light" x-model="$flux.appearance" class="form-radio text-blue-600" />
                    <span>{{ __('Light') }}</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="appearance" value="dark" x-model="$flux.appearance" class="form-radio text-blue-600" />
                    <span>{{ __('Dark') }}</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="appearance" value="system" x-model="$flux.appearance" class="form-radio text-blue-600" />
                    <span>{{ __('System') }}</span>
                </label>
            </div>
        </x-settings.layout>
    </section>
</x-layouts.app> {{-- Close main app layout wrapper --}}
