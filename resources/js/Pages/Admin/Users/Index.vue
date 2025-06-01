<template>
  <div>
    <h1>Users</h1>
    <Link href="/admin/users/create">New</Link>
    <DataTableWrapper
      :value="users.data"
      :totalRecords="users.meta.total"
      :rows="users.meta.per_page"
      :columns="columns"
      @paginate="onPage"
    >
      <template #cell="{ column, data }">
        <span v-if="column.field === 'actions'">
          <Link :href="route('admin.users.edit', data.id)">Edit</Link>
          <button
            v-if="!data.deleted_at"
            @click="destroy(data.id)"
            class="ml-2 text-red-600"
          >
            Delete
          </button>
          <button
            v-if="data.deleted_at"
            @click="restore(data.id)"
            class="ml-2 text-green-600"
          >
            Restore
          </button>
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

const { users } = usePage().props.value as { users: any };
// Column definitions
const columns = [
  { field: 'name', header: 'Name', sortable: true },
  { field: 'email', header: 'Email', sortable: true },
  { field: 'role', header: 'Role', sortable: true },
  { field: 'deleted_at', header: 'Status', sortable: true },
  { field: 'actions', header: 'Actions' },
];

function onPage({ page, rows }: { page: number; rows: number }) {
  Inertia.get(route('admin.users.index'), { page }, { preserveState: true });
}

function destroy(id: number) {
  if (confirm('Delete user?')) Inertia.delete(route('admin.users.destroy', id));
}
function restore(id: number) {
  if (confirm('Restore user?')) Inertia.put(route('admin.users.restore', id));
}
</script> 