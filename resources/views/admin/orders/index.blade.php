<x-layouts.admin :title="__('Orders')">
    <div class="flex flex-col gap-6">
        <!-- Search and Filters Form -->
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4" x-data="{ searchTerm: '{{ $search ?? '' }}' }">
            <div class="flex-1 flex flex-col sm:flex-row sm:items-end gap-4">
                <!-- Search Input -->
                <div class="flex-1 relative">
                    <label for="order-search" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                    <flux:input
                        name="search"
                        id="order-search"
                        placeholder="Search ID or Customer Name..."
                        icon="magnifying-glass"
                        clearable
                        class="w-full"
                        value="{{ $search ?? '' }}"
                        x-model="searchTerm"
                    />
                    <span x-show="searchTerm.length > 0" x-cloak class="absolute right-10 top-1/2 mt-2.5 -translate-y-1/2 text-xs text-zinc-500 dark:text-zinc-400 pr-2" x-text="searchTerm.length"></span>
                </div>
                <!-- Status Filter -->
                <div class="min-w-[160px] md:min-w-[200px] w-full sm:w-auto" x-data="{ openStatusFilter: false, selectedStatusFilter: '{{ $statusFilter ?? '' }}' }">
                    <label for="status-filter-button" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                    <input type="hidden" name="status" x-model="selectedStatusFilter">
                    <div class="relative">
                        <button @click="openStatusFilter = !openStatusFilter" type="button" id="status-filter-button" class="w-full flex items-center justify-between px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm bg-white dark:bg-zinc-700 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span x-text="selectedStatusFilter === '' ? 'All Status' : selectedStatusFilter.charAt(0).toUpperCase() + selectedStatusFilter.slice(1)">
                                {{ $statusFilter === '' ? 'All Status' : ucfirst($statusFilter) }}
                            </span>
                            <svg class="ml-2 -mr-0.5 h-4 w-4 text-zinc-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                        <div x-show="openStatusFilter" @click.away="openStatusFilter = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-700 shadow-lg rounded-md border border-zinc-200 dark:border-zinc-600 max-h-60 overflow-y-auto py-1" style="display: none;">
                            <a href="#" @click.prevent="selectedStatusFilter = ''; openStatusFilter = false" class="block px-4 py-2 text-sm text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-600">All Status</a>
                            @foreach($statuses as $statusOption)
                                <a href="#" @click.prevent="selectedStatusFilter = '{{ $statusOption }}'; openStatusFilter = false" class="block px-4 py-2 text-sm text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-600">{{ ucfirst($statusOption) }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
             <!-- Apply Filters Button -->
            <div class="flex items-stretch sm:items-end gap-2 w-full sm:w-auto">
                 <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-400 dark:focus:ring-blue-600">Apply Filters</button>
            </div>
        </form>

        <!-- Orders Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                       @php
                           $sortLink = fn($field, $displayName) => '
                               <a href="' . route('admin.orders.index', array_merge(request()->except(['sort_by', 'direction', 'page']), ['sort_by' => $field, 'direction' => $sortField == $field && $sortDirection == 'asc' ? 'desc' : 'asc'])) . '" class="group inline-flex items-center">
                                   ' . $displayName . '
                                   <span class="ml-1 text-zinc-400 group-hover:text-zinc-500 ' . ($sortField == $field ? 'text-zinc-600 dark:text-zinc-300' : '') . '">
                                       ' . ($sortField == $field ? ($sortDirection == 'asc' ? '↑' : '↓') : '↕') . '
                                   </span>
                               </a>';
                       @endphp
                       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{!! $sortLink('order_number', 'Order ID') !!}</th>
                       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Customer</th>
                       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{!! $sortLink('created_at', 'Date') !!}</th>
                       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{!! $sortLink('status', 'Status') !!}</th>
                       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{!! $sortLink('total_amount', 'Total') !!}</th>
                       <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="font-mono text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">
                                    #{{ $order->order_number ?? $order->id }}
                                </a>
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
                               <div class="flex items-center justify-end gap-1">
                                   <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-1" x-data="{ currentStatus: '{{ $order->status }}' }">
                                       @csrf
                                       @method('PUT')
                                       <select name="status" x-model="currentStatus" @change="$event.target.form.submit()"
                                               class="block w-full pl-3 pr-8 py-1.5 text-xs border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-700 dark:text-zinc-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm appearance-none">
                                           @foreach($statuses as $statusOption)
                                               <option value="{{ $statusOption }}" {{ $order->status == $statusOption ? 'selected' : '' }}>{{ ucfirst($statusOption) }}</option>
                                           @endforeach
                                       </select>
                                       {{-- Minimalist submit button, hidden if JS enabled and select @change works --}}
                                       {{-- <button type="submit" class="text-xs px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded" x-show="currentStatus !== '{{ $order->status }}'">Save</button> --}}
                                   </form>
                                   <flux:button href="{{ route('admin.orders.show', $order->id) }}" as="a" variant="ghost" size="xs" icon="eye" tooltip="View Details" class="!p-1.5" />
                               </div>
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
