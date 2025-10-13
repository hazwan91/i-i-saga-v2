<template>
    <q-dialog ref="dialogRef" @hide="onDialogHide" @before-show="onDialogShow">
        <q-card
            class="q-dialog-plugin q-pa-md"
            style="width: 700px; max-width: 80vw"
        >
            <div class="text-h6 q-mb-md">
                {{
                    operation === 'create'
                        ? 'Tambah Jenis Agensi'
                        : 'Kemaskini Jenis Agensi'
                }}
            </div>

            <q-form
                @submit.prevent="operation === 'create' ? store() : update()"
                class="q-gutter-md q-mt-md q-mb-md"
            >
                <q-input
                    v-model="form.code"
                    filled
                    label="Kod Jenis Agensi"
                    placeholder="Masukkan kod Jenis Agensi"
                    :error="form.errors.code ? true : false"
                    :error-message="form.errors.code"
                    hide-bottom-space
                    autofocus
                />
                <q-input
                    v-model="form.name"
                    filled
                    label="Nama Jenis Agensi"
                    placeholder="Masukkan nama Jenis Agensi"
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
import { useForm } from '@inertiajs/vue3';
import { useDialogPluginComponent } from 'quasar';

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

const form = useForm({
    code: '',
    name: '',
});

const { dialogRef, onDialogHide, onDialogOK, onDialogCancel } =
    useDialogPluginComponent();

const onDialogShow = () => {
    if (props.operation === 'edit' && props.row) {
        form.code = props.row.code;
        form.name = props.row.name;
    } else {
        form.reset();
    }
};

// this is part of our example (so not required)
const store = () => {
    form.post('/admin/jenis-agensi', {
        onSuccess: (res) => {
            onDialogOK();
        },
    });
};

const update = () => {
    form.put(`/admin/jenis-agensi/${props.row.id}`, {
        onSuccess: (res) => {
            onDialogOK();
        },
    });
};
</script>
