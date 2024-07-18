<x-template css="index.css" title="Message">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">EDIT MESSAGE</div>
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
                <form action="{{ route('message.update', $message->id) }}" method="post" class="flex flex-col items-center gap-4 w-full max-w-md">
                    @csrf
                    <div class="flex flex-col gap-2 items-start w-full">
                        <label for="user_id" class="text-sm eng-title">To</label>
                        <div class="flex items-center gap-2">
                            @if($message->user_icon)
                                <img src="{{ asset('storage/account/'.$message->user_id.'/'.$message->user_icon) }}" alt="{{ $message->user_name }}" class="w-8 h-8 object-cover rounded-full">
                            @else
                                <img src="{{ asset('storage/person-circle.svg') }}" alt="{{ $message->user_name }}" class="w-6 h-6">
                            @endif
                            <div class="text-sm">{{ $message->user_name }}</div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 items-start w-full">
                        <label for="title" class="text-sm eng-title">Title</label>
                        <input type="text" name="title" id="title" class="w-full rounded-lg text-gray-600" value="{{ $message->title }}">
                    </div>
                    <div class="flex flex-col gap-2 items-start w-full">
                        <label for="message" class="text-sm eng-title">Message</label>
                        <div id="message" class="w-full">

                        </div>
                    </div>
                    <button id="updateBtn" type="button" class="entry-btn py-2 px-4 text-gray-600 text-xl garnet">UPDATE</button>
                </form>
        </div>
    </div>
    <div class="hidden h-0"></div>
    <script>
        window.Laravel = {};
        window.Laravel.user = @json($user);
        window.Laravel.message = @json($message);
        window.Laravel.csrf_token = '{{ csrf_token() }}';
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/mypage/message-edit.js'])
</x-template>
