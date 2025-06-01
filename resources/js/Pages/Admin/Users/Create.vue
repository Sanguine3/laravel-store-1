<template>
  <div>
    <h1>New User</h1>
    <form @submit.prevent="submit">
      <input v-model="form.name" placeholder="Name" />
      <input v-model="form.email" placeholder="Email" />
      <input type="password" v-model="form.password" placeholder="Password" />
      <select v-model="form.role">
        <option value="admin">Admin</option>
        <option value="customer">Customer</option>
      </select>
      <button type="submit">Create</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const form = reactive({ name: '', email: '', password: '', role: 'customer' });
function submit() {
  Inertia.post('/admin/users', form);
}
</script> 