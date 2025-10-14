<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import { ref, watch } from 'vue';

const $q = useQuasar();
let lastFlashKey = null;

watch(
    () => usePage().props.flash,
    (flash) => {
        // Serialize flash object to compare
        const currentFlashKey = JSON.stringify(flash);

        if (currentFlashKey !== lastFlashKey) {
            lastFlashKey = currentFlashKey;
            if (flash.fail) {
                $q.notify({
                    type: 'negative',
                    message: flash.fail,
                });
            }

            if (flash.pass) {
                $q.notify({
                    type: 'positive',
                    message: flash.pass,
                });
            }

            if (flash.info) {
                $q.notify({
                    type: 'info',
                    message: flash.info,
                });
            }
        }
    },
    { immediate: true, deep: true }, // `immediate` is optional, but helpful if there's already flash data
);

const leftDrawerOpen = ref(false);
// const search = ref('');

const toggleLeftDrawer = () => {
    leftDrawerOpen.value = !leftDrawerOpen.value;
};
</script>

<style lang="sass">
.YL

  &__toolbar-input-container
    min-width: 100px
    width: 55%

  &__toolbar-input-btn
    border-radius: 0
    border-style: solid
    border-width: 1px 1px 1px 0
    border-color: rgba(0,0,0,.24)
    max-width: 60px
    width: 100%

  &__drawer-footer-link
    color: inherit
    text-decoration: none
    font-weight: 500
    font-size: .75rem

    &:hover
      color: #000
</style>

<template>
    <!-- <q-layout view="hHh lpR fFf" class="bg-grey-1"> -->
    <q-layout view="hHh Lpr fFf" class="">
        <q-header
            :class="`text-grey-8 q-py-xs ${$q.dark.isActive ? 'bg-amber-500' : 'bg-white'} h-[73px] pt-3 shadow-md`"
            height-hint="73">
            <q-toolbar>
                <q-btn flat dense round @click="toggleLeftDrawer" aria-label="Menu" icon="mdi-menu" />

                <q-btn flat no-caps no-wrap class="q-ml-xs" v-if="$q.screen.gt.xs" :href="''"
                    @click.prevent="router.get('')">
                    <q-img src="/images/logo_msn.png" width="28px"></q-img>
                    <q-toolbar-title shrink class="text-weight-bold text-xl">
                        I-SAGA
                        <span :class="`text-[14px] ${$q.dark.isActive ? '' : 'text-amber-500'}`">v2</span>
                    </q-toolbar-title>
                    <q-img src="/images/saga_logo.png" width="28px"></q-img>
                </q-btn>

                <q-space />

                <!-- <div class="YL__toolbar-input-container row no-wrap">
                    <q-input dense outlined square v-model="search" placeholder="Search" class="col bg-white" />
                    <q-btn class="YL__toolbar-input-btn" color="grey-3" text-color="grey-8" icon="mdi-magnify" unelevated />
                </div> -->

                <div class="q-gutter-sm row no-wrap items-center">
                    <q-btn round dense flat color="grey-8" icon="mdi-message-bulleted" v-if="$q.screen.gt.sm">
                        <q-tooltip>Messages</q-tooltip>
                    </q-btn>
                    <q-btn round dense flat color="grey-8" icon="mdi-bell">
                        <q-badge color="red" text-color="white" floating>
                            2
                        </q-badge>
                        <q-tooltip>Notifications</q-tooltip>
                    </q-btn>
                    <q-btn round dense flat color="grey-8" icon="mdi-theme-light-dark"
                        @click.prevent="$q.dark.toggle()">
                        <q-tooltip>Mod Gelap</q-tooltip>
                    </q-btn>
                    <q-btn-dropdown flat icon="mdi-account">
                        <q-list>
                            <q-item clickable v-close-popup @click.prevent="router.post('/auth/logout')">
                                <q-item-section avatar>
                                    <q-avatar icon="mdi-logout" color="primary" text-color="white" size="md" />
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>Log Keluar</q-item-label>
                                </q-item-section>
                            </q-item>
                        </q-list>
                        <!-- <q-avatar size="26px">
                            <img src="https://cdn.quasar.dev/img/boy-avatar.png" />
                        </q-avatar> -->
                        <!-- <q-tooltip>Account</q-tooltip> -->
                    </q-btn-dropdown>
                </div>
            </q-toolbar>
            <!-- <q-toolbar inset>
                <q-breadcrumbs class="text-grey" active-color="primary" v-if="$slots.breadcrumbs">
                    <template v-slot:separator>
                        <q-icon size="1.2em" name="mdi-arrow-right" color="primary" />
                    </template>

