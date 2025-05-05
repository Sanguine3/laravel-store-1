<x-layouts.admin :title="__('Orders')">
    <div class="flex flex-col gap-6">
        <!-- Search and Filters Form -->
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div class="flex-1 flex flex-col sm:flex-row sm:items-end gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="order-search" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                    <flux:input
                        name="search"
                        id="order-search"
                        placeholder="Search ID or Customer Name..."
                        icon="magnifying-glass"
                        clearable
                        class="w-full"
                        value="{{ $search ?? '' }}"
                    />
                </div>
                <!-- Status Filter -->
                <div class="min-w-[160px] md:min-w-[200px] w-full sm:w-auto" x-data="{ openStatus: false, selectedStatus: '{{ $statusFilter ?? '' }}' }">
                    <label for="status-filter-button" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                    <input type="hidden" name="status" x-model="selectedStatus">
                    <div class="relative">
                        <flux:button id="status-filter-button" type="button" icon:trailing="chevron-down" color="outline" class="w-full flex justify-between" @click="openStatus = !openStatus">
                            <span x-text="selectedStatus === '' ? 'All Status' : selectedStatus.charAt(0).toUpperCase() + selectedStatus.slice(1)">
                                {{ $statusFilter === '' ? 'All Status' : ucfirst($statusFilter) }}
                            </span>
                        </flux:button>
                        <div x-show="openStatus" @click.away="openStatus = false" class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-700 shadow-lg rounded-md border border-zinc-200 dark:border-zinc-600 max-h-60 overflow-y-auto" style="display: none;">
                            <flux:menu>
                                <flux:menu.item @click="selectedStatus = ''; openStatus = false">All Status</flux:menu.item>
                                @foreach($statuses as $statusOption)
                                    <flux:menu.item @click="selectedStatus = '{{ $statusOption }}'; openStatus = false">{{ ucfirst($statusOption) }}</flux:menu.item>
                                @endforeach
                            </flux:menu>
                        </div>
                    </div>
                </div>
            </div>
             <!-- Apply Filters Button -->
            <div class="flex items-stretch sm:items-end gap-2 w-full sm:w-auto">
                 <flux:button type="submit" color="primary" class="w-full sm:w-auto">Apply Filters</flux:button>
            </div>
        </form>

        <!-- Orders Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Order ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                <span class="font-mono text-sm">#{{ $order->id }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center">
                                        <span class="text-xs font-bold text-zinc-600 dark:text-zinc-300">{{ strtoupper(substr($order->user?->name ?? 'G', 0, 2)) }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $order->user?->name ?? 'Guest' }}</span>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $order->user?->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                <div>{{ $order->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $order->created_at->format('g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusClasses = [
                                        'completed' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400',
                                        'shipped' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400',
                                        'processing' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400',
                                        'pending' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400',
                                        'cancelled' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400',
                                    ];
                                    $statusClass = $statusClasses[$order->status] ?? 'bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-400';
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                ${{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <flux:button href="{{ route('admin.orders.show', $order->id) }}" as="a" color="info" size="sm" icon="eye" tooltip="View" class="mr-1 !bg-blue-500 !text-white hover:!bg-blue-600 focus:!ring-blue-400" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">No orders found matching your criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if ($orders->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                 {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
