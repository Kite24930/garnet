import '../index.js';

document.querySelectorAll('.btn').forEach((el) => {
    const rank_id = el.getAttribute('data-rank');
    const category_id = el.getAttribute('data-category');
    const group_id = el.getAttribute('data-group');
    const item_id = el.getAttribute('data-item');
    el.addEventListener('click', () => {
        let maxRank = 0;
        document.querySelectorAll(`.btn[data-category="${category_id}"][data-group="${group_id}"][data-item="${item_id}"]`).forEach((el) => {
            if (el.classList.contains('active')) {
                maxRank = Math.max(maxRank, el.getAttribute('data-rank'));
            }
            el.classList.remove('active');
            el.querySelector('label').classList.add('hidden');
        });
        if (Number(rank_id) !== maxRank) {
            let time = 0;
            for (let i = 1; i <= rank_id; i++) {
                const target = document.querySelector(`.btn[data-rank="${i}"][data-category="${category_id}"][data-group="${group_id}"][data-item="${item_id}"]`);
                if (target) {
                    setTimeout(() => {
                        target.classList.add('active');
                        target.querySelector('.bullet-hole').classList.remove('hidden');
                    }, time * 100);
                    setTimeout(() => {
                        target.querySelector('label').classList.remove('hidden');
                    }, time * 100 + 300);
                    time++;
                }
            }
        }
    });
});

document.getElementById('entry').addEventListener('click', () => {
    let data = [];
    Laravel.task_counts.forEach((task) => {
        let task_id = null;
        let rank = 0;
        document.querySelectorAll(`.btn.active[data-category="${task.category_id}"][data-group="${task.group_id}"][data-item="${task.item_id}"]`).forEach((el) => {
            if (el.getAttribute('data-rank') > rank) {
                rank = el.getAttribute('data-rank');
                task_id = el.getAttribute('data-task');
            }
        });
        if (task_id !== null) {
            data.push(task_id);
        }
    });
    const targetDate = document.getElementById('date').value;
    const sendData = {
        tasks: data,
        _token: Laravel.csrfToken,
        date: targetDate,
    };
    axios.post(Laravel.action, sendData)
        .then((response) => {
            console.log(response);
            const a = document.createElement('a');
            a.href = '/entry/result/' + targetDate;
            a.click();
        })
        .catch((error) => {
            console.log(error);
        });
})
