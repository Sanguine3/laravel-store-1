<x-layouts.admin :title="$product ? 'Edit Product' : 'Create Product'">
    <div class="flex flex-col gap-6">
         <!-- Session Status Message -->
        @if (session('status'))
            <div class="rounded-md bg-green-50 dark:bg-green-900/20 p-4 border border-green-200 dark:border-green-700">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <flux:icon name="check-circle" class="h-5 w-5 text-green-400 dark:text-green-300" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <flux:card>
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
                            <flux:field>
                                <flux:label for="name">Product Name</flux:label>
                                <flux:input wire:model="name" id="name" placeholder="Enter product name" required />
                                <flux:error name="name" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="description">Description</flux:label>
                                <flux:textarea wire:model="description" id="description" rows="8" placeholder="Enter product description" />
                                <flux:error name="description" />
                            </flux:field>

                             <flux:field>
                                 <flux:label for="price">Price</flux:label>
                                <flux:input.group>
                                     <flux:input.group.prefix>$</flux:input.group.prefix>
                                    <flux:input wire:model="price" type="number" id="price" placeholder="0.00" step="0.01" min="0" required />
                                     <flux:input.group.suffix>USD</flux:input.group.suffix>
                                </flux:input.group>
                                 <flux:error name="price" />
                            </flux:field>
                        </div>

                        <!-- Right Column: Image, Category, Stock, Status -->
                        <div class="md:col-span-1 space-y-6">
                            <flux:field>
                                <flux:label for="imageUrl">Product Image URL</flux:label>
                                <div class="mt-1 flex flex-col items-center">
                                     <!-- Image Preview -->
                                    <div class="mb-2 h-32 w-32 overflow-hidden rounded-md border border-zinc-300 dark:border-zinc-600 bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        @if ($imageUrl)
                                            <img src="{{ $imageUrl }}" alt="Image preview" class="h-full w-full object-cover">
                                        @else
                                             <flux:icon name="photo" class="h-12 w-12 text-zinc-400" />
                                        @endif
                                    </div>
                                    <!-- URL Input -->
                                    <flux:input type="url" wire:model="imageUrl" id="imageUrl" placeholder="https://example.com/image.jpg" />
                                </div>
                                <flux:error name="imageUrl" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="category_id">Category</flux:label>
                                <flux:select id="category_id" disabled>
                                    <option value="">Select a category</option>
                                    <option value="1">Electronics</option>
                                </flux:select>
                                 <flux:description>Category assignment not implemented.</flux:description>
                            </flux:field>

                            <flux:field>
                                <flux:label for="stock_quantity">Stock Quantity</flux:label>
                                <flux:input type="number" id="stock_quantity" value="0" min="0" disabled />
                                <flux:description>Stock management not implemented.</flux:description>
                            </flux:field>

                             <flux:field>
                                <flux:label for="status">Status</flux:label>
                                <flux:select id="status" disabled>
                                    <option value="draft">Draft</option>
                                    <option value="published" selected>Published (Default)</option>
                                </flux:select>
                                <flux:description>Status management not implemented.</flux:description>
                            </flux:field>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="p-6 flex items-center justify-end space-x-3 bg-zinc-50 dark:bg-zinc-800 rounded-b-xl border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button :href="route('admin.products')" wire:navigate variant="subtle">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">{{ $product ? 'Update Product' : 'Create Product' }}</flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-layouts.admin>
