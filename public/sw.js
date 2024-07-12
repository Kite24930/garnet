const CACHE_NAME = 'garnet-cache-v1';
const urlsToCache = [
    '/',
    '/index.php',
    '/storage/favicon.ico',
    '/robots.txt',
    '/storage/icon.png',
    '/storage/icon-192x192.png',
    '/storage/icon-512x512.png',
    '/storage/modal-back.mp4',
    '/storage/modal-back-pc.mp4',
    '/storage/background.jpg',
    '/resources/css/app.css',
    '/resources/js/app.js',
    '/resources/js/common.js',
    '/resources/css/common.css',
    '/resources/js/index.js',
    '/resources/css/index.css',
    '/resources/js/entry/entry.js',
    '/resources/css/entry.css',
    '/resources/js/entry/result.js',
    '/resources/css/result.css',
    '/resources/js/settings.js',
    '/resources/css/settings.css',
    '/resources/js/settings/rank.js',
    '/resources/js/settings/category.js',
    '/resources/js/settings/group.js',
    '/resources/js/settings/item.js',
    '/resources/js/settings/task.js',
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response;
                }
                return fetch(event.request);
            })
    );
});

self.addEventListener('activate', event => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys()
            .then(cacheNames => {
                return Promise.all(
                    cacheNames.map(cacheName => {
                        if (cacheName !== CACHE_NAME) {
                            return caches.delete(cacheName);
                        }
                    })
                );
            })
    );
});
