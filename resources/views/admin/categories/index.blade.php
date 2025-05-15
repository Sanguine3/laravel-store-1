<x-layouts.admin :title="__('Categories')">
    <div class="flex flex-col gap-6">
        @if (session('status'))
            <div class="mb-4 px-4 py-2 rounded bg-green-100 text-green-800 border border-green-300">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            {{-- Add error display --}}
            <div class="mb-4 px-4 py-2 rounded bg-red-100 text-red-800 border border-red-300">
                {{ session('error') }}
            </div>
        @endif
        <!-- Header with Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.categories.index') }}" class="flex-1"
                  x-data="{ searchTerm: '{{ $search ?? '' }}' }">
                <!-- Keep existing sort parameters if any -->
                @if(request('sort_by'))
                    <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                @endif
                @if(request('direction'))
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                @endif
                <div class="relative">
                    <flux:input
                        name="search"
                        id="category-search"
                        placeholder="Search categories..."
                        icon="magnifying-glass"
                        clearable
                        class="w-full"
                        value="{{ $search ?? '' }}"
                        x-model="searchTerm"
                    />
                    <span x-show="searchTerm.length > 0" x-cloak
                          class="absolute right-10 top-1/2 -translate-y-1/2 text-xs text-zinc-500 dark:text-zinc-400 pr-2"
                          x-text="searchTerm.length"></span>
                </div>
            </form>
            <flux:button href="{{ route('admin.categories.create') }}" color="warning" icon="plus" size="base"
                         class="!bg-amber-700 !text-white !shadow-lg !ring-0 !outline-none hover:!bg-amber-800 focus:!ring-0 focus:!outline-none">
                Add New Category
            </flux:button>
        </div>

        <!-- Categories Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    @php
                        // Helper function for sorting links
                        $sortLink = fn($field) => route('admin.categories.index', array_merge(request()->query(), ['sort_by' => $field, 'direction' => request('sort_by') === $field && request('direction', 'asc') === 'asc' ? 'desc' : 'asc']));
                        $sortIcon = fn($field) => request('sort_by') === $field ? (request('direction', 'asc') === 'asc' ? '▲' : '▼') : '';
                    @endphp
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        <a href="{{ $sortLink('name') }}"
                           class="flex items-center gap-1 hover:text-zinc-700 dark:hover:text-zinc-200">
                            Category Name <span class="text-xs">{{ $sortIcon('name') }}</span>
                        </a>
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Description
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Products
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        <a href="{{ $sortLink('slug') }}"
                           class="flex items-center gap-1 hover:text-zinc-700 dark:hover:text-zinc-200">
                            Slug <span class="text-xs">{{ $sortIcon('slug') }}</span>
                        </a>
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse($categories as $category)
                    <tr x-data="{ expanded: false }">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                            {{ $category->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400">
                            <span
                                x-show="!expanded">{{ \Illuminate\Support\Str::limit($category->description, 50) }}</span>
                            <span x-show="expanded" x-cloak>{{ $category->description }}</span>
                            @if(strlen($category->description) > 50)
                                <button @click="expanded = !expanded"
                                        class="ml-2 text-xs text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 focus:outline-none"
                                        x-text="expanded ? 'Show less' : 'Show more'"></button>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="text-sm text-zinc-900 dark:text-white">{{ $category->products_count ?? 0 }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $category->slug }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end items-center gap-1"> {{-- Use gap for spacing --}}
                                <flux:button href="{{ route('admin.categories.edit', $category->id) }}" as="a"
                                             color="warning" size="sm" icon="pencil" tooltip="Edit"
                                             class="!bg-yellow-400 !text-zinc-900 hover:!bg-yellow-500 focus:!ring-yellow-300"/>
                                <!-- Delete Form -->
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this category? This might affect associated products.');">
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
                        <td colspan="5" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">No categories
                            found matching your criteria.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <!-- Pagination Summary (always shown) -->
            <div
                class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                @if ($categories->total() > 0)
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
                @endif
                @if ($categories->hasPages())
                    <div>
                        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                            {{ $categories->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
