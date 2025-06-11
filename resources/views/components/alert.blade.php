<div {{ $attributes->merge(['class' => 'border-l-4 p-4 bg-blue-50 border-blue-400']) }} x-data="{ show: true }" x-show="show">
    <button type="button" x-on:click="show = false" class="float-right text-xl leading-none">&times;</button>
    <div class="mt-2 text-sm text-blue-700">
        {{ $slot }}
    </div>
</div> 