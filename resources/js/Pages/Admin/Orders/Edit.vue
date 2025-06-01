<template>
  <div>
    <h1>Edit Order #{{ order.id }}</h1>
    <form @submit.prevent="submit">
      <label>Status</label>
      <select v-model="form.status">
        <option value="pending">Pending</option>
        <option value="processing">Processing</option>
        <option value="completed">Completed</option>
        <option value="cancelled">Cancelled</option>
      </select>
      <button type="submit">Save</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const { order } = usePage().props.value as { order: any };
const form = reactive({ status: order.status });
function submit() {
  Inertia.put(`/admin/orders/${order.id}`, form);
}
</script> 