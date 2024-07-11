import '../index.js';

window.addEventListener('load', () => {
    const modal = document.getElementById('modal');
    const container = document.getElementById('container');
    const rankName = document.getElementById('rank-name');
    container.classList.add('container');
    rankName.classList.add('rank-name');
    setTimeout(() => {
        modal.classList.add('fadeOut');
    }, 4000);
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 5000);
})
