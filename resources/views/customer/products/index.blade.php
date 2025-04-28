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
                <form x-ref="filterForm" method="GET" action="{{ route('products.index') }}" class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg shadow-sm border dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <!-- Search Input -->
                        <div class="flex-1 min-w-0 w-full">
                            <label for="product-search" class="sr-only">Search products</label>
                            {{-- Added x-model and debounce --}}
                            <flux:input type="search" name="search" x-model="search" @input.debounce.300ms="$refs.filterForm.submit()" id="product-search" placeholder="Search products..." icon="magnifying-glass" class="w-full" />
                        </div>
                        <!-- Category Filter -->
                        <div class="w-full sm:w-56">
                            <label for="category-filter" class="sr-only">Filter by category</label>
                            {{-- Added x-model and @change submit --}}
                            <flux:select name="category" x-model="categoryFilter" @change="$refs.filterForm.submit()" id="category-filter" class="w-full">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected($categoryFilter == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                        <!-- Submit Button (Optional, kept for explicit filtering) -->
                        <div class="w-full sm:w-auto">
                            <button type="submit" class="w-full sm:w-auto text-sm px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-md">Filter</button>
                        </div>
                        <!-- Clear Button -->
                        <div class="w-full sm:w-auto">
                            <button type="button"
                                    @click="search = ''; categoryFilter = ''; $nextTick(() => $refs.filterForm.submit())"
                                    class="w-full sm:w-auto text-sm px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white rounded-md">
                                Clear
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
                   <span x-show="currentSortField == 'price'" x-text="currentSortDirection == 'asc' ? '↑' : '↓'"></span>
                </a>
                 {{-- Add other sort links (e.g., date) if needed --}}
            </div>

            <!-- Product Grid -->
            @if($products->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden flex flex-col">
                            <a href="{{ route('products.show', $product) }}">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}" class="h-48 w-full object-cover">
                            </a>
                            <div class="p-4 flex items-center gap-4 flex-grow">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/80' }}" alt="{{ $product->name }}" class="h-16 w-16 object-cover rounded-md border border-neutral-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-1 truncate">
                                        <a href="{{ route('products.show', $product) }}" class="hover:text-orange-600 dark:hover:text-orange-400">{{ $product->name }}</a>
                                    </h4>
                                    <p class="text-lg font-bold text-orange-600 dark:text-orange-400 mb-1">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                            <div class="px-4 pb-4 mt-auto">
                                <a href="{{ route('products.show', $product) }}" class="block w-full text-center text-sm px-3 py-1.5 bg-orange-600 hover:bg-orange-700 text-white rounded-md">Details</a>
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
                <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <flux:icon name="cube" class="h-12 w-12 mx-auto text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No products found</h3>
                    @if($search || $categoryFilter)
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search or filter criteria.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>