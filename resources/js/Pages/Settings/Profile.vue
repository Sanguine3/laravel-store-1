<template>
    <div>
        <h1>Profile</h1>
        <form @submit.prevent="submit">
            <InputText id="name" v-model="form.name" class="w-full" placeholder="Name"/>
            <InputText id="email" v-model="form.email" class="w-full" placeholder="Email"/>
            <Button :loading="form.processing" class="p-button p-component p-button-primary" type="submit">Save</Button>
        </form>
    </div>
</template>

<script lang="ts" setup>
import {useForm, usePage} from '@inertiajs/inertia-vue3';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import {route} from "ziggy-js";

interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
    role: 'admin' | 'customer';
}

interface PageProps {
    auth: {
        user: User;
    };
}

const { auth: { user } } = usePage<PageProps>().props.value;
const form = useForm<Pick<User, 'name' | 'email'>>({
    name: user.name,
    email: user.email
});

function submit() {
    form.patch(route('settings.profile.update'), {preserveScroll: true});
}
</script>
