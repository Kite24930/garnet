<x-template css="index.css" title="Message">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">MESSAGE</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-8 w-full mb-12">
            @if(count($unread_messages) > 0)
                <div class="w-full max-w-md flex flex-col items-start gap-2">
                    <div class="flex flex-col w-full">
                        <div class="eng-title ml-2">New Message</div>
                        <div class="garnet-line !h-0.5"></div>
                    </div>
                    @foreach($unread_messages as $message)
                        <a href="{{ route('message.view', $message->id) }}" class="flex items-center gap-4 ml-4">
                            <img src="{{ asset('storage/envelope-fill.svg') }}" alt="envelope" class="h-6 w-auto">
                            <div class="flex flex-col">
                                <div class="text-xs">{{ __('from '.$message->sent_name) }}</div>
                                <div>{{ $message->title }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
            @if(count($read_messages) > 0)
                <div class="w-full max-w-md flex flex-col items-start gap-2">
                    <div class="flex flex-col w-full">
                        <div class="eng-title ml-2">Message</div>
                        <div class="garnet-line !h-0.5"></div>
                    </div>
                    @foreach($read_messages as $message)
                        <a href="{{ route('message.view', $message->id) }}" class="flex items-center gap-4 ml-4">
                            <img src="{{ asset('storage/envelope-paper.svg') }}" alt="envelope" class="h-6 w-auto">
                            <div class="flex flex-col">
                                <div class="text-xs">{{ __('from '.$message->sent_name) }}</div>
                                <div>{{ $message->title }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="hidden h-0"></div>
    <script>
        window.Laravel = {};
        window.Laravel.user = @json($user);
        window.Laravel.unread_messages = @json($unread_messages);
        window.Laravel.read_messages = @json($read_messages);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/mypage/message.js'])
</x-template>
