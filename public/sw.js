import 'https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js';
import 'https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging-compat.js';

const CACHE_NAME = 'garnet-cache-v1';
const urlsToCache = [
    '/storage/favicon.ico',
    '/robots.txt',
    '/storage/icon.png',
    '/storage/icon-192x192.png',
    '/storage/icon-512x512.png',
    '/storage/background.jpg',
];

// Initialize Firebase
const firebaseConfig = {
    apiKey: "AIzaSyBXgRopwxv2Oq-71q9c2jVoiXaHAxb2nZ0",
    authDomain: "garnet-b7ded.firebaseapp.com",
    projectId: "garnet-b7ded",
    storageBucket: "garnet-b7ded.appspot.com",
    messagingSenderId: "1097692902486",
    appId: "1:1097692902486:web:ac1fa554248cd17b03b7f7",
    measurementId: "G-N23GV5YHWM"
};

const app = firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log('[sw.js] Received background message ', payload);
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: 'storage/icon.png'
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});

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
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
