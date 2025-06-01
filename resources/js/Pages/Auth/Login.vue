<template>
    <GuestLayout>
        <form class="w-full max-w-md bg-white dark:bg-zinc-800 p-8 rounded-lg shadow" @submit.prevent="submit">
            <AuthHeader description="Enter your credentials to log in." title="Login"/>

            <div class="mt-4">
                <InputText
                    id="email"
                    v-model="form.email"
                    class="w-full"
                    placeholder="Email"
                />
                <div v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</div>
            </div>

            <div class="mt-4">
                <InputText
                    id="password"
                    v-model="form.password"
                    class="w-full"
                    placeholder="Password"
                    type="password"
                />
                <div v-if="form.errors.password" class="text-red-600 text-sm mt-1">{{ form.errors.password }}</div>
            </div>

            <div class="mt-4 flex items-center">
                <input id="remember" v-model="form.remember" class="mr-2" type="checkbox"/>
                <label class="text-sm text-gray-700 dark:text-gray-200" for="remember">Remember me</label>
            </div>

            <div class="mt-6 flex justify-between items-center">
                <Link :href="route('password.request')" class="text-sm text-blue-600 hover:underline">Forgot your
                    password?
                </Link>
                <Button :loading="form.processing" class="p-button p-component p-button-primary" type="submit">Log in
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>

<script lang="ts" setup>
import {useForm} from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AuthHeader from '@/Components/AuthHeader.vue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import {route} from "ziggy-js";

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post(route('login'), {preserveScroll: true});
}
</script>
