@props([
    'name',
    'label',
    'checked' => false,
])

<div {{ $attributes->merge(['class' => 'flex items-center']) }}>
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $checked ? 'checked' : '' }}
        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
    />
    <label for="{{ $name }}" class="ml-2 text-gray-700">
        {{ $label }}
    </label>
</div> 