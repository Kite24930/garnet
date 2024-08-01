<x-template css="logs.css" title="logs">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">LOGS</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-4 w-full">
            <div class="flex flex-col justify-center items-center">
                <button id="dropdown" data-dropdown-toggle="dropdownMenu" class="flex items-center justify-center gap-2 px-2 font-medium" type="button">
                    @if($user->icon)
                        <img src="{{ asset('storage/account/'.$user->id.'/'.$user->icon) }}" alt="{{ $user->name }}" class="w-8 h-8 object-cover rounded-full">
                    @else
                        <img src="{{ asset('storage/person-circle.svg') }}" alt="{{ $user->name }}" class="w-6 h-6">
                    @endif
                    <div class="">{{ $user->name }}</div>
                    <img src="{{ asset('/storage/chevron-down.svg') }}" alt="↓">
                </button>
                <div class="garnet-line w-full !h-0.5"></div>
                <div id="dropdownMenu" class="flex flex-col justify-center items-start gap-4 py-2 px-4 bg-[#800000] rounded-lg hidden">
                    @foreach($users as $usr)
                        <a href="{{ route('logs.show', [$year, $month, $usr->id]) }}" class="flex items-center gap-2 border-b pb-1">
                            @if($usr->icon)
                                <img src="{{ asset('storage/account/'.$usr->id.'/'.$usr->icon) }}" alt="{{ $usr->name }}" class="w-8 h-8 object-cover rounded-full">
                            @else
                                <img src="{{ asset('storage/person-circle.svg') }}" alt="{{ $usr->name }}" class="w-8 h-8">
                            @endif
                            <div class="">{{ $usr->name }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="w-full flex justify-between items-center">
                <a href="{{ route('logs.show', [$prev_month->format('Y'), $prev_month->format('m'), $user->id]) }}" class="rounded-lg border border-gray-300 py-2 px-4 hover:bg-gray-100 hover:text-[#800000] duration-500">
                    {{ __('← '.$prev_month->format('n月')) }}
                </a>
                <div class="text-xl garnet">
                    {{ date('M', strtotime($year.'-'.$month)) }}
                </div>
                <a href="{{ route('logs.show', [$next_month->format('Y'), $next_month->format('m'), $user->id]) }}" class="rounded-lg border border-gray-300 py-2 px-4 hover:bg-gray-100 hover:text-[#800000] duration-500">
                    {{ __($next_month->format('n月').' →') }}
                </a>
            </div>
            <table class="w-full max-w-md table-fixed">
                <thead>
                    <tr>
                        @foreach($weekdays as $weekday)
                            <th>{{ $weekday }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($dates as $index => $date)
                        @if($index % 7 === 0)
                            <tr>
                        @endif
                        <td class="align-top">
                            <div class="flex flex-col justify-start items-center p-0.5">
                                <div class="text-xs">{{ date('j', strtotime($date['date'])) }}</div>
                                <a href="{{ route('logs.view', [$date['date'], $user->id]) }}" class="flex flex-col justify-center items-center min-h-12">
                                    @if($date['rank'])
                                        <img src="{{ asset('storage/icons/'.$date['rank']->icon) }}" alt="{{ $date['rank']->eng_name }}" class="h-8">
                                        <div class="text-xs break-all text-center">
                                            {{ $date['rank']->ja_name }}
                                        </div>
                                    @endif
                                </a>
                            </div>
                        </td>
                        @if($index % 7 === 6)
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.year = @json($year);
        window.Laravel.month = @json($month);
        window.Laravel.dates = @json($dates);
        window.Laravel.prev_month = @json($prev_month);
        window.Laravel.next_month = @json($next_month);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/log/logs.js'])
</x-template>
