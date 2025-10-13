<script setup>
import AuthLayout from '@/layouts/AuthLayout.vue';
import { routeHelper as route } from '@/utils/route';
import { router } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import { ref, watch } from 'vue';
import _Form from './_Form.vue';

const $q = useQuasar();

const props = defineProps({
    districts: {
        type: Object,
        default: () => [],
    },
});

const search = ref(route.query().carian || '');
const currentPage = ref(props.districts.current_page);
console.log(route.url());

watch(currentPage, (page) => {
    router.get(
        route.url(),
        { ...route.query(), laman: page },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
});

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
                        placeholder="Cari Daerah..."
                        dense
                        @update:model-value="
                            router.get(
                                route.url(),
                                { carian: search },
                                { preserveState: true, replace: true },
                            )
                        "
                    >
                        <template #append>
                            <q-icon name="mdi-magnify" />
                        </template>
                    </q-input>
                </div>
            </q-card-section>
            <!-- <q-card-section> -->

            <q-card-section>
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div>
                            Jumlah Rekod: <strong>{{ districts.total }}</strong>
                        </div>
                        <div>
                            Dipaparkan {{ districts.from }} -
                            {{ districts.to }} /
                            {{ districts.total }}
                        </div>
                    </div>
                    <q-pagination
                        v-model="currentPage"
                        color="primary"
                        outline
                        active-design="unelevated"
                        active-color="brown"
                        active-text-color="orange"
                        :max="districts.last_page"
                        :max-pages="5"
                        boundary-links
                        direction-links
                    />
                </div>
            </q-card-section>
            <q-markup-table separator="cell" flat bordered>
                <thead
                    :class="`h-12 uppercase ${$q.dark.isActive ? 'bg-grey-8' : 'bg-grey-4'}`"
                >
                    <th class="w-20 text-center">No.</th>
                    <th class="text-left">Nama Daerah</th>
                </thead>
                <tbody>
                    <template
                        v-for="(district, index) in districts.data"
                        :key="`district_${index}`"
                    >
                        <tr>
                            <td class="text-center">
                                {{
                                    (districts.current_page - 1) *
                                        districts.per_page +
                                    index +
                                    1
                                }}
                            </td>
                            <td>{{ district.name }}</td>
                        </tr>
                    </template>
                </tbody>
            </q-markup-table>
            <q-card-section>
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div>
                            Jumlah Rekod: <strong>{{ districts.total }}</strong>
                        </div>
                        <div>
                            Dipaparkan {{ districts.from }} -
                            {{ districts.to }} /
                            {{ districts.total }}
                        </div>
                    </div>
                    <q-pagination
                        v-model="currentPage"
                        color="primary"
                        outline
                        active-design="unelevated"
                        active-color="brown"
                        active-text-color="orange"
                        :max="districts.last_page"
                        :max-pages="5"
                        boundary-links
                        direction-links
                    />
                </div>
            </q-card-section>
        </q-card>
    </AuthLayout>
</template>
