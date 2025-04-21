<div>
    <div class="mb-4 flex items-center justify-between">
        <h2 class="text-xl font-semibold dark:text-white">Products</h2>
        <div class="flex items-center">
            <x-flux::input wire:model.live.debounce.300ms="search" placeholder="Search products..." class="w-64" icon="magnifying-glass" />
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            <button wire:click="sortBy('name')" class="flex items-center space-x-1">
                                <span>Name</span>
                                @if($sortField === 'name')
                                    <span>
                                        @if($sortDirection === 'asc')
                                            <x-flux::icon name="arrow-up" class="h-3 w-3" />
                                        @else
                                            <x-flux::icon name="arrow-down" class="h-3 w-3" />
                                        @endif
                                    </span>
                                @endif
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            <button wire:click="sortBy('price')" class="flex items-center space-x-1">
                                <span>Price</span>
                                @if($sortField === 'price')
                                    <span>
                                        @if($sortDirection === 'asc')
                                            <x-flux::icon name="arrow-up" class="h-3 w-3" />
                                        @else
                                            <x-flux::icon name="arrow-down" class="h-3 w-3" />
                                        @endif
                                    </span>
                                @endif
                            </button>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            Stock
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-700 dark:bg-zinc-900">
                    @forelse($products as $product)
                        <tr class="cursor-pointer hover:bg-gray-50 dark:hover:bg-zinc-800" wire:click="showProductDetail({{ $product->id }})">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center">
                                    @if($product->image)
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        </div>
                                    @else
                                        <div class="flex h-10 w-10 items-center justify-center rounded-md bg-neutral-100 dark:bg-neutral-800">
                                            <x-flux::icon name="photo" class="h-6 w-6 text-neutral-400" />
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                            {{ $product->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm text-neutral-900 dark:text-white">${{ number_format($product->price, 2) }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm text-neutral-900 dark:text-white">{{ $product->category->name ?? 'Uncategorized' }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm text-neutral-900 dark:text-white">{{ $product->stock_quantity }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if($product->is_published)
                                    <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 dark:bg-green-800/30 dark:text-green-500">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-neutral-100 px-2 text-xs font-semibold leading-5 text-neutral-800 dark:bg-neutral-700/30 dark:text-neutral-400">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <button
                                    wire:click.stop="showProductDetail({{ $product->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="showProductDetail({{ $product->id }})"
                                    class="p-2 rounded-full text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                    <x-flux::icon wire:loading.remove wire:target="showProductDetail({{ $product->id }})" name="eye" class="h-5 w-5" />
                                    <x-flux::icon wire:loading wire:target="showProductDetail({{ $product->id }})" name="arrow-path" class="h-5 w-5 animate-spin" />
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-neutral-200 bg-white px-4 py-3 dark:border-neutral-700 dark:bg-zinc-900">
            {{ $products->links() }}
        </div>
    </div>
</div>
