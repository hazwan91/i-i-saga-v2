<script setup>
import QBaseTable from '@/components/QBaseTable.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';

const props = defineProps({
    races: {
        type: Object,
        default: () => [],
    },
});

const columns = [
    { name: 'name', label: 'Nama Bangsa', field: 'name', align: 'left' },
];
</script>

<template>
    <AuthLayout>
        <template #title>Pengguna</template>

        <template #breadcrumbs>
            <q-breadcrumbs-el label="Bangsa"></q-breadcrumbs-el>
        </template>

        <QBaseTable :rows="races" :columns="columns"></QBaseTable>
    </AuthLayout>
</template>
