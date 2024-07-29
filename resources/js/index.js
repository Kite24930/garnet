import axios from "axios";

window.addEventListener('load', () => {
    document.body.classList.add('fade-in');
    const logoArea = document.getElementById('logo-area');
    if (logoArea !== null) {
        document.querySelector('.garnet').classList.add('title-fade-in');
        setTimeout(() => {
            document.querySelectorAll('#logo-area .garnet-line').forEach((el) => {
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
    const newMission = document.getElementById('new-mission');
    if (newMission) {
        if (logoArea) {
            setTimeout(() => {
                newMission.classList.add('fade-out');
            }, 6500);
            setTimeout(() => {
                newMission.remove();
            }, 7500);
        } else {
            setTimeout(() => {
                newMission.classList.add('fade-out');
            }, 1500);
            setTimeout(() => {
                newMission.remove();
            }, 2500);
        }
    }
    const mission = document.querySelectorAll('.mission');
    if (mission.length > 0) {
        mission.forEach(el => {
            setTimeout(() => {
                el.classList.add('blink');
            }, 500)
        })
    }
})

document.querySelectorAll('.btn-item').forEach((el) => {
    el.addEventListener('click', () => {
        const link = el.getAttribute('data-link');
        const line = el.querySelector('.garnet-line');
        line.classList.add('btn-effect');
        setTimeout(() => {
            document.body.classList.remove('fade-in');
            document.body.classList.add('fade-out');
        }, 500);
        setTimeout(() => {
            const a = document.createElement('a');
            a.href = link;
            a.click();
        }, 1200)
    })
});
