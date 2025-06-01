<template>
  <AdminLayout>
    <div class="p-6 flex flex-col gap-6">
      <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Dashboard</h1>

      <Card>
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Orders</p>
            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ customerTotalOrders }}</h3>
          </div>
        </div>
      </Card>

      <Card>
        <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
          <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Recent Orders</h2>
        </div>
        <DataTableWrapper
          :value="recentOrders.data"
          :totalRecords="recentOrders.meta.total"
          :rows="recentOrders.meta.per_page"
          :columns="columns"
          @paginate="onPage"
        >
          <template #cell="{ column, data }">
            <span v-if="column.field === 'order_number'">
              <Link :href="route('orders.show', data.id)">Order #{{ data.order_number }}</Link>
            </span>
            <span v-else-if="column.field === 'created_at'">
              {{ new Date(data.created_at).toLocaleDateString('en-GB') }}
            </span>
            <span v-else-if="column.field === 'total_amount'">
              ${{ data.total_amount.toFixed(2) }}
            </span>
            <span v-else>
              {{ data[column.field] }}
            </span>
          </template>
        </DataTableWrapper>
      </Card>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { usePage, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { route } from 'ziggy-js/src/js';
import DataTableWrapper from '@/Components/DataTableWrapper.vue';
import { computed } from 'vue';

interface PageProps {
  recentOrders: {
    data: Array<{
      id: number;
      order_number: string;
      created_at: string;
      status: string;
      total_amount: number;
    }>;
    meta: {
      total: number;
      per_page: number;
    };
  };
  customerTotalOrders: number;
}

const page = usePage<PageProps>();
const recentOrders = computed(() => page.props.value.recentOrders);
const customerTotalOrders = computed(() => page.props.value.customerTotalOrders);

// Column definitions
const columns = [
  { field: 'order_number', header: 'Order #', sortable: true },
  { field: 'created_at', header: 'Date', sortable: true },
  { field: 'status', header: 'Status', sortable: true },
  { field: 'total_amount', header: 'Total', sortable: true },
];

function onPage({ page }: { page: number }) {
  Inertia.get(route('dashboard'), { page }, { preserveState: true });
}
</script>
