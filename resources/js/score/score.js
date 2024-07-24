import '../index.js';
import 'flowbite';

document.getElementById('pitcher').addEventListener('click', (e) => {
    const pitcher_area = document.getElementById('pitcher_area');
    if (pitcher_area.classList.contains('h-0')) {
        pitcher_area.classList.remove('h-0', 'overflow-hidden');
        pitcher_area.classList.add('h-[60dvh]', 'overflow-auto', 'border', 'p-2');
    } else {
        pitcher_area.classList.add('h-0', 'overflow-hidden');
        pitcher_area.classList.remove('h-[60dvh]', 'overflow-auto', 'border', 'p-2');
    }
});

document.getElementById('batter').addEventListener('click', (e) => {
    const batter_area = document.getElementById('batter_area');
    if (batter_area.classList.contains('h-0')) {
        batter_area.classList.remove('h-0', 'overflow-hidden');
        batter_area.classList.add('h-[60dvh]', 'overflow-auto', 'border', 'p-2');
    } else {
        batter_area.classList.add('h-0', 'overflow-hidden');
        batter_area.classList.remove('h-[60dvh]', 'overflow-auto', 'border', 'p-2');
    }
});

document.getElementById('defense').addEventListener('click', (e) => {
    const defense_area = document.getElementById('defense_area');
    if (defense_area.classList.contains('h-0')) {
        defense_area.classList.remove('h-0', 'overflow-hidden');
        defense_area.classList.add('h-[60dvh]', 'overflow-auto', 'border', 'p-2');
    } else {
        defense_area.classList.add('h-0', 'overflow-hidden');
        defense_area.classList.remove('h-[60dvh]', 'overflow-auto', 'border', 'p-2');
    }
});
