<x-layouts.admin :title="__('Admin Dashboard')">
    <div class="flex flex-col gap-6">
        <!-- Summary Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Orders Card -->
            <flux:card class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 mr-4">
                        <flux:icon name="shopping-bag" class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Orders</p>
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalOrders }}</h3>
                    </div>
                </div>
            </flux:card>

            <!-- Pending Orders Card -->
            <flux:card class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 mr-4">
                        <flux:icon name="clock" class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Pending Orders</p>
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $pendingOrders }}</h3>
                    </div>
                </div>
            </flux:card>

            <!-- Total Customers Card -->
            <flux:card class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 mr-4">
                        <flux:icon name="users" class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Customers</p>
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalCustomers }}</h3>
                    </div>
                </div>
            </flux:card>

            <!-- Total Products Card -->
            <flux:card class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 mr-4">
                        <flux:icon name="cube" class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Products</p>
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalProducts }}</h3>
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Quick Actions Block -->
        <flux:card>
             <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                 <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Quick Actions</h2>
             </div>
             <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.products.create') }}" wire:navigate class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                    <div class="p-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 mr-3">
                         <flux:icon name="plus" class="h-5 w-5" />
                    </div>
                    <span class="text-sm font-medium text-zinc-900 dark:text-white">Add New Product</span>
                </a>

                <a href="{{ route('admin.orders') }}" wire:navigate class="flex items-center p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg hover:bg-amber-100 dark:hover:bg-amber-900/30 transition-colors">
                    <div class="p-2 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 mr-3">
                         <flux:icon name="clipboard-list" class="h-5 w-5" />
                    </div>
                    <span class="text-sm font-medium text-zinc-900 dark:text-white">View All Orders</span>
                </a>

                <a href="{{ route('admin.users') }}" wire:navigate class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                    <div class="p-2 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 mr-3">
                        <flux:icon name="users" class="h-5 w-5" />
                    </div>
                    <span class="text-sm font-medium text-zinc-900 dark:text-white">Manage Users</span>
                </a>
             </div>
        </flux:card>

        <!-- Recent Orders Table -->
        <flux:card>
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Recent Orders</h2>
            </div>
            <div class="overflow-x-auto">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Order ID</flux:table.column>
                        <flux:table.column>Customer</flux:table.column>
                        <flux:table.column>Date</flux:table.column>
                        <flux:table.column>Status</flux:table.column>
                        <flux:table.column>Total</flux:table.column>
                        <flux:table.column align="end">Actions</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse($recentOrders as $order)
                            <flux:table.row :key="$order->id">
                                <flux:table.cell>{{ $order->id }}</flux:table.cell>
                                <flux:table.cell>{{ $order->user?->name ?? 'N/A' }}</flux:table.cell>
                                <flux:table.cell>{{ $order->created_at->format('M d, Y') }}</flux:table.cell>
                                <flux:table.cell>
                                    <flux:badge size="sm" inset="top bottom" @class([
                                        'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' => $order->status === 'completed',
                                        'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400' => $order->status === 'processing' || $order->status === 'pending',
                                        'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' => $order->status === 'cancelled',
                                        'bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-400' => !in_array($order->status, ['completed', 'processing', 'pending', 'cancelled'])
                                    ])>
                                        {{ ucfirst($order->status) }}
                                    </flux:badge>
                                </flux:table.cell>
                                <flux:table.cell>${{ number_format($order->total_amount, 2) }}</flux:table.cell>
                                <flux:table.cell align="end">
                                    <flux:button size="sm" variant="link" :href="route('admin.orders.show', $order->id)" wire:navigate>View</flux:button>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="6">
                                    <div class="text-center py-4">No recent orders found.</div>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </div>
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                 <flux:link :href="route('admin.orders')" wire:navigate>View all orders →</flux:link>
             </div>
        </flux:card>
    </div>
</x-layouts.admin>
