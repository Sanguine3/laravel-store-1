<template>
  <div>
    <h1>New Product</h1>
    <form @submit.prevent="submit">
      <input v-model="form.name" placeholder="Name" />
      <input v-model="form.price" placeholder="Price" />
      <button type="submit">Create</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const form = reactive({ name: '', price: '' });
function submit() {
  Inertia.post('/admin/products', form);
}
</script> 