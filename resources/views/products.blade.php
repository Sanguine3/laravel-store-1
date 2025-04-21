<x-layouts.app :title="__('Products')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold dark:text-white">Products</h1>
        </div>

        <div class="flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <livewire:products.product-list />
        </div>

        <livewire:products.product-detail />
    </div>
</x-layouts.app>
