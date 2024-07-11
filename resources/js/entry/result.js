import '../index.js';

window.addEventListener('load', () => {
    const modal = document.getElementById('modal');
    setTimeout(() => {
        modal.classList.add('fadeOut');
    }, 4000);
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 5000);
})
