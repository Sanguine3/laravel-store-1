<template>
  <div>
    <h1>Order #{{ order.order_number }}</h1>
    <p>Status: {{ order.status }}</p>
    <p>Total: {{ order.total_amount }}</p>

    <h2>Items</h2>
    <ul>
      <li v-for="item in order.orderItems" :key="item.id">
        {{ item.product.name }} x {{ item.quantity }} @ {{ item.price }}
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/inertia-vue3';

const { order } = usePage().props.value as { order: any };
</script> 