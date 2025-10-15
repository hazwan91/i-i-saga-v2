<script setup>
import AuthLayout from '@/layouts/AuthLayout.vue';
import { routeHelper as route } from '@/utils/route';
import { router } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import { ref } from 'vue';
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
    zones: {
        type: Array,
        default: () => [],
    },
});

const listZones = props.zones.map((zone) => {
    return {
        label: zone.name,
        value: zone.id,
    };
});

const search = ref(route.query().carian || '');
const perPage = ref(route.query().per_page || 10);
const currentPage = ref(props.districts.current_page);
const filters = ref({
    zone_id: props.zones.find((zone) => {
        return zone.id === route.query().zon;
    })?.id,
});

const create = () => {
    $q.dialog({
        component: _Form,
        componentProps: {
            operation: 'create',
        },
    });
};

const edit = (row) => {
    console.log(row);
    $q.dialog({
        component: _Form,
        componentProps: {
            operation: 'edit',
            row: row,
        },
    });
};

const destroy = (row) => {
    $q.dialog({
        title: 'Peringatan',
        message: 'Adakah anda pasti untuk memadam data ini?',
        cancel: true,
    }).onOk(() => {
        router.delete(`/admin/daerah/${row.id}`, {
            preserveState: true,
            preserveScroll: true,
        });
    });
};
</script>

<template>
    <AuthLayout>
        <template #title> Daerah </template>

        <template #headerActions>
            <q-btn label="Tambah" color="primary" @click="create" />
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

            <q-card-section>
                <q-card flat bordered>
                    <q-card-section>
                        <div>Tapisan</div>
                    </q-card-section>
                    <q-card-section>
                        <q-select
                            v-model="filters.zone_id"
                            outlined
                            label="Pilih Zon"
                            :options="listZones"
                            clearable
                            emit-value
                            map-options
                            hide-bottom-space
                            @update:model-value="
                                router.get(
                                    route.url(),
                                    { zon: filters.zone_id, laman: 1 },
                                    { preserveState: true, replace: true },
                                )
                            "
                        >
                        </q-select>
                    </q-card-section>
                </q-card>
            </q-card-section>

            <q-card-section>
                <div class="flex items-center justify-between gap-4">
                    <div class="text-sm">
                        <div>
                            Jumlah Rekod: <strong>{{ districts.total }}</strong>
                        </div>
                        <div>
                            Dipaparkan {{ districts.from }} -
                            {{ districts.to }} /
                            {{ districts.total }}
                        </div>
                    </div>
                    <div>
                        <q-select
                            v-model="perPage"
                            debounce="500"
                            hide-bottom-space
                            dense
                            :options="[10, 25, 50, 100]"
                            @update:model-value="
                                router.get(
                                    route.url(),
                                    { per_page: perPage },
                                    { preserveState: true, replace: true },
                                )
                            "
                        ></q-select>
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
                        size="md"
                        @update:model-value="
                            router.get(
                                route.url(),
                                { laman: currentPage },
                                { preserveState: true, replace: true },
                            )
                        "
                    />
                </div>
            </q-card-section>
            <q-markup-table separator="cell" flat bordered>
                <thead
                    :class="`h-12 uppercase ${$q.dark.isActive ? 'bg-grey-8' : 'bg-grey-4'}`"
                >
                    <tr>
                        <th class="w-20 text-center">No.</th>
                        <th class="text-left">Nama Daerah</th>
                        <th class="w-36 text-end"></th>
                    </tr>
                </thead>
                <tbody>
                    <template
                        v-for="(
                            [zone, listOfDistricts], indexLoop
                        ) in Object.entries(groupDistricts)"
                        :key="`groupDistrict_${indexLoop}`"
                    >
                        <tr>
                            <td
                                colspan="3"
                                :class="`${$q.dark.isActive ? 'bg-grey-8' : 'bg-grey-4'} font-semibold`"
                            >
                                <div v-if="zone === ''">
                                    Tiada Zon ({{
                                        zones.find(
                                            (item) => item.id === 'tiada',
                                        ).districts_count || 0
                                    }})
                                </div>
                                <div v-else>
                                    {{ zone }} ({{
                                        zones.find(
                                            (item) =>
                                                item.id ===
                                                listOfDistricts[0].zone_id,
                                        )?.districts_count || 0
                                    }})
                                </div>
                            </td>
                        </tr>
                        <template
                            v-for="(district, indexLoop2) in listOfDistricts"
                            :key="`district_${indexLoop2}`"
                        >
                            <tr>
                                <td class="text-center">
                                    {{
                                        (districts.current_page - 1) *
                                            districts.per_page +
                                        Object.entries(groupDistricts)
                                            .slice(0, indexLoop)
                                            .reduce(
                                                (sum, [, districts]) =>
                                                    sum + districts.length,
                                                0,
                                            ) +
                                        indexLoop2 +
                                        1
                                    }}
                                </td>
                                <td>{{ district.name }}</td>
                                <td>
                                    <q-btn
                                        flat
                                        color="primary"
                                        icon="mdi-pencil"
                                        @click="edit(district)"
                                    />
                                    <q-btn
                                        flat
                                        color="negative"
                                        icon="mdi-delete"
                                        @click="destroy(district)"
                                    />
                                </td>
                            </tr>
                        </template>
                    </template>
                </tbody>
            </q-markup-table>
            <q-card-section>
                <div class="flex items-center justify-between gap-4">
                    <div class="text-sm">
                        <div>
                            Jumlah Rekod: <strong>{{ districts.total }}</strong>
                        </div>
                        <div>
                            Dipaparkan {{ districts.from }} -
                            {{ districts.to }} /
                            {{ districts.total }}
                        </div>
                    </div>
                    <div>
                        <q-select
                            v-model="perPage"
                            debounce="500"
                            hide-bottom-space
                            dense
                            :options="[10, 25, 50, 100]"
                            @update:model-value="
                                router.get(
                                    route.url(),
                                    { per_page: perPage },
                                    { preserveState: true, replace: true },
                                )
                            "
                        ></q-select>
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
                        size="md"
                        @update:model-value="
                            router.get(
                                route.url(),
                                { laman: currentPage },
                                { preserveState: true, replace: true },
                            )
                        "
                    />
                </div>
            </q-card-section>
        </q-card>
    </AuthLayout>
</template>
