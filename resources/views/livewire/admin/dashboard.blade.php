<x-layouts.admin :title="__('Dashboard')">
    {{ $slot ?? '' }}
    <div class="flex flex-col gap-6">
        <!-- Summary Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Orders Card -->
            <x-card class="p-6 bg-white dark:bg-zinc-900 shadow-md border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 mr-4">
                        <flux:icon name="shopping-bag" class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Orders</p>
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalOrders }}</h3>
                    </div>
                </div>
            </x-card>

            <!-- Pending Orders Card -->
            <x-card class="p-6 bg-white dark:bg-zinc-900 shadow-md border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 mr-4">
                        <flux:icon name="clock" class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Pending Orders</p>
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $pendingOrders }}</h3>
                    </div>
                </div>
            </x-card>

            <!-- Total Customers Card -->
            <x-card class="p-6 bg-white dark:bg-zinc-900 shadow-md border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 mr-4">
                        <flux:icon name="users" class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Customers</p>
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalCustomers }}</h3>
                    </div>
                </div>
            </x-card>

            <!-- Total Products Card -->
            <x-card class="p-6 bg-white dark:bg-zinc-900 shadow-md border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 mr-4">
                        <flux:icon name="cube" class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Products</p>
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalProducts }}</h3>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Quick Actions Block -->
        <x-card>
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
                         <flux:icon.clipboard variant="outline" class="h-5 w-5" />
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
        </x-card>

        <!-- Recent Orders Table -->
        <x-card>
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Recent Orders</h2>
            </div>
            <div class="overflow-x-auto">
               <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700"> {{-- Added table with classes --}}
                   <thead class="bg-zinc-50 dark:bg-zinc-800"> {{-- Added thead with classes --}}
                       <tr> {{-- Added tr --}}
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Order ID</th> {{-- Replaced flux:table.column with th --}}
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Customer</th> {{-- Replaced flux:table.column with th --}}
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date</th> {{-- Replaced flux:table.column with th --}}
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th> {{-- Replaced flux:table.column with th --}}
                           <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total</th> {{-- Replaced flux:table.column with th --}}
                           <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th> {{-- Replaced flux:table.column with th --}}
                       </tr> {{-- Closed tr --}}
                   </thead> {{-- Closed thead --}}

                   <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700"> {{-- Added tbody with classes --}}
                       @forelse($recentOrders as $order)
                           <tr wire:key="order-{{ $order->id }}"> {{-- Replaced flux:table.row with tr --}}
                               <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">{{ $order->id }}</td> {{-- Replaced flux:table.cell with td --}}
                               <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $order->user?->name ?? 'N/A' }}</td> {{-- Replaced flux:table.cell with td --}}
                               <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ $order->created_at->format('M d, Y') }}</td> {{-- Replaced flux:table.cell with td --}}
                               <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400"> {{-- Replaced flux:table.cell with td --}}
                                   <flux:badge size="sm" inset="top bottom" @class([
                                       'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' => $order->status === 'completed',
                                       'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400' => $order->status === 'processing' || $order->status === 'pending',
                                       'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' => $order->status === 'cancelled',
                                       'bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-400' => !in_array($order->status, ['completed', 'processing', 'pending', 'cancelled'])
                                   ])>
                                       {{ ucfirst($order->status) }}
                                   </flux:badge>
                               </td> {{-- Closed td --}}
                               <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">${{ number_format($order->total_amount, 2) }}</td> {{-- Replaced flux:table.cell with td --}}
                               <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"> {{-- Replaced flux:table.cell with td --}}
                                   <flux:button size="sm" variant="subtle" :href="route('admin.orders.show', $order->id)" wire:navigate>View</flux:button>
                               </td> {{-- Closed td --}}
                           </tr> {{-- Closed tr --}}
                        @empty
                            <tr> {{-- Replaced flux:table.row with tr --}}
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white"> {{-- Replaced flux:table.cell with td, adjusted colspan --}}
                                    <div class="text-center py-4">No recent orders found.</div>
                                </td> {{-- Closed td --}}
                            </tr> {{-- Closed tr --}}
                        @endforelse
                    </tbody> {{-- Closed tbody --}}
                </table> {{-- Closed table --}}
            </div>
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                 <flux:link :href="route('admin.orders')" wire:navigate>View all orders →</flux:link>
             </div>
        </x-card>
    </div>
</x-layouts.admin>
