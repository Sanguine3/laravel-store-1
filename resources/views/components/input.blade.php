@props([
    'label' => null,
    'name',
    'value' => null,
    'type' => 'text'
])

<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    @if ($label)
        <label for="{{ $name }}" class="mb-1 font-medium text-gray-700">{{ $label }}</label>
    @endif
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->except(['class','name','value','type','label'])->merge(['class' => 'border rounded px-3 py-2 focus:outline-none focus:ring']) }}
    />
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div> 