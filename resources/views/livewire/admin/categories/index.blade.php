<x-layouts.admin :title="__('Categories')">
    <div class="flex flex-col gap-6">
        @if (session('status'))
            <div class="mb-4 px-4 py-2 rounded bg-green-100 text-green-800 border border-green-300">
                {{ session('status') }}
            </div>
        @endif
        <!-- Header with Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex-1">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    id="category-search"
                    placeholder="Search categories..."
                    icon="magnifying-glass"
                    clearable
                    class="w-full"
                />
            </div>
            <flux:button href="{{ route('admin.categories.create') }}" color="warning" icon="plus" size="base" class="!bg-amber-700 !text-white !shadow-lg !ring-0 !outline-none hover:!bg-amber-800 focus:!ring-0 focus:!outline-none">
                Add New Category
            </flux:button>
        </div>

        <!-- Categories Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Category Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Products</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Slug</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($categories as $category)
                        <tr wire:key="category-{{ $category->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-white">
                                {{ $category->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-zinc-900 dark:text-white">{{ $category->products_count ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $category->slug }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <flux:button href="{{ route('admin.categories.edit', $category->id) }}" as="a" color="warning" size="sm" icon="pencil" tooltip="Edit" class="mr-1 !bg-yellow-400 !text-zinc-900 hover:!bg-yellow-500 focus:!ring-yellow-300" />
                                    <flux:button wire:click="delete({{ $category->id }})" color="danger" size="sm" icon="trash" tooltip="Delete" square class="!bg-red-600 !text-white hover:!bg-red-700 focus:!ring-red-400" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Pagination Summary (always shown) -->
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <p class="text-sm text-zinc-700 dark:text-zinc-300">
                        Showing
                        <span class="font-medium">{{ $categories->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $categories->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $categories->total() }}</span>
                        results
                    </p>
                </div>
                @if ($categories->hasPages())
                    <div>
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
