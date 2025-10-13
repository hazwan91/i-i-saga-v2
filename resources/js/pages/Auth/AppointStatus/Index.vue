<script setup>
import QBaseTable from '@/components/QBaseTable.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { router } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import _Form from './_Form.vue';

const $q = useQuasar();

const props = defineProps({
    appointStatuses: {
        type: Object,
        default: () => [],
    },
});

const columns = [
    {
        name: 'code',
        label: 'Kod Taraf Lantikan',
        field: 'code',
        align: 'center',
        style: 'width: 150px',
    },
    {
        name: 'name',
        label: 'Nama Taraf Lantikan',
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
        router.delete(`/admin/taraf-lantikan/${row.id}`);
    });
};
</script>

<template>
    <AuthLayout>
        <template #title> Taraf Lantikan </template>

        <template #headerActions>
            <q-btn label="Tambah" color="primary" @click="onCreate" />
        </template>

        <template #breadcrumbs>
            <q-breadcrumbs-el label="Taraf Lantikan"></q-breadcrumbs-el>
        </template>

        <QBaseTable
            :rows="appointStatuses"
            :columns="columns"
            @edit="onEdit"
            @delete="onDelete"
        ></QBaseTable>
    </AuthLayout>
</template>
