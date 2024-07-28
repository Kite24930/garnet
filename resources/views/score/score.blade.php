<x-template css="score.css" title="score">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">SCORE</div>
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
                        <a href="{{ route('score', $usr->id) }}" class="flex items-center gap-2 border-b pb-1">
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
            <a href="{{ route('score.new') }}" class="entry-btn bottom-4 right-4 py-2 px-4 text-gray-600 garnet">New Score</a>
            <div class="flex flex-col items-center justify-center gap-6 w-full">
                @if($game_count !== 0)
                    <div class="flex flex-col items-start gap-2 w-full">
                        <div id="pitcher" class="w-full">
                            <div class="px-2 flex items-center justify-between">
                                <div class="eng-italic">Pitcher</div>
                                <img src="{{ asset('storage/plus-circle.svg') }}" alt="+">
                            </div>
                            <div class="garnet-line w-full !h-0.5"></div>
                        </div>
                        <div id="pitcher_area" class="flex flex-col items-center gap-2 px-6 overflow-hidden h-0 duration-500 rounded-lg w-full">
                            <div class="flex flex-col gap-2">
                                <x-parts.score-item item_name="{{ __('勝利投手回数') }}" :item_value="$all_data['win'].'回'" />
                                <x-parts.score-item item_name="{{ __('負け投手回数') }}" :item_value="$all_data['lose'].'回'" />
                                <x-parts.score-item item_name="{{ __('セーブ回数') }}" :item_value="$all_data['save'].'回'" />
                                <x-parts.score-item item_name="{{ __('ホールド回数') }}" :item_value="$all_data['hold'].'回'" />
                                <x-parts.score-item item_name="{{ __('勝率') }}" :item_value="number_format($all_data['win']/$game_count, 3)" />
                                @if($all_data['fine_inning'] % 3 === 0)
                                    <x-parts.score-item item_name="{{ __('投球回数') }}" :item_value="($all_data['inning'] + intdiv($all_data['fine_inning'], 3)).'回'" />
                                @else
                                    <x-parts.score-item item_name="{{ __('投球回数') }}" :item_value="($all_data['inning'] + intdiv($all_data['fine_inning'], 3)).' '.($all_data['fine_inning'] % 3).'/3 回'" />
                                @endif
                                <x-parts.score-item item_name="{{ __('対戦打者数') }}" :item_value="$all_data['batter_count'].'人'" />
                                @if(($all_data['inning'] + ($all_data['fine_inning'] / 3)) !== 0)
                                    <x-parts.score-item item_name="{{ __('防御率') }}" :item_value="number_format(($all_data['earned_run'] * 9) / ($all_data['inning'] + ($all_data['fine_inning'] / 3)), 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('防御率') }}" :item_value="__('-')" />
                                @endif
                                <x-parts.score-item item_name="{{ __('投球数') }}" :item_value="$all_data['pitch_count'].'球'" />
                                @if(($all_data['inning'] + ($all_data['fine_inning'] / 3)) !== 0)
                                    <x-parts.score-item item_name="{{ __('回あたり投球数') }}" :item_value="number_format($all_data['pitch_count'] / ($all_data['inning'] + ($all_data['fine_inning'] / 3)), 1).'球'" />
                                @else
                                    <x-parts.score-item item_name="{{ __('回あたり投球数') }}" :item_value="__('-')" />
                                @endif
                                @if($all_data['pitch_count'] !== 0)
                                    <x-parts.score-item item_name="{{ __('ストライク率') }}" :item_value="number_format($all_data['strike'] / $all_data['pitch_count'], 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('ストライク率') }}" :item_value="__('-')" />
                                @endif
                                <x-parts.score-item item_name="{{ __('奪三振数') }}" :item_value="$all_data['strikeout'].'個'" />
                                @if($all_data['batter_count'] !== 0)
                                    <x-parts.score-item item_name="{{ __('奪三振率') }}" :item_value="number_format(($all_data['strikeout']) / ($all_data['batter_count']), 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('奪三振率') }}" :item_value="__('-')" />
                                @endif
                                <x-parts.score-item item_name="{{ __('被安打数') }}" :item_value="($all_data['single_hits_allowed'] + $all_data['double_hits_allowed'] + $all_data['triple_hits_allowed'] + $all_data['homerun_allowed']).'個'" />
                                <x-parts.score-item item_name="{{ __('与四球数') }}" :item_value="$all_data['base_on_balls'].'個'" />
                                @if(($all_data['inning'] + ($all_data['fine_inning'] / 3)) !== 0)
                                    <x-parts.score-item item_name="{{ __('与四球率') }}" :item_value="number_format(($all_data['base_on_balls'] * 9) / ($all_data['inning'] + ($all_data['fine_inning'] / 3)), 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('与四球率') }}" :item_value="__('-')" />
                                @endif
                                <x-parts.score-item item_name="{{ __('与死球数') }}" :item_value="$all_data['hit_by_pitch'].'個'" />
                                @if(($all_data['inning'] + ($all_data['fine_inning'] / 3)) !== 0)
                                    <x-parts.score-item item_name="{{ __('与死球率') }}" :item_value="number_format(($all_data['hit_by_pitch'] * 9) / ($all_data['inning'] + ($all_data['fine_inning'] / 3)), 3)" />
                                    <x-parts.score-item item_name="{{ __('与四死球率') }}" :item_value="number_format((($all_data['base_on_balls'] + $all_data['hit_by_pitch']) * 9) / ($all_data['inning'] + ($all_data['fine_inning'] / 3)), 3)" />
                                    <x-parts.score-item item_name="{{ __('WHIP') }}" :item_value="number_format(($all_data['single_hits_allowed'] + $all_data['double_hits_allowed'] + $all_data['triple_hits_allowed'] + $all_data['homerun_allowed'] + $all_data['base_on_balls']) / ($all_data['inning'] + ($all_data['fine_inning'] / 3)), 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('与死球率') }}" :item_value="__('-')" />
                                    <x-parts.score-item item_name="{{ __('与四死球率') }}" :item_value="__('-')" />
                                    <x-parts.score-item item_name="{{ __('WHIP') }}" :item_value="__('-')" />
                                @endif
                                @if(($all_data['ground_out'] + $all_data['fly_out'] + $all_data['line_out']) !== 0)
                                    <x-parts.score-item item_name="{{ __('ゴロアウト率') }}" :item_value="number_format($all_data['ground_out'] / ($all_data['ground_out'] + $all_data['fly_out'] + $all_data['line_out']), 3)" />
                                    <x-parts.score-item item_name="{{ __('フライアウト率') }}" :item_value="number_format($all_data['fly_out'] / ($all_data['ground_out'] + $all_data['fly_out'] + $all_data['line_out']), 3)" />
                                    <x-parts.score-item item_name="{{ __('ライナーアウト率') }}" :item_value="number_format($all_data['line_out'] / ($all_data['ground_out'] + $all_data['fly_out'] + $all_data['line_out']), 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('ゴロアウト率') }}" :item_value="__('-')" />
                                    <x-parts.score-item item_name="{{ __('フライアウト率') }}" :item_value="__('-')" />
                                    <x-parts.score-item item_name="{{ __('ライナーアウト率') }}" :item_value="__('-')" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-start gap-2 w-full">
                        <div id="batter" class="w-full">
                            <div class="px-2 flex items-center justify-between">
                                <div class="eng-italic">Batter</div>
                                <img src="{{ asset('storage/plus-circle.svg') }}" alt="+">
                            </div>
                            <div class="garnet-line w-full !h-0.5"></div>
                        </div>
                        <div id="batter_area" class="flex flex-col items-center gap-2 px-6 overflow-hidden h-0 duration-500 rounded-lg w-full">
                            <div class="flex flex-col gap-2">
                                <x-parts.score-item item_name="{{ __('打席数') }}" :item_value="$all_data['hitting'].'打席'" />
                                <x-parts.score-item item_name="{{ __('打数') }}" :item_value="($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])).'打数'" />
                                <x-parts.score-item item_name="{{ __('安打数') }}" :item_value="($all_data['single_hits'] + $all_data['double_hits'] + $all_data['triple_hits'] + $all_data['homerun']).'安打'" />
                                @if(($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])) !== 0)
                                    <x-parts.score-item item_name="{{ __('打率') }}" :item_value="number_format(($all_data['single_hits'] + $all_data['double_hits'] + $all_data['triple_hits'] + $all_data['homerun']) / ($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])), 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('打率') }}" :item_value="__('-')" />
                                @endif
                                <x-parts.score-item item_name="{{ __('単打数') }}" :item_value="$all_data['single_hits'].'本'" />
                                <x-parts.score-item item_name="{{ __('二塁打数') }}" :item_value="$all_data['double_hits'].'本'" />
                                <x-parts.score-item item_name="{{ __('三塁打数') }}" :item_value="$all_data['triple_hits'].'本'" />
                                <x-parts.score-item item_name="{{ __('本塁打数') }}" :item_value="$all_data['homerun'].'本'" />
                                <x-parts.score-item item_name="{{ __('打点数') }}" :item_value="$all_data['runs_batted_in'].'点'" />
                                <x-parts.score-item item_name="{{ __('得点数') }}" :item_value="$all_data['runs'].'点'" />
                                <x-parts.score-item item_name="{{ __('四球数') }}" :item_value="$all_data['four_balls'].'個'" />
                                <x-parts.score-item item_name="{{ __('死球数') }}" :item_value="$all_data['dead_balls'].'個'" />
                                <x-parts.score-item item_name="{{ __('犠打数') }}" :item_value="$all_data['sacrifice_bunt'].'個'" />
                                <x-parts.score-item item_name="{{ __('犠飛数') }}" :item_value="$all_data['sacrifice_fly'].'個'" />
                                <x-parts.score-item item_name="{{ __('盗塁数') }}" :item_value="$all_data['stolen_bases'].'個'" />
                                <x-parts.score-item item_name="{{ __('盗塁死数') }}" :item_value="$all_data['caught_stealing'].'個'" />
                                @if($all_data['stolen_bases'] !== 0)
                                    <x-parts.score-item item_name="{{ __('盗塁成功率') }}" :item_value="number_format($all_data['stolen_bases'] / ($all_data['stolen_bases'] + $all_data['caught_stealing']), 3)" />
                                @endif
                                @if(($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])) !== 0)
                                    <x-parts.score-item item_name="{{ __('長打率') }}" :item_value="number_format(($all_data['single_hits'] + 2 * $all_data['double_hits'] + 3 * $all_data['triple_hits'] + 4 * $all_data['homerun']) / ($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])), 3)" />
                                @endif
                                <x-parts.score-item item_name="{{ __('出塁数') }}" :item_value="$all_data['times_on_base'].'個'" />
                                @if(($all_data['hitting'] - $all_data['sacrifice_bunt']) !== 0)
                                    <x-parts.score-item item_name="{{ __('出塁率') }}" :item_value="number_format(($all_data['single_hits'] + $all_data['double_hits'] + $all_data['triple_hits'] + $all_data['homerun'] + $all_data['four_balls'] + $all_data['dead_balls']) / ($all_data['hitting'] - $all_data['sacrifice_bunt']), 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('出塁率') }}" :item_value="__('-')" />
                                @endif
                                @if(($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])) !== 0 && ($all_data['hitting'] - $all_data['sacrifice_bunt']) !== 0)
                                    <x-parts.score-item item_name="{{ __('OPS') }}" :item_value="number_format(($all_data['single_hits'] + 2 * $all_data['double_hits'] + 3 * $all_data['triple_hits'] + 4 * $all_data['homerun']) / ($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])) + ($all_data['single_hits'] + $all_data['double_hits'] + $all_data['triple_hits'] + $all_data['homerun'] + $all_data['four_balls'] + $all_data['dead_balls']) / ($all_data['hitting'] - $all_data['sacrifice_bunt']), 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('OPS') }}" :item_value="__('-')" />
                                @endif
                                @if(($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])) !== 0 && ($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])) !== 0)
                                    <x-parts.score-item item_name="{{ __('ISO') }}" :item_value="number_format(($all_data['single_hits'] + 2 * $all_data['double_hits'] + 3 * $all_data['triple_hits'] + 4 * $all_data['homerun']) / ($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])) - ($all_data['single_hits'] + $all_data['double_hits'] + $all_data['triple_hits'] + $all_data['homerun']) / ($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])), 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('ISO') }}" :item_value="__('-')" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-start gap-2 w-full">
                        <div id="defense" class="w-full">
                            <div class="px-2 flex items-center justify-between">
                                <div class="eng-italic">Defense</div>
                                <img src="{{ asset('storage/plus-circle.svg') }}" alt="+">
                            </div>
                            <div class="garnet-line w-full !h-0.5"></div>
                        </div>
                        <div id="defense_area" class="flex flex-col items-center gap-2 px-6 overflow-hidden h-0 duration-500 rounded-lg w-full">
                            <div class="flex flex-col gap-2">
                                @if($all_data['defense_fine_inning'] % 3 === 0)
                                    <x-parts.score-item item_name="{{ __('守備回数') }}" :item_value="($all_data['defense_inning'] + ($all_data['defense_fine_inning'] / 3)).'回'" />
                                @else
                                    <x-parts.score-item item_name="{{ __('守備回数') }}" :item_value="($all_data['defense_inning'] + intdiv($all_data['defense_fine_inning'], 3)).' '.($all_data['defense_fine_inning'] % 3).'/3 回'" />
                                @endif
                                <x-parts.score-item item_name="{{ __('守備機会') }}" :item_value="$all_data['defense_chance'].'回'" />
                                <x-parts.score-item item_name="{{ __('刺殺数') }}" :item_value="$all_data['outs'].'個'" />
                                <x-parts.score-item item_name="{{ __('補殺数') }}" :item_value="$all_data['assists'].'個'" />
                                <x-parts.score-item item_name="{{ __('併殺数') }}" :item_value="$all_data['double_play'].'個'" />
                                <x-parts.score-item item_name="{{ __('失策数(捕失)') }}" :item_value="$all_data['errors'].'個'" />
                                <x-parts.score-item item_name="{{ __('失策数(投失)') }}" :item_value="$all_data['errors_wild_pitch'].'個'" />
                                @if(($all_data['outs'] + $all_data['assists'] + $all_data['errors'] + $all_data['errors_wild_pitch']) !== 0)
                                    <x-parts.score-item item_name="{{ __('守備率') }}" :item_value="number_format(($all_data['outs'] + $all_data['assists']) / ($all_data['outs'] + $all_data['assists'] + $all_data['errors'] + $all_data['errors_wild_pitch']), 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('守備率') }}" :item_value="__('-')" />
                                @endif
                                @if(($all_data['defense_inning'] + ($all_data['defense_fine_inning'] / 3)) !== 0)
                                    <x-parts.score-item item_name="{{ __('Range Factor') }}" :item_value="number_format(($all_data['outs'] + $all_data['assists']) / ($all_data['defense_inning'] + ($all_data['defense_fine_inning'] / 3)). 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('Range Factor') }}" :item_value="__('-')" />
                                @endif
                                <x-parts.score-item item_name="{{ __('捕逸数') }}" :item_value="$all_data['passed_ball'].'個'" />
                                @if(($all_data['steal_allowed'] + $all_data['steal_stopped']) !== 0)
                                    <x-parts.score-item item_name="{{ __('盗塁阻止率') }}" :item_value="number_format($all_data['steal_stopped'] / ($all_data['steal_allowed'] + $all_data['steal_stopped']), 3)" />
                                @else
                                    <x-parts.score-item item_name="{{ __('盗塁阻止率') }}" :item_value="__('-')" />
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                <div class="flex flex-col items-center gap-4 w-full">
                    @foreach($scores as $score)
                        <a href="{{ route('score.view', $score->score_id) }}" class="flex gap-2 items-center">
                            <img src="{{ asset('storage/award.svg') }}" alt="match" class="h-8">
                            <div class="flex flex-col items-start">
                                <div class="text-xs">{{ __($score->date.' '.$score->match_number.'試合目') }}</div>
                                <div class="pl-2">{{ $score->opponent }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.scores = @json($scores);
        window.Laravel.game_count = @json($game_count);
        window.Laravel.all_data = @json($all_data);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/score/score.js'])
</x-template>
