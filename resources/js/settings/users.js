import '../index.js';
import axios from "axios";

document.querySelectorAll('.unassignBtn').forEach((btn) => {
    btn.addEventListener('click', () => {
        const userId = Number(btn.getAttribute('data-target'));
        axios.delete('/settings/user/unassign/captain/' + userId)
            .then(res => {
                console.log(res.data);
                if (res.data.status === 'success') {
                    window.location.reload();
                } else {
                    alert(res.data.message);
                }
            })
            .catch(err => {
                console.error(err);
            });1
    });
});

document.querySelectorAll('.assignBtn').forEach((btn) => {
    btn.addEventListener('click', () => {
        const sendData = {
            user_id: Number(btn.getAttribute('data-target')),
            _token: Laravel.token,
        };
        axios.post('/settings/user/assign/captain', sendData)
            .then(res => {
                console.log(res.data);
                if (res.data.status === 'success') {
                    window.location.reload();
                } else {
                    alert(res.data.message);
                }
            })
            .catch(err => {
                console.error(err);
            });
    });
});
