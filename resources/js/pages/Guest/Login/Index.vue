<script setup>
import GuestLayout from '@/layouts/GuestLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import { onMounted, ref } from 'vue';

onMounted(() => {
    setTimeout(() => {
        animated.value = true;
    }, 500);

    form.saga = props.sagas.find((item) => item.year === props.currentYear)?.slug || null;
});

const props = defineProps({
    currentYear: String,
    sagas: Array,
});

const form = useForm({
    ic: null,
    password: null,
    saga: null,
    remember: false,
});

const $q = useQuasar();
const animated = ref(false);
const isPwd = ref(true);

const login = () => {
    $q.loading.show();
    form.post('/login', {
        onError: (err) => {
            $q.notify({
                type: 'negative',
                message: 'Sila semak semula maklumat anda',
            });
        },
        onFinish: () => {
            $q.loading.hide();
        },
    });
};
</script>

<template>
    <GuestLayout>
        <div class="grid grid-cols-12">
            <div class="col-span-12 lg:col-span-8">
                <div class="flex h-screen w-full justify-center bg-gray-900">
                    <div class="w-full bg-cover opacity-70 lg:block lg:w-full"
                        style="background-image: url('images/sagav2_images/bg/yellow-orange-abstract-painting-black-orange-background.jpg')">
                        <div class="flex h-full w-full flex-col items-center justify-center gap-10 px-20">
                            <div>
                                <img src="images/sabah3.png" alt="" class="w-28 opacity-0" :class="{
                                    'animate__animated animate__lightSpeedInLeft opacity-100': animated,
                                }" />
                            </div>
                            <div class="flex w-full flex-col items-center justify-center gap-5 opacity-100">
                                <div class="mb-5 grid grid-cols-3 gap-10 text-center">
                                    <img src="images/state_logo_kbss.png" alt="" class="w-[110px] opacity-0" :class="{
                                        'animate__animated animate__backInLeft opacity-100': animated,
                                    }" />
                                    <img src="images/logo_msn.png" alt="" class="w-[108px] pt-[3px] opacity-0" :class="{
                                        'animate__animated animate__backInUp opacity-100': animated,
                                    }" />
                                    <img src="images/saga_logo.png" alt="" class="w-[100px] pt-[5px] opacity-0" :class="{
                                        'animate__animated animate__backInRight opacity-100': animated,
                                    }" />
                                </div>
                                <div>
                                    <h2 class="permanent-marker-regular text-4xl font-bold text-white opacity-0 sm:text-6xl"
                                        :class="{
                                            'animate__animated animate__zoomInLeft opacity-100': animated,
                                        }">
                                        I-SAGA
                                    </h2>
                                </div>
                                <div>
                                    <h4 class="pacifico-regular text-center text-lg font-bold text-white opacity-0 sm:text-xl"
                                        :class="{
                                            'animate__animated animate__flipInX opacity-100': animated,
                                        }">
                                        Sistem Elektronik Pengurusan Kontinjen Sabah Games (SAGA)
                                    </h4>
                                </div>
                                <div>
                                    <p class="text-md mt-3 max-w-xl text-center text-gray-100 opacity-0" :class="{
                                        'animate__animated animate__fadeInUp opacity-100': animated,
                                    }">
                                        &copy; 2025 Hak Cipta Terpelihara Majlis Sukan Negeri Sabah
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="particle-container absolute inset-0 z-0 opacity-20">
                        <span class="particle" v-for="ï in 30" :key="ï"></span>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <div class="relative flex h-screen w-full flex-col items-center justify-around border p-10 shadow-lg">
                    <div>
                        <div class="permanent-marker-regular text-5xl">I-SAGA (v2)</div>
                    </div>
                    <div class="w-full space-y-10">
                        <div class="text-center text-2xl">Sila Log Masuk</div>
                        <q-banner inline-actions class="bg-red text-white" v-cloak v-show="usePage().props.flash.fail">
                            {{ usePage().props.flash.fail }}
                            <template v-slot:action>
                                <q-btn flat color="white" icon="mdi-close" />
                            </template>
                        </q-banner>
                        <q-form @submit.prevent="login" class="space-y-5">
                            <q-input v-model="form.ic" :error="form.errors.ic ? true : false"
                                :error-message="form.errors.ic" label="No. Kad Pengenalan" mask="######-##-####"
                                name="ic" filled hide-bottom-space autofocus></q-input>
                            <q-input v-model="form.password" :error="form.errors.password ? true : false"
                                :error-message="form.errors.password" label="Kata Laluan" name="password" filled
                                :type="isPwd ? 'password' : 'text'" hide-bottom-space>
                                <template v-slot:append>
                                    <q-icon :name="isPwd ? 'mdi-eye-off' : 'mdi-eye'" class="cursor-pointer"
                                        @click="isPwd = !isPwd" />
                                </template>
                            </q-input>
                            <q-select filled v-model="form.saga" :error="form.errors.saga ? true : false"
                                :error-message="form.errors.saga" :options="sagas" option-label="name"
                                option-value="slug" emit-value map-options label="Pilih Program" />
                            <q-checkbox v-model="form.remember" label="Ingat Saya" />
                            <q-btn type="submit" label="Log Masuk" color="primary"
                                class="full-width text-black"></q-btn>
                        </q-form>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 italic">&copy; 2025 HakCipta Terpelihara, Majlis Sukan Negeri
                        </div>
                    </div>
                    <!-- <q-inner-loading :showing="form.processing"> -->
                    <!--     <q-img src="images/logo_msn.png" width="100px" class="animate-spin"></q-img> -->
                    <!-- </q-inner-loading> -->
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
