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
             <form wire:submit="save">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        {{ $product ? 'Edit Product' : 'Create Product' }}
                    </h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $product ? 'Update product information' : 'Add a new product to your store' }}
                    </p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Column: Basic Info -->
                        <div class="md:col-span-2 space-y-6">
                            <div class="flex flex-col space-y-2">
                                <label for="name" class="text-sm font-medium text-zinc-900 dark:text-white">Product Name</label>
                                <input wire:model="name" id="name" placeholder="Enter product name" required class="block w-full p-2 border border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-0 focus:border-zinc-300" />
                                @error('name')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col space-y-2">
                                <flux:textarea
                                    wire:model.defer="description"
                                    label="Description"
                                    placeholder="Enter product description..."
                                    rows="6"
                                    resize="vertical"
                                    :invalid="$errors->has('description')"
                                />
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
                                    <flux:input wire:model="price" id="price" type="number" step="0.01" min="0" placeholder="$99.99" required />
                                </flux:input.group>
                                @error('price')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column: Image, Category, Stock, Status -->
                        <div class="md:col-span-1 space-y-6">
                            <div class="flex flex-col space-y-2">
                                <label for="imageUrl" class="text-sm font-medium text-zinc-900 dark:text-white">Product Image URL</label>
                                <input wire:model="imageUrl" id="imageUrl" placeholder="Paste image URL..." class="block w-full p-2 border border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-0 focus:border-zinc-300" />
                                @if($imageUrl)
                                    <img src="{{ $imageUrl }}" alt="Preview" class="mt-2 h-24 w-24 object-cover rounded border border-zinc-200 dark:border-zinc-700" />
                                @endif
                                @error('imageUrl')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col space-y-2">
                                <label for="category_id" class="text-sm font-medium text-zinc-900 dark:text-white">Category</label>
                                <flux:dropdown class="w-full" placement="bottom-start">
                                    <flux:button icon:trailing="chevron-down" class="w-full flex justify-between">
                                        {{ $categories->firstWhere('id', $category_id)?->name ?? 'Select Category' }}
                                    </flux:button>
                                    <flux:menu>
                                        <flux:menu.radio.group wire:model.live="category_id">
                                            <flux:menu.radio value="">Select Category</flux:menu.radio>
                                            @foreach($categories as $category)
                                                <flux:menu.radio value="{{ $category->id }}">{{ $category->name }}</flux:menu.radio>
                                            @endforeach
                                        </flux:menu.radio.group>
                                    </flux:menu>
                                </flux:dropdown>
                                @error('category_id')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col space-y-2">
                                <label for="stock_quantity" class="text-sm font-medium text-zinc-900 dark:text-white">Stock Quantity</label>
                                <input wire:model="stock_quantity" id="stock_quantity" type="number" min="0" placeholder="0" required class="block w-full p-2 border border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-0 focus:border-zinc-300" />
                                @error('stock_quantity')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col space-y-2">
                                <label for="is_published" class="text-sm font-medium text-zinc-900 dark:text-white">Status</label>
                                <div class="flex items-center space-x-2">
                                    <input wire:model="is_published" id="is_published" type="checkbox" class="rounded-md focus:ring-0 focus:border-zinc-300" />
                                    <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $is_published ? 'Published' : 'Draft' }}</span>
                                </div>
                                @error('is_published')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="p-6 flex items-center justify-end space-x-3 bg-zinc-50 dark:bg-zinc-800 rounded-b-xl border-t border-zinc-200 dark:border-zinc-700">
                    <a href="{{ route('admin.products') }}" class="text-sm font-medium text-zinc-900 dark:text-white hover:text-zinc-700 dark:hover:text-zinc-300">Cancel</a>
                    @if ($product)
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
</x-layouts.admin>
