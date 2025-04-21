<x-layouts.admin :title="isset($category) ? __('Edit Category') : __('Create Category')">
    <div class="flex flex-col gap-6">
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    {{ isset($category) ? __('Edit Category') : __('Create Category') }}
                </h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ isset($category) ? __('Update category information') : __('Add a new category to your store') }}
                </p>
            </div>

            <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST" class="p-6">
                @csrf
                @if(isset($category))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <!-- Category Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Category Name</label>
                        <input type="text" name="name" id="name" value="{{ $category->name ?? old('name') }}" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400" placeholder="Enter category name" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Slug</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center rounded-l-md border border-r-0 border-zinc-300 bg-zinc-50 px-3 text-zinc-500 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-400">
                                /categories/
                            </span>
                            <input type="text" name="slug" id="slug" value="{{ $category->slug ?? old('slug') }}" class="block w-full flex-1 rounded-none rounded-r-md border-zinc-300 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400" placeholder="category-slug">
                        </div>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                            The slug is used in the URL. It should be unique, contain only letters, numbers, and hyphens.
                        </p>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Description</label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="4" class="block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400" placeholder="Enter category description">{{ $category->description ?? old('description') }}</textarea>
                        </div>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                            A brief description of the category. This helps customers understand what products they can find in this category.
                        </p>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon Color (Optional) -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Icon Color</label>
                        <select id="color" name="color" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                            <option value="blue" {{ (isset($category) && $category->color == 'blue') ? 'selected' : '' }}>Blue</option>
                            <option value="green" {{ (isset($category) && $category->color == 'green') ? 'selected' : '' }}>Green</option>
                            <option value="amber" {{ (isset($category) && $category->color == 'amber') ? 'selected' : '' }}>Amber</option>
                            <option value="red" {{ (isset($category) && $category->color == 'red') ? 'selected' : '' }}>Red</option>
                            <option value="purple" {{ (isset($category) && $category->color == 'purple') ? 'selected' : '' }}>Purple</option>
                            <option value="pink" {{ (isset($category) && $category->color == 'pink') ? 'selected' : '' }}>Pink</option>
                        </select>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                            Choose a color for the category icon. This is used for visual distinction in the category list.
                        </p>
                        @error('color')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Parent Category (Optional) -->
                    <div>
                        <label for="parent_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Parent Category (Optional)</label>
                        <select id="parent_id" name="parent_id" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                            <option value="">None (Top Level Category)</option>
                            <option value="1" {{ (isset($category) && $category->parent_id == 1) ? 'selected' : '' }}>Electronics</option>
                            <option value="2" {{ (isset($category) && $category->parent_id == 2) ? 'selected' : '' }}>Clothing</option>
                            <option value="3" {{ (isset($category) && $category->parent_id == 3) ? 'selected' : '' }}>Home & Kitchen</option>
                        </select>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                            If this is a subcategory, select the parent category. Leave as "None" for a top-level category.
                        </p>
                        @error('parent_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end space-x-3 border-t border-zinc-200 dark:border-zinc-700 pt-5">
                    <a href="{{ route('admin.categories') }}" class="inline-flex justify-center rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 py-2 px-4 text-sm font-medium text-zinc-700 dark:text-zinc-300 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        {{ isset($category) ? 'Update Category' : 'Create Category' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
