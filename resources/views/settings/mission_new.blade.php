<x-template css="settings.css">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-3xl garnet">NEW MISSION</div>
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
            <div class="flex flex-col gap-4 items-start w-full">
                <form action="{{ route('setting.mission.store') }}" method="post" class="flex flex-col gap-4 items-start w-full">
                    @csrf
                    <div class="flex flex-col gap-2 items-start w-full">
                        <label for="user_id" class="text-sm">To</label>
                        <button id="dropdownBgHoverButton" data-dropdown-toggle="dropdownBgHover" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">Target User <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownBgHover" class="z-10 hidden w-48 bg-white rounded-lg shadow">
                            <ul class="p-3 space-y-1 text-sm text-gray-700 h-48 overflow-y-auto" aria-labelledby="dropdownBgHoverButton">
                                <li>
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100">
                                        <input id="checkbox-item-0" name="user_id[]" type="checkbox" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        <label for="checkbox-item-0" class="w-full ms-2 text-sm font-medium text-gray-900 rounded">TEAM</label>
                                    </div>
                                </li>
                                @foreach($users as $user)
                                    <li>
                                        <div class="flex items-center p-2 rounded hover:bg-gray-100">
                                            <input id="{{ __('checkbox-item-'.$user->id) }}" name="user_id[]" type="checkbox" value="{{ $user->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                            <label for="{{ __('checkbox-item-'.$user->id) }}" class="w-full ms-2 text-sm font-medium text-gray-900 rounded">{{ $user->name }}</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 items-start w-full">
                        <label for="start_date" class="text-sm">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="w-full rounded-lg text-gray-600" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="flex flex-col gap-2 items-start w-full">
                        <label for="due_date" class="text-sm">Due Date</label>
                        <input type="date" name="due_date" id="due_date" class="w-full rounded-lg text-gray-600" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="flex flex-col gap-2 items-start w-full">
                        <label for="message" class="text-sm">Message</label>
                        <textarea name="message" id="message" class="w-full rounded-lg text-gray-600"></textarea>
                    </div>
                    <button type="submit" class="entry-btn bottom-4 right-4 py-2 px-4 text-gray-600 garnet">Add</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.tasks = @json($tasks);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/settings/mission.js'])
</x-template>
