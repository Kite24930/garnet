<x-template css="settings.css">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">SETTINGS</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center text-4xl gap-4 w-full">
            <x-parts.menu-item link="{{ route('setting.users') }}">
                Users
            </x-parts.menu-item>
            <x-parts.menu-item link="{{ route('setting.mission') }}">
                Mission
            </x-parts.menu-item>
            <x-parts.menu-item link="{{ route('setting.rank') }}">
                Rank
            </x-parts.menu-item>
            <x-parts.menu-item link="{{ route('setting.category') }}">
                Category
            </x-parts.menu-item>
            <x-parts.menu-item link="{{ route('setting.group') }}">
                Group
            </x-parts.menu-item>
            <x-parts.menu-item link="{{ route('setting.item') }}">
                Item
            </x-parts.menu-item>
            <x-parts.menu-item link="{{ route('setting.task') }}">
                Task
            </x-parts.menu-item>
            <x-parts.menu-item link="{{ route('setting.period') }}">
                Period
            </x-parts.menu-item>
        </div>
    </div>
    @vite(['resources/js/settings.js'])
</x-template>
