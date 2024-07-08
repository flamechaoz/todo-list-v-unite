<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import { onMounted, ref } from 'vue';

const fields = [
    { "key": "id", "label": "ID" },
    { "key": "task", "label": "Task" },
    { "key": "status", "label": "Status" },
    { "key": "created_at", "label": "Date Created" },
    { "key": "updated_at", "label": "Date Updated" }
];

const props = defineProps({
    data: {
        type: Array,
        required: true,
        default: () => []
    },
});

onMounted(() => {
  console.log(props.data);
});

</script>

<template>
    <Head title="Todos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">TODO's</h2>
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
    </AuthenticatedLayout>
</template>
