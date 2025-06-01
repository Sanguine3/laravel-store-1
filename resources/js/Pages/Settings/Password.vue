<template>
    <div>
        <h1>Change Password</h1>
        <form @submit.prevent="submit">
            <InputText id="current_password" v-model="form.current_password" class="w-full"
                       placeholder="Current Password" type="password"/>
            <InputText id="password" v-model="form.password" class="w-full" placeholder="New Password" type="password"/>
            <InputText id="password_confirmation" v-model="form.password_confirmation" class="w-full"
                       placeholder="Confirm Password" type="password"/>
            <Button :loading="form.processing" class="p-button p-component p-button-primary" type="submit">Update
                Password
            </Button>
        </form>
    </div>
</template>

<script lang="ts" setup>
import {useForm} from '@inertiajs/inertia-vue3';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import {route} from "ziggy-js";

const form = useForm({current_password: '', password: '', password_confirmation: ''});

function submit() {
    form.put(route('settings.password.update'), {preserveScroll: true});
}
</script>
