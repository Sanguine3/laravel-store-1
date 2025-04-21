<x-layouts.app :title="__('Product Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <livewire:products.product-detail :productId="$productId" />
    </div>
</x-layouts.app>
