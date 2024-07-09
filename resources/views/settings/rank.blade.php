<x-template css="settings.css">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">RANK</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-4 w-full">
            <form id="rankForm" action="{{ route('setting.rank.store') }}" method="POST" class="flex flex-col gap-4 items-center justify-center">
                @foreach($ranks as $rank)
                    <div class="flex gap-4 items-center">
                        <div class="flex flex-col items-center justify-center">
                            <img src="{{ asset('storage/icons/'.$rank->icon) }}" alt="{{ $rank->eng_name }}" class="h-20 rank-icon" data-target="{{ __('rankIconFile_'.$rank->id) }}">
                            <input id="{{ __('rankIconFile_'.$rank->id) }}" type="file" class="hidden rank-icon-input" data-target-id="{{ $rank->id }}" accept="image/png">
                            <input id="{{ __('rankIcon_'.$rank->id) }}" type="hidden" value="{{ $rank->icon }}">
                            <input id="{{ __('rankEngName_'.$rank->id) }}" type="text" class="eng-italic text-gray-600 text-sm w-28 text-center rounded active:border-blue-500" value="{{ $rank->eng_name }}" />
                        </div>
                        <input id="{{ __('rankName_'.$rank->id) }}" type="text" class="text-xl text-gray-600 max-w-40 rounded active:border-blue-500" value="{{ $rank->name }}" />
                    </div>
                @endforeach
            </form>
            <button id="addBtn" type="button" class="rounded-lg eng-title border-red-300 bg-red-800 py-2 px-4">Add</button>
            <button id="saveBtn" type="button" class="rounded-lg eng-title border-yellow-100 bg-yellow-500 text-gray-700 text-xl hover:bg-yellow-800 hover:text-gray-100 py-2 px-4">Save</button>
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.csrfToken = "{{ csrf_token() }}";
        window.Laravel.ranks = @json($ranks);
        window.Laravel.count = @json($ranks->count());
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/settings/rank.js'])
</x-template>
