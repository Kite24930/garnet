<x-template css="entry.css" title="Entry">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">ENTRY</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-start gap-2 relative w-full">
            @php
                $category = 0;
                $group = 0;
                $item = 0;
            @endphp
            @foreach($tasks as $task)
                @if(($category !== $task->category_id || $group !== $task->group_id || $item !== $task->item_id) && ($category !== 0 && $group !== 0 && $item !== 0))
                    </div>
                @endif
                @if($category !== $task->category_id)
                    <div class="flex flex-col gap-1 items-center">
                        <div class="px-2 flex gap-2 items-end">
                            <div class="text-xl">{{ $task->category_eng_name }}</div>
                            <div class="text-xs pb-0.5">{{ $task->category_name }}</div>
                        </div>
                        <div class="garnet-line w-full"></div>
                    </div>
                @endif
                @if($group !== $task->group_id)
                    <div class="flex flex-col gap-1 items-center ml-4">
                        <div class="px-2 flex gap-2 items-end text-sm">
                            {{ $task->group_name }}
                        </div>
                        <div class="garnet-line w-full !h-1"></div>
                    </div>
                @endif
                @if($item !== $task->item_id)
                    <div class="flex flex-col gap-1 items-center justify-center w-full">
                        <div class="w-full flex gap-2 items-end text-xs justify-center">
                            {{ $task->item_name }}
                        </div>
                        <div class="garnet-line w-full !h-0.5"></div>
                    </div>
                    <div class="flex w-full gap-4 flex-wrap justify-center items-center mb-4">
                @endif
                <div class="flex flex-col justify-center items-center gap-2 p-4 btn duration-500 w-[30%]">
                    <div class="flex flex-col justify-center items-center">
                        <img src="{{ asset('storage/icons/'.$task->rank_icon) }}" alt="{{ $task->rank_eng_name }}" class="w-12">
                        <div class="eng-italic text-xs">
                            {{ $task->rank_eng_name }}
                        </div>
                    </div>
                    <div class="text-xs">
                        {{ $task->text }}
                    </div>
                </div>
                @php
                    $category = $task->category_id;
                    $group = $task->group_id;
                    $item = $task->item_id;
                @endphp
            @endforeach
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.csrfToken = "{{ csrf_token() }}";
        window.Laravel.ranks = @json($ranks);
        window.Laravel.categories = @json($categories);
        window.Laravel.groups = @json($groups);
        window.Laravel.items = @json($items);
        window.Laravel.tasks = @json($tasks);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/entry/entry.js'])
</x-template>
