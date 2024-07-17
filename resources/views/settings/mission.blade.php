<x-template css="settings.css">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">MISSION</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-4 w-full">
            @if(session('success'))
                <div class="text-green-500 text-2xl">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="text-red-500 text-2xl">{{ session('error') }}</div>
                <div class="text-red-500 text-base">{{ session('message') }}</div>
            @endif
            <a href="{{ route('setting.mission.new') }}" class="entry-btn bottom-4 right-4 py-2 px-4 text-gray-600 garnet">Add</a>
            <div class="flex flex-col gap-4 items-start w-full">
                @foreach($missions as $mission)
                    <div class="flex items-center justify-between gap-2 border-b border-gray-300 w-full">
                        <div class="flex flex-col items-start gap-1">
                            <div class="flex items-center gap-2">
                                <div class="text-sm">To</div>
                                @if($mission->user_id !== 0)
                                    @if($mission->user_icon)
                                        <img src="{{ asset('storage/account/'.$mission->user_id.'/'.$mission->user_icon) }}" alt="{{ $mission->user_name }}" class="w-6 h-6 object-cover rounded-full">
                                    @else
                                        <img src="{{ asset('storage/person-circle.svg') }}" alt="{{ $mission->user_name }}" class="w-6 h-6">
                                    @endif
                                    <div class="text-sm">{{ $mission->user_name }}</div>
                                @else
                                    <img src="{{ asset('storage/baseball.png') }}" alt="{{ __('TEAM') }}" class="w-6 h-6 bg-gray-100 rounded-full p-0.5">
                                    <div class="text-sm">TEAM</div>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 ml-2">
                                <div class="text-xs">{{ date('y.m.d', strtotime($mission->start_date)) }}</div>
                                <div class="text-xs">〜</div>
                                <div class="text-xs">{{ date('y.m.d', strtotime($mission->due_date)) }}</div>
                            </div>
                            <div class="ml-4">
                                {{ $mission->message }}
                            </div>
                        </div>
                        <a href="{{ route('setting.mission.edit', $mission->id) }}" class="entry-btn bottom-4 right-4 py-2 px-4 text-gray-600 garnet">Edit</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.missions = @json($missions);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/settings/mission.js'])
</x-template>
