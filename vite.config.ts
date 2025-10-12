import { quasar, transformAssetUrls } from '@quasar/vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { fileURLToPath } from 'node:url';
import path from 'path';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        // wayfinder({
        //     formVariants: true,
        // }),
        vue({
            // template: {
            //     transformAssetUrls: {
            //         base: null,
            //         includeAbsolute: false,
            //     },
            // },
            template: { transformAssetUrls },
        }),
        quasar({
            sassVariables: fileURLToPath(
                new URL(
                    './resources/sass/quasar-variables.scss',
                    import.meta.url,
                ),
            ),
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    },
    // server: {
    //     watch: {
    //         ignored: [
    //             '**/app/**',
    //             '**/bootstrap/**',
    //             '**/config/**',
    //             '**/database/**',
    //             '**/lang/**',
    //             '**/storage/**',
    //             '**/tests/**',
    //         ]
    //     }
    // },
});
