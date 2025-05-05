<x-layouts.admin :title="'Order Details - #' . $order->id">

    <!-- Session Status Messages -->
    @if (session('status'))
        <div class="rounded-md bg-green-50 dark:bg-green-900/20 p-4 border border-green-200 dark:border-green-700 mb-4">
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
     @if (session('error'))
        <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-4 border border-red-200 dark:border-red-700 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <flux:icon name="exclamation-circle" class="h-5 w-5 text-red-400 dark:text-red-300" />
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800 dark:text-red-200">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-col gap-6">
        <!-- Order Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Order #{{ $order->id }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    Placed on {{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('g:i A') }}
                </p>
            </div>

            <!-- Status Update Form -->
            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="flex items-center gap-2"> {{-- Assuming a route named 'admin.orders.updateStatus' --}}
                @csrf
                @method('PUT') {{-- Or PATCH --}}
                <flux:select name="status" id="status">
                    @php
                        // Define statuses here or pass from controller
                        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
                    @endphp
                    @foreach($statuses as $statusOption)
                        <option value="{{ $statusOption }}" @if($order->status === $statusOption) selected @endif>{{ ucfirst($statusOption) }}</option>
                    @endforeach
                </flux:select>

                <flux:button type="submit" variant="primary">Update Status</flux:button>
            </form>
        </div>

        <!-- Order Information -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Order Summary -->
            <div class="md:col-span-2">
                <x-card>
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Order Items</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-zinc-50 dark:bg-zinc-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Product</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Quantity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                @forelse(($order->orderItems ?? []) as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
                                                    <img class="h-full w-full object-cover" src="{{ $item->product?->image_path ?? 'https://via.placeholder.com/100' }}" alt="{{ $item->product?->name }}">
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $item->product?->name ?? 'Product Not Found' }}</span>
                                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">SKU: {{ $item->product?->sku ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400"> ${{ number_format($item->price, 2) }} </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400"> {{ $item->quantity }} </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400"> ${{ number_format($item->price * $item->quantity, 2) }} </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                            <div class="text-center py-4">No items found in this order.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                             <!-- Table Footer -->
                             <tfoot>
                                <tr class="border-t border-zinc-200 dark:border-zinc-700">
                                    <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-zinc-500 dark:text-zinc-400">Subtotal:</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-zinc-900 dark:text-white">${{ number_format($order->subtotal_amount ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-zinc-500 dark:text-zinc-400">Tax:</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-zinc-900 dark:text-white">${{ number_format($order->tax_amount ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-zinc-500 dark:text-zinc-400">Shipping:</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-zinc-900 dark:text-white">${{ number_format($order->shipping_amount ?? 0, 2) }}</td>
                                </tr>
                                <tr class="border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                                    <td colspan="3" class="px-6 py-3 text-right text-sm font-bold text-zinc-900 dark:text-white">Total:</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm font-bold text-zinc-900 dark:text-white">${{ number_format($order->total_amount ?? 0, 2) }}</td>
                                </tr>
                             </tfoot>
                         </table>
                    </div>
                </x-card>
            </div>

            <!-- Customer Information -->
            <div class="md:col-span-1 space-y-6">
                <!-- Customer Details -->
                <x-card>
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                         <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Customer</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-4 gap-3">
                            <flux:avatar size="md">
                                {{ strtoupper(substr($order->user?->name ?? 'G', 0, 2)) }}
                            </flux:avatar>
                             <div class="flex flex-col">
                                <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $order->user?->name ?? 'Guest User' }}</span>
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $order->user?->email }}</span>
                            </div>
                        </div>
                        @if($order->user)
                        <div class="mt-2">
                            <flux:link :href="route('admin.users.edit', $order->user->id)">View Customer Profile</flux:link>
                        </div>
                        @endif
                    </div>
                </x-card>

                <!-- Shipping Address -->
                 <x-card>
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Shipping Address</h2>
                    </div>
                     <div class="p-6 text-sm text-zinc-600 dark:text-zinc-400 space-y-1">
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $order->shipping_address_name ?? ($order->user?->name ?? 'N/A') }}</p>
                        <p>{{ $order->shipping_address_line1 ?? 'N/A' }}</p>
                        @if($order->shipping_address_line2)<p>{{ $order->shipping_address_line2 }}</p>@endif
                        <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                        <p>{{ $order->shipping_country }}</p>
                    </div>
                </x-card>

                 <!-- Billing Address -->
                 <x-card>
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Billing Address</h2>
                    </div>
                     <div class="p-6 text-sm text-zinc-600 dark:text-zinc-400 space-y-1">
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $order->billing_address_name ?? ($order->user?->name ?? 'N/A') }}</p>
                        <p>{{ $order->billing_address_line1 ?? 'N/A' }}</p>
                        @if($order->billing_address_line2)<p>{{ $order->billing_address_line2 }}</p>@endif
                        <p>{{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_zip }}</p>
                        <p>{{ $order->billing_country }}</p>
                    </div>
                </x-card>

                <!-- Payment Information -->
                 <x-card>
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Payment</h2>
                    </div>
                     <div class="p-6 text-sm text-zinc-600 dark:text-zinc-400 space-y-1">
                        <p><span class="font-medium text-zinc-900 dark:text-white">Method:</span> {{ $order->payment_method ?? 'N/A' }}</p>
                        <p><span class="font-medium text-zinc-900 dark:text-white">Status:</span> {{ ucfirst($order->payment_status ?? 'N/A') }}</p>
                    </div>
                </x-card>
            </div>
        </div>


        <!-- Back Button -->
        <div class="flex justify-start">
             <flux:button :href="route('admin.orders.index')" variant="outline" icon="arrow-left">
                 Back to Orders
             </flux:button>
        </div>
    </div>
</x-layouts.admin>