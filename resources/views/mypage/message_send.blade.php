<x-template css="index.css" title="Message">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">MESSAGE SEND</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-4 w-full mb-12">
            @if(session('success'))
                <div class="text-green-500 text-2xl">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="text-red-500 text-2xl">{{ session('error') }}</div>
                <div class="text-red-500 text-base">{{ session('message') }}</div>
            @endif
            <form action="{{ route('message.store') }}" method="post" class="flex flex-col items-center gap-4 w-full max-w-md">
                @csrf
                <div class="flex flex-col gap-2 items-start w-full">
                    <label for="user_id" class="text-sm eng-title">To</label>
                    <button id="dropdownBgHoverButton" data-dropdown-toggle="dropdownBgHover" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">Target User <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <ul id="userList" class="list-disc pl-6">

                    </ul>

                    <!-- Dropdown menu -->
                    <div id="dropdownBgHover" class="z-10 hidden w-48 bg-white rounded-lg shadow">
                        <ul class="p-3 space-y-1 text-sm text-gray-700 h-48 overflow-y-auto" aria-labelledby="dropdownBgHoverButton">
                            <li>
                                <button id="allUser" type="button" class="text-gray-600 p-2 hover:bg-gray-100 rounded items-center">All User Select</button>
                            </li>
                            @foreach($users as $user)
                                <li>
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100">
                                        <input id="{{ __('checkbox-item-'.$user->id) }}" name="user_id[]" type="checkbox" value="{{ $user->id }}" data-user-name="{{ $user->name }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 user-input">
                                        <label for="{{ __('checkbox-item-'.$user->id) }}" class="w-full ms-2 text-sm font-medium text-gray-900 rounded">{{ $user->name }}</label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col gap-2 items-start w-full">
                    <label for="title" class="text-sm eng-title">Title</label>
                    <input type="text" name="title" id="title" class="w-full rounded-lg text-gray-600">
                </div>
                <div class="flex flex-col gap-2 items-start w-full">
                    <label for="message" class="text-sm eng-title">Message</label>
                    <div id="message" class="w-full">

                    </div>
                </div>
                <button id="sendBtn" type="button" class="entry-btn py-2 px-4 text-gray-600 text-xl garnet">SEND</button>
            </form>
        </div>
    </div>
    <div class="hidden h-0"></div>
    <script>
        window.Laravel = {};
        window.Laravel.users = @json($users);
        window.Laravel.csrf_token = '{{ csrf_token() }}';
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/mypage/message-send.js'])
</x-template>
