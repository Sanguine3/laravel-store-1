<template>
  <div>
    <h1>Products</h1>
    <Link href="/admin/products/create">New</Link>
    <DataTableWrapper
      :value="products.data"
      :totalRecords="products.meta.total"
      :rows="products.meta.per_page"
      :columns="columns"
      @paginate="onPage"
    >
      <template #cell="{ column, data }">
        <span v-if="column.field === 'actions'">
          <Link :href="route('admin.products.edit', data.id)">Edit</Link>
          <button @click="destroy(data.id)" class="ml-2 text-red-600">Delete</button>
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

const { products } = usePage().props.value as { products: any };

// Column definitions
const columns = [
  { field: 'name', header: 'Name', sortable: true },
  { field: 'price', header: 'Price', sortable: true },
  { field: 'actions', header: 'Actions' },
];

// Handle pagination
function onPage({ page, rows }: { page: number; rows: number }) {
  Inertia.get(route('admin.products.index'), { page }, { preserveState: true });
}

function destroy(id: number) {
  if (confirm('Delete?')) Inertia.delete(route('admin.products.destroy', id));
}
</script> 