<template>
    <GuestLayout>
        <div class="w-full max-w-md bg-white dark:bg-zinc-800 p-8 rounded-lg shadow text-center">
            <AuthHeader description="Please verify your email address by clicking the link we sent."
                        title="Verify Email"/>

            <div class="mt-6">
                <p class="text-sm text-gray-700 dark:text-gray-200">
                    If you did not receive the email,
                    <Button class="p-button-text text-blue-600 underline p-0" type="button" @click="resend">click here
                        to request another
                    </Button>
                    .
                </p>
                <div v-if="status === 'verification-link-sent'" class="mt-4 text-green-600 text-sm">
                    A new verification link has been sent to your email address.
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script lang="ts" setup>
import {ref} from 'vue';
import {useForm, usePage} from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AuthHeader from '@/Components/AuthHeader.vue';
import Button from 'primevue/button';
import {route} from "ziggy-js";

const props = usePage().props;
const status = ref(props.status || '');
const form = useForm();

function resend() {
    form.post(route('verification.send'), {
        preserveScroll: true,
        onSuccess: (page) => {
            status.value = page.props.status;
        },
    });
}
</script>
