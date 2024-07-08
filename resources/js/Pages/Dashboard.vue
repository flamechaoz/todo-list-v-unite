<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Table from '@/Components/Table.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { FwbButton, FwbInput, FwbModal } from 'flowbite-vue';

const fields = [
    { "key": "id", "label": "ID" },
    { "key": "task", "label": "Task" },
    { "key": "status", "label": "Status" },
    { "key": "created_at", "label": "Date Created" },
    { "key": "updated_at", "label": "Date Updated" }
];

const todos = ref([]);

const task = ref('');

const isShowAddModal = ref(false)

function closeAddModal () {
    isShowAddModal.value = false
}
function showAddModal () {
    isShowAddModal.value = true
}

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
                        <fwb-button class="ms-4" @click="showAddModal" color="alternative">
                            Add
                        </fwb-button>
                    </div>
                    <Table
                        :fields="fields"
                        :data="todos"
                        >
                    </Table>
                </div>
            </div>
        </div>
        <fwb-modal v-if="isShowAddModal" @close="closeAddModal">
            <template #body>
                <fwb-input
                    v-model="task"
                    placeholder="enter new task"
                    label="New task"
                />
            </template>
            <template #footer>
                <div class="flex justify-end">
                    <fwb-button @click="closeAddModal" color="green">
                        Save
                    </fwb-button>
                </div>
            </template>
        </fwb-modal>
    </GuestLayout>
</template>
