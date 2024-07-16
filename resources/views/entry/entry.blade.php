<x-template css="entry.css" title="Entry">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">ENTRY</div>
                <div class="garnet-line w-full"></div>
            </div>
            <input id="date" type="date" value="{{ $date }}" class="bg-transparent border-transparent mt-2 rounded-lg" data-link="{{ route('entry.show') }}">
        </div>
        @if(session('error'))
            <div class="text-red-500 text-sm">
                {{ session('error') }}
            </div>
            <div class="text-red-500 text-xs">
                @foreach(session('massage') as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif
        <div class="flex flex-col items-start gap-2 relative w-full max-w-md mb-20">
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
                <div class="flex flex-col justify-center items-center gap-2 py-4 px-2 btn duration-500 w-[28%] relative" data-rank="{{ $task->rank_id }}" data-category="{{ $task->category_id }}" data-group="{{ $task->group_id }}" data-item="{{ $task->item_id }}" data-task="{{ $task->task_id }}">
                    <div class="flex flex-col justify-center items-center relative">
                        <img src="{{ asset('storage/icons/'.$task->rank_icon) }}" alt="{{ $task->rank_eng_name }}" class="w-12">
                        <div class="eng-italic text-xs">
                            {{ $task->rank_eng_name }}
                        </div>
                        <div class="absolute bullet-hole w-24 hidden">
                            <img src="{{ asset('storage/bullet.png') }}" alt="bullet">
                        </div>
                        <label class="absolute clear-label garnet text-2xl hidden">
                            CLEAR
                        </label>
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
        <div id="entry" class="fixed entry-btn bottom-4 right-4 py-2 px-4 text-gray-600 text-4xl garnet">
            ENTRY
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.csrfToken = "{{ csrf_token() }}";
        window.Laravel.action = "{{ route('entry.store') }}";
        window.Laravel.ranks = @json($ranks);
        window.Laravel.categories = @json($categories);
        window.Laravel.groups = @json($groups);
        window.Laravel.items = @json($items);
        window.Laravel.tasks = @json($tasks);
        window.Laravel.task_counts = @json($task_counts);
        window.Laravel.entered_tasks = @json($entered_tasks);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/entry/entry.js'])
</x-template>
