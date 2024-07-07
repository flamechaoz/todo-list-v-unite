<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import { ref } from 'vue';

const todos = ref([
    {
        "id": 1,
        "task": "John",
        "status": "john@example.com",
        "created_at": "john@example.com",
        "updated_at": "john@example.com"
    },
    {
        "id": 2,
        "task": "John",
        "status": "john@example.com",
        "created_at": "john@example.com",
        "updated_at": "john@example.com"
    }
]);

const fields = ref([
    { "key": "id", "label": "ID" },
    { "key": "task", "label": "Task" },
    { "key": "status", "label": "Status" },
    { "key": "created_at", "label": "Date Created" },
    { "key": "updated_at", "label": "Date Updated" }
]);

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">TODO's</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <Table
                        :fields="fields"
                        :data="todos"
                        >
                    </Table>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
