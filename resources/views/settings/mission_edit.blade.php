<x-template css="settings.css">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-3xl garnet">EDIT MISSION</div>
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
            <div class="flex flex-col gap-4 items-start w-full">
                <form action="{{ route('setting.mission.update', $mission->id) }}" method="post" class="flex flex-col gap-4 items-start w-full">
                    @csrf
                    @method('PATCH')
                    <div class="flex gap-2 items-center w-full">
                        <label for="user_id" class="text-sm">To</label>
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
                    <div class="flex flex-col gap-2 items-start w-full">
                        <label for="start_date" class="text-sm">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="w-full rounded-lg text-gray-600" value="{{ $mission->start_date }}">
                    </div>
                    <div class="flex flex-col gap-2 items-start w-full">
                        <label for="due_date" class="text-sm">Due Date</label>
                        <input type="date" name="due_date" id="due_date" class="w-full rounded-lg text-gray-600" value="{{ $mission->due_date }}">
                    </div>
                    <div class="flex flex-col gap-2 items-start w-full">
                        <label for="message" class="text-sm">Message</label>
                        <textarea name="message" id="message" class="w-full rounded-lg text-gray-600">{{ $mission->message }}</textarea>
                    </div>
                    <button type="submit" class="entry-btn bottom-4 right-4 py-2 px-4 text-gray-600 garnet">Update</button>
                </form>
                <form action="{{ route('setting.mission.destroy', $mission->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="entry-btn bottom-4 right-4 py-2 px-4 text-gray-600 garnet">Delete</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.mission = @json($mission);
        window.Laravel.users = @json($users);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/settings/mission.js'])
</x-template>
