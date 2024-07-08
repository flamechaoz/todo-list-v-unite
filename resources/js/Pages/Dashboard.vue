<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Table from '@/Components/Table.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { FwbButton, FwbInput, FwbModal } from 'flowbite-vue';
import axios from 'axios';

const fields = [
    { "key": "id", "label": "ID" },
    { "key": "task", "label": "Task" },
    { "key": "status", "label": "Status" },
    { "key": "created_at", "label": "Date Created" },
    { "key": "updated_at", "label": "Date Updated" }
];

const todos = ref([]);

const task = ref('');

const modals = ref({
    add: false,
    edit: false,
    delete: false,
    addConfirm: false,
    editConfirm: false,
    deleteConfirm: false,
});

const openModal = (modal) => {
  modals.value[modal] = true;
}

const closeModal = (modal) => {
  modals.value[modal] = false;
}

const isOpen = (modal) => {
  return modals.value[modal];
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
}

const saveTodo = async () => {
  try {
    const response = await axios.post('/api/todos', {task: task.value, status: 'pending'});
    console.log('Todo saved:', response.data);
    // Reset the newTodo object
    task.value = '';
    fetchTodos();
  } catch (error) {
    console.error('Error saving todo:', error);
  }
}

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
                        <fwb-button class="ms-4" @click="openModal('add')" color="alternative">
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

        <fwb-modal size="md" v-if="isOpen('add')" @close="closeModal('add')">
            <template #body>
                <fwb-input
                    v-model="task"
                    placeholder="enter new task"
                    label="New task"
                />
            </template>
            <template #footer>
                <div class="flex justify-between">
                    <fwb-button @click="closeModal('add')" color="alternative">
                        Close
                    </fwb-button>
                    <fwb-button @click="openModal('addConfirm'); closeModal('add')" color="green">
                        Save
                    </fwb-button>
                </div>
            </template>
        </fwb-modal>

        <fwb-modal size="md" v-if="isOpen('addConfirm')" @close="closeModal('addConfirm')">
            <template #body>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    Add the task <b>"{{ task }}"</b> ?
                </p>
            </template>
            <template #footer>
                <div class="flex justify-between">
                    <fwb-button @click="openModal('add'); closeModal('addConfirm')" color="alternative">
                        Cancel
                    </fwb-button>
                    <fwb-button @click="saveTodo(); closeModal('addConfirm')" color="green">
                        Confirm
                    </fwb-button>
                </div>
            </template>
        </fwb-modal>

    </GuestLayout>
</template>
