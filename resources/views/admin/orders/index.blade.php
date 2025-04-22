<x-layouts.admin :title="__('Orders')">
    <div class="flex flex-col gap-6">
        <!-- Header with Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative">
                     <flux:input wire:model.live.debounce.300ms="search" id="order-search" placeholder="Search orders (ID, Name)..." icon="magnifying-glass" />
                </div>

                <flux:select wire:model.live="statusFilter" id="status-filter" class="min-w-[150px]">
                    <option selected value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                    {{-- Add other statuses like shipped if needed/handled --}}
                </flux:select>
            </div>
            {{-- Removed static Filter/Export --}}
        </div>

        <!-- Orders Table -->
        <flux:card>
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
                         @forelse($orders as $order)
                             <flux:table.row wire:key="order-{{ $order->id }}">
                                <flux:table.cell>
                                    <span class="font-mono text-sm">#{{ $order->id }}</span>
                                </flux:table.cell>
                                <flux:table.cell>
                                     <div class="flex items-center gap-3">
                                         <flux:avatar size="sm">
                                             {{ strtoupper(substr($order->user?->name ?? 'G', 0, 2)) }}
                                         </flux:avatar>
                                         <div class="flex flex-col">
                                             <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $order->user?->name ?? 'Guest' }}</span>
                                             <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $order->user?->email }}</span>
                                         </div>
                                     </div>
                                </flux:table.cell>
                                <flux:table.cell>
                                     <div class="text-sm text-zinc-900 dark:text-white">{{ $order->created_at->format('M d, Y') }}</div>
                                     <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $order->created_at->format('g:i A') }}</div>
                                </flux:table.cell>
                                <flux:table.cell>
                                     <flux:badge size="sm" inset="top bottom" @class([
                                        'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' => $order->status === 'completed',
                                        'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400' => $order->status === 'shipped',
                                        'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400' => $order->status === 'processing' || $order->status === 'pending',
                                        'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' => $order->status === 'cancelled',
                                        'bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-400' => !in_array($order->status, ['completed', 'processing', 'pending', 'cancelled', 'shipped'])
                                    ])>
                                        {{ ucfirst($order->status) }}
                                    </flux:badge>
                                </flux:table.cell>
                                <flux:table.cell>
                                     <span class="text-sm font-medium text-zinc-900 dark:text-white">${{ number_format($order->total_amount, 2) }}</span> {{-- Adjust total_amount property name --}}
                                </flux:table.cell>
                                <flux:table.cell align="end">
                                    <div class="flex justify-end space-x-1">
                                         <flux:button size="sm" variant="ghost" :href="route('admin.orders.show', $order->id)" wire:navigate icon="eye" />
                                    </div>
                                </flux:table.cell>
                             </flux:table.row>
                         @empty
                              <flux:table.row>
                                 <flux:table.cell colspan="6">
                                     <div class="text-center py-12">
                                        <flux:icon name="clipboard-list" class="h-12 w-12 mx-auto text-gray-400" />
                                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No orders found</h3>
                                        @if($search)
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Adjust your search criteria.</p>
                                        @endif
                                    </div>
                                 </flux:table.cell>
                             </flux:table.row>
                         @endforelse
                     </flux:table.rows>
                </flux:table>
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                 {{ $orders->links() }}
            </div>
            @endif
        </flux:card>
    </div>
</x-layouts.admin>
