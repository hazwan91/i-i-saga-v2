<script setup>
import AuthLayout from '@/layouts/AuthLayout.vue';
import { router } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import _Form from './_Form.vue';

const $q = useQuasar();

const props = defineProps({
    districts: {
        type: Object,
        default: () => [],
    },
});

const columns = [
    {
        name: 'zone',
        label: 'Zon',
        field: (row) => row.zone?.name ?? 'Tiada Zon',
        align: 'center',
        style: 'width: 150px',
    },
    {
        name: 'name',
        label: 'Nama Daerah',
        field: 'name',
        align: 'left',
    },
    { name: 'actions', label: '', align: 'right' },
];

const groupedRows = (rows = []) => {
    console.log(rows);
    const groups = {};
    for (const row of rows.data) {
        const key = row.zone_id ?? 'No Zone';
        if (!groups[key]) groups[key] = [];
        groups[key].push(row);
    }
    return groups;
};

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
        <template #title> Daerah </template>

        <template #headerActions>
            <q-btn label="Tambah" color="primary" @click="onCreate" />
        </template>

        <template #breadcrumbs>
            <q-breadcrumbs-el label="Daerah"></q-breadcrumbs-el>
        </template>

        <q-card class="rounded-xl shadow-md">
            <q-card-section class="row items-center justify-between">
                <div class="text-xl">Senarai</div>
                <div>
                    <q-input
                        v-model="search"
                        debounce="500"
                        outlined
                        hide-bottom-space
                        placeholder="Cari..."
                        dense
                    >
                        <template #append>
                            <q-icon name="mdi-magnify" />
                        </template>
                        <!-- <q-input
                            v-model="props.districts.query.carian"
                            debounce="300"
                            @keyup.enter="props.districts.refresh()"
                        /> -->
                    </q-input>
                </div>
            </q-card-section>
            <!-- <q-card-section> -->
            <q-markup-table separator="cell" flat bordered>
                <thead
                    :class="`h-12 uppercase ${$q.dark.isActive ? 'bg-grey-8' : 'bg-grey-4'}`"
                >
                    <th class="text-left">Nama Daerah</th>
                    <th class="text-left">Nama Daerah</th>
                </thead>
                <tbody>
                    <tr>
                        <td>das</td>
                        <td>das</td>
                    </tr>
                </tbody>
            </q-markup-table>
            <!-- </q-card-section> -->
        </q-card>

        <!-- <QBaseTable
            :rows="districts"
            :columns="columns"
            @edit="onEdit"
            @delete="onDelete"
        >
            <template #body="props">
                <template
                    v-for="(group, zoneId) in groupedRows(props.rows)"
                    :key="zoneId"
                >
                    <q-tr class="bg-slate-500 font-bold">
                        <q-td :colspan="columns.length">
                            Zon: {{ group[0].zone?.name ?? 'Tiada Zon' }}
                        </q-td>
                    </q-tr>

                    
                    <q-tr v-for="row in group" :key="row.id">
                        <q-td
                            v-for="col in columns"
                            :key="col.name"
                            :props="{ row, col }"
                        >
                        
                            <slot
                                :name="`body-cell-${col.name}`"
                                :row="row"
                                :col="col"
                                :value="row[col.field]"
                            >
                                {{ row[col.field] }}
                            </slot>
                        </q-td>
                    </q-tr>
                </template>
            </template>
        </QBaseTable> -->
    </AuthLayout>
</template>
