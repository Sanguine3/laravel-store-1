@props([
    'size' => null,
    'inset' => null,
])

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full']) }}>
    {{ $slot }}
</span> 