<template>
  <DataTable
    :value="value"
    :loading="loading"
    :paginator="true"
    :rows="rows"
    :first="first"
    :totalRecords="totalRecords"
    :lazy="true"
    @paginate="onPage"
  >
    <Column
      v-for="col in columns"
      :key="col.field"
      :field="col.field"
      :header="col.header"
      :sortable="col.sortable || false"
      :filter="col.filter || false"
    >
      <template #body="{ data }">
        <slot name="cell" :column="col" :data="data">
          {{ data[col.field] }}
        </slot>
      </template>
    </Column>
  </DataTable>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

const props = defineProps({
  value: { type: Array as () => any[], required: true },
  totalRecords: { type: Number, required: true },
  loading: { type: Boolean, default: false },
  columns: {
    type: Array as () => { field: string; header: string; sortable?: boolean; filter?: boolean }[],
    required: true,
  },
  rows: { type: Number, default: 10 },
});

const emit = defineEmits(['paginate']);
const first = ref(0);

function onPage(event: any) {
  first.value = event.first;
  emit('paginate', { page: event.page + 1, rows: event.rows });
}
</script> 