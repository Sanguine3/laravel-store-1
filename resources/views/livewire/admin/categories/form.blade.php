<x-layouts.admin :title="isset($category) ? __('Edit Category') : __('Create Category')">
    <div class="flex flex-col gap-6">
        @if (session('status'))
            <div class="rounded-md bg-green-50 dark:bg-green-900/20 p-4 border border-green-200 dark:border-green-700">
                <div class="flex">
                    <i class="fas fa-check-circle h-5 w-5 text-green-400 dark:text-green-300"></i>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-md p-6">
            <form wire:submit.prevent="save">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            {{ isset($category) ? __('Edit Category') : __('Create Category') }}
                        </h2>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ isset($category) ? __('Update category information') : __('Add a new category to your store') }}
                        </p>
                    </div>
                    @if(isset($category))
                        <button
                            type="button"
                            wire:click="deleteCategory"
                            onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone.')"
                            class="text-red-600 hover:text-red-800 flex items-center space-x-1"
                        >
                            <i class="fas fa-trash-alt"></i>
                            <span>Delete</span>
                        </button>
                    @endif
                </div>

                <div class="p-6 space-y-6">
                    <flux:input
                        wire:model.defer="name"
                        label="Category Name"
                        placeholder="Enter category name"
                        :invalid="$errors->has('name')"
                        required
                    />
                    @error('name')
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <flux:input
                        wire:model.defer="slug"
                        label="Slug"
                        placeholder="category-slug"
                        :invalid="$errors->has('slug')"
                    />
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        The slug is used in the URL. It should be unique, contain only letters, numbers, and hyphens.<br>
                        <strong>Leave blank to auto-generate from the category name.</strong>
                    </p>
                    @error('slug')
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <flux:textarea
                        wire:model.defer="description"
                        label="Description"
                        placeholder="Enter category description..."
                        rows="4"
                        resize="vertical"
                        :invalid="$errors->has('description')"
                    />
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        A brief description of the category. This helps customers understand what products they can find in this category.
                    </p>
                    @error('description')
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-6 flex items-center justify-end space-x-3 bg-zinc-50 dark:bg-zinc-800 rounded-b-xl border-t border-zinc-200 dark:border-zinc-700">
                    <a href="{{ route('admin.categories') }}" class="text-sm font-medium text-zinc-900 dark:text-white hover:text-zinc-700 dark:hover:text-zinc-300">Cancel</a>
                    @if ($category)
                        <button type="submit" class="text-sm font-medium text-zinc-900 bg-yellow-400 hover:bg-yellow-500 rounded-md px-4 py-2 focus:ring-0 focus:border-zinc-300 flex items-center gap-2">
                            <x-heroicon-o-pencil-square class="w-4 h-4 text-zinc-900" /> Update Category
                        </button>
                    @else
                        <button type="submit" class="text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 rounded-md px-4 py-2 focus:ring-0 focus:border-amber-300 flex items-center gap-2">
                            <x-heroicon-o-plus class="w-4 h-4 text-white" /> Create Category
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
