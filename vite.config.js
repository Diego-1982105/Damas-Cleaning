import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        tailwindcss(),
    ],
    server: {
        host: process.env.LARAVEL_SAIL ? '0.0.0.0' : undefined,
        port: process.env.LARAVEL_SAIL ? Number(process.env.VITE_PORT || 5173) : undefined,
        hmr: process.env.LARAVEL_SAIL
            ? { host: process.env.VITE_HOST || 'localhost' }
            : undefined,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
