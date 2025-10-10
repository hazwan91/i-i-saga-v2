<script setup>
import { logout } from '@/routes/auth';
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
    <q-layout view="hHh Lpr fFf" class="bg-slate-200">
        <q-header
            class="text-grey-8 q-py-xs bg-white shadow-md"
            height-hint="58"
        >
            <q-toolbar>
                <q-btn
                    flat
                    dense
                    round
                    @click="toggleLeftDrawer"
                    aria-label="Menu"
                    icon="mdi-menu"
                />

                <q-btn
                    flat
                    no-caps
                    no-wrap
                    class="q-ml-xs"
                    v-if="$q.screen.gt.xs"
                    :href="''"
                    @click.prevent="router.get('')"
                >
                    <q-img src="/images/logo_msn.png" width="28px"></q-img>
                    <q-img src="/images/saga_logo.png" width="28px"></q-img>
                    <q-toolbar-title shrink class="text-weight-bold text-xl">
                        I-SAGA
                        <span class="text-[14px] text-amber-500">v2</span>
                    </q-toolbar-title>
                </q-btn>

                <q-space />

                <!-- <div class="YL__toolbar-input-container row no-wrap">
                    <q-input dense outlined square v-model="search" placeholder="Search" class="col bg-white" />
                    <q-btn class="YL__toolbar-input-btn" color="grey-3" text-color="grey-8" icon="mdi-magnify" unelevated />
                </div> -->

                <q-space />

                <div class="q-gutter-sm row no-wrap items-center">
                    <q-badge outline color="primary" label="" />
                    <q-btn
                        round
                        dense
                        flat
                        color="grey-8"
                        icon="mdi-message-bulleted"
                        v-if="$q.screen.gt.sm"
                    >
                        <q-tooltip>Messages</q-tooltip>
                    </q-btn>
                    <q-btn round dense flat color="grey-8" icon="mdi-bell">
                        <q-badge color="red" text-color="white" floating>
                            2
                        </q-badge>
                        <q-tooltip>Notifications</q-tooltip>
                    </q-btn>
                    <q-btn-dropdown flat icon="mdi-account">
                        <q-list>
                            <q-item
                                clickable
                                v-close-popup
                                @click.prevent="router.post(logout())"
                            >
                                <q-item-section avatar>
                                    <q-avatar
                                        icon="mdi-logout"
                                        color="primary"
                                        text-color="white"
                                        size="md"
                                    />
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

        <q-drawer
            v-model="leftDrawerOpen"
            show-if-above
            bordered
            class="bg-white"
            :width="240"
        >
            <q-scroll-area class="fit">
                <q-list padding>
                    <q-item
                        v-ripple
                        clickable
                        :active="''"
                        :href="''"
                        @click.prevent="router.get('')"
                    >
                        <q-item-section avatar>
                            <q-icon color="grey" name="mdi-home" />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>Laman Utama</q-item-label>
                        </q-item-section>
                    </q-item>

                    <!-- <q-expansion-item icon="mdi-finance" label="Dashboard">
                        <q-item v-ripple clickable class="ml-8">
                            <q-item-section avatar>
                                <q-icon color="grey" name="mdi-home" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>Keseluruhan</q-item-label>
                            </q-item-section>
                        </q-item>
                    </q-expansion-item> -->

                    <q-separator class="q-mt-md q-mb-xs" />

                    <q-item-label
                        header
                        class="text-weight-bold text-uppercase"
                    >
                        Dashboard
                    </q-item-label>

                    <!-- <q-item v-ripple clickable :active="route().current('auth.saga.dashboard.overall.*')"
                        :href="route('auth.saga.dashboard.overall.index')"
                        @click.prevent="router.get(route('auth.saga.dashboard.overall.index'))">
                        <q-item-section avatar>
                            <q-icon color="grey" name="mdi-finance" />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>Keseluruhan</q-item-label>
                        </q-item-section>
                    </q-item> -->

                    <q-separator class="q-mt-md q-mb-xs" />

                    <q-item-label
                        header
                        class="text-weight-bold text-uppercase"
                    >
                        Pendaftaran
                    </q-item-label>

                    <!-- <q-expansion-item icon="mdi-text-box-edit" label="Jawatankuasa"
                        :default-opened="route().current('auth.saga.registration.commitee.*')">
                        <q-item :inset-level="1" v-ripple clickable
                            :active="route().current('auth.saga.registration.commitee.role.*')"
                            :href="route('auth.saga.registration.commitee.role.index')"
                            @click.prevent="router.get(route('auth.saga.registration.commitee.role.index'))">
                            <q-item-section>
                                <q-item-label>Jawatan</q-item-label>
                            </q-item-section>
                        </q-item>
                        <q-item :inset-level="1" v-ripple clickable
                            :active="route().current('auth.saga.registration.commitee.individual.*')"
                            :href="route('auth.saga.registration.commitee.individual.index')"
                            @click.prevent="router.get(route('auth.saga.registration.commitee.individual.index'))">
                            <q-item-section>
                                <q-item-label>Individu</q-item-label>
                            </q-item-section>
                        </q-item>
                    </q-expansion-item> -->

                    <!-- <q-item -->
                    <!--     :inset-level="1" -->
                    <!--     v-ripple -->
                    <!--     clickable -->
                    <!--     :active="route().current('auth.saga.registration.technical.*')" -->
                    <!--     :href="route('auth.saga.registration.technical.index')" -->
                    <!--     @click.prevent="router.get(route('auth.saga.registration.technical.index'))" -->
                    <!-- > -->
                    <!--     <q-item-section> -->
                    <!--         <q-item-label>Teknikal</q-item-label> -->
                    <!--     </q-item-section> -->
                    <!-- </q-item> -->
                    <!-- <q-item -->
                    <!--     v-ripple -->
                    <!--     clickable -->
                    <!--     :active="route().current('auth.saga.registration.contingent.*')" -->
                    <!--     :href="route('auth.saga.registration.contingent.index')" -->
                    <!--     @click.prevent="router.get(route('auth.saga.registration.contingent.index'))" -->
                    <!-- > -->
                    <!--     <q-item-section avatar> -->
                    <!--         <q-icon color="grey" name="mdi-text-box-edit" /> -->
                    <!--     </q-item-section> -->
                    <!--     <q-item-section> -->
                    <!--         <q-item-label>Kontinjen</q-item-label> -->
                    <!--     </q-item-section> -->
                    <!-- </q-item> -->

                    <q-item-label
                        header
                        class="text-weight-bold text-uppercase"
                    >
                        Admin
                    </q-item-label>

                    <!-- <q-item v-ripple clickable :active="route().current('auth.admin.user.index.*')"
                        :href="route('auth.admin.user.index')"
                        @click.prevent="router.get(route('auth.admin.user.index'))">
                        <q-item-section avatar>
                            <q-icon color="grey" name="mdi-finance" />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>Pengguna</q-item-label>
                        </q-item-section>
                    </q-item>

                    <q-item v-ripple clickable :active="route().current('auth.admin.race.index.*')"
                        :href="route('auth.admin.race.index')"
                        @click.prevent="router.get(route('auth.admin.race.index'))">
                        <q-item-section avatar>
                            <q-icon color="grey" name="mdi-finance" />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>Bangsa</q-item-label>
                        </q-item-section>
                    </q-item> -->

                    <q-separator class="q-mt-md q-mb-lg" />

                    <div class="q-px-md text-grey-9">
                        <div
                            class="row q-gutter-x-sm q-gutter-y-xs items-center"
                        >
                            <a class="YL__drawer-footer-link" href=""
                                >Kredits</a
                            >
                            <a class="YL__drawer-footer-link" href="">Versi</a>
                            <!-- <a class="YL__drawer-footer-link" href=""></a> -->
                        </div>
                    </div>
                </q-list>
            </q-scroll-area>
        </q-drawer>

        <q-page-container>
            <div
                class="scrollable-container space-y-10 px-3 pt-6 pb-20 sm:px-10"
            >
                <q-breadcrumbs
                    class="text-grey"
                    active-color="primary"
                    v-if="$slots.breadcrumbs"
                >
                    <template v-slot:separator>
                        <q-icon
                            size="1.2em"
                            name="mdi-arrow-right"
                            color="primary"
                        />
                    </template>

                    <slot name="breadcrumbs" />
                </q-breadcrumbs>

                <div
                    class="row items-center justify-between"
                    v-if="$slots.title || $slots.headerActions"
                >
                    <div>
                        <h5 class="font-semibold">
                            <slot name="title" />
                        </h5>
                    </div>
                    <div>
                        <slot name="headerActions" />
                    </div>
                </div>

                <slot />

                <div class="flex justify-center">
                    <span class="text-gray-500"
                        >&copy; 2025 HakCipta Terpelihara; Majlis Sukan Negeri
                        Sabah</span
                    >
                </div>
            </div>
        </q-page-container>
    </q-layout>
</template>
