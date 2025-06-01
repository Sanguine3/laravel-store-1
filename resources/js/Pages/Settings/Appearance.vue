<template>
    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Appearance</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Customize how the application looks on your device.
                </p>
            </div>

            <div class="px-4 py-5 sm:p-6">
                <div class="space-y-6">
                    <!-- Theme Selection -->
                    <div>
                        <h3 class="text-base font-medium text-gray-900 dark:text-white mb-4">Theme</h3>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <button
                                v-for="theme in themes"
                                :key="theme.name"
                                :class="{
                  'border-indigo-500 ring-2 ring-indigo-500': selectedTheme === theme.name,
                  'border-gray-300 dark:border-gray-600': selectedTheme !== theme.name,
                  'bg-white dark:bg-gray-700': true
                }"
                                class="relative rounded-lg border p-4 flex flex-col items-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                type="button"
                                @click="setTheme(theme.name)"
                            >
                                <div class="h-10 w-10 mb-2 flex items-center justify-center">
                                    <component :is="theme.icon" class="h-6 w-6"/>
                                </div>
                                <span class="block text-sm font-medium text-gray-900 dark:text-white">
                  {{ theme.label }}
                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { SunIcon, MoonIcon, ComputerDesktopIcon } from '@heroicons/vue/24/outline';

const themes = [
  { name: 'light', label: 'Light', icon: SunIcon },
  { name: 'dark', label: 'Dark', icon: MoonIcon },
  { name: 'system', label: 'System', icon: ComputerDesktopIcon },
];

const selectedTheme = ref('system');

// Set theme and store preference
const setTheme = (theme: string) => {
    selectedTheme.value = theme;
    localStorage.setItem('theme', theme);

    if (theme === 'system') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.classList.toggle('dark', prefersDark);
    } else {
        document.documentElement.classList.toggle('dark', theme === 'dark');
    }
};

// Initialize theme from localStorage or system preference
onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (savedTheme) {
        selectedTheme.value = savedTheme;
        document.documentElement.classList.toggle('dark', savedTheme === 'dark');
    } else if (prefersDark) {
        selectedTheme.value = 'system';
        document.documentElement.classList.add('dark');
    }

    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (selectedTheme.value === 'system') {
            document.documentElement.classList.toggle('dark', e.matches);
        }
    });
});
</script>
