<template>
    <div>
        <!-- Trigger Slot -->
        <slot name="trigger" :open="handleTriggerOpen" />

        <!-- Modal -->
        <q-dialog v-model="show">
            <q-card class="q-pa-md" style="width: 700px; max-width: 80vw">
                <div class="text-h6 q-mb-md">{{ title }}</div>

                <!-- Default slot for form/content -->
                <slot :close="closeModal" />

                <q-card-actions align="right">
                    <q-btn
                        flat
                        label="Tutup"
                        color="grey"
                        @click="closeModal"
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    modelValue: { type: Boolean, default: false },
    title: { type: String, default: 'Modal' },
});

const emit = defineEmits(['update:modelValue', 'trigger-opened']);

const show = ref(props.modelValue);

watch(
    () => props.modelValue,
    (value) => (show.value = value),
);
watch(show, (value) => emit('update:modelValue', value));

const openModal = () => (show.value = true);
const closeModal = () => (show.value = false);

// This is only for trigger slot button
const handleTriggerOpen = () => {
    emit('trigger-opened');
    openModal();
};
</script>
