<template>
  <AdminLayout>
    <div class="flex flex-col gap-6">
      <!-- Summary Statistics Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <Card>
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 mr-4">
              <flux-icon name="currency-dollar" class="h-6 w-6" />
            </div>
            <div>
              <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Revenue</p>
              <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">
                ${{ stats.totalRevenue.toFixed(2) }}
              </h3>
            </div>
          </div>
        </Card>
        <Card>
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 mr-4">
              <flux-icon name="shopping-bag" class="h-6 w-6" />
            </div>
            <div>
              <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Orders</p>
              <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ stats.totalOrders }}</h3>
            </div>
          </div>
        </Card>
        <!-- Add other cards similarly... -->
      </div>
      <!-- Quick Actions Block -->
      <Card>
        <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
          <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Quick Actions</h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
          <inertia-link href="/admin/products/create" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
            <div class="p-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 mr-3">
              <flux-icon name="plus" class="h-5 w-5" />
            </div>
            <span class="text-sm font-medium text-zinc-900 dark:text-white">Add New Product</span>
          </inertia-link>
          <!-- Add other quick actions... -->
        </div>
      </Card>
      <!-- Recent Orders Table -->
      <Card>
        <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
          <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Recent Orders</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-50 dark:bg-zinc-800">
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
              <tr v-for="order in stats.recentOrders.data" :key="order.id">
                <td>{{ order.id }}</td>
                <td>{{ order.user.name }}</td>
                <td>{{ new Date(order.created_at).toLocaleDateString('en-GB') }}</td>
                <td>{{ order.status }}</td>
                <td>${{ order.total_amount.toFixed(2) }}</td>
                <td>
                  <inertia-link :href="`/admin/orders/${order.id}`" class="text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300">
                    View
                  </inertia-link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="p-6 flex justify-center space-x-1">
          <inertia-link
            v-for="link in stats.recentOrders.links"
            :key="link.label"
            :href="link.url"
            class="px-3 py-1 border rounded-lg"
            :class="{ 'bg-zinc-200 dark:bg-zinc-700': link.active, 'opacity-50 pointer-events-none': !link.url }"
          >
            <span v-html="link.label"></span>
          </inertia-link>
        </div>
      </Card>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/inertia-vue3';

const { props } = usePage();
const stats = props.stats;
</script> 