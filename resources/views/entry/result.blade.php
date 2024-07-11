<x-template css="result.css" title="Result">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div class="flex flex-col gap-1 items-center">
            <div class="px-4 text-4xl garnet">RESULT</div>
            <div class="garnet-line w-full"></div>
        </div>
        <div id="modal" class="fixed top-0 bottom-0 left-0 right-0 w-[100dvw] h-[100dvh] flex flex-col justify-center items-center z-30">
            <div id="container" class="flex flex-col items-center z-40">
                <div class="text-8xl garnet z-40">GET</div>
                <img src="{{ asset('storage/icons/'.$get_rank->icon) }}" alt="{{ $get_rank->eng_name }}" class="relative z-50">
            </div>
            <div id="rank-name" class="flex flex-col items-center justify-center z-40">
                <div class="text-6xl eng-italic px-4">
                    {{ $get_rank->eng_name }}
                </div>
                <div class="garnet-line w-full"></div>
            </div>
            <video src="{{ asset('storage/modal_back.mp4') }}" class="absolute md:hidden a-30 w-[100dvw] h-[100dvh] object-cover" autoplay muted playsinline></video>
            <video src="{{ asset('storage/modal_back_pc.mp4') }}" class="absolute md:block hidden z-30 h-[100dvh] w-[100dvw] object-cover" autoplay muted playsinline></video>
        </div>
        <div class="flex flex-col items-center gap-2 relative w-full max-w-md z-0">
            <div class="result-icon h-full flex flex-col justify-center items-center">
                <img src="{{ asset('storage/icons/'.$get_rank->icon) }}" alt="{{ $get_rank->eng_name }}" class="w-2/3">
                <div class="flex flex-col justify-center">
                    <div class="eng-italic px-4 text-xl">{{ $get_rank->eng_name }}</div>
                    <div class="garnet-line w-full"></div>
                </div>
            </div>
        </div>
        <div class="flex flex-col items-start px-6 gap-2 relative w-full max-w-md">
            @php $rank = 0; @endphp
            @foreach($results as $result)
                @if($rank !== $result->rank_id)
                    <div class="flex flex-col gap-1 items-center">
                        <div class="px-2 flex gap-2 items-end">
                            <div class="text-xl">{{ $result->rank_eng_name }}</div>
                            <div class="text-xs pb-0.5">{{ $result->rank_name }}</div>
                        </div>
                        <div class="garnet-line w-full"></div>
                    </div>
                @endif
                <div class="flex items-center justify-center gap-4 ml-6">
                    <div class="flex flex-col justify-center items-center">
                        <img src="{{ asset('storage/icons/'.$result->rank_icon) }}" alt="{{ $result->rank_eng_name }}" class="h-10">
                        <div class="eng-italic text-xs">{{ $result->rank_eng_name }}</div>
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <div class="text-xs">{{ __('['.$result->item_name.']') }}</div>
                        <div class="text-sm ml-4">{{ $result->text }}</div>
                    </div>
                </div>
                @php $rank = $result->rank_id; @endphp
            @endforeach
        </div>
        <div class="flex justify-center w-full mb-6">
            <a href="{{ route('index') }}" class="btn duration-500 px-4 py-2 text-gray-600">TOP PAGE</a>
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.results = @json($results);
        window.Laravel.rank_counts = @json($rank_counts);
        window.Laravel.get_rank = @json($get_rank);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/entry/result.js'])
</x-template>
