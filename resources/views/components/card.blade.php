@props(['padding' => 'p-6', 'variant' => 'default'])

@php
    $classes = [
        'default' => 'bg-white dark:bg-zinc-800 overflow-hidden shadow-sm rounded-xl',
        'primary' => 'border border-blue-500 dark:border-blue-700 bg-blue-50 dark:bg-blue-900/20 shadow-md rounded-lg', // Example primary
        'success' => 'border border-green-500 dark:border-green-700 bg-green-50 dark:bg-green-900/20 shadow-md rounded-lg', // Example success
        'danger' => 'border border-red-500 dark:border-red-700 bg-red-50 dark:bg-red-900/20 shadow-md rounded-lg', // Example danger
        'warning' => 'border border-amber-500 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/20 shadow-md rounded-lg', // Example warning
    ];

    $variantClass = $classes[$variant] ?? $classes['default'];
@endphp

<div {{ $attributes->merge(['class' => $variantClass]) }}>
    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>
