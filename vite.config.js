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
            includeAssets: ['/storage/favicon.ico', '/robots.txt', '/storage/icon.png', '/storage/icons/*'],
            manifest: {
                name: 'GARNET',
                short_name: 'GARNET',
                description: 'GARNET is a web application that helps you to manage your tasks and goals.',
                lang: 'ja',
                start_url: '/',
                scope: '/',
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
            workbox: {
                cleanupOutdatedCaches: true,
                skipWaiting: true,
                clientsClaim: true,
                navigateFallback: '/',
                runtimeCaching: [
                    {
                        urlPattern: /^https:\/\/garnets\.tech\/.*\.(?:css|js)$/,
                        handler: 'NetworkFirst',
                        options: {
                            cacheName: 'garnet-cache-v1',
                            expiration: {
                                maxEntries: 100,
                                maxAgeSeconds: 60,
                            },
                        },
                    },
                ],
            }
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
                logs: 'resources/js/log/logs.js',
                logsStyle: 'resources/css/logs.css',
                score: 'resources/js/score/score.js',
                scoreStyle: 'resources/css/score.css',
                scoreNew: 'resources/js/score/score-new.js',
                scoreEdit: 'resources/js/score/score-edit.js',
                mypage: 'resources/js/mypage/mypage.js',
                message: 'resources/js/mypage/message.js',
                messageSend: 'resources/js/mypage/message-send.js',
                messageEdit: 'resources/js/mypage/message-edit.js',
                messageView: 'resources/js/mypage/message-view.js',
                settings: 'resources/js/settings.js',
                settingsStyle: 'resources/css/settings.css',
                users: 'resources/js/settings/users.js',
                rank: 'resources/js/settings/rank.js',
                category: 'resources/js/settings/category.js',
                group: 'resources/js/settings/group.js',
                item: 'resources/js/settings/item.js',
                task: 'resources/js/settings/task.js',
                mission: 'resources/js/settings/mission.js',
            },
        }
    },
});
