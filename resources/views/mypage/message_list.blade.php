<x-template css="index.css" title="Message">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">MESSAGE LIST</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-4 w-full mb-12">
            <div class="flex flex-col items-start gap-4 w-full max-w-md">
                <a href="{{ route('message.send') }}" class="entry-btn py-2 px-4 text-gray-600 text-xl garnet">NEW MESSAGE</a>
                @foreach($messages as $message)
                    <div class="flex gap-4 items-center w-full justify-between">
                        <a href="{{ route('message.edit', $message->id) }}" class="flex items-center gap-4">
                            @if($message->is_read)
                                <img src="{{ asset('storage/envelope-paper.svg') }}" alt="envelope" class="h-8 w-auto">
                            @else
                                <img src="{{ asset('storage/envelope-fill.svg') }}" alt="envelope" class="h-8 w-auto">
                            @endif
                            <div class="flex flex-col">
                                <div class="text-xs">{{ __('to '.$message->user_name) }}</div>
                                <div>{{ $message->title }}</div>
                            </div>
                        </a>
                        <form action="{{ route('message.destroy', $message->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete" class="entry-btn py-2 px-4 text-gray-600 garnet">
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="hidden h-0"></div>
    <script>
        window.Laravel = {};
        window.Laravel.user = @json($user);
        window.Laravel.messages = @json($messages);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/mypage/message.js'])
</x-template>
