<script setup>
  import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
  } from 'flowbite-vue';

  const props = defineProps({
      data: {
        type: Array,
        required: true,
        default: () => []
      },
      fields: {
        type: Array,
        required: true,
        default: () => []
      },
  });
</script>

<template>
  <fwb-table>
    <fwb-table-head>
      <fwb-table-head-cell
        v-for="(item, idx) in fields"
        :key="idx">{{ item.label }}
      </fwb-table-head-cell>
      <fwb-table-head-cell>
        <span class="sr-only">Edit</span>
      </fwb-table-head-cell>
    </fwb-table-head>
    <fwb-table-body>
      <fwb-table-row v-for="(item, index) in data" :key="index">
        <fwb-table-cell v-for="(field, idx) in fields" :key="idx">{{ item[field.key] }}</fwb-table-cell>
        <fwb-table-cell>
          <fwb-a href="#">
            Edit
          </fwb-a>
        </fwb-table-cell>
      </fwb-table-row>
    </fwb-table-body>
  </fwb-table>
</template>