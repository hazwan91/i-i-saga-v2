<template>
    <q-table
        :title="title"
        :rows="rows"
        :columns="columns"
        :row-key="rowKey"
        :loading="loading"
        :pagination.sync="pagination"
        :filter="filter"
        :rows-per-page-options="rowsPerPageOptions"
        :no-data-label="noDataLabel"
        :no-results-label="noResultsLabel"
        :bordered="bordered"
        :class="tableClass"
        :separator="separator"
        @request="onRequest"
    >
        <!-- Top slot -->
        <template v-if="$slots.top" #top>
            <slot name="top" />
        </template>

        <!-- Optional body slot -->
        <template v-if="$slots.body" #body="props">
            <slot name="body" v-bind="props" />
        </template>

        <!-- Bottom slot -->
        <template v-if="$slots.bottom" #bottom>
            <slot name="bottom" />
        </template>

        <!-- No-data slot -->
        <template #no-data="{ icon, message, filter }">
            <slot
                name="no-data"
                :icon="icon"
                :message="message"
                :filter="filter"
            >
                <div class="full-width row flex-center q-gutter-sm">
                    <q-icon size="2em" name="mdi-sentiment_dissatisfied" />
                    <span> Maaf... {{ message }} </span>
                    <q-icon
                        size="2em"
                        :name="filter ? 'mdi-filter_b_and_w' : icon"
                    />
                </div>
            </slot>
        </template>
    </q-table>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const page = usePage();

const props = defineProps({
    title: { type: String, default: 'Senarai' },
    columns: { type: Array, required: true },
    // When true, force server-side pagination/filtering (always fetch on page/filter change)
    serverSide: { type: Boolean, default: true },
    debug: { type: Boolean, default: false },
    rows: { type: [Array, Object, null], default: null }, // array, paginator, or null
    rowKey: { type: String, default: 'id' },
    rowsPerPageOptions: { type: Array, default: () => [5, 10, 25, 50] },
    initialPagination: {
        type: Object,
        default: () => ({ page: 1, rowsPerPage: 10 }),
    },
    initialFilter: { type: String, default: '' },
    noDataLabel: { type: String, default: 'Tiada maklumat untuk dipaparkan' },
    noResultsLabel: {
        type: String,
        default: 'Carian/tapisan tidak padan dengan apa-apa rekod',
    },
    bordered: { type: Boolean, default: false },
    tableClass: {
        type: [String, Array, Object],
        default: 'rounded-xl shadow-md',
    },
    separator: { type: String, default: 'horizontal' },
});

const rows = ref([]);
const loading = ref(false);
const pagination = ref({ ...props.initialPagination });
const filter = ref(props.initialFilter);
const sortBy = ref(null);
const descending = ref(false);
const syncingPagination = ref(false);

// Determine if using client-side or server-side. Only plain arrays are client-side,
// unless `props.serverSide` is true which forces server-side mode.
const isClientSide = ref(!props.serverSide && Array.isArray(props.rows));

function updateRows(newRows) {
    if (!newRows) {
        rows.value = [];
        pagination.value.rowsNumber = 0;
        return;
    }

    const isPaginated = newRows.data && Array.isArray(newRows.data);

    rows.value = isPaginated
        ? newRows.data
        : Array.isArray(newRows)
          ? newRows
          : [];

    pagination.value.rowsNumber = isPaginated
        ? newRows.total
        : rows.value.length;

    if (isPaginated) {
        pagination.value.page = newRows.current_page || 1;
        pagination.value.rowsPerPage =
            newRows.per_page || pagination.value.rowsPerPage;
    }
}

// Watch rows prop for client-side
watch(
    () => props.rows,
    (newRows) => {
        // If `serverSide` is true, always operate in server-side mode. Use provided
        // paginated data to initialize the first page if available; otherwise start
        // empty and rely on fetchData to populate rows.
        if (props.serverSide) {
            isClientSide.value = false;
            if (newRows && newRows.data && Array.isArray(newRows.data)) {
                updateRows(newRows);
            } else {
                updateRows(null);
            }
            return;
        }

        // Non-server mode: accept plain arrays as client-side datasets, or paginated
        // objects as server-style datasets (but only when serverSide=false).
        if (!newRows) {
            isClientSide.value = false;
            updateRows(null);
            return;
        }

        if (Array.isArray(newRows)) {
            isClientSide.value = true;
            updateRows(newRows);
            return;
        }

        if (newRows && newRows.data && Array.isArray(newRows.data)) {
            isClientSide.value = false;
            updateRows(newRows);
            return;
        }
    },
    { immediate: true },
);

// Fetch data for server-side (only if rows prop is null)
function fetchData() {
    if (isClientSide.value) return;

    loading.value = true;
    // prevent watcher-triggered fetch loops while we apply server-returned pagination
    syncingPagination.value = true;

    // Build visit options and only include `only` when it's defined. Passing an
    // explicit `only: undefined` can cause Inertia internals to error when they
    // access `.length` on the value.
    const visitOptions = {
        method: 'get',
        preserveState: true,
        data: {
            page: pagination.value.page,
            per_page: pagination.value.rowsPerPage,
            filter: filter.value,
            sortBy: sortBy.value,
            descending: descending.value,
        },
        onSuccess: (response) => {
            const propsPayload = response.props || {};
            let data = propsPayload.rows ?? propsPayload.races ?? null;

            if (!data) {
                for (const key in propsPayload) {
                    const val = propsPayload[key];
                    if (
                        Array.isArray(val) ||
                        (val && val.data && Array.isArray(val.data))
                    ) {
                        data = val;
                        break;
                    }
                }
            }

            updateRows(data);
        },
        onFinish: () => {
            loading.value = false;
            // allow pagination watcher to trigger fetches again
            syncingPagination.value = false;
        },
    };

    const only = page?.props?.value?.$pageOnly;
    if (only !== undefined && only !== null) {
        visitOptions.only = only;
    }

    if (props.debug) console.debug('[QBaseTable] visitOptions', visitOptions);

    router.visit(window.location.pathname, visitOptions);
}

// Watch for server-side changes
// Watch for server-side changes. Skip triggering fetchData when we're syncing
// pagination state coming from a server response to avoid loops.
watch(
    [pagination, filter, sortBy, descending],
    () => {
        if (syncingPagination.value) return;
        fetchData();
    },
    { deep: true },
);

function onRequest({
    pagination: newPagination,
    filter: newFilter,
    sortBy: newSort,
    descending: newDesc,
}) {
    pagination.value = newPagination;
    filter.value = newFilter;
    sortBy.value = newSort;
    descending.value = newDesc;
}
</script>
