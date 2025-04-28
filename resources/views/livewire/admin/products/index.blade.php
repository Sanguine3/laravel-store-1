<x-layouts.admin>
    @if (session('status'))
        <div class="mb-4 px-4 py-2 rounded bg-green-100 text-green-800 border border-green-300">
            {{ session('status') }}
        </div>
    @endif
    <div class="flex flex-col gap-6">
        <!-- Search and Filters -->
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
            <div class="flex flex-row gap-2 sm:flex-row flex-1 items-stretch sm:items-center">
                <div class="flex-[2_2_0%] min-w-0">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        id="product-search"
                        placeholder="Search products..."
                        icon="magnifying-glass"
                        clearable
                        class="w-full min-w-0"
                    />
                </div>
                <div class="flex-1 min-w-0">
                    <flux:dropdown class="min-w-[140px] max-w-xs w-full" placement="bottom-start">
                        <flux:button icon:trailing="chevron-down" class="w-full flex justify-between">
                            {{ $categories->firstWhere('id', $categoryFilter)?->name ?? 'All Categories' }}
                        </flux:button>
                        <flux:menu>
                            <flux:menu.radio.group wire:model.live="categoryFilter">
                                <flux:menu.radio value="">All Categories</flux:menu.radio>
                                @foreach($categories as $category)
                                    <flux:menu.radio value="{{ $category->id }}">{{ $category->name }}</flux:menu.radio>
                                @endforeach
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>
                </div>
            </div>
            <div class="flex items-stretch sm:items-center gap-2 w-full sm:w-auto">
                <flux:dropdown class="min-w-[160px] md:min-w-[200px] w-full" placement="bottom-start">
                    <flux:button icon:trailing="chevron-down" color="outline" class="w-full flex justify-between">
                        {{ $statusFilter === '' ? 'All Status' : ($statusFilter === 'published' ? 'Published' : 'Draft') }}
                    </flux:button>
                    <flux:menu>
                        <flux:menu.radio.group wire:model.live="statusFilter">
                            <flux:menu.radio value="">All Status</flux:menu.radio>
                            <flux:menu.radio value="published">Published</flux:menu.radio>
                            <flux:menu.radio value="draft">Draft</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>
            </div>
        </div>
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
                        <tr wire:key="product-{{ $product->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
                                        <img class="h-full w-full object-cover" src="{{ $product->image ?? 'https://via.placeholder.com/100' }}" alt="{{ $product->name }}">
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
                                <flux:button href="{{ route('admin.products.edit', $product->id) }}" as="a" color="warning" size="sm" icon="pencil" tooltip="Edit" class="mr-1 !bg-yellow-400 !text-zinc-900 hover:!bg-yellow-500 focus:!ring-yellow-300" />
                                <flux:button wire:click="delete({{ $product->id }})" color="danger" size="sm" icon="trash" tooltip="Delete" square class="!bg-red-600 !text-white hover:!bg-red-700 focus:!ring-red-400" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if ($products->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                <p class="text-sm text-zinc-700 dark:text-zinc-300">
                {{ $products->links() }}
                </p>
            </div>
        @endif
    </div>
</x-layouts.admin>
