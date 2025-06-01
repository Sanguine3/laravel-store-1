<template>
  <div>
    <h1>Orders</h1>
    <DataTableWrapper
      :value="orders.data"
      :totalRecords="orders.meta.total"
      :rows="orders.meta.per_page"
      :columns="columns"
      @paginate="onPage"
    >
      <template #cell="{ column, data }">
        <span v-if="column.field === 'actions'">
          <Link :href="route('admin.orders.show', data.id)">View</Link>
          <Link :href="route('admin.orders.edit', data.id)" class="ml-2">Edit</Link>
        </span>
        <span v-else-if="column.field === 'user.name'">
          {{ data.user.name }}
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
  { field: 'id', header: 'ID', sortable: true },
  { field: 'user.name', header: 'User' },
  { field: 'total_amount', header: 'Total', sortable: true },
  { field: 'status', header: 'Status', sortable: true },
  { field: 'actions', header: 'Actions' },
];

function onPage({ page, rows }: { page: number; rows: number }) {
  Inertia.get(route('admin.orders.index'), { page }, { preserveState: true });
}
</script> 