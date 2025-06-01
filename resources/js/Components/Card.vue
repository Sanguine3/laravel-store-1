<template>
  <PrimeCard :class="variantClasses[variant] || variantClasses.default">
    <div :class="padding">
      <slot />
    </div>
  </PrimeCard>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import PrimeCard from 'primevue/card';

const props = defineProps({
  variant: { type: String, default: 'default' },
  padding: { type: String, default: 'p-6' },
});

const variantClasses: Record<string, string> = {
  default: 'bg-white dark:bg-zinc-800 overflow-hidden shadow-sm rounded-xl',
  primary: 'border border-blue-500 dark:border-blue-700 bg-blue-50 dark:bg-blue-900/20 shadow-md rounded-lg',
  success: 'border border-green-500 dark:border-green-700 bg-green-50 dark:bg-green-900/20 shadow-md rounded-lg',
  danger: 'border border-red-500 dark:border-red-700 bg-red-50 dark:bg-red-900/20 shadow-md rounded-lg',
  warning: 'border border-amber-500 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/20 shadow-md rounded-lg',
};
</script> 