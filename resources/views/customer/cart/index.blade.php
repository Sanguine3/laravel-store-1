<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if (count($cart) > 0)
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Cart Items</h3>
                        <div class="space-y-4">
                            @foreach ($cart as $id => $details)
                                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $details['image'] ?? 'https://via.placeholder.com/100' }}" alt="{{ $details['name'] }}" class="w-16 h-16 object-cover rounded">
                                        <div>
                                            <h4 class="font-semibold text-gray-800 dark:text-gray-200">{{ $details['name'] }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Price: ${{ number_format($details['price'], 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                           <div x-data="{ quantity: {{ $details['quantity'] }} }" class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md overflow-hidden">
                                               <button
                                                   type="button"
                                                   @click="quantity = Math.max(1, quantity - 1)"
                                                   class="px-2 py-1 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50 transition-colors duration-150 ease-in-out disabled:opacity-50"
                                                   aria-label="Decrease quantity"
                                                   :disabled="quantity <= 1"
                                               >
                                                   <flux:icon name="minus" class="w-4 h-4"/>
                                               </button>
                                               <input
                                                   type="text"
                                                   name="quantity"
                                                   x-model.number="quantity"
                                                   min="1"
                                                   class="w-10 text-center text-sm border-x border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-0 appearance-none [-moz-appearance:_textfield]"
                                                   readonly
                                               >
                                               <button
                                                   type="button"
                                                   @click="quantity = quantity + 1"
                                                   class="px-2 py-1 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50 transition-colors duration-150 ease-in-out"
                                                   aria-label="Increase quantity"
                                               >
                                                   <flux:icon name="plus" class="w-4 h-4"/>
                                               </button>
                                           </div>
                                            <button type="submit" class="ml-2 px-3 py-1 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Update</button>
                                        </form>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">Remove</button>
                                        </form>
                                        <div class="text-right w-24">
                                            <p class="font-semibold text-gray-800 dark:text-gray-200">Subtotal: ${{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-center mb-6">
                                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Order Total:</h4>
                                <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">${{ number_format($total, 2) }}</p>
                            </div>
                            <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                                <flux:button href="{{ route('products.index') }}" variant="outline" class="w-full sm:w-auto order-last sm:order-first"> {{-- Removed size="lg" --}}
                                    <flux:icon name="arrow-left" class="mr-2"/> Continue Shopping
                                </flux:button>
                                <flux:button href="{{ route('checkout.show') }}" variant="primary" class="w-full sm:w-auto bg-gradient-to-r from-orange-500 via-pink-500 to-purple-600 hover:from-orange-600 hover:via-pink-600 hover:to-purple-700 shadow-lg hover:shadow-xl transition-all duration-200 ease-in-out transform hover:scale-105"> {{-- Removed size="lg" --}}
                                    Proceed to Checkout <flux:icon name="arrow-right" class="ml-2"/>
                                </flux:button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-6 text-center">
                        <p class="text-gray-600 dark:text-gray-400 text-lg">Your cart is empty.</p>
                        <a href="{{ route('products.index') }}" class="mt-4 inline-block px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                            Continue Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>