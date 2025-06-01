<template>
  <div class="dark flex min-h-screen">
    <Sidebar :cart-count="cartCount" />
    <div class="flex-1 flex flex-col">
      <InertiaHead />
      <Toast />
      <ConfirmDialog />
      <ToastGroup />
      <Transition name="fade" mode="out-in">
        <slot />
      </Transition>
    </div>
  </div>
</template>

<script setup lang="ts">
import { usePage, Head as InertiaHead } from '@inertiajs/inertia-vue3';
import Sidebar from '@/Components/Sidebar.vue';
import ToastGroup from '@/Components/ToastGroup.vue';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import { Transition } from 'vue';

const { props } = usePage();
const cartCount = props.cartCount || 0;
</script> 