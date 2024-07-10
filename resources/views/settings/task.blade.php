<x-template css="settings.css">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">TASK</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        @if(session('success'))
            <div class="text-green-500 text-2xl">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="text-red-500 text-2xl">{{ session('error') }}</div>
            <div class="text-red-500 text-base">{{ session('message') }}</div>
        @endif
        <div>
            <a href="{{ route('setting.task.new') }}" class="rounded-lg eng-title border-red-300 bg-red-800 py-2 px-4">New</a>
        </div>
        <div class="flex flex-col items-center justify-center gap-4 w-full p-6">
            @php
                $category = 0;
                $group = 0;
                $item = 0;
            @endphp
            @foreach($tasks as $task)
                @if($category != $task->category_id)
                    @if($category != 0)
                        </div>
                    @endif
                    <div class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <div class="flex gap-2 items-center py-2">
                            <div class="text-2xl border-b border-gray-300 px-2">{{ $task->category_name }}</div>
                        </div>
                    @php $category = $task->category_id; @endphp
                @endif
                @if($group != $task->group_id)
                    <div class="flex gap-2 items-center pb-2 ml-2">
                        <div class="border-b border-gray-300 px-2">{{ $task->group_name }}</div>
                    </div>
                    @php $group = $task->group_id; @endphp
                @endif
                @if($item != $task->item_id)
                    <div class="flex gap-2 items-center pb-2 ml-4">
                        <div class="text-sm border-b border-gray-300 px-2">{{ $task->item_name }}</div>
                    </div>
                    @php $item = $task->item_id; @endphp
                @endif
                <div class="flex items-center justify-between gap-2 ml-6 mb-1">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('storage/icons/'.$task->rank_icon) }}" alt="{{ $task->rank_name }}" class="h-12">
                        <div class="text-lg">
                            {{ $task->text }}
                        </div>
                    </div>
                    <div class="flex gap-2 items-center">
                        <a href="{{ route('setting.task.edit', $task->task_id) }}" class="py-2 px-4 rounded-lg bg-blue-200 text-sm text-gray-600">Update</a>
                        <form action="{{ route('setting.task.destroy', $task->task_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="py-2 px-4 rounded-lg bg-red-200 text-sm text-gray-600">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.csrfToken = "{{ csrf_token() }}";
        window.Laravel.tasks = @json($tasks);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/settings/task.js'])
</x-template>
