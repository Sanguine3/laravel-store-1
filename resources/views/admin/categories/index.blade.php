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
            <div class="flex-1">
                <div class="relative">
                    <input type="text"
                           id="category-search"
                           class="w-full px-3 py-2 border rounded"
                           placeholder="Search categories..."
                           x-model.debounce.500ms="searchTerm"
                           @input="fetchCategories()">
                    <span x-show="searchTerm.length > 0" x-cloak
                          class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-zinc-500 dark:text-zinc-400"
                          x-text="searchTerm.length"></span>
                </div>
            </div>
            <a href="{{ route('admin.categories.create') }}"
               class="inline-flex items-center px-4 py-2 bg-amber-700 text-white rounded shadow hover:bg-amber-800 focus:outline-none">
                Add New Category
            </a>
        </div>

        <!-- TanStack Table placeholder -->
        <div id="categories-table" class="overflow-x-auto"></div>
    </div>
</x-layouts.admin>
