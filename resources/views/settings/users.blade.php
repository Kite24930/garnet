<x-template css="settings.css">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">USERS</div>
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
            <div class="flex flex-col items-start gap-4 max-w-sm w-full">
                @foreach($users as $user)
                    <div class="flex justify-between items-center w-full">
                        <div class="flex items-center gap-2">
                            @if($user->icon)
                                <img src="{{ asset('storage/account/'.$user->id.'/'.$user->icon) }}" alt="{{ $user->name }}" class="w-8 h-8 object-cover rounded-full">
                            @else
                                <img src="{{ asset('storage/person-circle.svg') }}" alt="{{ $user->name }}" class="w-8 h-8">
                            @endif
                            <div class="text-sm">{{ $user->name }}</div>
                        </div>
                        @if(in_array($user->id, $captains))
                            <button class="unassignBtn entry-btn py-1 px-2 text-gray-600 garnet text-xs" type="button" data-target="{{ $user->id }}">
                                Captain
                                <br>
                                Unassigned
                            </button>
                        @else
                            <button class="assignBtn entry-btn py-1 px-2 text-gray-600 garnet text-xs" type="button" data-target="{{ $user->id }}">
                                Captain
                                <br>
                                Assigned
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.users = @json($users);
        window.Laravel.admins = @json($admins);
        window.Laravel.captains = @json($captains);
        window.Laravel.token = '{{ csrf_token() }}';
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/settings/users.js'])
</x-template>
