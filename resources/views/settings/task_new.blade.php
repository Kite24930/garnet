<x-template css="settings.css">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">NEW TASK</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-4 w-full">
            @if(session('success'))
                <div class="text-green-500 text-2xl">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="text-red-500 text-2xl">{{ session('error') }}</div>
                <div class="text-red-500 text-base">{{ session('message') }}</div>
            @endif
            <form action="{{ route('setting.task.store') }}" method="POST" class="flex flex-col gap-4 w-full max-w-lg">
                @csrf
                <div class="flex flex-col gap-2">
                    <label for="rank_id" class="uppercase text-xl eng-italic">rank</label>
                    <select name="rank_id" id="rank_id" class="text-gray-600 rounded-lg ml-4">
                        <option value="" class="hidden">select rank</option>
                        @foreach($ranks as $rank)
                            <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="category_id" class="uppercase text-xl eng-italic">category</label>
                    <select name="category_id" id="category_id" class="text-gray-600 rounded-lg ml-4">
                        <option value="" class="hidden">select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="group_id" class="uppercase text-xl eng-italic">group</label>
                    <select name="group_id" id="group_id" class="text-gray-600 rounded-lg ml-4">
                        <option value="" class="hidden">select group</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="item_id" class="uppercase text-xl eng-italic">item</label>
                    <select name="item_id" id="item_id" class="text-gray-600 rounded-lg ml-4">
                        <option value="" class="hidden">select item</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="text" class="uppercase text-xl eng-italic">group</label>
                    <input type="text" id="text" name="text" class="rounded-lg ml-4 text-gray-600">
                </div>
                <div class="flex justify-end">
                    <button id="saveBtn" class="rounded-lg eng-title border-yellow-100 bg-yellow-500 text-gray-700 text-xl hover:bg-yellow-800 hover:text-gray-100 py-2 px-4">Save</button>
                </div>
            </form>
        </div>
    </div>
    @vite(['resources/js/settings/task.js'])
</x-template>
