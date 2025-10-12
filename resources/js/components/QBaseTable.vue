<template>
    <div>
        <!-- Main table -->
        <q-table
            :title="title"
            :rows="rows"
            :columns="columns"
            row-key="id"
            :loading="loading"
            v-model:pagination="pagination"
            :rows-per-page-options="rowsPerPageOptions"
            :no-data-label="noDataLabel"
            :no-results-label="noResultsLabel"
            :bordered="bordered"
            :class="tableClass"
            :separator="separator"
            @request="onRequest"
        >
            <template #top>
                <q-input
                    v-model="filter"
                    dense
                    outlined
                    debounce="500"
                    placeholder="Cari..."
                    clearable
                    class="q-mr-md"
                    style="max-width: 250px"
                    @update:model-value="onSearch"
                >
                    <template #append>
                        <q-icon name="mdi-magnify" />
                    </template>
                </q-input>
            </template>

            <template v-if="$slots.body" #body="props">
                <slot name="body" v-bind="props" />
            </template>

            <template #no-data>
                <div class="full-width row flex-center q-gutter-sm q-pa-md">
                    <q-icon size="2em" name="mdi-sentiment_dissatisfied" />
                    <span>Tiada data ditemui</span>
                </div>
            </template>
        </q-table>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    title: { type: String, default: 'Senarai' },
    columns: { type: Array, required: true },
    rows: { type: [Array, Object], default: null },
    rowsPerPageOptions: { type: Array, default: () => [5, 10, 25, 50] },
    initialPagination: {
        type: Object,
        default: () => ({ page: 1, rowsPerPage: 10 }),
    },
    noDataLabel: { type: String, default: 'Tiada maklumat' },
    noResultsLabel: { type: String, default: 'Tiada padanan ditemui' },
    bordered: { type: Boolean, default: false },
    tableClass: {
        type: [String, Array, Object],
        default: 'rounded-xl shadow-md',
    },
    separator: { type: String, default: 'horizontal' },
});

const rows = ref([]);
const loading = ref(false);
const filter = ref('');
const pagination = ref({ ...props.initialPagination, rowsNumber: 0 });

watch(
    () => props.rows,
    (data) => {
        if (data?.data) {
            rows.value = data.data;
            pagination.value.page = data.current_page || 1;
            pagination.value.rowsPerPage = data.per_page || 10;
            pagination.value.rowsNumber = data.total || 0;
        } else if (Array.isArray(data)) {
            rows.value = data;
            pagination.value.rowsNumber = data.length;
        } else {
            rows.value = [];
            pagination.value.rowsNumber = 0;
        }
    },
    { immediate: true },
);

function onSearch() {
    pagination.value.page = 1;
    fetchData();
}

function onRequest({ pagination: newPagination }) {
    pagination.value = newPagination;
    fetchData();
}

function fetchData() {
    loading.value = true;
    router.visit(window.location.pathname, {
        method: 'get',
        preserveState: true,
        replace: true,
        data: {
            page: pagination.value.page,
            per_page: pagination.value.rowsPerPage,
            carian: filter.value,
        },
        onFinish: () => (loading.value = false),
    });
}
</script>
