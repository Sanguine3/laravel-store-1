<x-layouts.admin :title="__('Products')">
    <div class="flex flex-col gap-6">
        <!-- Header with Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative">
                    <flux:input wire:model.live.debounce.300ms="search" id="product-search" placeholder="Search products..." icon="magnifying-glass" />
                </div>

                <flux:select wire:model.live="categoryFilter" id="category-filter" class="min-w-[150px]">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.live="statusFilter" id="status-filter" class="min-w-[150px]">
                    <option value="">All Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                    {{-- Archived status filter not implemented in component query --}}
                    {{-- <option value="archived">Archived</option> --}}
                </flux:select>
            </div>

             <flux:button :href="route('admin.products.create')" wire:navigate variant="primary" icon="plus">
                Add New Product
            </flux:button>
        </div>

        <!-- Products Table -->
        <flux:card>
            <div class="overflow-x-auto">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Product</flux:table.column>
                        <flux:table.column>Price</flux:table.column>
                        <flux:table.column>Category</flux:table.column>
                        <flux:table.column>Stock</flux:table.column>
                        <flux:table.column>Status</flux:table.column>
                        <flux:table.column align="end">Actions</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @forelse($products as $product)
                            <flux:table.row wire:key="product-{{ $product->id }}">
                                <flux:table.cell>
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
                                             <img class="h-full w-full object-cover" src="{{ $product->image_path ?? 'https://via.placeholder.com/100' }}" alt="{{ $product->name }}">
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $product->name }}</span>
                                            <span class="text-xs text-zinc-500 dark:text-zinc-400">SKU: {{ $product->sku ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </flux:table.cell>
                                <flux:table.cell>
                                    ${{ number_format($product->price, 2) }}
                                </flux:table.cell>
                                <flux:table.cell>
                                    {{ $product->category?->name ?? 'Uncategorized' }}
                                </flux:table.cell>
                                <flux:table.cell>
                                    {{ $product->stock_quantity ?? 'N/A' }}
                                </flux:table.cell>
                                <flux:table.cell>
                                    <flux:badge size="sm" inset="top bottom" @class([
                                        'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' => $product->is_published,
                                        'bg-zinc-100 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-400' => !$product->is_published,
                                    ])>
                                        {{ $product->is_published ? 'Published' : 'Draft' }}
                                    </flux:badge>
                                </flux:table.cell>
                                <flux:table.cell align="end">
                                     <div class="flex justify-end space-x-1">
                                        <flux:button size="sm" variant="ghost" :href="route('admin.products.edit', $product->id)" wire:navigate icon="pencil-square" />
                                        <flux:button size="sm" variant="ghost" color="danger" wire:click="delete({{ $product->id }})" wire:confirm="Are you sure you want to delete this product?" icon="trash" />
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                             <flux:table.row>
                                <flux:table.cell colspan="6">
                                     <div class="text-center py-12">
                                        <flux:icon name="cube" class="h-12 w-12 mx-auto text-gray-400" />
                                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No products found</h3>
                                        @if($search)
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Adjust your search criteria.</p>
                                        @endif
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </div>

            <!-- Pagination -->
             @if ($products->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                 {{ $products->links() }}
            </div>
            @endif
        </flux:card>
    </div>
</x-layouts.admin>
