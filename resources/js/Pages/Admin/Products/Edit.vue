<template>
  <div>
    <h1>Edit Product</h1>
    <form @submit.prevent="submit">
      <input v-model="form.name" placeholder="Name" />
      <input v-model="form.price" placeholder="Price" />
      <button type="submit">Save</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';

const { product } = usePage().props.value as { product: any };
const form = reactive({ name: product.name, price: product.price });
function submit() {
  Inertia.put(`/admin/products/${product.id}`, form);
}
</script> 