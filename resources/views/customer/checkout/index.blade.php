<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-xl sm:rounded-lg">
                <div x-data="{{ Js::from(['sameAsShipping' => true]) }}" class="md:grid md:grid-cols-10 md:gap-x-12 p-6 sm:p-8">
                    {{-- Form Section --}}
                    <div class="md:col-span-6">
                        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" class="space-y-10">
                            @csrf

                            @if (session('error'))
                                <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            {{-- Contact Information Section --}}
                            <section aria-labelledby="contact-info-heading">
                                <h3 id="contact-info-heading" class="text-xl font-semibold text-gray-900 dark:text-white mb-5 border-b border-gray-200 dark:border-gray-700 pb-3">Contact Information</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                                    <div class="sm:col-span-2">
                                        <flux:input type="text" name="name" id="name" label="Full Name" value="{{ old('name', $user->name ?? '') }}" required :invalid="$errors->has('name')" />
                                        @error('name') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <flux:input type="email" name="email" id="email" label="Email Address" value="{{ old('email', $user->email ?? '') }}" required :invalid="$errors->has('email')" />
                                        @error('email') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <flux:input type="tel" name="phone" id="phone" label="Phone Number" value="{{ old('phone') }}" required :invalid="$errors->has('phone')" />
                                        @error('phone') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </section>

                            {{-- Shipping Address Section --}}
                            <section aria-labelledby="shipping-address-heading">
                                <h3 id="shipping-address-heading" class="text-xl font-semibold text-gray-900 dark:text-white mb-5 border-b border-gray-200 dark:border-gray-700 pb-3">Shipping Address</h3>
                                <div class="space-y-5">
                                    <div>
                                        <flux:textarea name="shipping_address" id="shipping_address" label="Full Shipping Address" rows="4" required :invalid="$errors->has('shipping_address')">{{ old('shipping_address') }}</flux:textarea>
                                        @error('shipping_address') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </section>

                            {{-- Billing Address Section --}}
                            <section aria-labelledby="billing-address-heading">
                                <h3 id="billing-address-heading" class="text-xl font-semibold text-gray-900 dark:text-white mb-5 border-b border-gray-200 dark:border-gray-700 pb-3">Billing Address</h3>
                                <div class="space-y-5">
                                    <div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="same_as_shipping_checkbox_test" name="same_as_shipping_checkbox_test" x-model="sameAsShipping" class="h-4 w-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:focus:ring-orange-600 dark:focus:ring-offset-gray-800">
                                            <label for="same_as_shipping_checkbox_test" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">My billing address is the same as my shipping address.</label>
                                        </div>
                                    </div>
                                    <div x-show="!sameAsShipping">
                                        <flux:textarea name="billing_address" id="billing_address" label="Full Billing Address" rows="4" x-bind:required="!sameAsShipping" :invalid="$errors->has('billing_address')">{{ old('billing_address') }}</flux:textarea>
                                        @error('billing_address') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </section>

                            {{-- Payment and Notes Section --}}
                            <section aria-labelledby="payment-options-heading">
                                <h3 id="payment-options-heading" class="text-xl font-semibold text-gray-900 dark:text-white mb-5 border-b border-gray-200 dark:border-gray-700 pb-3">Payment & Options</h3>
                                <div class="space-y-5">
                                    <div>
                                        <flux:input type="text" name="payment_method" id="payment_method" label="Payment Method" value="{{ old('payment_method', 'Cash on Delivery') }}" required :invalid="$errors->has('payment_method')" />
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Currently, we only support Cash on Delivery.</p>
                                        @error('payment_method') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <flux:textarea name="notes" id="notes" label="Order Notes (Optional)" rows="3" :invalid="$errors->has('notes')">{{ old('notes') }}</flux:textarea>
                                        @error('notes') <p class="mt-1 text-xs text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="mt-4">
                                        <flux:checkbox name="receive_email_confirmation" id="receive_email_confirmation" label="Receive email updates for this order" value="1" :checked="old('receive_email_confirmation', true)" />
                                    </div>
                                </div>
                            </section>

                            <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                                <flux:button type="submit" variant="primary" class="px-8 py-3" :disabled="empty($cart)">
                                    Complete Checkout
                                </flux:button>
                            </div>
                        </form>
                    </div>

                    {{-- Order Summary Section (Sidebar-like) --}}
                    <div class="md:col-span-4 mt-12 md:mt-0">
                        <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-5 border-b border-gray-200 dark:border-gray-700 pb-3">Order Summary</h3>
                            @php $total = 0; @endphp
                            @if(!empty($cart))
                                <div class="space-y-4">
                                @foreach($cart as $id => $details)
                                @php $total += $details['price'] * $details['quantity']; @endphp
                                <div class="flex justify-between items-start">
                                    <img src="{{ $details['image'] ?? 'https://via.placeholder.com/50' }}" alt="{{ $details['name'] }}" class="w-12 h-12 object-cover rounded mr-3 flex-shrink-0">
                                    <div class="flex-grow pr-2 min-w-0">
                                        <p class="font-medium text-gray-800 dark:text-gray-200 leading-tight break-words">{{ $details['name'] }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Qty: {{ $details['quantity'] }} @ ${{ number_format($details['price'], 2) }}</p>
                                    </div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">${{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                                </div>
                                @endforeach
                                </div>
                                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex justify-between items-center text-base font-semibold text-gray-900 dark:text-white">
                                        <span>Order Total</span>
                                        <span>${{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400">Your cart is currently empty.</p>
                                <div class="mt-6">
                                    <flux:button href="{{ route('products.index') }}" variant="outline" class="w-full">
                                        Continue Shopping
                                    </flux:button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>