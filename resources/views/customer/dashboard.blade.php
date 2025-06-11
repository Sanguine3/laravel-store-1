<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Back Card (Visually Exciting, More Spacing) -->
            <div
                class="bg-gradient-to-r from-green-100 via-amber-50 to-yellow-100 dark:from-green-900 dark:via-amber-900/20 dark:to-yellow-900/20 shadow-lg sm:rounded-xl mb-10 border border-green-200 dark:border-green-700 flex flex-col sm:flex-row items-center gap-6 px-6 py-10">
                <div
                    class="flex-shrink-0 p-4 rounded-full bg-green-200 dark:bg-green-800 text-green-700 dark:text-green-300 shadow mb-4 sm:mb-0">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-2.21 0-4 1.79-4 4v2h8v-2c0-2.21-1.79-4-4-4z"/>
                    </svg>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <div class="text-2xl font-bold text-green-900 dark:text-green-200 mb-2">Welcome
                        back, {{ Auth::user()?->name }}!
                    </div>
                    <div class="text-base text-green-700 dark:text-green-300">Hope you have a productive day!</div>
                </div>
            </div>

            <!-- Stats Separator -->
            <div class="flex items-center mb-6">
                <div class="flex-grow border-t border-amber-200 dark:border-amber-700"></div>
                <span class="mx-4 text-amber-700 dark:text-amber-400 font-semibold uppercase tracking-wider text-xs">Your Store Stats</span>
                <div class="flex-grow border-t border-amber-200 dark:border-amber-700"></div>
            </div>

            <!-- Statistics Cards (More Spacing) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                <!-- My Total Orders -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 flex items-center">
                    <div class="p-4 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 mr-6">
                        <flux:icon name="shopping-bag" class="h-8 w-8"/>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-500 dark:text-zinc-400">My Total Orders</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $customerTotalOrders }}</h3>
                    </div>
                </div>
                {{-- Add more customer-centric stat cards here if needed --}}
                {{-- e.g., Wishlist items, Pending Shipments (if data available) --}}
            </div>

            <!-- Quick Links Separator -->
            <div class="flex items-center mb-6">
                <div class="flex-grow border-t border-green-300 dark:border-green-700"></div>
                <span class="mx-4 text-green-700 dark:text-green-400 font-semibold uppercase tracking-wider text-xs">Quick Links</span>
                <div class="flex-grow border-t border-green-300 dark:border-green-700"></div>
            </div>
            <!-- Quick Actions (More Spacing, Responsive) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                <a href="{{ route('products.index') }}"
                   class="flex items-center p-6 bg-teal-50 dark:bg-teal-900/20 rounded-lg hover:bg-teal-100 dark:hover:bg-teal-900/30 transition-colors border border-teal-200 dark:border-teal-800 shadow-sm">
                    <div class="p-3 rounded-full bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 mr-4">
                        <flux:icon name="layout-grid" class="h-6 w-6"/> {{-- Icon for browsing products --}}
                    </div>
                    <span class="text-base font-medium text-teal-900 dark:text-teal-200">View All Products</span>
                </a>
                <a href="{{ route('orders') }}"
                   class="flex items-center p-6 bg-gray-50 dark:bg-gray-900/20 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900/30 transition-colors border border-gray-200 dark:border-gray-800 shadow-sm">
                    <div class="p-3 rounded-full bg-gray-100 dark:bg-gray-900/30 text-gray-600 dark:text-gray-300 mr-4">
                        <flux:icon name="clipboard" class="h-6 w-6"/>
                    </div>
                    <span class="text-base font-medium text-gray-900 dark:text-gray-100">View My Orders</span>
                </a>
                <a href="{{ route('settings.profile') }}"
                   class="flex items-center p-6 bg-amber-50 dark:bg-amber-900/20 rounded-lg hover:bg-amber-100 dark:hover:bg-amber-900/30 transition-colors border border-amber-200 dark:border-amber-800 shadow-sm">
                    <div
                        class="p-3 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 mr-4">
                        <flux:icon name="user" class="h-6 w-6"/>
                    </div>
                    <span class="text-base font-medium text-amber-900 dark:text-amber-200">Account Settings</span>
                </a>
            </div>

            <!-- Recent Orders -->
            <div
                class="bg-gray-50 dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg mb-10 border border-gray-200 dark:border-zinc-800">
                <div class="p-6 border-b border-gray-200 dark:border-zinc-800">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">My Recent Orders</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-800">
                        <thead class="bg-gray-100 dark:bg-zinc-900">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">
                                Order #
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-gray-50 dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-800">
                        @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-500">
                                    <a href="{{ route('orders.show', $order) }}">#{{ $order->order_number }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-zinc-400">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <flux:badge size="sm" inset="top bottom" @class([
                                            'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' => $order->status === 'completed',
                                            'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400' => $order->status === 'pending' || $order->status === 'processing',
                                            'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' => $order->status === 'cancelled',
                                            'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400' => $order->status === 'shipped',
                                            'bg-gray-100 dark:bg-zinc-800 text-gray-800 dark:text-zinc-400' => !in_array($order->status, ['completed','pending', 'processing', 'cancelled', 'shipped']),
                                        ])>
                                        {{ ucfirst($order->status) }}
                                    </flux:badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">
                                    ${{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white text-center">
                                    <div class="py-8">
                                        <flux:icon name="shopping-bag"
                                                   class="h-10 w-10 mx-auto text-gray-400 dark:text-gray-500"/>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No orders
                                            found</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You haven’t placed any
                                            orders yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if (!empty($recentOrders))
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-zinc-900">
                        <a href="{{ route('orders') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">View
                            all my orders →</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
