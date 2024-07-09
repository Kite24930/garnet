import '../index.js';

const imgClick = (target) => {
    const fileInputId = target.getAttribute('data-target');
    document.getElementById(fileInputId).click();
}

const fileSelect = (target) => {
    console.log(target.files[0])
    const targetId = target.getAttribute('data-target-id');
    const imageTarget = document.querySelector('.rank-icon[data-target="rankIconFile_' + targetId + '"]');
    console.log(imageTarget, targetId);
    imageTarget.src = URL.createObjectURL(target.files[0]);
    document.getElementById('rankIcon_' + targetId).value = target.files[0].name;
}

document.querySelectorAll('.rank-icon').forEach((el) => {
    el.addEventListener('click', (e) => {
        imgClick(e.target);
    })
})

document.querySelectorAll('.rank-icon-input').forEach((el) => {
    el.addEventListener('change', (e) => {
        fileSelect(e.target);
    })
});

document.getElementById('addBtn').addEventListener('click', () => {
    const rankCount = Laravel.count + 1;
    const rankForm = document.getElementById('rankForm');
    const iconWrapper = document.createElement('div');
    iconWrapper.classList.add('flex', 'gap-4', 'items-center');
    const iconContainer = document.createElement('div');
    iconContainer.classList.add('flex', 'flex-col', 'items-center', 'justify-center');
    const icon = document.createElement('img');
    icon.classList.add('rank-icon', 'h-20');
    icon.src = '/storage/icons/icons.png';
    icon.setAttribute('data-target', 'rankIconFile_' + rankCount);
    icon.addEventListener('click', (e) => {
        imgClick(e.target);
    });
    iconContainer.appendChild(icon);
    const iconFileInput = document.createElement('input');
    iconFileInput.type = 'file';
    iconFileInput.id = 'rankIconFile_' + rankCount;
    iconFileInput.classList.add('hidden', 'rank-icon-input');
    iconFileInput.setAttribute('data-target-id', rankCount);
    iconFileInput.accept = 'image/png';
    iconFileInput.addEventListener('change', (e) => {
        fileSelect(e.target);
    });
    iconContainer.appendChild(iconFileInput);
    const iconInput = document.createElement('input');
    iconInput.type = 'hidden';
    iconInput.id = 'rankIcon_' + rankCount;
    iconContainer.appendChild(iconInput);
    const rankEngInput = document.createElement('input');
    rankEngInput.type = 'text';
    rankEngInput.id = 'rankEngName_' + rankCount;
    rankEngInput.classList.add('eng-italic', 'text-gray-600', 'text-sm', 'w-28', 'text-center', 'rounded', 'active:border-blue-500');
    iconContainer.appendChild(rankEngInput);
    iconWrapper.appendChild(iconContainer);
    const rankNameInput = document.createElement('input');
    rankNameInput.type = 'text';
    rankNameInput.id = 'rankName_' + rankCount;
    rankNameInput.classList.add('text-xl', 'text-gray-600', 'max-w-40', 'rounded', 'active:border-blue-500');
    iconWrapper.appendChild(rankNameInput);
    rankForm.appendChild(iconWrapper);
    Laravel.count++;
});

document.getElementById('saveBtn').addEventListener('click', () => {
    const rankForm = document.getElementById('rankForm');
    const formAction = rankForm.getAttribute('action');
    const form = document.createElement('form');
    const formData = new FormData(form);

    for(let i = 1; i <= Laravel.count; i++) {
        const ranKIconFile = document.getElementById('rankIconFile_' + i);
        const rankIcon = document.getElementById('rankIcon_' + i);
        const rankEngName = document.getElementById('rankEngName_' + i);
        const rankName = document.getElementById('rankName_' + i);
        if (ranKIconFile.files.length > 0) {
            formData.append(`icon_${i}`, ranKIconFile.files[0]);
        }
        formData.append(`ranks[${i}][id]`, i);
        formData.append(`ranks[${i}][icon]`, rankIcon.value);
        formData.append(`ranks[${i}][eng_name]`, rankEngName.value);
        formData.append(`ranks[${i}][name]`, rankName.value);
    }
    try {
        axios.post(formAction, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': Laravel.csrfToken,
            }
        }).then((response) => {
            console.log(response.data);
            if (response.data.success) {
                window.location.reload();
            }
        }).catch((error) => {
            console.error(error);
        });
    } catch (error) {
        console.error(error);
    }
});
