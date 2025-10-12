import 'quasar/src/css/index.sass';
import '../css/app.css';

import { routeHelper } from '@/utils/route';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { Dialog, Loading, Notify, Quasar } from 'quasar';
import quasarIconSet from 'quasar/icon-set/svg-mdi-v7';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';

import '@quasar/extras/mdi-v7/mdi-v7.css';

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
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Quasar, {
                plugins: {
                    Dialog,
                    Loading,
                    Notify,
                },
                iconSet: quasarIconSet,
                config: {
                    dark: 'auto',
                    dialog: {},
                    notify: {
                        progress: true,
                        position: 'top',
                    },
                    loading: {
                        spinner: CustomLoading,
                    },

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
                },
            });

        app.config.globalProperties.route = routeHelper;

        app.mount(el);
    },
    progress: {
        showSpinner: true,
        color: '#ff9c08',
    },
});

// This will set light / dark mode on page load...
// initializeTheme();
