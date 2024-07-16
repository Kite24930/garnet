<x-template css="logs.css" title="Result">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div class="flex flex-col gap-1 items-center">
            <div class="px-4 text-4xl garnet">LOG</div>
            <div class="garnet-line w-full"></div>
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
        <div class="flex flex-col items-center justify-center w-full mb-6 gap-4">
            <a href="{{ route('entry.show', $date) }}" class="btn duration-500 px-4 py-2 text-gray-600">EDIT</a>
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
    @vite(['resources/js/log/logs.js'])
</x-template>
