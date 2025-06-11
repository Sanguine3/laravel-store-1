@props([
    'type' => 'button',
    'variant' => 'primary'
])

@php
    $classes = $variant === 'primary'
        ? 'bg-blue-600 text-white hover:bg-blue-700'
        : 'bg-gray-200 text-gray-800 hover:bg-gray-300';
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'px-4 py-2 rounded ' . $classes]) }}
>
    {{ $slot }}
</button> 