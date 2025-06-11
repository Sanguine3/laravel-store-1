@props(['name'])

<select name="{{ $name }}" {{ $attributes->merge(['class' => 'border rounded px-3 py-2 focus:outline-none focus:ring']) }}>
    {{ $slot }}
</select> 