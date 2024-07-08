import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: 'manifest.json',
        rollupOptions: {
            input: {
                common: 'resources/js/common.js',
                commonStyle: 'resources/css/common.css',
                index: 'resources/js/index.js',
                indexStyle: 'resources/css/index.css',
            },
        }
    },
});
