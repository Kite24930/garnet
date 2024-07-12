import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { VitePWA } from "vite-plugin-pwa";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        VitePWA({
            registerType: 'autoUpdate',
            includeAssets: ['favicon.ico', 'robots.txt', 'apple-touch-icon.png', 'icons/*'],
            manifest: {
                name: 'GARNET',
                short_name: 'GARNET',
                description: 'GARNET is a web application that helps you to manage your tasks and goals.',
                start_url: '/',
                display: 'standalone',
                background_color: '#600000',
                theme_color: '#800000',
                icons: [
                    {
                        src: '/storage/icon-192x192.png',
                        sizes: '192x192',
                        type: 'image/png',
                    },
                    {
                        src: '/storage/icon-512x512.png',
                        sizes: '512x512',
                        type: 'image/png',
                    },
                ],
            },
        })
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
                entry: 'resources/js/entry/entry.js',
                entryStyle: 'resources/css/entry.css',
                result: 'resources/js/entry/result.js',
                resultStyle: 'resources/css/result.css',
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
