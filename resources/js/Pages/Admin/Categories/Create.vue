<template>
  <div>
    <h1>New Category</h1>
    <form @submit.prevent="submit">
      <input v-model="form.name" placeholder="Name" />
      <input v-model="form.slug" placeholder="Slug" />
      <textarea v-model="form.description" placeholder="Description"></textarea>
      <button type="submit">Create</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const form = reactive({ name: '', slug: '', description: '' });
function submit() {
  Inertia.post('/admin/categories', form);
}
</script> 