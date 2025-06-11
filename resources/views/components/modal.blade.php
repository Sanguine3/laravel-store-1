@props(['show'])

<div x-show="{{ $show }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-lg overflow-hidden']) }}>
        {{ $slot }}
    </div>
</div> 