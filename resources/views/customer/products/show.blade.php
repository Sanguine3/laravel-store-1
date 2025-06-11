<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    {{-- Added x-data for modal --}}
    <div x-data="{ imageModalOpen: false, quantity: 1 }" class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg overflow-hidden">
                <!-- Product Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold leading-tight text-gray-900 dark:text-white">
                        {{ $product->name }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Category: {{ $product->category->name ?? 'Uncategorized' }}
                    </p>
                </div>

                <!-- Product Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Image (Clickable for Modal) -->
                        <div class="md:col-span-1">
                            <img @click="imageModalOpen = true"
                                 src="{{ $product->image ?? 'https://via.placeholder.com/400' }}"
                                 alt="{{ $product->name }}"
                                 class="rounded-lg object-cover w-full aspect-square shadow border border-gray-200 dark:border-gray-700 cursor-pointer hover:opacity-90 transition-opacity">
                        </div>
                        <!-- Details -->
                        <div class="md:col-span-2 space-y-4 flex flex-col"> {{-- Added flex flex-col --}}
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</h4>
                                <p class="text-base text-gray-800 dark:text-gray-200 mt-1 leading-relaxed">{{ $product->description }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4 pt-2">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</h4>
                                    <p class="text-2xl font-bold text-orange-600 dark:text-orange-400 mt-1">${{ number_format($product->price, 2) }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock</h4>
                                    <p class="text-lg font-semibold dark:text-white mt-1">{{ $product->stock_quantity }} units</p>
                                </div>
                            </div>
                            {{-- Added mt-auto to push button down --}}
                            <div class="pt-4 mt-auto">
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <div class="flex items-center gap-4">
                                        {{-- Quantity Input Group --}}
                                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md overflow-hidden shadow-sm">
                                            <button type="button" @click="quantity = Math.max(1, quantity - 1)"
                                                    class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50 transition-colors duration-150 ease-in-out">
                                                -
                                            </button>
                                            {{-- Note: The x-model on quantity input will still work for display,
                                                 but we need a hidden input or ensure the name="quantity" on the visible one is submitted.
                                                 The current setup with readonly might prevent direct submission of the visible input's value
                                                 if not handled carefully by Alpine or a hidden input.
                                                 For simplicity, let's ensure the visible input's name is "quantity" and it's not readonly,
                                                 or add a hidden input that Alpine updates.
                                                 Let's make the visible input submittable by removing readonly and relying on Alpine to set its value.
                                            --}}
                                            <input type="number" name="quantity" x-model.number="quantity" min="1"
                                                   class="w-16 text-center border-y border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-0 appearance-none [-moz-appearance:_textfield] [&::-webkit-outer-spin-button]:m-0 [&::-webkit-inner-spin-button]:m-0">
                                            <button type="button" @click="quantity++"
                                                    class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50 transition-colors duration-150 ease-in-out">
                                                +
                                            </button>
                                        </div>
                                        {{-- Add to Cart Button with Icon, Gradient, and Effects --}}
                                        <x-button type="submit" variant="primary"
                                                  class="flex-1 sm:flex-none px-6 py-2 font-semibold flex items-center gap-2 bg-gradient-to-r from-orange-500 via-pink-500 to-purple-500 text-white shadow-lg shadow-orange-500/30 transition-all duration-200 ease-in-out transform hover:scale-105 hover:from-pink-500 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50 active:scale-95"
                                                  :disabled="$product->stock_quantity <= 0"
                                        >
                                            <x-icon name="shopping-cart" class="h-5 w-5 inline-block" />
                                            <span>Add to Cart</span>
                                        </x-button>
                                    </div>
                                </form>
                          </div>
                      </div>
                  </div>
              </div>

                 <!-- Back Link -->
                 <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                        &larr; Back to Products
                    </a>
                </div>
            </div>
        </div>

        <!-- Image Modal -->
        <div x-show="imageModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4"
             style="display: none;" {{-- Avoid flash of unstyled content --}}
             @keydown.escape.window="imageModalOpen = false">

            {{-- Changed max-w-3xl to max-w-5xl --}}
            <div @click.outside="imageModalOpen = false" class="relative bg-white dark:bg-gray-900 rounded-lg shadow-xl max-w-5xl max-h-[80vh] overflow-auto">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/800' }}" alt="{{ $product->name }} - Large View" class="block w-full h-auto">
                <button @click="imageModalOpen = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white bg-white/50 dark:bg-black/50 rounded-full p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>
</x-layouts.app>
