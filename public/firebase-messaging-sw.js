import 'https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js';
import 'https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging-compat.js';

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
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: 'storage/icon.png'
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
