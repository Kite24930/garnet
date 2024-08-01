import '../index.js';
import 'flowbite';

const majorTag = document.querySelectorAll('.major-tag');
const garnetLine = document.createElement('div');
garnetLine.classList.add('garnet-line', 'w-full');
const majorWrapper = document.querySelectorAll('.major-wrapper');
majorTag.forEach((tag) => {
    tag.addEventListener('click', () => {
        const major = tag.getAttribute('data-tag');
        majorTag.forEach((mTag) => {
            mTag.classList.remove('border');
            const gLine = mTag.querySelector('.garnet-line');
            if (gLine) {gLine.remove()}
        });
        tag.appendChild(garnetLine);
        tag.classList.add('border');
        majorWrapper.forEach((mWrapper) => {
            mWrapper.classList.add('hidden');
            if (mWrapper.id === major) {
                mWrapper.classList.remove('hidden');
            }
        });
    });
});

const scoreTag = document.querySelectorAll('.score-tag');
const scoreWrapper = document.querySelector('.score-wrapper');
scoreTag.forEach((tag) => {
    tag.addEventListener('click', () => {
        const targetId = tag.getAttribute('data-target');
        const target = document.getElementById(targetId);
        target.classList.toggle('h-0');
        target.classList.toggle('py-2');
    });
});

const targetMonth = document.getElementById('targetMonth');
if (targetMonth) {
    targetMonth.addEventListener('change', () => {
        console.log(targetMonth.value);
        const a = document.createElement('a');
        a.href = `/ranking/month/${targetMonth.value}`;
        a.click();
    });
}