<slot name="breadcrumbs" />
</q-breadcrumbs>
</q-toolbar> -->
        </q-header>

        <q-drawer v-model="leftDrawerOpen" show-if-above class="shadow-md" :width="320">
            <q-scroll-area class="fit">
                <q-list padding>
                    <q-item v-ripple clickable :active="route.is('/')" href="/"
                        @click.prevent="route.visit({ path: '/' })">
                        <q-item-section avatar>
                            <q-icon color="grey" name="mdi-home" />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>Laman Utama</q-item-label>
                        </q-item-section>
                    </q-item>

                    <!-- <q-separator class="q-mt-md q-mb-xs" /> -->
                    <!--
                    <q-item-label
                        header
                        class="text-weight-bold text-uppercase"
                    >
                        Dashboard
                    </q-item-label> -->

                    <!-- <q-separator class="q-mt-md q-mb-xs" /> -->

                    <q-expansion-item icon="mdi-text-box-edit" label="Admin" :default-opened="route.is('/admin/*')">
                        <q-item :inset-level="1" v-ripple clickable :active="route.is('/admin/pengguna*')"
                            href="/admin/pengguna" @click.prevent="
                                route.visit({ path: '/admin/pengguna' })
                                ">
                            <q-item-section avatar>
                                <q-icon color="grey" name="mdi-account-group" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>Pengguna</q-item-label>
                            </q-item-section>
                        </q-item>

                        <q-item :inset-level="1" v-ripple clickable :active="route.is('/admin/taraf-lantikan*')"
                            href="/admin/taraf-lantikan" @click.prevent="
                                route.visit({ path: '/admin/taraf-lantikan' })
                                ">
                            <q-item-section avatar>
                                <q-icon color="grey" name="mdi-account-group" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>Taraf Lantikan</q-item-label>
                            </q-item-section>
                        </q-item>

                        <q-item :inset-level="1" v-ripple clickable :active="route.is('/admin/bangsa*')"
                            href="/admin/bangsa" @click.prevent="
                                route.visit({ path: '/admin/bangsa' })
                                ">
                            <q-item-section avatar>
                                <q-icon color="grey" name="mdi-account-group" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>Bangsa</q-item-label>
                            </q-item-section>
                        </q-item>

                        <q-item :inset-level="1" v-ripple clickable :active="route.is('/admin/jenis-agensi*')"
                            href="/admin/jenis-agensi" @click.prevent="
                                route.visit({ path: '/admin/jenis-agensi' })
                                ">
                            <q-item-section avatar>
                                <q-icon color="grey" name="mdi-account-group" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>Jenis Agensi</q-item-label>
                            </q-item-section>
                        </q-item>

                        <q-item :inset-level="1" v-ripple clickable :active="route.is('/admin/agensi*')"
                            href="/admin/agensi" @click.prevent="
                                route.visit({ path: '/admin/agensi' })
                                ">
                            <q-item-section avatar>
                                <q-icon color="grey" name="mdi-account-group" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>Agensi</q-item-label>
                            </q-item-section>
                        </q-item>

                        <q-item :inset-level="1" v-ripple clickable :active="route.is('/admin/stesen*')"
                            href="/admin/stesen" @click.prevent="
                                route.visit({ path: '/admin/stesen' })
                                ">
                            <q-item-section avatar>
                                <q-icon color="grey" name="mdi-account-group" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>Stesen</q-item-label>
                            </q-item-section>
                        </q-item>

                        <q-item :inset-level="1" v-ripple clickable :active="route.is('/admin/zon*')" href="/admin/zon"
                            @click.prevent="route.visit({ path: '/admin/zon' })">
                            <q-item-section avatar>
                                <q-icon color="grey" name="mdi-account-group" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>Zon</q-item-label>
                            </q-item-section>
                        </q-item>

                        <q-item :inset-level="1" v-ripple clickable :active="route.is('/admin/daerah*')"
                            href="/admin/daerah" @click.prevent="
                                route.visit({ path: '/admin/daerah' })
                                ">
                            <q-item-section avatar>
                                <q-icon color="grey" name="mdi-account-group" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>Daerah</q-item-label>
                            </q-item-section>
                        </q-item>
                    </q-expansion-item>

                    <q-separator class="q-mt-md q-mb-lg" />

                    <div class="q-px-md text-grey-6">
                        <div class="row q-gutter-x-sm q-gutter-y-xs items-center">
                            <a class="YL__drawer-footer-link" href="">Kredits</a>
                            <a class="YL__drawer-footer-link" href="">Versi</a>
                            <!-- <a class="YL__drawer-footer-link" href=""></a> -->
                        </div>
                    </div>
                </q-list>
            </q-scroll-area>
        </q-drawer>

        <q-page-container>
            <div class="scrollable-container space-y-10 px-3 pt-6 pb-20 sm:px-10">
                <div class="space-y-4">
                    <q-breadcrumbs class="text-grey" active-color="primary" v-if="$slots.breadcrumbs">
                        <template v-slot:separator>
                            <q-icon size="1.2em" name="mdi-arrow-right" color="primary" />
                        </template>

                        <slot name="breadcrumbs" />
                    </q-breadcrumbs>

                    <div class="row items-center justify-between" v-if="$slots.title || $slots.headerActions">
                        <div>
                            <h5 class="font-semibold uppercase">
                                <slot name="title" />
                            </h5>
                            <h6 class="text-grey-7 font-semibold">
                                <slot name="subtitle" />
                            </h6>
                        </div>
                        <div>
                            <slot name="headerActions" />
                        </div>
                    </div>
                </div>

                <slot />

                <div class="flex justify-center">
                    <span class="text-sm text-gray-500 italic">&copy; 2025 HakCipta Terpelihara; Jabatan Perkhidmatan
                        Awam Negeri Sabah</span>
                </div>
            </div>
        </q-page-container>
    </q-layout>
</template>
