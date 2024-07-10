<x-template css="settings.css">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">ITEM</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center text-4xl gap-4 w-full">
            @if(session('success'))
                <div class="text-green-500 text-2xl">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="text-red-500 text-2xl">{{ session('error') }}</div>
                <div class="text-red-500 text-base">{{ session('message') }}</div>
            @endif
            <form id="itemForm" action="{{ route('setting.item.store') }}" method="POST" class="flex flex-col gap-4 items-center justify-center">
                @csrf
                @foreach($items as $item)
                    <div class="flex flex-col gap-4 items-center border border-gray-300 rounded-lg p-4">
                        <label class="text-sm">{{ __('Item '.$item->id) }}</label>
                        <input type="hidden" name="{{ __('items['.$item->id.'][id]') }}" value="{{ $item->id }}">
                        <input id="{{ __('itemName_'.$item->id) }}" name="{{ __('items['.$item->id.'][name]') }}" type="text" class="text-xl text-gray-600 max-w-40 rounded active:border-blue-500" value="{{ $item->name }}" placeholder="Item Name" />
                    </div>
                @endforeach
                <button id="addBtn" type="button" class="rounded-lg eng-title border-red-300 bg-red-800 py-2 px-4 text-sm">Add</button>
                <button type="submit" class="rounded-lg eng-title border-yellow-100 bg-yellow-500 text-gray-700 text-xl hover:bg-yellow-800 hover:text-gray-100 py-2 px-4">Save</button>
            </form>
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.csrfToken = "{{ csrf_token() }}";
        window.Laravel.groups = @json($items);
        window.Laravel.count = @json($item->count());
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/settings/item.js'])
</x-template>
