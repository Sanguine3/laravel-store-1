<template>
    <GuestLayout>
        <form class="w-full max-w-md bg-white dark:bg-zinc-800 p-8 rounded-lg shadow" @submit.prevent="submit">
            <AuthHeader description="Set a new password for your account." title="Reset Password"/>

            <input v-model="form.token" type="hidden"/>

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

            <div class="mt-4">
                <InputText
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    class="w-full"
                    placeholder="Confirm Password"
                    type="password"
                />
                <div v-if="form.errors.password_confirmation" class="text-red-600 text-sm mt-1">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <Link :href="route('login.form')" class="text-sm text-gray-600 hover:underline">Back to login</Link>
                <Button :loading="form.processing" class="p-button p-component p-button-primary" type="submit">Reset
                    Password
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>

<script lang="ts" setup>
import {Link, useForm, usePage} from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AuthHeader from '@/Components/AuthHeader.vue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import {route} from "ziggy-js";

const props = usePage().props;
const form = useForm({
    token: props.token || '',
    email: props.email || '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post(route('password.update'), {preserveScroll: true});
}
</script>
