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
                <q-input
                    v-model="form.color"
                    filled
                    label="Warna Zon"
                    placeholder="Masukkan warna Zon"
                    :error="form.errors.color ? true : false"
                    :error-message="form.errors.color"
                    hide-bottom-space
                    autofocus
                >
                    <template v-slot:append>
                        <q-icon name="mdi-palette" class="cursor-pointer">
                            <q-popup-proxy
                                cover
                                transition-show="scale"
                                transition-hide="scale"
                            >
                                <q-color v-model="form.color" />
                            </q-popup-proxy>
                        </q-icon>
                    </template>
                </q-input>
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
    color: '',
    name: '',
});

const { dialogRef, onDialogHide, onDialogOK, onDialogCancel } =
    useDialogPluginComponent();

const onDialogShow = () => {
    if (props.operation === 'edit' && props.row) {
        form.color = props.row.color;
        form.name = props.row.name;
    } else {
        form.reset();
    }
};

// this is part of our example (so not required)
const store = () => {
    form.post('/admin/zon', {
        onSuccess: (res) => {
            onDialogOK();
        },
    });
};

const update = () => {
    form.put(`/admin/zon/${props.row.id}`, {
        onSuccess: (res) => {
            onDialogOK();
        },
    });
};
</script>
