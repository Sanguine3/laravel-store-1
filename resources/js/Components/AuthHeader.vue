<template>
  <div class="flex w-full flex-col text-center">
    <Heading size="xl">{{ title }}</Heading>
    <Subheading>{{ description }}</Subheading>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import Heading from '@/Components/Heading.vue';
import Subheading from '@/Components/Subheading.vue';

const props = defineProps<{ title: string; description: string }>();
</script> 