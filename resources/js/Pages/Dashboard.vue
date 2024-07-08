<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Table from '@/Components/Table.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { 
    FwbButton,
    FwbInput,
    FwbModal,
    FwbSelect
} from 'flowbite-vue';
import axios from 'axios';

const fields = [
    { "key": "id", "label": "ID" },
    { "key": "task", "label": "Task" },
    { "key": "status", "label": "Status" },
    { "key": "created_at", "label": "Date Created" },
    { "key": "updated_at", "label": "Date Updated" }
];

const statuses = [
    {value: 'pending', name: 'pending'},
    {value: 'ongoing', name: 'ongoing'},
    {value: 'done', name: 'done'},
];

const todos = ref([]);

const activeTodo = ref({task: '', status: 'pending'});
const editTodo = ref({task: '', status: 'pending'});

const modals = ref({
    add: false,
    edit: false,
    delete: false,
    addConfirm: false,
    editConfirm: false,
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

const openEditModal = (todo) => {
    activeTodo.value = todo;
    editTodo.value = { ...todo }
    openModal('edit');
};

const closeEditModal = () => {
    activeTodo.value = {task: '', status: 'pending'};
    closeModal('edit');
}

const openDeleteModal = (todo) => {
    activeTodo.value = todo;
    openModal('delete');
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
        const response = await axios.post('/api/todos', activeTodo.value);
        console.log('Todo saved:', response.data);
        // Reset the activeTodo object
        activeTodo.value = {task: '', status: 'pending'};
        fetchTodos();
    } catch (error) {
        console.error('Error saving todo:', error);
    }
}

const patchTodo = async () => {
    try {
        const response = await axios.put(`/api/todos/${editTodo.value.id}`, editTodo.value);
        console.log('Todo edited:', response.data);
        // Reset the activeTodo object
        activeTodo.value = {task: '', status: 'pending'};
        fetchTodos();
    } catch (error) {
        console.error('Error saving todo:', error);
    }
}

const deleteTodo = async () => {
    try {
        await axios.delete(`/api/todos/${activeTodo.value.id}`);
        console.log('Todo deleted.');
        // Reset the activeTodo object
        activeTodo.value = {task: '', status: 'pending'};
        fetchTodos();
    } catch (error) {
        console.error('Error saving todo:', error);
    }
}

const actions = [
    { label: 'Edit', action: openEditModal, color: 'alternative' },
    { label: 'Delete', action: openDeleteModal, color: 'red' }
];

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
                        <fwb-button class="ms-4" @click="openModal('add')" color="green">
                            Add
                        </fwb-button>
                    </div>
                    <Table
                        :fields="fields"
                        :data="todos"
                        :actions="actions"
                        >
                    </Table>
                </div>
            </div>
        </div>

        <fwb-modal size="md" v-if="isOpen('add')" @close="closeModal('add')">
            <template #header>
                <div class="flex items-center text-lg">
                    New Task
                </div>
            </template>
            <template #body>
                <fwb-input
                    v-model="activeTodo.task"
                    placeholder="enter new task"
                    label="Task"
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
                    Add the task <b>"{{ activeTodo.task }}"</b> ?
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

        <fwb-modal size="md" v-if="isOpen('edit')" @close="closeEditModal()">
            <template #body>
                <fwb-input
                    class="mb-4"
                    v-model="editTodo.task"
                    placeholder="task"
                    label="Task"
                />
                <fwb-select
                    v-model="editTodo.status"
                    :options="statuses"
                    label="Select a status"
                />
            </template>
            <template #footer>
                <div class="flex justify-between">
                    <fwb-button @click="closeEditModal()" color="alternative">
                        Close
                    </fwb-button>
                    <fwb-button @click="openModal('editConfirm'); closeModal('edit')" color="green">
                        Save
                    </fwb-button>
                </div>
            </template>
        </fwb-modal>

        <fwb-modal size="md" v-if="isOpen('editConfirm')" @close="closeModal('editConfirm')">
            <template #body>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    Save the following changes?
                </p>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    Task <b>{{ activeTodo.task }}</b> >> <b>{{ editTodo.task }}</b>
                </p>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    Status <b>{{ activeTodo.status }}</b> >> <b>{{ editTodo.status }}</b>
                </p>
            </template>
            <template #footer>
                <div class="flex justify-between">
                    <fwb-button @click="openModal('edit'); closeModal('editConfirm')" color="alternative">
                        Cancel
                    </fwb-button>
                    <fwb-button @click="patchTodo(); closeModal('editConfirm')" color="green">
                        Confirm
                    </fwb-button>
                </div>
            </template>
        </fwb-modal>

        <fwb-modal size="md" v-if="isOpen('delete')" @close="closeModal('delete')">
            <template #body>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    Delete the task?
                </p>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    ID: <b>{{ activeTodo.id }}</b>
                </p>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    Task: <b>{{ activeTodo.task }}</b>
                </p>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    Status: <b>{{ activeTodo.status }}</b>
                </p>
            </template>
            <template #footer>
                <div class="flex justify-between">
                    <fwb-button @click="closeModal('delete')" color="alternative">
                        Cancel
                    </fwb-button>
                    <fwb-button @click="deleteTodo(); closeModal('delete')" color="red">
                        Delete
                    </fwb-button>
                </div>
            </template>
        </fwb-modal>
    </GuestLayout>
</template>
