/// <reference types="vite/client" />

// Stub core modules for TS
declare module 'vue';
declare module '@inertiajs/inertia-vue3';
declare module '@inertiajs/progress';
declare module 'pinia';

declare module '*.vue' {
    const component: any;
}

declare global {
}

declare module '@/*';

declare module '@inertiajs/inertia';
declare module 'primevue/card';
declare module 'primevue/inputtext';
declare module 'primevue/inputnumber';
declare module 'primevue/dropdown';
declare module 'primevue/button';
declare module 'primevue/toast';
declare module 'primevue/toastservice';
declare module 'primevue/confirmdialog';
declare module 'primevue/confirmationservice';
declare module 'primevue/avatar';
declare module 'primevue/tag';
declare module 'primevue/breadcrumb';
declare module 'primevue/panelmenu';
declare module 'primevue/tooltip';

export {};
