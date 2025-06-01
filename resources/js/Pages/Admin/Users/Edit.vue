<template>
  <div>
    <h1>Edit User</h1>
    <form @submit.prevent="submit">
      <input v-model="form.name" placeholder="Name" />
      <input v-model="form.email" placeholder="Email" />
      <select v-model="form.role">
        <option value="admin">Admin</option>
        <option value="customer">Customer</option>
      </select>
      <button type="submit">Save</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const { user } = usePage().props.value as { user: any };
const form = reactive({ name: user.name, email: user.email, role: user.role });
function submit() {
  Inertia.put(`/admin/users/${user.id}`, form);
}
</script> 