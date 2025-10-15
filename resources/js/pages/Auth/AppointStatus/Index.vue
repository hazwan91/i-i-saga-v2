<script setup>
import AuthLayout from '@/layouts/AuthLayout.vue';
import { routeHelper as route } from '@/utils/route';
import { router } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import { ref } from 'vue';
import _Form from './_Form.vue';

const $q = useQuasar();

const props = defineProps({
    appointStatuses: {
        type: Object,
        default: () => [],
    },
});

const search = ref(route.query().carian || '');
const perPage = ref(route.query().per_page || 10);
const currentPage = ref(props.appointStatuses.current_page);
const filters = ref({});

const create = () => {
    $q.dialog({
        component: _Form,
        componentProps: {
            operation: 'create',
        },
    });
};

const edit = (row) => {
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
        router.delete(`/admin/taraf-lantikan/${row.id}`, {
            preserveState: true,
            preserveScroll: true,
        });
    });
};
</script>

<template>
    <AuthLayout>
        <template #title> Taraf Lantikan </template>

        <template #headerActions>
            <q-btn label="Tambah" color="primary" @click="create" />
        </template>

        <template #breadcrumbs>
            <q-breadcrumbs-el label="Taraf Lantikan"></q-breadcrumbs-el>
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
                        placeholder="Cari Taraf Lantikan..."
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
                <div class="flex items-center justify-between gap-4">
                    <div class="text-sm">
                        <div>
                            Jumlah Rekod:
                            <strong>{{ appointStatuses.total }}</strong>
                        </div>
                        <div>
                            Dipaparkan {{ appointStatuses.from }} -
                            {{ appointStatuses.to }} /
                            {{ appointStatuses.total }}
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
                        :max="appointStatuses.last_page"
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
                        <th class="text-left">Nama Taraf Lantikan</th>
                        <th class="w-36 text-end">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <template
                        v-for="(
                            [key, appointStatus], indexLoop
                        ) in Object.entries(appointStatuses.data)"
                        :key="`appointStatus_${indexLoop}`"
                    >
                        <tr>
                            <td class="text-center">{{ indexLoop + 1 }}</td>
                            <td>{{ appointStatus.name }}</td>
                            <td>
                                <q-btn
                                    flat
                                    color="primary"
                                    icon="mdi-pencil"
                                    @click="edit(appointStatus)"
                                />
                                <q-btn
                                    flat
                                    color="negative"
                                    icon="mdi-delete"
                                    @click="destroy(appointStatus)"
                                />
                            </td>
                        </tr>
                    </template>
                </tbody>
            </q-markup-table>
            <q-card-section>
                <div class="flex items-center justify-between gap-4">
                    <div class="text-sm">
                        <div>
                            Jumlah Rekod:
                            <strong>{{ appointStatuses.total }}</strong>
                        </div>
                        <div>
                            Dipaparkan {{ appointStatuses.from }} -
                            {{ appointStatuses.to }} /
                            {{ appointStatuses.total }}
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
                        :max="appointStatuses.last_page"
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
