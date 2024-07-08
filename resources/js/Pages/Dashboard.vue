<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Table from '@/Components/Table.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const fields = [
    { "key": "id", "label": "ID" },
    { "key": "task", "label": "Task" },
    { "key": "status", "label": "Status" },
    { "key": "created_at", "label": "Date Created" },
    { "key": "updated_at", "label": "Date Updated" }
];

const data = ref([]);

onMounted(() => {
  console.log(data);
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

                    <Table
                        :fields="fields"
                        :data="data"
                        >
                    </Table>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
