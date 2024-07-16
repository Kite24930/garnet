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
    // '/storage/modal-back.mp4',
    // '/storage/modal-back-pc.mp4',
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
