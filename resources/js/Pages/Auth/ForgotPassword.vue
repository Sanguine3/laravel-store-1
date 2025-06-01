<template>
    <GuestLayout>
        <form class="w-full max-w-md bg-white dark:bg-zinc-800 p-8 rounded-lg shadow" @submit.prevent="submit">
            <AuthHeader description="Enter your email to reset your password." title="Forgot Password"/>

            <div class="mt-4">
                <InputText
                    id="email"
                    v-model="form.email"
                    class="w-full"
                    placeholder="Email"
                />
                <div v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</div>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <Link :href="route('login.form')" class="text-sm text-gray-600 hover:underline">Back to login</Link>
                <Button :loading="form.processing" class="p-button p-component p-button-primary" type="submit">Send
                    Reset Link
                </Button>
            </div>
            <div v-if="form.recentlySuccessful" class="mt-4 text-green-600 text-sm">
                Password reset link sent.
            </div>
        </form>
    </GuestLayout>
</template>

<script lang="ts" setup>
import {Link, useForm} from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AuthHeader from '@/Components/AuthHeader.vue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import {route} from "ziggy-js";

const form = useForm({email: ''});

function submit() {
    form.post(route('password.email'), {
        preserveScroll: true,
        onFinish: () => form.reset('email'),
    });
}
</script>
