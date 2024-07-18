import { initializeApp } from "firebase/app";
import { getMessaging, onMessage } from "firebase/messaging";

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

const app = initializeApp(firebaseConfig);

const messaging = getMessaging();

onMessage(messaging, (payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/firebase-logo.png'
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
