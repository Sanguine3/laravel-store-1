<template>
  <div class="flex items-center">
    <div class="flex aspect-square w-10 items-center justify-center rounded-md bg-transparent">
      <img :src="logoUrl" alt="Logo" class="w-8 h-8" />
    </div>
    <span class="ml-2 self-center truncate leading-none font-semibold text-base">{{ title }}</span>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

const props = defineProps({
  title: { type: String, default: import.meta.env.VITE_APP_NAME || 'Laravel Store' },
});

const logoUrl = import.meta.env.BASE_URL + 'favicon.ico';
</script> 