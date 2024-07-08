<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Table from '@/Components/Table.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { FwbButton, FwbModal } from 'flowbite-vue';

const fields = [
    { "key": "id", "label": "ID" },
    { "key": "task", "label": "Task" },
    { "key": "status", "label": "Status" },
    { "key": "created_at", "label": "Date Created" },
    { "key": "updated_at", "label": "Date Updated" }
];

const todos = ref([]);

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
            <template #header>
                <div class="flex items-center text-lg">
                    Terms of Service
                </div>
            </template>
            <template #body>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
                </p>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is meant to ensure a common set of data rights in the European Union. It requires organizations to notify users as soon as possible of high-risk data breaches that could personally affect them.
                </p>
            </template>
            <template #footer>
                <div class="flex justify-between">
                    <fwb-button @click="closeAddModal" color="alternative">
                        Decline
                    </fwb-button>
                    <fwb-button @click="closeAddModal" color="green">
                        I accept
                    </fwb-button>
                </div>
            </template>
        </fwb-modal>
    </GuestLayout>
</template>
