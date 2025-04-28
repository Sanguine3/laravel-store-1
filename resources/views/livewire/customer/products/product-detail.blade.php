<div>
    @if($showModal)
        <flux:modal wire:model.live="showModal" max-width="md">
            @if($loading)
                <div class="p-12 flex justify-center items-center min-h-[200px]">
                    <svg class="h-12 w-12 animate-spin text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            @elseif($error)
                <div class="p-8 text-center">
                    <div class="mb-4 text-red-500">
                        <flux:icon name="exclamation-triangle" class="h-10 w-10 mx-auto" />
                    </div>
                    <p class="text-lg font-semibold text-red-600 dark:text-red-400">{{ $error }}</p>
                </div>
            @elseif($product)
                <div class="px-8 pt-8 pb-4 border-b border-neutral-200 dark:border-zinc-700">
                    <h3 class="text-2xl font-bold leading-tight text-neutral-900 dark:text-white" id="modal-title">
                        {{ $product->name }}
                    </h3>
                    <p class="text-base text-neutral-500 dark:text-neutral-400 mt-1">
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </p>
                </div>
                <div class="px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center min-h-[330px] md:min-h-[480px]">
                        <div class="md:col-span-1 flex items-center justify-center">
                            <img src="{{ $product->image_path ?? 'https://via.placeholder.com/400' }}" alt="{{ $product->name }}" class="rounded-lg object-cover w-full max-w-xs aspect-square shadow border border-neutral-200 dark:border-zinc-800">
                        </div>
                        <div class="md:col-span-2 space-y-6 flex flex-col justify-center">
                            <div>
                                <h4 class="text-base font-medium text-neutral-600 dark:text-neutral-300">Description</h4>
                                <p class="text-base text-neutral-800 dark:text-neutral-200 mt-2 leading-relaxed">{{ $product->description }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-base font-medium text-neutral-600 dark:text-neutral-300">Price</h4>
                                    <p class="text-xl font-bold text-orange-600 dark:text-orange-400 mt-2">${{ number_format($product->price, 2) }}</p>
                                </div>
                                <div>
                                    <h4 class="text-base font-medium text-neutral-600 dark:text-neutral-300">Stock</h4>
                                    <p class="text-lg font-semibold dark:text-white mt-2">{{ $product->stock_quantity }} units</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-8 py-4 bg-neutral-50 dark:bg-zinc-800 border-t border-neutral-200 dark:border-zinc-700 flex justify-end">
                    <flux:button variant="primary" class="px-6 py-2 font-semibold">Add to Cart</flux:button>
                </div>
            @endif
        </flux:modal>
    @endif
</div>
