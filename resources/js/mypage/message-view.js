import '../index.js';
import Quill from "quill";

window.addEventListener('load', () => {
    const quill = new Quill('#viewer', {
        theme: 'snow',
        modules: {
            toolbar: false
        },
        readOnly: true
    });
    quill.setContents(JSON.parse(Laravel.message.message));
})
