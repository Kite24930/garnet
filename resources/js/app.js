import './bootstrap';

import { initializeApp } from 'firebase/app';
import { getAnalytics } from 'firebase/analytics';
import { getMessaging, getToken } from 'firebase/messaging';

import axios from "axios";

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js', { type: 'module' }).then(registration => {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, error => {
            console.log('ServiceWorker registration failed: ', error);
        });
        // navigator.serviceWorker.register('/firebase-messaging-sw.js', { type: 'module' }).then(registration => {
        //     console.log('firebase ServiceWorker registration successful with scope: ', registration.scope);
        // }, error => {
        //     console.log('firebase ServiceWorker registration failed: ', error);
        // });
    });
}

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyBXgRopwxv2Oq-71q9c2jVoiXaHAxb2nZ0",
    authDomain: "garnet-b7ded.firebaseapp.com",
    projectId: "garnet-b7ded",
    storageBucket: "garnet-b7ded.appspot.com",
    messagingSenderId: "1097692902486",
    appId: "1:1097692902486:web:ac1fa554248cd17b03b7f7",
    measurementId: "G-N23GV5YHWM"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

const requestPermission = () => {
    console.log('Requesting permission...');
    Notification.requestPermission()
        .then((permission) => {
            console.log(permission);
            if (permission === 'granted') {
                console.log('Notification permission granted.');
            } else {
                console.log('Unable to get permission to notify.');
            }
        })
        .catch((err) => {
            console.log('Unable to get permission to notify.', err);
        });
}

axios.post('/get/vapid_key').then(async (res) => {
    const messaging = getMessaging();
    // console.log(res.data);
    getToken(messaging, {
        vapidKey: res.data.vapid_key,
        serviceWorkerRegistration: await navigator.serviceWorker.register('/sw.js', { type: 'module' }),
    })
        .then((currentToken) => {
            if (currentToken) {
                console.log({currentToken: currentToken});
                const sendData = {
                    token: currentToken,
                }
                axios.post('/register/notification/token', sendData).then(res => {
                    console.log(res.data);
                }).catch(err => {
                    console.log(err);
                });
            } else {
                console.log('No registration token available. Request permission to generate one.');
            }
        }).catch((err) => {
            console.log('An error occurred while retrieving token. ', err);
        });
    requestPermission();
}).catch(err => {
    console.log('Unable to get VAPID key', err);
});
