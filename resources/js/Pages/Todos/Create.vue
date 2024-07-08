<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

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
                </div>
            </div>
        </div>
    </GuestLayout>
</template>