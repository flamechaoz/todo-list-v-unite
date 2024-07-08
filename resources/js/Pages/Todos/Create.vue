<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    task: '',
    email: '',
    password: '',
    password_confirmation: '',
});

</script>

<template>
    <Head title="Dashboard" />

    <GuestLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">New</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="py-4">
                        <Link :href="route('dashboard')">
                            <PrimaryButton class="ms-4">
                                Back
                            </PrimaryButton>
                        </Link>
                    </div>
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="task" value="task" />
                            <TextInput
                                id="task"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.task"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.task" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autocomplete="username"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Register
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>