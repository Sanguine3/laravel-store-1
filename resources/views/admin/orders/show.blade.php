<x-layouts.admin :title="__('Order Details')">
    <div class="flex flex-col gap-6">
        <!-- Order Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Order #ORD-001</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Placed on April 21, 2025 at 10:45 AM</p>
            </div>

            <div class="flex items-center gap-2">
                <select id="status" name="status" class="bg-white border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:bg-zinc-800 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed" selected>Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>

                <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Update Status
                </button>
            </div>
        </div>

        <!-- Order Information -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Order Summary -->
            <div class="md:col-span-2">
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
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
                            <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-700">
                                <!-- Order Item 1 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-md object-cover" src="https://via.placeholder.com/150" alt="Product image">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-zinc-900 dark:text-white">Wireless Headphones</div>
                                                <div class="text-sm text-zinc-500 dark:text-zinc-400">SKU: WH-001</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-zinc-900 dark:text-white">$129.99</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-zinc-900 dark:text-white">1</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-zinc-900 dark:text-white">$129.99</div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-zinc-50 dark:bg-zinc-800">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-zinc-900 dark:text-white">Subtotal:</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">$129.99</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-zinc-900 dark:text-white">Tax:</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">$0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-zinc-900 dark:text-white">Shipping:</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">$0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-zinc-900 dark:text-white">Total:</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-zinc-900 dark:text-white">$129.99</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="md:col-span-1 space-y-6">
                <!-- Customer Details -->
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Customer</h2>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center">
                                <span class="text-sm font-medium text-zinc-900 dark:text-white">JD</span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-zinc-900 dark:text-white">John Doe</div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">john.doe@example.com</div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <a href="{{ route('admin.users.edit', 1) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">View Customer Profile</a>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Shipping Address</h2>
                    </div>

                    <div class="p-6">
                        <p class="text-sm text-zinc-900 dark:text-white">John Doe</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">123 Main St</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Apt 4B</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">New York, NY 10001</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">United States</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">+1 (555) 123-4567</p>
                    </div>
                </div>

                <!-- Billing Address -->
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Billing Address</h2>
                    </div>

                    <div class="p-6">
                        <p class="text-sm text-zinc-900 dark:text-white">John Doe</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">123 Main St</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Apt 4B</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">New York, NY 10001</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">United States</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">+1 (555) 123-4567</p>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Payment</h2>
                    </div>

                    <div class="p-6">
                        <p class="text-sm text-zinc-900 dark:text-white">Payment Method: Credit Card</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Card: **** **** **** 1234</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Status: Paid</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Notes -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Order Notes</h2>
            </div>

            <div class="p-6">
                <div class="mb-4">
                    <textarea id="notes" name="notes" rows="3" class="block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400" placeholder="Add a note to this order..."></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Add Note
                    </button>
                </div>

                <div class="mt-6 space-y-4">
                    <div class="bg-zinc-50 dark:bg-zinc-800 p-4 rounded-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-zinc-900 dark:text-white">Admin User</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">April 21, 2025 at 11:30 AM</p>
                            </div>
                            <button type="button" class="text-zinc-400 hover:text-zinc-500 dark:hover:text-zinc-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2 text-sm text-zinc-700 dark:text-zinc-300">Order has been processed and shipped. Tracking number: 1Z999AA10123456784</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="flex justify-start">
            <a href="{{ route('admin.orders') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-md font-semibold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Orders
            </a>
        </div>
    </div>
</x-layouts.admin>
