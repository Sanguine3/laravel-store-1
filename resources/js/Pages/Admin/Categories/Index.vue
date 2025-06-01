<template>
  <div>
    <h1>Categories</h1>
    <Link href="/admin/categories/create">New</Link>
    <DataTableWrapper
      :value="categories.data"
      :totalRecords="categories.meta.total"
      :rows="categories.meta.per_page"
      :columns="columns"
      @paginate="onPage"
    >
      <template #cell="{ column, data }">
        <span v-if="column.field === 'actions'">
          <Link :href="route('admin.categories.edit', data.id)">Edit</Link>
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

const { categories } = usePage().props.value as { categories: any };
// Column definitions
const columns = [
  { field: 'name', header: 'Name', sortable: true },
  { field: 'slug', header: 'Slug', sortable: true },
  { field: 'actions', header: 'Actions' },
];

function onPage({ page, rows }: { page: number; rows: number }) {
  Inertia.get(route('admin.categories.index'), { page }, { preserveState: true });
}

function destroy(id: number) {
  if (confirm('Delete?')) Inertia.delete(route('admin.categories.destroy', id));
}
</script> 