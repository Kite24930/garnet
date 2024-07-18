<x-template css="index.css" title="Mypage">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">MY PAGE</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center text-4xl gap-4 w-full mb-12">
            <button id="notificationCheck" class="flex flex-col items-center cursor-pointer text-2xl duration-500">
                <div class="py-1 px-4 flex justify-center items-center eng-title">
                    通知を許可する
                </div>
                <div class="garnet-line"></div>
            </button>
            <x-parts.menu-item link="{{ route('messages') }}">
                Message
                @if($unread_messages > 0)
                    <div class="relative h-10 ml-2 w-7 new-message">
                        <img src="{{ asset('storage/chat.svg') }}" alt="" class="absolute h-7 w-auto top-0">
                        <div class="absolute text-sm garnet top-[5px] w-7 text-center">
                            {{ $unread_messages }}
                        </div>
                        <div class="absolute text-xs bottom-0 w-7 garnet text-center">
                            new
                        </div>
                    </div>
                @endif
            </x-parts.menu-item>
            <x-parts.menu-item link="{{ route('profile.edit') }}">
                Profile
            </x-parts.menu-item>
            @can('access to admin')
                <x-parts.menu-item link="{{ route('message.list') }}">
                    Message List
                </x-parts.menu-item>
            @endcan
            @can('access to captain')
                <x-parts.menu-item link="{{ route('message.list') }}">
                    Message List
                </x-parts.menu-item>
            @endcan
        </div>
    </div>
    <div class="hidden h-0"></div>
    <script>
        window.Laravel = {};
        window.Laravel.user = @json($user);
        window.Laravel.messages = @json($messages);
        window.Laravel.unread_messages = @json($unread_messages);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/mypage/mypage.js'])
</x-template>
