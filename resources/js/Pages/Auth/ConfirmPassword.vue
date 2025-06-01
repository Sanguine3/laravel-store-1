<template>
    <GuestLayout>
        <form class="w-full max-w-md bg-white dark:bg-zinc-800 p-8 rounded-lg shadow" @submit.prevent="submit">
            <AuthHeader description="Please confirm your password before continuing." title="Confirm Password"/>

            <div class="mt-4">
                <InputText
                    id="password"
                    v-model="form.password"
                    autocomplete="current-password"
                    class="w-full"
                    placeholder="Password"
                    type="password"
                />
                <div v-if="form.errors.password" class="text-red-600 text-sm mt-1">{{ form.errors.password }}</div>
            </div>

            <div class="mt-6">
                <Button :loading="form.processing" class="p-button p-component p-button-primary" type="submit">Confirm
                    Password
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

const form = useForm({password: ''});

function submit() {
    form.post(route('password.confirm.post'), {preserveScroll: true});
}
</script>
