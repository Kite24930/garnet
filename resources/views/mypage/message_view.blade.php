<x-template css="index.css" title="Message">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">MESSAGE</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-4 w-full mb-12 max-w-md">
            <div class="flex flex-col gap-2 items-start w-full">
                <div class="eng-italic text-sm">From</div>
                <div class="ml-4 flex gap-2 items-center">
                    @if($message->sent_icon)
                        <img src="{{ asset('storage/account/'.$message->sent_from.'/'.$message->sent_icon) }}" alt="{{ $message->sent_name }}" class="w-8 h-8 object-cover rounded-full">
                    @else
                        <img src="{{ asset('storage/person-circle.svg') }}" alt="{{ $message->sent_name }}" class="w-6 h-6">
                    @endif
                    <div class="text-sm">{{ $message->sent_name }}</div>
                </div>
            </div>
            <div class="flex flex-col gap-2 items-start w-full">
                <div class="eng-italic text-sm">Title</div>
                <div class="ml-4">
                    {{ $message->title }}
                </div>
            </div>
            <div class="flex flex-col gap-2 items-start w-full">
                <div class="eng-title text-sm">Contents</div>
                <div id="viewer" class="w-full">

                </div>
            </div>
            <div class="flex justify-center items-center w-full">
                <a href="{{ route('messages') }}" class="entry-btn py-2 px-4 text-gray-600 garnet">BACK</a>
            </div>
        </div>
    </div>
    <div class="hidden h-0"></div>
    <script>
        window.Laravel = {};
        window.Laravel.user = @json($user);
        window.Laravel.message = @json($message);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/mypage/message-view.js'])
</x-template>
