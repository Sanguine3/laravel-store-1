<template>
  <div>
    <h1>Your Orders</h1>
    <DataTableWrapper
      :value="orders.data"
      :totalRecords="orders.meta.total"
      :rows="orders.meta.per_page"
      :columns="columns"
      @paginate="onPage"
    >
      <template #cell="{ column, data }">
        <span v-if="column.field === 'order_number'">
          <Link :href="route('orders.show', data.id)">Order #{{ data.order_number }}</Link>
        </span>
        <span v-else>
          {{ data[column.field] }}
        </span>
      </template>
    </DataTableWrapper>
  </div>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { route } from 'ziggy-js/src/js';
import DataTableWrapper from '@/Components/DataTableWrapper.vue';

const { orders } = usePage().props.value as { orders: any };

// Column definitions
const columns = [
  { field: 'order_number', header: 'Order #', sortable: true },
  { field: 'status', header: 'Status', sortable: true },
  { field: 'total_amount', header: 'Total', sortable: true },
];

function onPage({ page, rows }: { page: number; rows: number }) {
  Inertia.get(route('orders.index'), { page }, { preserveState: true });
}
</script> 