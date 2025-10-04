import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';
import { Quasar, Dialog, Notify, Loading } from 'quasar'
import quasarIconSet from 'quasar/icon-set/svg-mdi-v7'

import '@quasar/extras/mdi-v7/mdi-v7.css'

import 'quasar/src/css/index.sass'

import CustomLoading from '@/components/CustomLoading.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Quasar, {
                plugins: {
                    Dialog,
                    Loading,
                    Notify,
                },
                iconSet: quasarIconSet,
                config: {
                    dark: false,
                    // brand: {
                    //     primary: '#e46262',
                    // },
                    dialog: {},
                    notify: {
                        progress: true,
                        position: 'top'
                    },
                    loading: {
                        spinner: CustomLoading,
                    }
                    // loading: {
                    //     // spinnerColor: 'primary',
                    //     // backgroundColor: 'purple',
                    //     // message: 'Some important process is in progress. Hang on...',
                    //     // messageColor: 'black',
                    //     html: `
                    //         <div class="flex text-white text-3xl">
                    //             Test
                    //         </div>
                    //     `
                    // },
                    // loadingBar: {},
                    // ..and many more (check Installation card on each Quasar component/directive/plugin)
                }
            })
            .mount(el);
    },
    progress: {
        showSpinner: true,
        color: '#ff9c08',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
