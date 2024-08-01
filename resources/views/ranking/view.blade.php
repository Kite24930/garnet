<x-template css="score.css" title="ranking">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">RANKING</div>
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
            @switch($type)
                @case('total')
                    <div class="text-2xl">通算ランキング</div>
                    <a href="{{ route('ranking.monthly') }}" class="entry-btn py-2 px-4 text-gray-600">月間ランキング</a>
                    @break
                @case('monthly')
                    <div class="text-2xl">{{ __(date('n', strtotime($month)).'月度ランキング') }}</div>
                    <input id="targetMonth" type="month" class="bg-transparent rounded" value="{{ date('Y-m', strtotime($month)) }}">
                    <a href="{{ route('ranking.total') }}" class="entry-btn py-2 px-4 text-gray-600">通算ランキング</a>
                    @break
            @endswitch

            <div class="w-full max-w-md flex flex-col justify-center items-center">
                <div class="w-full flex items-end justify-center gap-2">
                    <button type="button" class="border-gray-300 flex-1 eng-title py-2 text-xl px-6 major-tag rounded-t-lg border" id="scoreTag" data-tag="scoreWrapper">
                        SCORE
                        <div class="garnet-line w-full"></div>
                    </button>
                    <button type="button" class="border-gray-300 flex-1 eng-title py-2 text-xl px-6 major-tag rounded-t-lg" id="badgeTag" data-tag="badgeWrapper">
                        BADGE
                    </button>
                </div>
                <div id="scoreWrapper" class="w-full border rounded-b-lg flex flex-col gap-4 p-4 major-wrapper">
                    <div class="garnet">SCORE RANKING</div>
                    @foreach($ranking as $key => $rank)
                        <div class="border flex flex-col w-full">
                            <div class="py-2 px-4 flex justify-between items-center score-tag" data-target="{{ __($key.'Wrapper') }}">
                                <div class="font-bold">{{ __($rank['label']) }}</div>
                                <img src="{{ asset('storage/plus-circle.svg') }}" alt="+">
                            </div>
                            <div id="{{ __($key.'Wrapper') }}" class="px-4 flex flex-col gap-4 items-start justify-center score-wrapper border-t overflow-hidden h-0">
                                @foreach($rank as $index => $item)
                                    @if($index == 'label')
                                        @continue
                                    @endif
                                    @switch($index)
                                        @case(0)
                                            <div class="w-full flex flex-col gap-1">
                                                <div class="garnet text-xl flex items-center">
                                                    <img src="{{ asset('storage/icons/gold.png') }}" alt="GOLD" class="inline-block h-10 mr-2">
                                                    <div class="flex items-end text-xl garnet">
                                                        <span class="text-3xl garnet">1</span>st
                                                    </div>
                                                </div>
                                                <div class="px-2 text-xl flex justify-between items-end">
                                                    {{ $item['user']['name'] }}
                                                    <span class="text-base">
                                                        @if($key === 'rbi' || $key === 'sb')
                                                            {{ $item[$key] }}
                                                        @else
                                                            {{ number_format($item[$key], 3) }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="w-full garnet-line !h-0.5"></div>
                                            </div>
                                            @break
                                        @case(1)
                                            <div class="w-full flex flex-col gap-1">
                                                <div class="garnet text-lg flex items-center">
                                                    <img src="{{ asset('storage/icons/silver.png') }}" alt="SILVER" class="inline-block h-8 mr-2">
                                                    <div class="flex items-end text-lg garnet">
                                                        <span class="text-2xl garnet">2</span>nd
                                                    </div>
                                                </div>
                                                <div class="px-2 text-lg flex justify-between items-end">
                                                    {{ $item['user']['name'] }}
                                                    <span class="text-sm">
                                                        @if($key === 'rbi' || $key === 'sb')
                                                            {{ $item[$key] }}
                                                        @else
                                                            {{ number_format($item[$key], 3) }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="w-full garnet-line !h-0.5"></div>
                                            </div>
                                            @break
                                        @case(2)
                                            <div class="w-full flex flex-col gap-1">
                                                <div class="garnet text-lg flex items-center">
                                                    <img src="{{ asset('storage/icons/bronze.png') }}" alt="BRONZE" class="inline-block h-6 mr-2">
                                                    <div class="flex items-end text-lg garnet">
                                                        <span class="text-xl garnet">3</span>rd
                                                    </div>
                                                </div>
                                                <div class="px-2 text-base flex justify-between items-end">
                                                    {{ $item['user']['name'] }}
                                                <span class="text-xs">
                                                    @if($key === 'rbi' || $key === 'sb')
                                                        {{ $item[$key] }}
                                                    @else
                                                        {{ number_format($item[$key], 3) }}
                                                    @endif
                                                </span>
                                                </div>
                                                <div class="w-full garnet-line !h-0.5"></div>
                                            </div>
                                            @break
                                        @default
                                            <div class="w-full flex flex-col gap-1">
                                                <div class="garnet text-sm"><span class="text-lg garnet">4</span>th</div>
                                                <div class="px-2 text-sm flex justify-between items-end">
                                                    {{ $item['user']['name'] }}
                                                    <span class="text-xs">
                                                        @if($key === 'rbi' || $key === 'sb')
                                                            {{ $item[$key] }}
                                                        @else
                                                            {{ number_format($item[$key], 3) }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="w-full garnet-line !h-0.5"></div>
                                            </div>
                                            @break
                                    @endswitch
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="badgeWrapper" class="w-full border rounded-b-lg flex flex-col gap-4 p-4 hidden major-wrapper">
                    <div class="garnet">BADGE RANKING</div>
                    <div class="border flex flex-col w-full">
                        <div class="py-2 px-4 flex justify-between items-center score-tag" data-target="{{ __('rankDayWrapper') }}">
                            <div class="font-bold">{{ __('バッジポイント') }}</div>
                            <img src="{{ asset('storage/plus-circle.svg') }}" alt="+">
                        </div>
                        <div id="rankDayWrapper" class="px-4 flex flex-col gap-4 items-start justify-center score-wrapper border-t overflow-hidden h-0">
                            <div class="flex flex-col gap-4 items-start justify-center w-full">
                                @foreach($badge_ranking['day_rank_count']['all'] as $index => $item)
                                    @if($index == 'label')
                                        @continue
                                    @endif
                                    @switch($index)
                                        @case(0)
                                            <div class="w-full flex flex-col gap-1">
                                                <div class="garnet text-xl flex items-center">
                                                    <img src="{{ asset('storage/icons/gold.png') }}" alt="GOLD" class="inline-block h-10 mr-2">
                                                    <div class="flex items-end text-xl garnet">
                                                        <span class="text-3xl garnet">1</span>st
                                                    </div>
                                                </div>
                                                <div class="px-2 text-xl flex justify-between items-end">
                                                    {{ $item['user']['name'] }}
                                                    <span class="text-base">
                                                        {{ $item['day_rank_count']['all'] }}
                                                    </span>
                                                </div>
                                                <div class="w-full garnet-line !h-0.5"></div>
                                            </div>
                                            @break
                                        @case(1)
                                            <div class="w-full flex flex-col gap-1">
                                                <div class="garnet text-lg flex items-center">
                                                    <img src="{{ asset('storage/icons/silver.png') }}" alt="SILVER" class="inline-block h-8 mr-2">
                                                    <div class="flex items-end text-lg garnet">
                                                        <span class="text-2xl garnet">2</span>nd
                                                    </div>
                                                </div>
                                                <div class="px-2 text-lg flex justify-between items-end">
                                                    {{ $item['user']['name'] }}
                                                    <span class="text-sm">
                                                            {{ $item['day_rank_count']['all'] }}
                                                        </span>
                                                </div>
                                                <div class="w-full garnet-line !h-0.5"></div>
                                            </div>
                                            @break
                                        @case(2)
                                            <div class="w-full flex flex-col gap-1">
                                                <div class="garnet text-lg flex items-center">
                                                    <img src="{{ asset('storage/icons/bronze.png') }}" alt="BRONZE" class="inline-block h-6 mr-2">
                                                    <div class="flex items-end text-lg garnet">
                                                        <span class="text-xl garnet">3</span>rd
                                                    </div>
                                                </div>
                                                <div class="px-2 text-base flex justify-between items-end">
                                                    {{ $item['user']['name'] }}
                                                    <span class="text-xs">
                                                            {{ $item['day_rank_count']['all'] }}
                                                        </span>
                                                </div>
                                                <div class="w-full garnet-line !h-0.5"></div>
                                            </div>
                                            @break
                                        @default
                                            <div class="w-full flex flex-col gap-1">
                                                <div class="garnet text-sm"><span class="text-lg garnet">4</span>th</div>
                                                <div class="px-2 text-sm flex justify-between items-end">
                                                    {{ $item['user']['name'] }}
                                                    <span class="text-xs">
                                                        {{ $item['day_rank_count']['all'] }}
                                                    </span>
                                                </div>
                                                <div class="w-full garnet-line !h-0.5"></div>
                                            </div>
                                            @break
                                    @endswitch
                                @endforeach
                            </div>
                            @foreach($badge_ranking['day_rank_count'] as $key => $rank)
                                @if($key === 'all') @continue @endif
                                <div class="border flex flex-col w-full">
                                    <div class="py-2 px-4 flex justify-between items-center score-tag" data-target="{{ __($key.'DayWrapper') }}">
                                        <div class="font-bold">{{ __($key.' 獲得回数') }}</div>
                                        <img src="{{ asset('storage/plus-circle.svg') }}" alt="+">
                                    </div>
                                    <div id="{{ __($key.'DayWrapper') }}" class="px-4 flex flex-col gap-4 items-start justify-center score-wrapper border-t overflow-hidden h-0">
                                        @foreach($rank as $index => $item)
                                            @if($index == 'label')
                                                @continue
                                            @endif
                                            @switch($index)
                                                @case(0)
                                                    <div class="w-full flex flex-col gap-1">
                                                        <div class="garnet text-xl flex items-center">
                                                            <img src="{{ asset('storage/icons/gold.png') }}" alt="GOLD" class="inline-block h-10 mr-2">
                                                            <div class="flex items-end text-xl garnet">
                                                                <span class="text-3xl garnet">1</span>st
                                                            </div>
                                                        </div>
                                                        <div class="px-2 text-xl flex justify-between items-end">
                                                            {{ $item['user']['name'] }}
                                                            <span class="text-base">
                                                                {{ $item['day_rank_count'][$key] }}
                                                            </span>
                                                        </div>
                                                        <div class="w-full garnet-line !h-0.5"></div>
                                                    </div>
                                                    @break
                                                @case(1)
                                                    <div class="w-full flex flex-col gap-1">
                                                        <div class="garnet text-lg flex items-center">
                                                            <img src="{{ asset('storage/icons/silver.png') }}" alt="SILVER" class="inline-block h-8 mr-2">
                                                            <div class="flex items-end text-lg garnet">
                                                                <span class="text-2xl garnet">2</span>nd
                                                            </div>
                                                        </div>
                                                        <div class="px-2 text-lg flex justify-between items-end">
                                                            {{ $item['user']['name'] }}
                                                            <span class="text-sm">
                                                                {{ $item['day_rank_count'][$key] }}
                                                            </span>
                                                        </div>
                                                        <div class="w-full garnet-line !h-0.5"></div>
                                                    </div>
                                                    @break
                                                @case(2)
                                                    <div class="w-full flex flex-col gap-1">
                                                        <div class="garnet text-lg flex items-center">
                                                            <img src="{{ asset('storage/icons/bronze.png') }}" alt="BRONZE" class="inline-block h-6 mr-2">
                                                            <div class="flex items-end text-lg garnet">
                                                                <span class="text-xl garnet">3</span>rd
                                                            </div>
                                                        </div>
                                                        <div class="px-2 text-base flex justify-between items-end">
                                                            {{ $item['user']['name'] }}
                                                            <span class="text-xs">
                                                                {{ $item['day_rank_count'][$key] }}
                                                            </span>
                                                        </div>
                                                        <div class="w-full garnet-line !h-0.5"></div>
                                                    </div>
                                                    @break
                                                @default
                                                    <div class="w-full flex flex-col gap-1">
                                                        <div class="garnet text-sm"><span class="text-lg garnet">4</span>th</div>
                                                        <div class="px-2 text-sm flex justify-between items-end">
                                                            {{ $item['user']['name'] }}
                                                            <span class="text-xs">
                                                                {{ $item['day_rank_count'][$key] }}
                                                            </span>
                                                        </div>
                                                        <div class="w-full garnet-line !h-0.5"></div>
                                                    </div>
                                                    @break
                                            @endswitch
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="border flex flex-col w-full">
                        <div class="py-2 px-4 flex justify-between items-center score-tag" data-target="{{ __('rankWrapper') }}">
                            <div class="font-bold">{{ __('タスクポイント') }}</div>
                            <img src="{{ asset('storage/plus-circle.svg') }}" alt="+">
                        </div>
                        <div id="rankWrapper" class="px-4 flex flex-col gap-4 items-start justify-center score-wrapper border-t overflow-hidden h-0">
                            <div class="flex flex-col gap-4 items-start justify-center w-full">
                                @foreach($badge_ranking['rank_count']['all'] as $index => $item)
                                    @if($index == 'label')
                                        @continue
                                    @endif
                                    @switch($index)
                                        @case(0)
                                            <div class="w-full flex flex-col gap-1">
                                                <div class="garnet text-xl flex items-center">
                                                    <img src="{{ asset('storage/icons/gold.png') }}" alt="GOLD" class="inline-block h-10 mr-2">
                                                    <div class="flex items-end text-xl garnet">
                                                        <span class="text-3xl garnet">1</span>st
                                                    </div>
                                                </div>
                                                <div class="px-2 text-xl flex justify-between items-end">
                                                    {{ $item['user']['name'] }}
                                                    <span class="text-base">
                                                        {{ $item['rank_count']['all'] }}
                                                    </span>
                                                </div>
                                                <div class="w-full garnet-line !h-0.5"></div>
                                            </div>
                                            @break
                                        @case(1)
                                            <div class="w-full flex flex-col gap-1">
                                                <div class="garnet text-lg flex items-center">
                                                    <img src="{{ asset('storage/icons/silver.png') }}" alt="SILVER" class="inline-block h-8 mr-2">
                                                    <div class="flex items-end text-lg garnet">
                                                        <span class="text-2xl garnet">2</span>nd
                                                    </div>
                                                </div>
                                                <div class="px-2 text-lg flex justify-between items-end">
                                                    {{ $item['user']['name'] }}
                                                    <span class="text-sm">
                                                            {{ $item['rank_count']['all'] }}
                                                        </span>
                                                </div>
                                                <div class="w-full garnet-line !h-0.5"></div>
                                            </div>
                                            @break
                                        @case(2)
                                            <div class="w-full flex flex-col gap-1">
                                                <div class="garnet text-lg flex items-center">
                                                    <img src="{{ asset('storage/icons/bronze.png') }}" alt="BRONZE" class="inline-block h-6 mr-2">
                                                    <div class="flex items-end text-lg garnet">
                                                        <span class="text-xl garnet">3</span>rd
                                                    </div>
                                                </div>
                                                <div class="px-2 text-base flex justify-between items-end">
                                                    {{ $item['user']['name'] }}
                                                    <span class="text-xs">
                                                            {{ $item['rank_count']['all'] }}
                                                        </span>
                                                </div>
                                                <div class="w-full garnet-line !h-0.5"></div>
                                            </div>
                                            @break
                                        @default
                                            <div class="w-full flex flex-col gap-1">
                                                <div class="garnet text-sm"><span class="text-lg garnet">4</span>th</div>
                                                <div class="px-2 text-sm flex justify-between items-end">
                                                    {{ $item['user']['name'] }}
                                                    <span class="text-xs">
                                                        {{ $item['rank_count']['all'] }}
                                                    </span>
                                                </div>
                                                <div class="w-full garnet-line !h-0.5"></div>
                                            </div>
                                            @break
                                    @endswitch
                                @endforeach
                            </div>
                            @foreach($badge_ranking['rank_count'] as $key => $rank)
                                @if($key === 'all') @continue @endif
                                <div class="border flex flex-col w-full">
                                    <div class="py-2 px-4 flex justify-between items-center score-tag" data-target="{{ __($key.'Wrapper') }}">
                                        <div class="font-bold">{{ __($key.' 実施回数') }}</div>
                                        <img src="{{ asset('storage/plus-circle.svg') }}" alt="+">
                                    </div>
                                    <div id="{{ __($key.'Wrapper') }}" class="px-4 flex flex-col gap-4 items-start justify-center score-wrapper border-t overflow-hidden h-0">
                                        @foreach($rank as $index => $item)
                                            @if($index == 'label')
                                                @continue
                                            @endif
                                            @switch($index)
                                                @case(0)
                                                    <div class="w-full flex flex-col gap-1">
                                                        <div class="garnet text-xl flex items-center">
                                                            <img src="{{ asset('storage/icons/gold.png') }}" alt="GOLD" class="inline-block h-10 mr-2">
                                                            <div class="flex items-end text-xl garnet">
                                                                <span class="text-3xl garnet">1</span>st
                                                            </div>
                                                        </div>
                                                        <div class="px-2 text-xl flex justify-between items-end">
                                                            {{ $item['user']['name'] }}
                                                            <span class="text-base">
                                                                {{ $item['rank_count'][$key] }}
                                                            </span>
                                                        </div>
                                                        <div class="w-full garnet-line !h-0.5"></div>
                                                    </div>
                                                    @break
                                                @case(1)
                                                    <div class="w-full flex flex-col gap-1">
                                                        <div class="garnet text-lg flex items-center">
                                                            <img src="{{ asset('storage/icons/silver.png') }}" alt="SILVER" class="inline-block h-8 mr-2">
                                                            <div class="flex items-end text-lg garnet">
                                                                <span class="text-2xl garnet">2</span>nd
                                                            </div>
                                                        </div>
                                                        <div class="px-2 text-lg flex justify-between items-end">
                                                            {{ $item['user']['name'] }}
                                                            <span class="text-sm">
                                                                {{ $item['rank_count'][$key] }}
                                                            </span>
                                                        </div>
                                                        <div class="w-full garnet-line !h-0.5"></div>
                                                    </div>
                                                    @break
                                                @case(2)
                                                    <div class="w-full flex flex-col gap-1">
                                                        <div class="garnet text-lg flex items-center">
                                                            <img src="{{ asset('storage/icons/bronze.png') }}" alt="BRONZE" class="inline-block h-6 mr-2">
                                                            <div class="flex items-end text-lg garnet">
                                                                <span class="text-xl garnet">3</span>rd
                                                            </div>
                                                        </div>
                                                        <div class="px-2 text-base flex justify-between items-end">
                                                            {{ $item['user']['name'] }}
                                                            <span class="text-xs">
                                                                {{ $item['rank_count'][$key] }}
                                                            </span>
                                                        </div>
                                                        <div class="w-full garnet-line !h-0.5"></div>
                                                    </div>
                                                    @break
                                                @default
                                                    <div class="w-full flex flex-col gap-1">
                                                        <div class="garnet text-sm"><span class="text-lg garnet">4</span>th</div>
                                                        <div class="px-2 text-sm flex justify-between items-end">
                                                            {{ $item['user']['name'] }}
                                                            <span class="text-xs">
                                                                {{ $item['rank_count'][$key] }}
                                                            </span>
                                                        </div>
                                                        <div class="w-full garnet-line !h-0.5"></div>
                                                    </div>
                                                    @break
                                            @endswitch
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.scores = @json($scores);
        window.Laravel.ranking = @json($ranking);
        window.Laravel.badge_ranking = @json($badge_ranking);
        window.Laravel.ranking_label = @json($ranking_label);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/score/ranking.js'])
</x-template>
