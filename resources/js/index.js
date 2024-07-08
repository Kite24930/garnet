window.addEventListener('load', () => {
    const logoArea = document.getElementById('logo-area');
    if (logoArea !== null) {
        document.querySelector('.garnet').classList.add('title-fade-in');
        setTimeout(() => {
            document.querySelectorAll('.garnet-line').forEach((el) => {
                el.classList.add('line-effect');
            });
        }, 500)
        setTimeout(() => {
            document.querySelector('.garnet-logo').classList.add('logo-fade-in');
        }, 1500);
        setTimeout(() => {
            document.getElementById('logo').classList.add('logo-fade-out');
        }, 4000);
        setTimeout(() => {
            document.getElementById('logo-area').classList.add('logo-fade-out');
        }, 5000);
        setTimeout(() => {
            document.getElementById('logo-area').remove();
        }, 6000);
    }
})
