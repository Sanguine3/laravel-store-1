<template>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-gray-900 dark:to-gray-800">
        <!-- Navigation -->
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <AppLogo :title="defaultTitle" class="w-10 h-10"/>
                    <span
                        class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-blue-500">
            {{ defaultTitle }}
          </span>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
                       href="#features">Features</a>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
                       href="#features">Features</a>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
                       :href="route('contact')">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a class="px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200 transition-colors"
                       href="/login">
                        Log In
                    </a>
                    <a class="px-6 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-500 rounded-full shadow-lg hover:from-indigo-700 hover:to-blue-600 transition-all transform hover:-translate-y-0.5"
                       href="/register">
                        Get Started
                    </a>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="container mx-auto px-6 py-16 md:py-24 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-12 md:mb-0">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white leading-tight mb-6">
                    Welcome to
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-blue-500">
            {{ defaultTitle }}
          </span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                    Discover amazing products and services that will transform your online experience.
                    Join our community of satisfied customers today.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-full text-center font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300"
                       href="/register">
                        Get Started
                    </a>
                    <a class="px-8 py-3 border-2 border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400 rounded-full text-center font-medium hover:bg-indigo-50 dark:hover:bg-gray-800 transition-colors"
                       href="#features">
                        Learn More
                    </a>
                </div>
                <div class="mt-8 flex items-center space-x-4">
                    <div class="flex -space-x-2">
                        <img v-for="(img, index) in userAvatars" :key="index" :src="img"
                             :alt="`User avatar ${index + 1}`"
                             :style="{ zIndex: userAvatars.length - index }"
                             class="w-10 h-10 rounded-full border-2 border-white dark:border-gray-800" />
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Join <span class="font-semibold text-indigo-600 dark:text-indigo-400">10,000+</span> happy users
                    </p>
                </div>
            </div>
            <div class="md:w-1/2 relative">
                <div class="relative z-10 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                    <img
                        alt="Dashboard Preview"
                        class="w-full h-auto rounded-2xl transform hover:scale-105 transition-transform duration-500"
                        src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80"/>
                </div>
                <div
                    class="absolute -bottom-6 -left-6 w-32 h-32 bg-indigo-200 dark:bg-indigo-900 rounded-full opacity-50"></div>
                <div
                    class="absolute -top-6 -right-6 w-24 h-24 bg-blue-200 dark:bg-blue-900 rounded-full opacity-50"></div>
            </div>
        </div>

        <!-- Features Section -->
        <section id="features" class="py-16 bg-white dark:bg-gray-800">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Amazing Features</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Discover what makes our platform stand out from the crowd
                    </p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="p-6 bg-white dark:bg-gray-700 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div
                            class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                            <i class="pi pi-bolt text-2xl text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Lightning Fast</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Experience blazing fast performance with our optimized platform that loads in the blink of
                            an eye.
                        </p>
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-700 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div
                            class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                            <i class="pi pi-shield text-2xl text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Secure & Private</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Your data is protected with enterprise-grade security and end-to-end encryption.
                        </p>
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-700 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div
                            class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                            <i class="pi pi-thumbs-up text-2xl text-green-600 dark:text-green-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Easy to Use</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Intuitive interface designed for everyone, regardless of technical expertise.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-indigo-600 to-blue-500">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to get started?</h2>
                <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                    Join thousands of satisfied users and experience the difference today.
                </p>
                <a class="inline-block px-8 py-3 bg-white text-indigo-600 rounded-full font-medium shadow-lg hover:bg-gray-100 transform hover:-translate-y-0.5 transition-all duration-300"
                   href="/register">
                    Create Free Account
                </a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-400 py-12">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-2 mb-6 md:mb-0">
                        <AppLogo :title="defaultTitle" class="w-8 h-8"/>
                        <span class="text-xl font-semibold text-white">{{ defaultTitle }}</span>
                    </div>
                    <div class="flex space-x-6">
                        <a class="hover:text-white transition-colors" href="#">
                            <i class="pi pi-twitter text-xl"></i>
                        </a>
                        <a class="hover:text-white transition-colors" href="#">
                            <i class="pi pi-facebook text-xl"></i>
                        </a>
                        <a class="hover:text-white transition-colors" href="#">
                            <i class="pi pi-instagram text-xl"></i>
                        </a>
                        <a class="hover:text-white transition-colors" href="#">
                            <i class="pi pi-github text-xl"></i>
                        </a>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm mb-4 md:mb-0">
                        &copy; {{ new Date().getFullYear() }} {{ defaultTitle }}. All rights reserved.
                    </p>
                    <div class="flex space-x-6">
                        <a class="text-sm hover:text-white transition-colors" href="#">Privacy Policy</a>
                        <a class="text-sm hover:text-white transition-colors" href="#">Terms of Service</a>
                        <a class="text-sm hover:text-white transition-colors" href="#">Contact Us</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script lang="ts" setup>
import AppLogo from '@/Components/AppLogo.vue';
import { onMounted, ref } from 'vue';
import { route } from 'ziggy-js';

const defaultTitle = import.meta.env.VITE_APP_NAME || 'Laravel Store';

// Sample user avatars for the "Join X users" section
const userAvatars = ref([
    'https://randomuser.me/api/portraits/women/44.jpg',
    'https://randomuser.me/api/portraits/men/32.jpg',
    'https://randomuser.me/api/portraits/women/68.jpg',
    'https://randomuser.me/api/portraits/men/91.jpg',
]);

// Smooth scroll behavior is handled by the browser's native scroll behavior

onMounted(() => {
    // Initialize any animations or effects here
    document.querySelectorAll<HTMLElement>('[data-animate-delay]').forEach((el) => {
        if (el.dataset.animateDelay) {
            el.style.animationDelay = el.dataset.animateDelay;
        }
    });
});
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Dark mode scrollbar */
.dark ::-webkit-scrollbar-track {
    background: #1f2937;
}

.dark ::-webkit-scrollbar-thumb {
    background: #4b5563;
}

.dark ::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
}

/* Animation delays can be added here when needed */
</style>
