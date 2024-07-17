<x-template css="index.css" title="Mypage">
    <div class="w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div class="flex flex-col items-center justify-center text-4xl gap-8 w-full mb-12">
            <x-parts.menu-item link="{{ route('entry.show') }}">
                Entry
            </x-parts.menu-item>
            <x-parts.menu-item link="{{ route('logs.show') }}">
                Logs
            </x-parts.menu-item>
            @can('access to user')
                <x-parts.menu-item link="{{ route('profile.edit') }}">
                    Profile
                </x-parts.menu-item>
            @endcan
            @can('access to admin')
                <x-parts.menu-item link="{{ route('setting.show') }}">
                    Settings
                </x-parts.menu-item>
            @endcan
        </div>
    </div>
    <a href="{{ route('profile.edit') }}" class="fixed bottom-4 right-4 py-2 px-4 bg-[#eeeeee60] rounded-lg flex items-center gap-2">
        @if($user->icon)
            <img src="{{ asset('storage/account/'.$user->id.'/'.$user->icon) }}" alt="{{ $user->name }}" class="w-8 h-8 object-cover rounded-full">
        @else
            <img src="{{ asset('storage/person-circle.svg') }}" alt="{{ $user->name }}" class="w-6 h-6">
        @endif
        <div class="text-sm">{{ $user->name }}</div>
    </a>
    <script>
        window.Laravel = {};
        window.Laravel.access_log = @json($access_log);
        window.Laravel.start_of_day = @json($start_of_day);
        window.Laravel.end_of_day = @json($end_of_day);
        window.Laravel.user = @json($user);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/mypage/mypage.js'])
</x-template>
