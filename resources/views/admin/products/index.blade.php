<x-layouts.admin>
    @if (session('status'))
        <div class="mb-4 px-4 py-2 rounded bg-green-100 text-green-800 border border-green-300">
            {{ session('status') }}
        </div>
    @endif
    <div class="flex flex-col gap-6">
        <!-- Search and Filters Form -->
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between sm:gap-4">
            <div class="flex flex-row gap-2 sm:flex-row flex-1 items-stretch sm:items-end">
                <!-- Search Input -->
                <div class="flex-[2_2_0%] min-w-0">
                    <label for="product-search" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                    <flux:input
                        name="search"
                        id="product-search"
                        placeholder="Search name or SKU..."
                        icon="magnifying-glass"
                        clearable
                        class="w-full min-w-0"
                        value="{{ $search ?? '' }}"
                    />
                </div>
                <!-- Category Filter -->
                <div class="flex-1 min-w-0" x-data="{ openCategory: false, selectedCategory: '{{ $categoryFilter ?? '' }}' }">
                    <label for="category-filter-button" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Category</label>
                    <input type="hidden" name="category" x-model="selectedCategory">
                    <div class="relative">
                        <flux:button id="category-filter-button" icon:trailing="chevron-down" class="w-full flex justify-between" @click="openCategory = !openCategory">
                            <span x-text="$refs.categoryName{{ $categoryFilter ?? 'all' }}.textContent.trim()">{{ $categories->firstWhere('id', $categoryFilter)?->name ?? 'All Categories' }}</span>
                        </flux:button>
                        <div x-show="openCategory" @click.away="openCategory = false" class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-700 shadow-lg rounded-md border border-zinc-200 dark:border-zinc-600" style="display: none;">
                            <flux:menu>
                                <flux:menu.item @click="selectedCategory = ''; openCategory = false">
                                    <span x-ref="categoryNameall">All Categories</span>
                                </flux:menu.item>
                                @foreach($categories as $category)
                                    <flux:menu.item @click="selectedCategory = '{{ $category->id }}'; openCategory = false">
                                        <span x-ref="categoryName{{ $category->id }}">{{ $category->name }}</span>
                                    </flux:menu.item>
                                @endforeach
                            </flux:menu>
                        </div>
                    </div>
                </div>
                <!-- Status Filter -->
                <div class="flex-1 min-w-0" x-data="{ openStatus: false, selectedStatus: '{{ $statusFilter ?? '' }}' }">
                     <label for="status-filter-button" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                     <input type="hidden" name="status" x-model="selectedStatus">
                     <div class="relative">
                        <flux:button id="status-filter-button" icon:trailing="chevron-down" color="outline" class="w-full flex justify-between" @click="openStatus = !openStatus">
                             <span x-text="selectedStatus === '' ? 'All Status' : (selectedStatus === 'published' ? 'Published' : 'Draft')">
                                {{ $statusFilter === '' ? 'All Status' : ($statusFilter === 'published' ? 'Published' : 'Draft') }}
                             </span>
                        </flux:button>
                        <div x-show="openStatus" @click.away="openStatus = false" class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-700 shadow-lg rounded-md border border-zinc-200 dark:border-zinc-600" style="display: none;">
                            <flux:menu>
                                <flux:menu.item @click="selectedStatus = ''; openStatus = false">All Status</flux:menu.item>
                                <flux:menu.item @click="selectedStatus = 'published'; openStatus = false">Published</flux:menu.item>
                                <flux:menu.item @click="selectedStatus = 'draft'; openStatus = false">Draft</flux:menu.item>
                            </flux:menu>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Apply Filters Button -->
            <div class="flex items-stretch sm:items-end gap-2 w-full sm:w-auto">
                 <flux:button type="submit" color="primary" class="w-full sm:w-auto">Apply Filters</flux:button>
            </div>
        </form>

        <!-- Add New Product Button -->
        <div class="flex justify-end">
            <flux:button href="{{ route('admin.products.create') }}" color="warning" icon="plus" size="base" class="!bg-amber-700 !text-white !shadow-lg !ring-0 !outline-none hover:!bg-amber-800 focus:!ring-0 focus:!outline-none">
                Add New Product
            </flux:button>
        </div>
        <!-- Products Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Product</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Stock</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
                                        <img class="h-full w-full object-cover" src="{{ $product->image_url ?? 'https://via.placeholder.com/100' }}" alt="{{ $product->name }}"> {{-- Assuming image_url field --}}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $product->name }}</span>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">SKU: {{ $product->sku ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">${{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $product->category?->name ?? 'Uncategorized' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $product->stock_quantity ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($product->is_published)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Published</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-zinc-100 text-zinc-500 dark:bg-zinc-700/30 dark:text-zinc-400">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-1">
                                    <flux:button href="{{ route('admin.products.edit', $product->id) }}" as="a" color="warning" size="sm" icon="pencil" tooltip="Edit" class="!bg-yellow-400 !text-zinc-900 hover:!bg-yellow-500 focus:!ring-yellow-300" />
                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" color="danger" size="sm" icon="trash" tooltip="Delete" square class="!bg-red-600 !text-white hover:!bg-red-700 focus:!ring-red-400" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">No products found matching your criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if ($products->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                <!-- Pagination links will automatically include filter parameters due to withQueryString() -->
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- Include AlpineJS if not already included globally -->
    <!-- <script src="//unpkg.com/alpinejs" defer></script> -->
</x-layouts.admin>