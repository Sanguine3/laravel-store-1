<x-layouts.admin>
    <div class="flex flex-col gap-6">
         <!-- Session Status Message -->
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
             <form method="POST" action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        {{ isset($product) ? 'Edit Product' : 'Create Product' }}
                    </h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ isset($product) ? 'Update product information' : 'Add a new product to your store' }}
                    </p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Column: Basic Info -->
                        <div class="md:col-span-2 space-y-6">
                            <div class="flex flex-col space-y-2">
                                <label for="name" class="text-sm font-medium text-zinc-900 dark:text-white">Product Name</label>
                                <input name="name" id="name" placeholder="Enter product name" required value="{{ old('name', $product->name ?? '') }}" class="block w-full p-2 border border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-0 focus:border-zinc-300" />
                                @error('name')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col space-y-2">
                                <label for="description" class="text-sm font-medium text-zinc-900 dark:text-white">Description</label>
                                <flux:textarea
                                    name="description"
                                    id="description"
                                    label="Description"
                                    placeholder="Enter product description..."
                                    rows="6"
                                    resize="vertical"
                                    :invalid="$errors->has('description')"
                                >{{ old('description', $product->description ?? '') }}</flux:textarea>
                                @error('description')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col space-y-2">
                                <label for="price" class="text-sm font-medium text-zinc-900 dark:text-white">Price</label>
                                <flux:input.group>
                                    <flux:select class="max-w-fit" disabled>
                                        <flux:select.option selected>USD</flux:select.option>
                                    </flux:select>
                                    <flux:input name="price" id="price" type="number" step="0.01" min="0" placeholder="$99.99" required value="{{ old('price', $product->price ?? '') }}" />
                                </flux:input.group>
                                @error('price')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column: Image, Category, Stock, Status -->
                        <div class="md:col-span-1 space-y-6">
                            <div class="flex flex-col space-y-2">
                                <label for="image_url" class="text-sm font-medium text-zinc-900 dark:text-white">Product Image URL</label>
                                <input name="image_url" id="image_url" placeholder="Paste image URL..." value="{{ old('image_url', $product->image ?? '') }}" class="block w-full p-2 border border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-0 focus:border-zinc-300" /> {{-- Use image field from DB --}}
                                @if(isset($product) && $product->image)
                                    <img src="{{ $product->image }}" alt="Preview" class="mt-2 h-24 w-24 object-cover rounded border border-zinc-200 dark:border-zinc-700" />
                                @endif
                                @error('image_url')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category Dropdown with AlpineJS -->
                            <div class="flex flex-col space-y-2" x-data="{ openCategory: false, selectedCategory: '{{ old('category_id', $product->category_id ?? '') }}' }">
                                <label for="category-button" class="text-sm font-medium text-zinc-900 dark:text-white">Category</label>
                                <input type="hidden" name="category_id" id="category_id" x-model="selectedCategory">
                                <div class="relative">
                                    <flux:button id="category-button" type="button" icon:trailing="chevron-down" class="w-full flex justify-between" @click="openCategory = !openCategory">
                                        <span x-text="$refs.categoryName{{ old('category_id', $product->category_id ?? 'none') }}.textContent.trim()">
                                            {{ $categories->firstWhere('id', old('category_id', $product->category_id ?? ''))?->name ?? 'Select Category' }}
                                        </span>
                                        <span x-ref="categoryNamenone" style="display: none;">Select Category</span> {{-- Hidden ref for default text --}}
                                    </flux:button>
                                    <div x-show="openCategory" @click.away="openCategory = false" class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-700 shadow-lg rounded-md border border-zinc-200 dark:border-zinc-600 max-h-60 overflow-y-auto" style="display: none;">
                                        <flux:menu>
                                            <flux:menu.item @click="selectedCategory = ''; openCategory = false">
                                                <span x-ref="categoryName">Select Category</span>
                                            </flux:menu.item>
                                            @foreach($categories as $category)
                                                <flux:menu.item @click="selectedCategory = '{{ $category->id }}'; openCategory = false">
                                                    <span x-ref="categoryName{{ $category->id }}">{{ $category->name }}</span>
                                                </flux:menu.item>
                                            @endforeach
                                        </flux:menu>
                                    </div>
                                </div>
                                @error('category_id')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col space-y-2">
                                <label for="stock_quantity" class="text-sm font-medium text-zinc-900 dark:text-white">Stock Quantity</label>
                                <input name="stock_quantity" id="stock_quantity" type="number" min="0" placeholder="0" required value="{{ old('stock_quantity', $product->stock_quantity ?? '') }}" class="block w-full p-2 border border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-0 focus:border-zinc-300" />
                                @error('stock_quantity')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col space-y-2">
                                <label for="is_published" class="text-sm font-medium text-zinc-900 dark:text-white">Status</label>
                                <div class="flex items-center space-x-2">
                                    <input name="is_published" id="is_published" type="checkbox" value="1" @checked(old('is_published', $product->is_published ?? false)) class="rounded-md focus:ring-0 focus:border-zinc-300" /> {{-- Use @checked --}}
                                    <span class="text-sm font-medium text-zinc-900 dark:text-white">Published</span>
                                </div>
                                {{-- No hidden field needed if using $request->has('is_published') in controller --}}
                                @error('is_published')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="p-6 flex items-center justify-end space-x-3 bg-zinc-50 dark:bg-zinc-800 rounded-b-xl border-t border-zinc-200 dark:border-zinc-700">
                    <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-zinc-900 dark:text-white hover:text-zinc-700 dark:hover:text-zinc-300">Cancel</a>
                    @if (isset($product))
                        <button type="submit" class="text-sm font-medium text-zinc-900 bg-yellow-400 hover:bg-yellow-500 rounded-md px-4 py-2 focus:ring-0 focus:border-zinc-300 flex items-center gap-2">
                            <x-heroicon-o-pencil-square class="w-4 h-4 text-zinc-900" /> Update Product
                        </button>
                    @else
                        <button type="submit" class="text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 rounded-md px-4 py-2 focus:ring-0 focus:border-amber-300 flex items-center gap-2">
                            <x-heroicon-o-plus class="w-4 h-4 text-white" /> Create Product
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <!-- Include AlpineJS if not already included globally -->
    <!-- <script src="//unpkg.com/alpinejs" defer></script> -->
</x-layouts.admin>