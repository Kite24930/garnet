import '../index.js';

const notificationBtn = document.getElementById('notificationCheck');

window.addEventListener('load', () => {
    Notification.requestPermission().then((permission) => {
        console.log(permission);
        if (permission === 'granted') {
            console.log('Notification permission granted.');
            notificationBtn.classList.add('hidden');
        } else {
            console.log('Unable to get permission to notify.');
        }
    });
});

notificationBtn.addEventListener('click', () => {
    Notification.requestPermission().then((permission) => {
        console.log(permission);
        if (permission === 'granted') {
            console.log('Notification permission granted.');
            setTimeout(() => {
                notificationBtn.classList.add('fade-out');
            }, 500)
            setTimeout(() => {
                notificationBtn.classList.add('h-0');
            }, 1500)
            setTimeout(() => {
                notificationBtn.classList.add('hidden');
            })
        } else {
            console.log('Unable to get permission to notify.');
        }
    });
});
