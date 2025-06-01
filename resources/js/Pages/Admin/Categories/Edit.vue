<template>
  <div>
    <h1>Edit Category</h1>
    <form @submit.prevent="submit">
      <input v-model="form.name" placeholder="Name" />
      <input v-model="form.slug" placeholder="Slug" />
      <textarea v-model="form.description" placeholder="Description"></textarea>
      <button type="submit">Save</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';

const { category } = usePage().props.value as { category: any };
const form = reactive({ name: category.name, slug: category.slug, description: category.description });
function submit() {
  Inertia.put(`/admin/categories/${category.id}`, form);
}
</script> 