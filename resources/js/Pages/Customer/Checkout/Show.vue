<template>
  <div>
    <h1>Checkout</h1>
    <form @submit.prevent="submit">
      <input v-model="form.name" placeholder="Full Name" />
      <input v-model="form.address" placeholder="Address" />
      <button type="submit">Place Order</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const form = reactive({ name: '', address: '' });
function submit() {
  Inertia.post('/checkout', form);
}
</script> 