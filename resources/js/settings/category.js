import '../index.js';

document.getElementById('addBtn').addEventListener('click', (e) => {
    const categoryCount = Laravel.count + 1;
    const categoryWrapper = document.createElement('div');
    categoryWrapper.classList.add('flex', 'flex-col', 'gap-4', 'items-center', 'border', 'border-gray-300', 'p-4', 'rounded-lg');
    const categoryLabel = document.createElement('label');
    categoryLabel.classList.add('text-sm');
    categoryLabel.innerText = 'Category ' + categoryCount;
    categoryWrapper.appendChild(categoryLabel);
    const categoryIdInput = document.createElement('input');
    categoryIdInput.type = 'hidden';
    categoryIdInput.name = 'categories[' + categoryCount + '][id]';
    categoryIdInput.value = categoryCount;
    categoryWrapper.appendChild(categoryIdInput);
    const categoryInput = document.createElement('input');
    categoryInput.type = 'text';
    categoryInput.id = 'categoryName_' + categoryCount;
    categoryInput.name = 'categories[' + categoryCount + '][name]';
    categoryInput.classList.add('text-xl', 'text-gray-600', 'max-w-40', 'rounded', 'active:border-blue-500');
    categoryInput.placeholder = 'Category Name';
    categoryWrapper.appendChild(categoryInput);
    const categoryEngInput = document.createElement('input');
    categoryEngInput.type = 'text';
    categoryEngInput.id = 'categoryEngName_' + categoryCount;
    categoryEngInput.name = 'categories[' + categoryCount + '][eng_name]';
    categoryEngInput.classList.add('eng-italic', 'text-gray-600', 'text-xl -d' +
        '', 'w-28', 'text-center', 'rounded', 'active:border-blue-500');
    categoryEngInput.placeholder = 'Category English Name';
    categoryWrapper.appendChild(categoryEngInput);
    e.target.before(categoryWrapper);
    Laravel.count++;
});
