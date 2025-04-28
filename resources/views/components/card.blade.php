<div {{ $attributes->merge(['class' => 'bg-white dark:bg-zinc-800 overflow-hidden shadow-sm rounded-xl']) }}>
    <div class="p-6">
        {{ $slot }}
    </div>
</div>