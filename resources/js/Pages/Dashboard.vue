<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Table from '@/Components/Table.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const fields = [
    { "key": "id", "label": "ID" },
    { "key": "task", "label": "Task" },
    { "key": "status", "label": "Status" },
    { "key": "created_at", "label": "Date Created" },
    { "key": "updated_at", "label": "Date Updated" }
];

const todos = ref([]);

const fetchTodos = async () => {
    try {
        const response = await fetch('/api/todos');
        if (!response.ok) {
            throw new Error('Network response error.');
        }
        const data = await response.json();
        todos.value = data;
    } catch (error) {
        console.error('Error fetching todos:', error);
    }
};

onMounted(() => {
    fetchTodos();
});
</script>

<template>
    <Head title="Dashboard" />

    <GuestLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="py-4">
                        <Link :href="route('new')">
                            <PrimaryButton class="ms-4">
                                Add
                            </PrimaryButton>
                        </Link>
                    </div>
                    <Table
                        :fields="fields"
                        :data="todos"
                        >
                    </Table>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
