import '../index.js';
import Quill from "quill";
import axios from "axios";

let quill;

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
    quill.setContents(JSON.parse(Laravel.message.message));
});

document.getElementById('updateBtn').addEventListener('click', () => {
    const messageContent = quill.getContents();
    const sendData = {
        title: document.getElementById('title').value,
        message: JSON.stringify(messageContent),
        _token: Laravel.csrf_token
    }
    axios.patch('/message/edit/' + Laravel.message.id, sendData)
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
        });
});
