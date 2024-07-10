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
                app: 'resources/js/app.js',
                appStyle: 'resources/css/app.css',
                common: 'resources/js/common.js',
                commonStyle: 'resources/css/common.css',
                index: 'resources/js/index.js',
                indexStyle: 'resources/css/index.css',
                settings: 'resources/js/settings.js',
                settingsStyle: 'resources/css/settings.css',
                rank: 'resources/js/settings/rank.js',
                category: 'resources/js/settings/category.js',
                group: 'resources/js/settings/group.js',
                item: 'resources/js/settings/item.js',
                task: 'resources/js/settings/task.js',
            },
        }
    },
});
