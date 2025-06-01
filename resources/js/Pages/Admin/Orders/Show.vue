<template>
  <div>
    <h1>Order #{{ order.id }}</h1>
    <p>User: {{ order.user.name }}</p>
    <p>Total: {{ order.total }}</p>
    <p>Status: {{ order.status }}</p>

    <h2>Items</h2>
    <ul>
      <li v-for="item in order.items" :key="item.id">
        {{ item.product.name }} x {{ item.quantity }} @ {{ item.price }}
      </li>
    </ul>

    <h2>Update Status</nobr></h2>
    <form @submit.prevent="submit">
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