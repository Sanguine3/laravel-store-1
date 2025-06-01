<template>
  <div>
    <h1>Your Cart</h1>
    <ul>
      <li v-for="product in products" :key="product.id">
        {{ product.name }} x {{ cart[product.id] }}
        <button @click="update(product.id)">Update</button>
        <button @click="remove(product.id)">Remove</button>
      </li>
    </ul>
    <Link href="/checkout">Proceed to Checkout</Link>
  </div>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const { cart, products } = usePage().props.value as { cart: Record<string, number>; products: any[] };
function update(id: number) {
  const quantity = parseInt(prompt('Quantity', cart[id]) || `${cart[id]}`);
  Inertia.patch(`/cart/update/${id}`, { quantity });
}
function remove(id: number) {
  if (confirm('Remove?')) Inertia.delete(`/cart/remove/${id}`);
}
</script> 