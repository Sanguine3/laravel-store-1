<template>
  <div>
    <h1>{{ product.name }}</h1>
    <p>Price: {{ product.price }}</p>
    <p>{{ product.description }}</p>
    <button @click="addToCart">Add to Cart</button>
  </div>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const { product } = usePage().props.value as { product: any };
function addToCart() {
  Inertia.post(`/cart/add/${product.id}`, { quantity: 1 });
}
</script> 