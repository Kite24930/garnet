<x-template css="index.css">
    <div class="w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        @if($access_log === 0)
            <div id="logo-area" class="fixed top-0 bottom-0 right-0 left-0 w-[100dvw] h-[100dvh] flex items-center justify-center z-40 bg-garnet">
                <div id="logo" class="flex flex-col items-center gap-2 relative z-50">
                    <img src="{{ asset('storage/icon.png') }}" alt="GARNET" class="garnet-logo">
                    <div class="garnet-line"></div>
                    <div class="px-4 text-6xl garnet">GARNET</div>
                    <div class="garnet-line"></div>
                </div>
            </div>
        @endif
        @if($new_mission > 0)
            <div id="new-mission" class="fixed top-0 bottom-0 left-0 right-0 flex justify-center items-center z-30 h-[100dvh] w-[100dvw]">
                <img src="{{ asset('storage/new_mission.png') }}" alt="NEW MISSION" class="object-cover">
            </div>
        @endif
        @if(count($team_mission) > 0 || count($your_mission) > 0)
            <div class="w-full max-w-md flex flex-col items-center justify-center gap-4 relative z-20">
                @if(count($team_mission) > 0)
                    <div class="w-full flex flex-col items-start">
                        <div class="flex flex-col justify-center items-center w-full">
                            <div class="garnet text-lg px-2 w-full opacity-0 mission">TEAM MISSION</div>
                            <div class="garnet-line !h-0.5 w-full"></div>
                        </div>
                        <ul class="pl-4">
                            @foreach($team_mission as $mission)
                                <li>{{ $mission->message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(count($your_mission) > 0)
                    <div class="w-full flex flex-col items-start">
                        <div class="flex flex-col justify-center items-center w-full">
                            <div class="garnet text-lg px-2 w-full opacity-0 mission">YOUR MISSION</div>
                            <div class="garnet-line !h-0.5 w-full"></div>
                        </div>
                        <ul class="pl-4">
                            @foreach($your_mission as $mission)
                                <li>{{ $mission->message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif
        <div class="flex flex-col items-center justify-center text-4xl gap-4 w-full mb-12">
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
    <a href="{{ route('mypage') }}" class="fixed bottom-4 right-4 py-2 px-4 bg-[#eeeeee60] rounded-lg flex items-center gap-2 z-20">
        @if($unread_messages > 0)
            <div class="absolute -top-9 -right-2 unread-message">
                <div class="h-8 w-8 relative flex justify-center items-center">
                    <img src="{{ asset('storage/chat.svg') }}" alt="" class="h-8 w-auto">
                    <div class="text-sm garnet absolute left-0 right-0 top-0 bottom-0 flex justify-center items-center">
                        {{ $unread_messages }}
                    </div>
                </div>
            </div>
        @endif
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
        window.Laravel.team_mission = @json($team_mission);
        window.Laravel.your_mission = @json($your_mission);
        window.Laravel.new_mission = @json($new_mission);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/index.js'])
</x-template>
