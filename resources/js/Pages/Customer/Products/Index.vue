<template>
  <div>
    <h1>Products</h1>
    <DataTableWrapper
      :value="products.data"
      :totalRecords="products.meta.total"
      :rows="products.meta.per_page"
      :columns="columns"
      @paginate="onPage"
    >
      <template #cell="{ column, data }">
        <span v-if="column.field === 'name'">
          <Link :href="route('products.show', data.id)">{{ data.name }}</Link>
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
];

function onPage({ page }: { page: number }) {
  Inertia.get(route('products.index'), { page }, { preserveState: true });
}
</script> 