<x-template css="settings.css">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">PERIOD</div>
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
            <form action="{{ route('setting.period.store') }}" method="POST" class="flex flex-col gap-4 w-full max-w-lg">
                @csrf
                <div class="flex flex-col gap-2">
                    <label for="text" class="uppercase text-xl eng-italic">target</label>
                    @if($period)
                        <input type="text" id="target" name="target" class="rounded-lg ml-4 text-gray-600" value="{{ $period->target }}">
                    @else
                        <input type="text" id="target" name="target" class="rounded-lg ml-4 text-gray-600">
                    @endif
                </div>
                <div class="flex flex-col gap-2">
                    <label for="text" class="uppercase text-xl eng-italic">target date</label>
                    @if($period)
                        <input type="date" id="target_date" name="target_date" class="rounded-lg ml-4 text-gray-600" value="{{ $period->target_date }}">
                    @else
                        <input type="date" id="target_date" name="target_date" class="rounded-lg ml-4 text-gray-600" value="{{ date('Y-m-d') }}">
                    @endif
                </div>
                <div class="flex justify-end">
                    <button id="saveBtn" class="rounded-lg eng-title border-yellow-100 bg-yellow-500 text-gray-700 text-xl hover:bg-yellow-800 hover:text-gray-100 py-2 px-4">Save</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.period = @json($period);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/settings/task.js'])
</x-template>
