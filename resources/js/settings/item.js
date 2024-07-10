import '../index.js';

document.getElementById('addBtn').addEventListener('click', (e) => {
    const itemCount = Laravel.count + 1;
    const itemWrapper = document.createElement('div');
    itemWrapper.classList.add('flex', 'flex-col', 'gap-4', 'items-center', 'border', 'border-gray-300', 'p-4', 'rounded-lg');
    const itemLabel = document.createElement('label');
    itemLabel.classList.add('text-sm');
    itemLabel.innerText = 'Item ' + itemCount;
    itemWrapper.appendChild(itemLabel);
    const itemIdInput = document.createElement('input');
    itemIdInput.type = 'hidden';
    itemIdInput.name = 'items[' + itemCount + '][id]';
    itemIdInput.value = itemCount;
    itemWrapper.appendChild(itemIdInput);
    const itemInput = document.createElement('input');
    itemInput.type = 'text';
    itemInput.id = 'itemName_' + itemCount;
    itemInput.name = 'items[' + itemCount + '][name]';
    itemInput.classList.add('text-xl', 'text-gray-600', 'max-w-40', 'rounded', 'active:border-blue-500');
    itemInput.placeholder = 'Item Name';
    itemWrapper.appendChild(itemInput);
    e.target.before(itemWrapper);
    Laravel.count++;
});
