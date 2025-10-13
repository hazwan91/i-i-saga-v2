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
    groupDistricts: {
        type: Object,
        default: () => [],
    },
    zoneOffsets: {
        type: Array,
        default: () => [],
    },
});

const cumulativeIndex = (groups, currentGroupIndex, districtIndex) => {
    let sum = 0;
    const groupKeys = Object.keys(groups);
    for (let i = 0; i < currentGroupIndex; i++) {
        sum += groups[groupKeys[i]].length;
    }
    return sum + districtIndex;
};

const search = ref(route.query().carian || '');
const currentPage = ref(props.districts.current_page);

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
                        v-for="(
                            [zone, listOfDistricts], index
                        ) in Object.entries(groupDistricts)"
                        :key="`groupDistrict_${index}`"
                    >
                        <tr>
                            <td colspan="2" class="bg-grey-6 font-semibold">
                                {{ zone === '' ? 'Tanpa Zon' : zone }} ({{
                                    districts.data.filter(
                                        (item) =>
                                            item.zone_id ===
                                            listOfDistricts[0].zone_id,
                                    ).length
                                }})
                            </td>
                        </tr>
                        <template
                            v-for="(district, index2) in listOfDistricts"
                            :key="`district_${index2}`"
                        >
                            <tr>
                                <td class="text-center">
                                    <!-- {{
                                        (districts.current_page - 1) *
                                            districts.per_page +
                                        cumulativeIndex(
                                            groupDistricts,
                                            index,
                                            index2,
                                        ) +
                                        1
                                    }} -->
                                    {{
                                        (districts.current_page - 1) *
                                            districts.per_page +
                                        Object.entries(groupDistricts)
                                            .slice(0, index)
                                            .reduce(
                                                (sum, [, districts]) =>
                                                    sum + districts.length,
                                                0,
                                            ) +
                                        index2 +
                                        1
                                    }}
                                </td>
                                <td>{{ district.name }}</td>
                            </tr>
                        </template>
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
