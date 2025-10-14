<template>
    <q-dialog ref="dialogRef" @hide="onDialogHide" @before-show="onDialogShow">
        <q-card
            class="q-dialog-plugin q-pa-md"
            style="width: 700px; max-width: 80vw"
        >
            <div class="text-h6 q-mb-md">
                {{ operation === 'create' ? 'Tambah Zon' : 'Kemaskini Zon' }}
            </div>

            <q-form
                @submit.prevent="operation === 'create' ? store() : update()"
                class="q-gutter-md q-mt-md q-mb-md"
            >
                <q-select
                    v-model="form.zone_id"
                    filled
                    label="Pilih Zon"
                    :options="listZones"
                    :error="form.errors.zone_id ? true : false"
                    :error-message="form.errors.zone_id"
                    clearable
                    emit-value
                    map-options
                    hide-bottom-space
                >
                </q-select>
                <q-input
                    v-model="form.name"
                    filled
                    label="Nama Zon"
                    placeholder="Masukkan nama Zon"
                    :error="form.errors.name ? true : false"
                    :error-message="form.errors.name"
                    hide-bottom-space
                />

                <q-card-actions align="right" class="space-x-5">
                    <q-btn label="Tutup" @click="onDialogCancel" />
                    <q-btn type="submit" color="primary" label="Simpan" />
                </q-card-actions>
            </q-form>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { router, useForm } from '@inertiajs/vue3';
import { useDialogPluginComponent } from 'quasar';
import { ref } from 'vue';

const props = defineProps({
    // ...your custom props
    operation: {
        type: String,
        required: true,
    },
    row: {
        type: Object,
        default: () => ({}),
    },
});

defineEmits([
    // REQUIRED; need to specify some events that your
    // component will emit through useDialogPluginComponent()
    ...useDialogPluginComponent.emits,
]);

const listZones = ref([]);

const form = useForm({
    zone_id: '',
    name: '',
});

const { dialogRef, onDialogHide, onDialogOK, onDialogCancel } =
    useDialogPluginComponent();

const onDialogShow = () => {
    router.get(
        '/admin/zon/senarai',
        {},
        {
            preserveState: true,
            preserveScroll: true,
            onSuccess: (res) => {
                listZones.value = res.props.data.zones.map((zone) => {
                    return {
                        label: zone.name,
                        value: zone.id,
                    };
                });
            },
        },
    );

    if (props.operation === 'edit' && props.row) {
        form.zone_id = props.row.zone_id;
        form.name = props.row.name;
    } else {
        form.reset();
    }
};

// this is part of our example (so not required)
const store = () => {
    form.post('/admin/daerah', {
        onSuccess: (res) => {
            onDialogOK();
        },
    });
};

const update = () => {
    form.put(`/admin/daerah/${props.row.id}`, {
        onSuccess: (res) => {
            onDialogOK();
        },
    });
};
</script>
