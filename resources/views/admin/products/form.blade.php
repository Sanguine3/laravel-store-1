<x-layouts.admin :title="isset($product) ? __('Edit Product') : __('Create Product')">
    <div class="flex flex-col gap-6">
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    {{ isset($product) ? __('Edit Product') : __('Create Product') }}
                </h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ isset($product) ? __('Update product information') : __('Add a new product to your store') }}
                </p>
            </div>

            <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Product Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Product Name</label>
                            <input type="text" name="name" id="name" value="{{ $product->name ?? old('name') }}" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400" placeholder="Enter product name" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SKU -->
                        <div>
                            <label for="sku" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">SKU</label>
                            <input type="text" name="sku" id="sku" value="{{ $product->sku ?? old('sku') }}" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400" placeholder="Enter product SKU">
                            @error('sku')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Price</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-zinc-500 dark:text-zinc-400 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="price" id="price" value="{{ $product->price ?? old('price') }}" class="block w-full rounded-md border-zinc-300 pl-7 pr-12 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400 sm:text-sm" placeholder="0.00" step="0.01" min="0" required>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-zinc-500 dark:text-zinc-400 sm:text-sm">USD</span>
                                </div>
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Category</label>
                            <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                                <option value="">Select a category</option>
                                <option value="1" {{ (isset($product) && $product->category_id == 1) ? 'selected' : '' }}>Electronics</option>
                                <option value="2" {{ (isset($product) && $product->category_id == 2) ? 'selected' : '' }}>Clothing</option>
                                <option value="3" {{ (isset($product) && $product->category_id == 3) ? 'selected' : '' }}>Home & Kitchen</option>
                                <option value="4" {{ (isset($product) && $product->category_id == 4) ? 'selected' : '' }}>Books</option>
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock Quantity -->
                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ $product->stock_quantity ?? old('stock_quantity', 0) }}" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400" min="0" required>
                            @error('stock_quantity')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                                <option value="draft" {{ (isset($product) && $product->status == 'draft') ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ (isset($product) && $product->status == 'published') ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ (isset($product) && $product->status == 'archived') ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Product Image -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Product Image</label>
                            <div class="mt-1 flex items-center">
                                <div class="flex-shrink-0 h-32 w-32 overflow-hidden rounded-md border border-zinc-300 dark:border-zinc-600 bg-zinc-100 dark:bg-zinc-800">
                                    @if(isset($product) && $product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <svg class="h-12 w-12 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="flex text-sm text-zinc-600 dark:text-zinc-400">
                                        <label for="image" class="relative cursor-pointer rounded-md bg-white dark:bg-zinc-800 font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Product Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Description</label>
                            <div class="mt-1">
                                <textarea id="description" name="description" rows="8" class="block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400" placeholder="Enter product description">{{ $product->description ?? old('description') }}</textarea>
                            </div>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end space-x-3 border-t border-zinc-200 dark:border-zinc-700 pt-5">
                    <a href="{{ route('admin.products') }}" class="inline-flex justify-center rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 py-2 px-4 text-sm font-medium text-zinc-700 dark:text-zinc-300 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        {{ isset($product) ? 'Update Product' : 'Create Product' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
