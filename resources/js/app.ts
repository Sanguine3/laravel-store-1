/// <reference path="./env.d.ts" />
/// <reference types="vite/client" />

// Initialize theme from localStorage or system preference
const savedTheme = localStorage.getItem('theme');
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
  document.documentElement.classList.add('dark');
} else {
  document.documentElement.classList.remove('dark');
}

import { createApp, type DefineComponent, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { createPinia } from 'pinia';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import Tooltip from 'primevue/tooltip';

// PrimeVue styles
import 'primevue/resources/themes/saga-blue/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';

// Layouts
import AdminLayout from './Layouts/AdminLayout.vue';
import AuthHeader from './Components/AuthHeader.vue';

// Stores
import { useAuthStore } from '@/stores/auth';
import { useCartStore } from '@/stores/cart';
import { useFlashStore } from '@/stores/flash';

// Initialize progress bar
InertiaProgress.init({
  delay: 250,
  color: '#4f46e5',
  includeCSS: true,
  showSpinner: true,
});

// PrimeVue components with dynamic imports
const primeComponents = {
  PanelMenu: () => import('primevue/panelmenu'),
  Card: () => import('primevue/card'),
  InputText: () => import('primevue/inputtext'),
  InputNumber: () => import('primevue/inputnumber'),
  Dropdown: () => import('primevue/dropdown'),
  Button: () => import('primevue/button'),
  Toast: () => import('primevue/toast'),
  ConfirmDialog: () => import('primevue/confirmdialog'),
  Avatar: () => import('primevue/avatar'),
  Tag: () => import('primevue/tag'),
  Breadcrumb: () => import('primevue/breadcrumb'),
};

// Define flash message types
type FlashMessageType = 'success' | 'error' | 'warning' | 'info';

// Initialize and hydrate stores
function initializeStores(props: any) {
  const authStore = useAuthStore();
  const cartStore = useCartStore();
  const flashStore = useFlashStore();

  // Hydrate auth and cart
  authStore.setUser(props.initialPage.props.auth?.user || null);
  cartStore.setCount(props.initialPage.props.cartCount || 0);

  // Process flash messages
  const flashes = props.initialPage.props.flash || {};
  Object.entries(flashes).forEach(([type, message]) => {
    if (message && ['success', 'error', 'warning', 'info'].includes(type)) {
      flashStore.add({ 
        type: type as FlashMessageType, 
        message: String(message) 
      });
    }
  });
}

createInertiaApp({
  resolve: async (name: string) => {
    const pages = import.meta.glob<DefineComponent>('./Pages/**/*.vue', { eager: false });
    const page = await pages[`./Pages/${name}.vue`]?.();
    
    if (!page) throw new Error(`Page not found: ${name}`);
    
    // Auto-set layouts
    if (!page.default.layout) {
      if (name.startsWith('Admin/')) page.default.layout = AdminLayout;
      else if (name.startsWith('Auth/')) page.default.layout = AuthHeader;
    }
    
    return page;
  },

  setup({ el, app, props, plugin }) {
    const vueApp = createApp({
      render: () => h(app, {
        ...props,
        key: props.initialPage.component,
      })
    });

    // Plugins
    vueApp.use(createPinia());
    vueApp.use(PrimeVue, {
      ripple: true,
      inputStyle: 'filled',
    });
    vueApp.use(ToastService);
    vueApp.use(ConfirmationService);

    // Register components
    Object.entries(primeComponents).forEach(([name, component]) => {
      vueApp.component(name, component);
    });

    // Register custom components
    vueApp.component('AdminLayout', AdminLayout);
    vueApp.component('AuthHeader', AuthHeader);
    vueApp.directive('tooltip', Tooltip);

    // Initialize stores
    initializeStores(props);

    // Mount app
    vueApp.use(plugin).mount(el);
  },
});
