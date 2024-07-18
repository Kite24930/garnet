import '../index.js';
import 'flowbite';
import Quill from "quill";
import axios from "axios";

const userInputs = document.querySelectorAll('.user-input');
const userList = document.getElementById('userList');
let quill;

document.getElementById('allUser').addEventListener('click', () => {
    userList.innerHTML = '';
    userInputs.forEach(user => {
        user.checked = true;
        const li = document.createElement('li');
        li.textContent = user.getAttribute('data-user-name');
        userList.appendChild(li);
    });
})

userInputs.forEach(user => {
    user.addEventListener('change', () => {
        userList.innerHTML = '';
        userInputs.forEach(user => {
            if (user.checked) {
                const li = document.createElement('li');
                li.textContent = user.getAttribute('data-user-name');
                userList.appendChild(li);
            }
        })
    })
});

window.addEventListener('load', () => {
    quill = new Quill('#message', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{size: ['small', false, 'large', 'huge']}],
                ['bold', 'italic', 'underline', 'strike'],
                [{'color': []}, {'background': []}],
                [{'list': 'ordered'}, {'list': 'bullet'},
                {'indent': '-1'}, {'indent': '+1'}],
                ['image'],
                ['clean']
            ]
        }
    })
})

document.getElementById('sendBtn').addEventListener('click', () => {
    let targetUsers = [];
    userInputs.forEach(user => {
        if (user.checked) {
            targetUsers.push(user.value);
        }
    });
    const messageContent = quill.getContents();
    const sendData = {
        users: targetUsers,
        title: document.getElementById('title').value,
        message: JSON.stringify(messageContent),
        _token: Laravel.csrf_token
    }
    axios.post('/message/send', sendData)
    .then((res) => {
        console.log(res.data);
        if (res.data.status === 'success') {
            const a = document.createElement('a');
            a.href = '/message/list';
            a.click();
        } else {
            alert('Failed to send message.');
        }
    }).catch((err) => {
        console.log(err);
    })
});
