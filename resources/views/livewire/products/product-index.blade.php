<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 flex flex-col items-center gap-4">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Browse Products</h2>
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full max-w-2xl">
                    <!-- Search Input (twice as wide as category) -->
                    <div class="flex-1 min-w-0">
                        <flux:input wire:model.live.debounce.300ms="search" id="product-search" placeholder="Search products..." icon="magnifying-glass" class="w-full" />
                    </div>
                    <!-- Category Filter (fixed width) -->
                    <div class="w-full sm:w-48">
                        <flux:select wire:model.live="categoryFilter" id="category-filter" class="w-full">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            @if($products->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div wire:key="product-{{ $product->id }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                            <a href="#" wire:click.prevent="$dispatchTo('products.product-detail', 'setProduct', [{{ $product->id }}])">
                                <img src="{{ $product->image_path ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}" class="h-48 w-full object-cover">
                            </a>
                            <div class="p-4 flex items-center gap-4">
                                <img src="{{ $product->image_path ?? 'https://via.placeholder.com/80' }}" alt="{{ $product->name }}" class="h-16 w-16 object-cover rounded-md border border-neutral-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-1 truncate">{{ $product->name }}</h4>
                                    <p class="text-lg font-bold text-orange-600 dark:text-orange-400 mb-1">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                            <div class="px-4 pb-4">
                                <button wire:click.prevent="$dispatchTo('products.product-detail', 'setProduct', [{{ $product->id }}])" class="w-full text-sm px-3 py-1.5 bg-orange-600 hover:bg-orange-700 text-white rounded-md">Details</button>
                                {{-- Add Add-to-Cart button/logic here if needed --}}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <flux:icon name="cube" class="h-12 w-12 mx-auto text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No products found</h3>
                    @if($search || $categoryFilter)
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search or filter criteria.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <livewire:products.product-detail />
</div>