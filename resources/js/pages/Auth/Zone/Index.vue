<script setup>
import QBaseTable from '@/components/QBaseTable.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { router } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import _Form from './_Form.vue';

const $q = useQuasar();

const props = defineProps({
    zones: {
        type: Object,
        default: () => [],
    },
});

const columns = [
    {
        name: 'color',
        label: 'Warna Zon',
        field: 'color',
        align: 'center',
        style: 'width: 150px',
    },
    {
        name: 'name',
        label: 'Nama Zon',
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
        router.delete(`/admin/zon/${row.id}`);
    });
};
</script>

<template>
    <AuthLayout>
        <template #title> Zon </template>

        <template #headerActions>
            <q-btn label="Tambah" color="primary" @click="onCreate" />
        </template>

        <template #breadcrumbs>
            <q-breadcrumbs-el label="Zon"></q-breadcrumbs-el>
        </template>

        <QBaseTable
            :rows="zones"
            :columns="columns"
            @edit="onEdit"
            @delete="onDelete"
        >
            <template #body-cell-color="props">
                <q-td :props="props">
                    <span
                        class="font-bold"
                        :style="{ color: props.row.color }"
                        >{{ props.row.color }}</span
                    >
                </q-td>
            </template>
        </QBaseTable>
    </AuthLayout>
</template>
