@props([
    'label' => null,
    'name',
    'rows' => 4,
])

<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    @if ($label)
        <label for="{{ $name }}" class="mb-1 font-medium text-gray-700">{{ $label }}</label>
    @endif
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->except(['class','label','name','rows'])->merge(['class' => 'border rounded px-3 py-2 focus:outline-none focus:ring']) }}
    >{{ $slot }}</textarea>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div> 