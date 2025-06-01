<template>
  <aside class="w-64 border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <!-- Responsive toggle not yet implemented -->

    <div class="p-4 flex items-center justify-center">
      <AppLogo />
    </div>

    <PanelMenu :model="menuItems" class="mt-4" />

    <div class="flex-1"></div>

    <PanelMenu :model="externalItems" class="mb-4 p-4" />

    <!-- Profile Dropdown TODO: Replace with PrimeVue Menu -->
  </aside>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useCartStore } from '@/stores/cart';
import { route } from 'ziggy-js/src/js';
import AppLogo from '@/Components/AppLogo.vue';

// Pinia stores
const authStore = useAuthStore();
const cartStore = useCartStore();

// User and cart computed properties
const user = computed(() => authStore.user || {} as Record<string, any>);
const userName = computed(() => user.value.name || 'Guest');
const userInitials = computed(() => user.value.name
  ? (user.value.name as string).split(' ').map((n: string) => n[0]).join('')
  : 'G');
const cartCount = computed(() => cartStore.count);
const isCustomer = computed(() => authStore.isCustomer);
const dashboardRoute = computed(() => authStore.isAdmin ? route('admin.dashboard') : route('dashboard'));
const currentRoute = window.location.pathname;
const dashboardPath = new URL(dashboardRoute, window.location.origin).pathname;

// Sidebar menu items
const menuItems = ref([
  { label: 'Dashboard', icon: 'pi pi-home', url: dashboardRoute.value },
  { label: 'Products', icon: 'pi pi-box', url: route('products.index') },
  ...(authStore.isCustomer ? [
    { label: 'My Orders', icon: 'pi pi-list', url: route('orders.index') },
    { label: 'Cart', icon: 'pi pi-shopping-cart', url: route('cart.view') },
  ] : []),
]);

// External links
const externalItems = ref([
  { label: 'Repository', icon: 'pi pi-github', url: 'https://github.com/imacrayon/blade-starter-kit', target: '_blank' },
  { label: 'Docs', icon: 'pi pi-book', url: 'https://laravel.com/docs/starter-kits', target: '_blank' },
]);
</script> 