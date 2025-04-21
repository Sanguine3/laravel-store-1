<div class="w-full">
    @if($showModal)
        <!-- Modal overlay with dimmed background -->
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black bg-opacity-60 transition-opacity" aria-hidden="true" wire:click="returnToProducts"></div>

            <!-- Modal panel -->
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all dark:bg-zinc-900 sm:my-8 sm:w-full sm:max-w-3xl">
                    <!-- Close button in the top-left corner -->
                    <button wire:click="returnToProducts" class="absolute top-4 left-4 rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 dark:hover:bg-zinc-800">
                        <x-flux::icon name="arrow-left" class="h-6 w-6" />
                    </button>

                    <!-- Loading spinner -->
                    @if($loading)
                    <div class="flex items-center justify-center p-12">
                        <div class="flex flex-col items-center">
                            <div class="mb-4">
                                <svg class="h-12 w-12 animate-spin text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <p class="text-lg font-medium text-gray-900 dark:text-white">Loading product details...</p>
                        </div>
                    </div>
                    @endif

                    <!-- Error message -->
                    @if($error && !$loading)
                    <div class="rounded-xl bg-red-50 p-6 dark:bg-red-900/20">
                        <div class="flex flex-col items-center text-center">
                            <div class="mb-4 text-red-500">
                                <x-flux::icon name="exclamation-triangle" class="h-12 w-12" />
                            </div>
                            <p class="text-lg font-medium text-red-600 dark:text-red-400">{{ $error }}</p>
                            <div class="mt-6">
                                <x-flux::button wire:click="returnToProducts" variant="outline" class="px-6">Close</x-flux::button>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Product details content -->
                    @if(!$loading && !$error && $product)
    <div class="rounded-xl bg-white dark:bg-zinc-900 overflow-hidden">
        <div class="relative">
            <!-- Product image banner -->
            <div class="h-64 w-full bg-gradient-to-r from-blue-500 to-purple-600 relative overflow-hidden">
                @if($product->image)
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover opacity-75"
                    >
                @endif
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-end">
                    <div class="p-8">
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $product->name }}</h1>
                        <div class="flex items-center">
                            @if($product->is_published)
                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800">
                                    Published
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-neutral-100 px-3 py-1 text-sm font-semibold text-neutral-800">
                                    Draft
                                </span>
                            @endif
                            <span class="mx-2 text-white">•</span>
                            <span class="text-white">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Left column: Details -->
                <div class="md:col-span-2">
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4 dark:text-white">Product Description</h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4 dark:text-white">Product Details</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</h3>
                                <p class="text-lg font-medium dark:text-white">{{ $product->category->name ?? 'Uncategorized' }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock</h3>
                                <p class="text-lg font-medium dark:text-white">{{ $product->stock_quantity }} units</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h3>
                                <p class="text-lg font-medium dark:text-white">
                                    @if($product->is_published)
                                        <span class="text-green-600 dark:text-green-400">Published</span>
                                    @else
                                        <span class="text-gray-600 dark:text-gray-400">Draft</span>
                                    @endif
                                </p>
                            </div>
                            <div class="bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Product ID</h3>
                                <p class="text-lg font-medium dark:text-white">{{ $product->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right column: Price and actions -->
                <div class="bg-gray-50 dark:bg-zinc-800 p-6 rounded-xl h-fit">
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Price</h3>
                        <p class="text-5xl font-bold text-blue-600 dark:text-blue-400">${{ number_format($product->price, 2) }}</p>
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center mb-2">
                            <x-flux::icon name="check" class="h-5 w-5 text-green-500 mr-2" />
                            <span class="text-sm text-gray-600 dark:text-gray-300">In stock: {{ $product->stock_quantity }} available</span>
                        </div>
                        <div class="flex items-center">
                            <x-flux::icon name="truck" class="h-5 w-5 text-blue-500 mr-2" />
                            <span class="text-sm text-gray-600 dark:text-gray-300">Free shipping</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <x-flux::button class="w-full justify-center py-3 text-base" variant="primary">
                            <x-flux::icon name="shopping-cart" class="h-5 w-5 mr-2" />
                            Add to Cart
                        </x-flux::button>

                        <x-flux::button class="w-full justify-center py-3 text-base" variant="outline">
                            <x-flux::icon name="credit-card" class="h-5 w-5 mr-2" />
                            Buy Now
                        </x-flux::button>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
