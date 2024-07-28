<x-template css="score.css" title="score">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">SCORE</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-6 w-full">
            <div class="flex items-center justify-between w-full">
                <a href="{{ route('score', $score->user_id) }}" class="entry-btn bottom-4 right-4 py-2 px-4 text-gray-600 garnet">back</a>
                @if(auth()->id() === $score->user_id)
                    <a href="{{ route('score.edit', $score->score_id) }}" class="entry-btn bottom-4 right-4 py-2 px-4 text-gray-600 garnet">edit</a>
                @endif
            </div>
            <div class="flex items-center justify-center gap-2 px-2 font-medium">
                @if($score->user_icon)
                    <img src="{{ asset('storage/account/'.$score->user_id.'/'.$score->user_icon) }}" alt="{{ $score->user_name }}" class="w-8 h-8 object-cover rounded-full">
                @else
                    <img src="{{ asset('storage/person-circle.svg') }}" alt="{{ $score->user_name }}" class="w-6 h-6">
                @endif
                <div class="">{{ $score->user_name }}</div>
            </div>
            <div class="flex flex-col items-center">
                <div class="text-sm">{{ __($score->date.' '.$score->match_number.'試合目') }}</div>
                <div class="pl-2">{{ $score->opponent }}</div>
            </div>
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
                        <x-parts.score-item item_name="{{ __('勝利投手回数') }}" :item_value="$score['win'].'回'" />
                        <x-parts.score-item item_name="{{ __('負け投手回数') }}" :item_value="$score['lose'].'回'" />
                        <x-parts.score-item item_name="{{ __('セーブ回数') }}" :item_value="$score['save'].'回'" />
                        <x-parts.score-item item_name="{{ __('ホールド回数') }}" :item_value="$score['hold'].'回'" />
                        @if($score['fine_inning'] % 3 === 0)
                            <x-parts.score-item item_name="{{ __('投球回数') }}" :item_value="($score['inning'] + intdiv($score['fine_inning'], 3)).'回'" />
                        @else
                            <x-parts.score-item item_name="{{ __('投球回数') }}" :item_value="($score['inning'] + intdiv($score['fine_inning'], 3)).' '.($score['fine_inning'] % 3).'/3 回'" />
                        @endif
                        <x-parts.score-item item_name="{{ __('対戦打者数') }}" :item_value="$score['batter_count'].'人'" />
                        @if(($score['inning'] + ($score['fine_inning'] / 3)) !== 0)
                            <x-parts.score-item item_name="{{ __('防御率') }}" :item_value="number_format(($score['earned_run'] * 9) / ($score['inning'] + ($score['fine_inning'] / 3)), 3)" />
                        @else
                            <x-parts.score-item item_name="{{ __('防御率') }}" :item_value="__('-')" />
                        @endif
                        <x-parts.score-item item_name="{{ __('投球数') }}" :item_value="$score['pitch_count'].'球'" />
                        @if($score['inning'] !== 0 || $score['fine_inning'] !== 0)
                            <x-parts.score-item item_name="{{ __('回あたり投球数') }}" :item_value="number_format($score['pitch_count'] / ($score['inning'] + ($score['fine_inning'] / 3)), 1).'球'" />
                        @else
                            <x-parts.score-item item_name="{{ __('回あたり投球数') }}" :item_value="__('-')" />
                        @endif
                        @if($score['pitch_count'] !== 0)
                            <x-parts.score-item item_name="{{ __('ストライク率') }}" :item_value="number_format($score['strike'] / $score['pitch_count'], 3)" />
                        @else
                            <x-parts.score-item item_name="{{ __('ストライク率') }}" :item_value="__('-')" />
                        @endif
                        <x-parts.score-item item_name="{{ __('奪三振数') }}" :item_value="$score['strikeout'].'個'" />
                        @if($score['batter_count'] !== 0)
                            <x-parts.score-item item_name="{{ __('奪三振率') }}" :item_value="number_format(($score['strikeout']) / ($score['batter_count']), 3)" />
                        @else
                            <x-parts.score-item item_name="{{ __('奪三振率') }}" :item_value="__('-')" />
                        @endif
                        <x-parts.score-item item_name="{{ __('被安打数') }}" :item_value="($score['single_hits_allowed'] + $score['double_hits_allowed'] + $score['triple_hits_allowed'] + $score['homerun_allowed']).'個'" />
                        <x-parts.score-item item_name="{{ __('与四球数') }}" :item_value="$score['base_on_balls'].'個'" />
                        @if($score['inning'] !== 0 || $score['fine_inning'] !== 0)
                            <x-parts.score-item item_name="{{ __('与四球率') }}" :item_value="number_format(($score['base_on_balls'] * 9) / ($score['inning'] + ($score['fine_inning'] / 3)), 3)" />
                        @else
                            <x-parts.score-item item_name="{{ __('与四球率') }}" :item_value="__('-')" />
                        @endif
                        <x-parts.score-item item_name="{{ __('与死球数') }}" :item_value="$score['hit_by_pitch'].'個'" />
                        @if($score['inning'] !== 0 || $score['fine_inning'] !== 0)
                            <x-parts.score-item item_name="{{ __('与死球率') }}" :item_value="number_format(($score['hit_by_pitch'] * 9) / ($score['inning'] + ($score['fine_inning'] / 3)), 3)" />
                            <x-parts.score-item item_name="{{ __('与四死球率') }}" :item_value="number_format((($score['base_on_balls'] + $score['hit_by_pitch']) * 9) / ($score['inning'] + ($score['fine_inning'] / 3)), 3)" />
                            <x-parts.score-item item_name="{{ __('WHIP') }}" :item_value="number_format(($score['single_hits_allowed'] + $score['double_hits_allowed'] + $score['triple_hits_allowed'] + $score['homerun_allowed'] + $score['base_on_balls']) / ($score['inning'] + ($score['fine_inning'] / 3)), 3)" />
                        @else
                            <x-parts.score-item item_name="{{ __('与死球率') }}" :item_value="__('-')" />
                            <x-parts.score-item item_name="{{ __('与四死球率') }}" :item_value="__('-')" />
                            <x-parts.score-item item_name="{{ __('WHIP') }}" :item_value="__('-')" />
                        @endif
                        @if($score['ground_out'] !== 0 || $score['fly_out'] !== 0 || $score['line_out'] !== 0)
                            <x-parts.score-item item_name="{{ __('ゴロアウト率') }}" :item_value="number_format($score['ground_out'] / ($score['ground_out'] + $score['fly_out'] + $score['line_out']), 3)" />
                            <x-parts.score-item item_name="{{ __('フライアウト率') }}" :item_value="number_format($score['fly_out'] / ($score['ground_out'] + $score['fly_out'] + $score['line_out']), 3)" />
                            <x-parts.score-item item_name="{{ __('ライナーアウト率') }}" :item_value="number_format($score['line_out'] / ($score['ground_out'] + $score['fly_out'] + $score['line_out']), 3)" />
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
                        <x-parts.score-item item_name="{{ __('打席数') }}" :item_value="$score['hitting'].'打席'" />
                        <x-parts.score-item item_name="{{ __('打数') }}" :item_value="($score['hitting'] - ($score['four_balls'] + $score['dead_balls'] + $score['sacrifice_bunt'] + $score['sacrifice_fly'])).'打数'" />
                        <x-parts.score-item item_name="{{ __('安打数') }}" :item_value="($score['single_hits'] + $score['double_hits'] + $score['triple_hits'] + $score['homerun']).'安打'" />
                        @if(($score['hitting'] - ($score['four_balls'] + $score['dead_balls'] + $score['sacrifice_bunt'] + $score['sacrifice_fly'])) !== 0)
                            <x-parts.score-item item_name="{{ __('打率') }}" :item_value="number_format(($score['single_hits'] + $score['double_hits'] + $score['triple_hits'] + $score['homerun']) / ($score['hitting'] - ($score['four_balls'] + $score['dead_balls'] + $score['sacrifice_bunt'] + $score['sacrifice_fly'])), 3)" />
                        @else
                            <x-parts.score-item item_name="{{ __('打率') }}" :item_value="__('-')" />
                        @endif
                        <x-parts.score-item item_name="{{ __('単打数') }}" :item_value="$score['single_hits'].'本'" />
                        <x-parts.score-item item_name="{{ __('二塁打数') }}" :item_value="$score['double_hits'].'本'" />
                        <x-parts.score-item item_name="{{ __('三塁打数') }}" :item_value="$score['triple_hits'].'本'" />
                        <x-parts.score-item item_name="{{ __('本塁打数') }}" :item_value="$score['homerun'].'本'" />
                        <x-parts.score-item item_name="{{ __('打点数') }}" :item_value="$score['runs_batted_in'].'点'" />
                        <x-parts.score-item item_name="{{ __('得点数') }}" :item_value="$score['runs'].'点'" />
                        <x-parts.score-item item_name="{{ __('四球数') }}" :item_value="$score['four_balls'].'個'" />
                        <x-parts.score-item item_name="{{ __('死球数') }}" :item_value="$score['dead_balls'].'個'" />
                        <x-parts.score-item item_name="{{ __('犠打数') }}" :item_value="$score['sacrifice_bunt'].'個'" />
                        <x-parts.score-item item_name="{{ __('犠飛数') }}" :item_value="$score['sacrifice_fly'].'個'" />
                        <x-parts.score-item item_name="{{ __('盗塁数') }}" :item_value="$score['stolen_bases'].'個'" />
                        <x-parts.score-item item_name="{{ __('盗塁死数') }}" :item_value="$score['caught_stealing'].'個'" />
                        @if(($score['stolen_bases'] + $score['caught_stealing']) !== 0)
                            <x-parts.score-item item_name="{{ __('盗塁成功率') }}" :item_value="number_format($score['stolen_bases'] / ($score['stolen_bases'] + $score['caught_stealing']), 3)" />
                        @endif
                        @if(($score['hitting'] - ($score['four_balls'] + $score['dead_balls'] + $score['sacrifice_bunt'] + $score['sacrifice_fly'])) !== 0)
                            <x-parts.score-item item_name="{{ __('長打率') }}" :item_value="number_format(($score['single_hits'] + 2 * $score['double_hits'] + 3 * $score['triple_hits'] + 4 * $score['homerun']) / ($score['hitting'] - ($score['four_balls'] + $score['dead_balls'] + $score['sacrifice_bunt'] + $score['sacrifice_fly'])), 3)" />
                        @endif
                        <x-parts.score-item item_name="{{ __('出塁数') }}" :item_value="$score['times_on_base'].'個'" />
                        @if(($score['hitting'] - $score['sacrifice_bunt']) !== 0)
                            <x-parts.score-item item_name="{{ __('出塁率') }}" :item_value="number_format(($score['single_hits'] + $score['double_hits'] + $score['triple_hits'] + $score['homerun'] + $score['four_balls'] + $score['dead_balls']) / ($score['hitting'] - $score['sacrifice_bunt']), 3)" />
                        @else
                            <x-parts.score-item item_name="{{ __('出塁率') }}" :item_value="__('-')" />
                        @endif
                        @if(($score['hitting'] - ($score['four_balls'] + $score['dead_balls'] + $score['sacrifice_bunt'] + $score['sacrifice_fly'])) !== 0 && ($score['hitting'] - $score['sacrifice_bunt']) !== 0)
                            <x-parts.score-item item_name="{{ __('OPS') }}" :item_value="number_format(($score['single_hits'] + 2 * $score['double_hits'] + 3 * $score['triple_hits'] + 4 * $score['homerun']) / ($score['hitting'] - ($score['four_balls'] + $score['dead_balls'] + $score['sacrifice_bunt'] + $score['sacrifice_fly'])) + ($score['single_hits'] + $score['double_hits'] + $score['triple_hits'] + $score['homerun'] + $score['four_balls'] + $score['dead_balls']) / ($score['hitting'] - $score['sacrifice_bunt']), 3)" />
                        @else
                            <x-parts.score-item item_name="{{ __('OPS') }}" :item_value="__('-')" />
                        @endif
                        @if(($score['hitting'] - ($score['four_balls'] + $score['dead_balls'] + $score['sacrifice_bunt'] + $score['sacrifice_fly'])) !== 0 && ($score['hitting'] - ($score['four_balls'] + $score['dead_balls'] + $score['sacrifice_bunt'] + $score['sacrifice_fly'])) !== 0)
                            <x-parts.score-item item_name="{{ __('ISO') }}" :item_value="number_format(($score['single_hits'] + 2 * $score['double_hits'] + 3 * $score['triple_hits'] + 4 * $score['homerun']) / ($score['hitting'] - ($score['four_balls'] + $score['dead_balls'] + $score['sacrifice_bunt'] + $score['sacrifice_fly'])) - ($score['single_hits'] + $score['double_hits'] + $score['triple_hits'] + $score['homerun']) / ($score['hitting'] - ($score['four_balls'] + $score['dead_balls'] + $score['sacrifice_bunt'] + $score['sacrifice_fly'])), 3)" />
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
                        @if($score['defense_fine_inning'] % 3 === 0)
                            <x-parts.score-item item_name="{{ __('守備回数') }}" :item_value="($score['defense_inning'] + ($score['defense_fine_inning'] / 3)).'回'" />
                        @else
                            <x-parts.score-item item_name="{{ __('守備回数') }}" :item_value="($score['defense_inning'] + intdiv($score['defense_fine_inning'], 3)).' '.($score['defense_fine_inning'] % 3).'/3 回'" />
                        @endif
                        <x-parts.score-item item_name="{{ __('守備機会') }}" :item_value="$score['defense_chance'].'回'" />
                        <x-parts.score-item item_name="{{ __('刺殺数') }}" :item_value="$score['outs'].'個'" />
                        <x-parts.score-item item_name="{{ __('補殺数') }}" :item_value="$score['assists'].'個'" />
                        <x-parts.score-item item_name="{{ __('併殺数') }}" :item_value="$score['double_play'].'個'" />
                        <x-parts.score-item item_name="{{ __('失策数(捕失)') }}" :item_value="$score['errors'].'個'" />
                        <x-parts.score-item item_name="{{ __('失策数(投失)') }}" :item_value="$score['errors_wild_pitch'].'個'" />
                        @if(($score['outs'] + $score['assists'] + $score['errors'] + $score['errors_wild_pitch']) !== 0)
                            <x-parts.score-item item_name="{{ __('守備率') }}" :item_value="number_format(($score['outs'] + $score['assists']) / ($score['outs'] + $score['assists'] + $score['errors'] + $score['errors_wild_pitch']), 3)" />
                        @else
                            <x-parts.score-item item_name="{{ __('守備率') }}" :item_value="__('-')" />
                        @endif
                        @if(($score['defense_inning'] + ($score['defense_fine_inning'] / 3)) !== 0)
                            <x-parts.score-item item_name="{{ __('Range Factor') }}" :item_value="number_format(($score['outs'] + $score['assists']) / ($score['defense_inning'] + ($score['defense_fine_inning'] / 3)). 3)" />
                        @else
                            <x-parts.score-item item_name="{{ __('Range Factor') }}" :item_value="__('-')" />
                        @endif
                        <x-parts.score-item item_name="{{ __('捕逸数') }}" :item_value="$score['passed_ball'].'個'" />
                        @if(($score['steal_allowed'] + $score['steal_stopped']) !== 0)
                            <x-parts.score-item item_name="{{ __('盗塁阻止率') }}" :item_value="number_format($score['steal_stopped'] / ($score['steal_allowed'] + $score['steal_stopped']), 3)" />
                        @else
                            <x-parts.score-item item_name="{{ __('盗塁阻止率') }}" :item_value="__('-')" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.Laravel = {};
        window.Laravel.score = @json($score);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/score/score.js'])
</x-template>
