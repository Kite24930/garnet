<x-template css="index.css">
    <div class="relative w-full h-full min-h-screen flex flex-col items-center justify-center p-4 gap-10">
        @if($access_log === 0)
            <div id="logo-area" class="absolute top-0 bottom-0 right-0 left-0 w-full h-full flex items-center justify-center z-40 bg-garnet">
                <div id="logo" class="flex flex-col items-center gap-2 relative z-50">
                    <img src="{{ asset('storage/icon.png') }}" alt="GARNET" class="garnet-logo">
                    <div class="garnet-line"></div>
                    <div class="px-4 text-6xl garnet">GARNET</div>
                    <div class="garnet-line"></div>
                </div>
            </div>
        @endif
        <div class="flex justify-center my-2">
            <div class="flex flex-col gap-2 items-center">
                <div class="garnet-line w-full"></div>
                <div class="px-4 text-6xl garnet">GARNET</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center text-4xl gap-4 w-full">
            <x-parts.menu-item link="">
                Entry
            </x-parts.menu-item>
            <x-parts.menu-item link="">
                Logs
            </x-parts.menu-item>
            @can('access to user')
                <x-parts.menu-item link="">
                    Profile
                </x-parts.menu-item>
            @endcan
            @can('access to admin')
                <x-parts.menu-item link="">
                    Settings
                </x-parts.menu-item>
            @endcan
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.access_log = @json($access_log);
        window.Laravel.start_of_day = @json($start_of_day);
        window.Laravel.end_of_day = @json($end_of_day);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/index.js'])
</x-template>
