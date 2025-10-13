<script setup>
import QBaseTable from '@/components/QBaseTable.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { router } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import _Form from './_Form.vue';

const $q = useQuasar();

const props = defineProps({
    departmentTypes: {
        type: Object,
        default: () => [],
    },
});

const columns = [
    {
        name: 'code',
        label: 'Kod Jenis Agensi',
        field: 'code',
        align: 'center',
        style: 'width: 150px',
    },
    {
        name: 'name',
        label: 'Nama Jenis Agensi',
        field: 'name',
        align: 'left',
    },
    { name: 'actions', label: '', align: 'right' },
];

const onCreate = () => {
    $q.dialog({
        component: _Form,
        componentProps: {
            operation: 'create',
        },
    });
};

const onEdit = (row) => {
    $q.dialog({
        component: _Form,
        componentProps: {
            operation: 'edit',
            row: row,
        },
    });
};

const onDelete = (row) => {
    $q.dialog({
        title: 'Peringatan',
        message: 'Adakah anda pasti untuk memadam data ini?',
        cancel: true,
    }).onOk(() => {
        router.delete(`/admin/jenis-agensi/${row.id}`);
    });
};
</script>

<template>
    <AuthLayout>
        <template #title> Jenis Agensi </template>

        <template #headerActions>
            <q-btn label="Tambah" color="primary" @click="onCreate" />
        </template>

        <template #breadcrumbs>
            <q-breadcrumbs-el label="Jenis Agensi"></q-breadcrumbs-el>
        </template>

        <QBaseTable
            :rows="departmentTypes"
            :columns="columns"
            @edit="onEdit"
            @delete="onDelete"
        ></QBaseTable>
    </AuthLayout>
</template>
