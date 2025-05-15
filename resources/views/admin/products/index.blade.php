<x-layouts.admin>
    @if (session('status'))
        <div class="mb-4 px-4 py-2 rounded bg-green-100 text-green-800 border border-green-300">
            {{ session('status') }}
        </div>
    @endif
    <div class="flex flex-col gap-6">
        <!-- Search and Filters Form -->
        <form method="GET" action="{{ route('admin.products.index') }}"
              class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between sm:gap-4"
              x-data="{ searchTerm: '{{ $search ?? '' }}' }">
            <div class="flex flex-row gap-2 sm:flex-row flex-1 items-stretch sm:items-end">
                <!-- Search Input -->
                <div class="flex-[2_2_0%] min-w-0 relative">
                    <label for="product-search" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                    <flux:input
                        name="search"
                        id="product-search"
                        placeholder="Search name or SKU..."
                        icon="magnifying-glass"
                        clearable
                        class="w-full min-w-0"
                        value="{{ $search ?? '' }}"
                        x-model="searchTerm"
                    />
                    <span x-show="searchTerm.length > 0" x-cloak
                          class="absolute right-10 top-1/2 mt-2.5 -translate-y-1/2 text-xs text-zinc-500 dark:text-zinc-400 pr-2"
                          x-text="searchTerm.length"></span>
                </div>
                <!-- Category Filter -->
                <div class="flex-1 min-w-0"
                     x-data="{ openCategoryFilter: false, selectedCategoryFilter: '{{ $categoryFilter ?? '' }}', categoriesMap: {{ Js::from($categories->pluck('name', 'id')) }} }">
                    <label for="category-filter-button"
                           class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Category</label>
                    <input type="hidden" name="category" x-model="selectedCategoryFilter">
                    <div class="relative">
                        <button @click="openCategoryFilter = !openCategoryFilter" type="button"
                                id="category-filter-button"
                                class="w-full flex items-center justify-between px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm bg-white dark:bg-zinc-700 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span
                                x-text="selectedCategoryFilter === '' ? 'All Categories' : (categoriesMap[selectedCategoryFilter] || 'All Categories')">
                                {{ $categories->firstWhere('id', $categoryFilter)?->name ?? 'All Categories' }}
                            </span>
                            <svg class="ml-2 -mr-0.5 h-4 w-4 text-zinc-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div x-show="openCategoryFilter" @click.away="openCategoryFilter = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-700 shadow-lg rounded-md border border-zinc-200 dark:border-zinc-600 max-h-60 overflow-y-auto py-1"
                             style="display: none;">
                            <a href="#" @click.prevent="selectedCategoryFilter = ''; openCategoryFilter = false"
                               class="block px-4 py-2 text-sm text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-600">All
                                Categories</a>
                            @foreach($categories as $category)
                                <a href="#"
                                   @click.prevent="selectedCategoryFilter = '{{ $category->id }}'; openCategoryFilter = false"
                                   class="block px-4 py-2 text-sm text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-600">{{ $category->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Status Filter -->
                <div class="flex-1 min-w-0"
                     x-data="{ openStatusFilter: false, selectedStatusFilter: '{{ $statusFilter ?? '' }}' }">
                    <label for="status-filter-button"
                           class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                    <input type="hidden" name="status" x-model="selectedStatusFilter">
                    <div class="relative">
                        <button @click="openStatusFilter = !openStatusFilter" type="button" id="status-filter-button"
                                class="w-full flex items-center justify-between px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm bg-white dark:bg-zinc-700 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                             <span
                                 x-text="selectedStatusFilter === '' ? 'All Status' : (selectedStatusFilter === 'published' ? 'Published' : 'Draft')">
                                {{ $statusFilter === '' ? 'All Status' : ($statusFilter === 'published' ? 'Published' : 'Draft') }}
                             </span>
                            <svg class="ml-2 -mr-0.5 h-4 w-4 text-zinc-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div x-show="openStatusFilter" @click.away="openStatusFilter = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-700 shadow-lg rounded-md border border-zinc-200 dark:border-zinc-600 max-h-60 overflow-y-auto py-1"
                             style="display: none;">
                            <a href="#" @click.prevent="selectedStatusFilter = ''; openStatusFilter = false"
                               class="block px-4 py-2 text-sm text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-600">All
                                Status</a>
                            <a href="#" @click.prevent="selectedStatusFilter = 'published'; openStatusFilter = false"
                               class="block px-4 py-2 text-sm text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-600">Published</a>
                            <a href="#" @click.prevent="selectedStatusFilter = 'draft'; openStatusFilter = false"
                               class="block px-4 py-2 text-sm text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-600">Draft</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Apply Filters Button -->
            <div class="flex items-stretch sm:items-end gap-2 w-full sm:w-auto">
                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-400 dark:focus:ring-blue-600">
                    Apply Filters
                </button>
            </div>
        </form>

        <!-- Add New Product Button -->
        <div class="flex justify-end">
            <flux:button href="{{ route('admin.products.create') }}" color="warning" icon="plus" size="base"
                         class="!bg-amber-700 !text-white !shadow-lg !ring-0 !outline-none hover:!bg-amber-800 focus:!ring-0 focus:!outline-none">
                Add New Product
            </flux:button>
        </div>
        <!-- Products Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Product
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Price
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Category
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Stock
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex-shrink-0 h-10 w-10 rounded-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
                                    <img class="h-full w-full object-cover"
                                         src="{{ $product->image ?? 'https://via.placeholder.com/100' }}"
                                         alt="{{ $product->name }}"> {{-- Using 'image' field from DB --}}
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-medium text-zinc-900 dark:text-white">{{ $product->name }}</span>
                                    <span
                                        class="text-xs text-zinc-500 dark:text-zinc-400">SKU: {{ $product->sku ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                            ${{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $product->category?->name ?? 'Uncategorized' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $product->stock_quantity ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($product->is_published)
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Published</span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-zinc-100 text-zinc-500 dark:bg-zinc-700/30 dark:text-zinc-400">Draft</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end items-center gap-1">
                                <flux:button href="{{ route('admin.products.edit', $product->id) }}" as="a"
                                             color="warning" size="sm" icon="pencil" tooltip="Edit"
                                             class="!bg-yellow-400 !text-zinc-900 hover:!bg-yellow-500 focus:!ring-yellow-300"/>
                                <!-- Delete Form -->
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" color="danger" size="sm" icon="trash" tooltip="Delete"
                                                 square
                                                 class="!bg-red-600 !text-white hover:!bg-red-700 focus:!ring-red-400"/>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">No products found
                            matching your criteria.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if ($products->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
