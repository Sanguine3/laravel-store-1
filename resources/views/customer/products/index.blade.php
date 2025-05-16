<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Browse Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div x-data="{
                search: '{{ $search ?? '' }}',
                categoryFilter: '{{ $categoryFilter ?? '' }}',
                currentSortField: '{{ $sortField ?? 'name' }}',
                currentSortDirection: '{{ $sortDirection ?? 'asc' }}'
             }"
             class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header & Filters -->
            <div class="mb-6">
                <form x-ref="filterForm" method="GET" action="{{ route('products.index') }}"
                      class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg shadow-sm border dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <!-- Search Input -->
                        <div class="flex-1 min-w-0 w-full">
                            <label for="product-search" class="sr-only">Search products</label>
                            <flux:input type="search" name="search" x-model="search"
                                        @input.debounce.300ms="$refs.filterForm.submit()" id="product-search"
                                        placeholder="Search products..." icon="magnifying-glass" class="w-full"/>
                        </div>

                        <!-- Category Filter (Flux Select) -->
                        <div class="w-full sm:w-56">
                            <label for="category-filter-flux" class="sr-only">Filter by category</label>
                            <flux:select name="category" x-model="categoryFilter" @change="$refs.filterForm.submit()"
                                         id="category-filter-flux" class="w-full">
                                <flux:select.option value="">All Categories</flux:select.option>
                                @foreach($categories as $category)
                                    <flux:select.option
                                        value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>
                        <!-- Submit Button (Optional, kept for explicit filtering) -->
                        <div class="w-full sm:w-auto">
                            <button type="submit"
                                    class="w-full sm:w-auto text-sm px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-md">
                                Filter
                            </button>
                        </div>
                        <!-- Clear Button -->
                        <div class="w-full sm:w-auto">
                            <button type="button"
                                    @click="search = ''; categoryFilter = ''; $nextTick(() => $refs.filterForm.submit())"
                                    class="w-full sm:w-auto text-sm px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white rounded-md">
                                Clear Filters {{-- Text was 'Clear', changed to 'Clear Filters' for clarity --}}
                            </button>
                        </div>
                    </div>
                    {{-- Hidden inputs for sorting are removed, handled by links now --}}
                </form>
            </div>

            <!-- Sorting Links -->
            <div class="mb-4 text-sm flex items-center gap-4 text-gray-600 dark:text-gray-400">
                <span>Sort by:</span>
                @php
                    $defaultSortParams = request()->except(['sort_by', 'direction', 'page']); // Params for default sort link
                    $sortParamsName = array_merge($defaultSortParams, ['sort_by' => 'name', 'direction' => ($sortField == 'name' && $sortDirection == 'asc') ? 'desc' : 'asc']);
                    $sortParamsPrice = array_merge($defaultSortParams, ['sort_by' => 'price', 'direction' => ($sortField == 'price' && $sortDirection == 'asc') ? 'desc' : 'asc']);
                    $isDefaultSort = !request()->has('sort_by'); // Check if default sort is active
                @endphp
                {{-- Default Sort Link --}}
                <a href="{{ route('products.index', $defaultSortParams) }}"
                   class="hover:text-orange-600 dark:hover:text-orange-400"
                   :class="{ 'font-semibold text-orange-600 dark:text-orange-400': {{ $isDefaultSort ? 'true' : 'false' }} }">
                    Default
                </a>
                <span class="text-gray-300 dark:text-gray-600">|</span> {{-- Separator --}}
                {{-- Name Sort Link --}}
                <a href="{{ route('products.index', $sortParamsName) }}"
                   class="hover:text-orange-600 dark:hover:text-orange-400"
                   :class="{ 'font-semibold text-orange-600 dark:text-orange-400': currentSortField == 'name' }">
                    Name
                    <span x-show="currentSortField == 'name'" x-text="currentSortDirection == 'asc' ? '↑' : '↓'"></span>
                </a>
                <a href="{{ route('products.index', $sortParamsPrice) }}"
                   class="hover:text-orange-600 dark:hover:text-orange-400"
                   :class="{ 'font-semibold text-orange-600 dark:text-orange-400': currentSortField == 'price' }">
                    Price
                    <span x-show="currentSortField == 'price'"
                          x-text="currentSortDirection == 'asc' ? '↑' : '↓'"></span>
                </a>
                {{-- Add other sort links (e.g., date) if needed --}}
            </div>

            <!-- Session Messages -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
                     class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-300 shadow-md"
                     role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
                     class="mb-6 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-300 shadow-md"
                     role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Product Grid -->
            @if($products->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden flex flex-col border dark:border-gray-700">
                            <a href="{{ route('products.show', $product) }}"
                               class="block aspect-square overflow-hidden">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/300x300' }}"
                                     alt="{{ $product->name }}"
                                     class="h-full w-full object-cover transition-transform duration-300 hover:scale-105">
                            </a>
                            <div class="p-4 flex flex-col flex-grow">
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-1 truncate">
                                    <a href="{{ route('products.show', $product) }}"
                                       class="hover:text-orange-600 dark:hover:text-orange-400"
                                       title="{{ $product->name }}">{{ $product->name }}</a>
                                </h4>
                                <p class="text-lg font-bold text-orange-600 dark:text-orange-400 mb-3">
                                    ${{ number_format($product->price, 2) }}</p>

                                <div class="mt-auto">
                                    <form action="{{ route('cart.add', $product) }}" method="POST"
                                          class="flex items-center gap-2" x-data="{ quantity: 1 }">
                                        @csrf
                                        <div class="flex-shrink-0"> {{-- Container for the quantity stepper --}}
                                            <label for="quantity_{{ $product->id }}" class="sr-only">Quantity</label>
                                            <div
                                                class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md shadow-sm overflow-hidden"
                                                style="max-width: 100px;">
                                                <button
                                                    type="button"
                                                    @click="quantity = Math.max(1, quantity - 1)"
                                                    class="px-2 py-1 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50 transition-colors duration-150 ease-in-out disabled:opacity-50"
                                                    aria-label="Decrease quantity"
                                                    :disabled="quantity <= 1"
                                                >
                                                    <flux:icon name="minus" class="w-4 h-4"/>
                                                </button>
                                                <input
                                                    type="text"
                                                    {{-- Using text for appearance, Alpine handles number --}}
                                                    name="quantity"
                                                    id="quantity_{{ $product->id }}"
                                                    x-model.number="quantity"
                                                    class="w-10 text-center text-sm border-x border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-0 appearance-none [-moz-appearance:_textfield]"
                                                    readonly {{-- Value controlled by Alpine buttons --}}
                                                >
                                                <button
                                                    type="button"
                                                    @click="quantity = Math.min(quantity + 1, {{ $product->stock_quantity > 0 ? $product->stock_quantity : 999 }})"
                                                    {{-- Allow incrementing if stock is 0 but main button will be disabled --}}
                                                    class="px-2 py-1 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50 transition-colors duration-150 ease-in-out disabled:opacity-50"
                                                    aria-label="Increase quantity"
                                                    :disabled="quantity >= {{ $product->stock_quantity > 0 ? $product->stock_quantity : 0 }} || {{ $product->stock_quantity <= 0 ? 'true' : 'false' }}"
                                                >
                                                    <flux:icon name="plus" class="w-4 h-4"/>
                                                </button>
                                            </div>
                                        </div>
                                        <flux:button
                                            type="submit"
                                            variant="primary" {{-- Base variant, gradient will override background --}}
                                            size="sm"
                                            icon="shopping-cart"
                                            class="flex-grow py-1.5 text-white font-semibold shadow-md hover:shadow-lg bg-gradient-to-r from-orange-500 via-pink-500 to-purple-600 hover:from-orange-600 hover:via-pink-600 hover:to-purple-700 transition-all duration-200 ease-in-out transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50"
                                            :disabled="$product->stock_quantity <= 0"
                                        >
                                            <span
                                                class="sm:hidden">Add</span> {{-- Text for smaller screens, icon is primary --}}
                                            <span class="hidden sm:inline">Quick Add</span>
                                        </flux:button>
                                    </form>
                                    @if($product->stock_quantity <= 0)
                                        <p class="text-xs text-red-500 dark:text-red-400 mt-1 text-center">Out of
                                            stock</p>
                                    @elseif($product->stock_quantity < 10)
                                        <p class="text-xs text-amber-600 dark:text-amber-400 mt-1 text-center">
                                            Only {{ $product->stock_quantity }} left!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <flux:icon name="cube" class="h-12 w-12 mx-auto text-gray-400"/>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No products found</h3>
                    @if($search || $categoryFilter)
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search or filter
                            criteria.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
