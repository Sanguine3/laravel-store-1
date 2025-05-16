<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6">
                <x-card>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-zinc-50 dark:bg-zinc-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Order #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-500">
                                            <a href="{{ route('orders.show', $order) }}">#{{ $order->order_number }}</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <flux:badge size="sm" inset="top bottom" @class([
                                                'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' => $order->status === 'completed',
                                                'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400' => $order->status === 'pending' || $order->status === 'processing',
                                                'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' => $order->status === 'cancelled',
                                                'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400' => $order->status === 'shipped',
                                                'bg-zinc-100 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-400' => !in_array($order->status, ['completed','pending', 'processing', 'cancelled', 'shipped']),
                                            ])>
                                                {{ ucfirst($order->status) }}
                                            </flux:badge>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-zinc-900 dark:text-white">${{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('orders.show', $order) }}" class="text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white text-center">
                                            <div class="py-8">
                                                <flux:icon name="shopping-bag" class="h-10 w-10 mx-auto text-gray-400 dark:text-gray-500" />
                                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No orders found</h3>
                                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You haven’t placed any orders yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                        {{ $orders->links() }}
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-layouts.app>