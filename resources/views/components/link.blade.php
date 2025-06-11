@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'text-blue-600 hover:underline']) }}>
    {{ $slot }}
</a> 