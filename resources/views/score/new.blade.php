<x-template css="score.css" title="score">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 gap-10">
        <div>
            <div class="flex flex-col gap-1 items-center">
                <div class="px-4 text-4xl garnet">NEW SCORE</div>
                <div class="garnet-line w-full"></div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-4 w-full max-w-md">
            @if(session('success'))
                <div class="text-green-500 text-2xl">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="text-red-500 text-2xl">{{ session('error') }}</div>
                <div class="text-red-500 text-base">{{ session('message') }}</div>
            @endif
            <form action="{{ route('score.store') }}" method="POST" class="flex flex-col items-start gap-2 w-full mb-6" enctype="multipart/form-data">
                @csrf
                @can('access to admin')
                    <select name="user_id" id="user_id" class="w-full p-2 border border-gray-300 rounded-md bg-transparent">
                        <option value="" class="hidden">Whose score do you want to enter?</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                @endcan
                <div class="w-full">
                    <div class="eng-italic pl-2 text-lg">Games</div>
                    <div class="garnet-line w-full !h-0.5"></div>
                </div>
                <div class="w-full flex flex-col gap-2 items-start">
                    <select name="game_id" id="game_id" class="w-full p-2 border border-gray-300 rounded-md bg-transparent">
                        <option value="" class="hidden">Select a game</option>
                        <option value="0">New Game</option>
                        @foreach($games as $game)
                            <option value="{{ $game->id }}">
                                {{ __(date('y-m-d', strtotime($game->date)).' '.$game->opponent.' '.$game->match_number.'試合目') }}
                            </option>
                        @endforeach
                    </select>
                    <div id="game_area" class="w-full flex flex-col gap-2 items-start overflow-hidden h-0 duration-500 rounded-lg">
                        <div class="flex flex-col gap-1 items-start w-full">
                            <label for="date" class="text-xs">日付</label>
                            <input id="date" name="date" type="date" value="{{ date('Y-m-d') }}" class="w-full bg-transparent text-sm border border-gray-300 rounded-md">
                        </div>
                        <div class="flex flex-col gap-1 items-start w-full">
                            <label for="opponent" class="text-xs">対戦相手</label>
                            <input id="opponent" name="opponent" type="text" class="w-full bg-transparent text-sm border border-gray-300 rounded-md">
                        </div>
                        <div class="flex flex-col gap-1 items-start w-full">
                            <label for="place" class="text-xs">試合会場</label>
                            <input id="place" name="place" type="text" class="w-full bg-transparent text-sm border border-gray-300 rounded-md">
                        </div>
                        <div class="flex flex-col gap-1 items-start w-full">
                            <label for="match_number" class="text-xs">何試合目</label>
                            <div class="flex items-center gap-2">
                                <input id="match_number" name="match_number" type="tel" class="bg-transparent text-sm w-10 text-center border border-gray-300 rounded-md">
                                <div class="text-sm">試合目</div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 items-start w-full">
                            <div>スコア</div>
                            <div class="flex gap-2 w-full px-2">
                                <div class="flex-1 flex flex-col gap-1 items-start">
                                    <label for="score_us" class="text-xs">自チーム得点</label>
                                    <input id="score_us" name="score_us" type="tel" class="bg-transparent text-sm text-center border border-gray-300 rounded-md w-20">
                                </div>
                                <div class="flex-1 flex flex-col gap-1 items-start">
                                    <label for="score_opponent" class="text-xs">相手チーム得点</label>
                                    <input id="score_opponent" name="score_opponent" type="tel" class="bg-transparent text-sm w-20 text-center border border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 items-start w-full">
                            <label for="result" class="text-xs">試合結果</label>
                            <input id="result" name="result" type="text" class="w-full bg-transparent text-sm border border-gray-300 rounded-md">
                        </div>
                        <div class="flex flex-col gap-1 items-start w-full">
                            <label for="comment" class="text-xs">コメント</label>
                            <textarea name="comment" id="comment" rows="3" class="w-full bg-transparent text-sm border border-gray-300 rounded-md"></textarea>
                        </div>
                        <div class="flex flex-col gap-1 items-start w-full">
                            <label class="text-xs flex flex-col gap-1">
                                スコア画像①
                                <input id="game_score_book_1" name="game_score_book_1" type="file" class="hidden">
                                <img id="game_score_book_img_1" src="https://placehold.jp/250x100.png?text=スコア画像1" alt="スコア画像" class="rounded-md">
                            </label>
                        </div>
                        <div class="flex flex-col gap-1 items-start w-full">
                            <label class="text-xs flex flex-col gap-1">
                                スコア画像②
                                <input id="game_score_book_2" name="game_score_book_2" type="file" class="hidden">
                                <img id="game_score_book_img_2" src="https://placehold.jp/250x100.png?text=スコア画像2" alt="スコア画像" class="rounded-md">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-10">
                    <div class="eng-italic pl-2 text-lg">Scores</div>
                    <div class="garnet-line w-full !h-0.5"></div>
                </div>
                <div class="w-full flex flex-col gap-6 items-start">
                    <div class="w-full flex flex-col gap-4 items-start pl-2">
                        <div id="pitcher" class="w-full">
                            <div class="px-2 flex items-center justify-between">
                                <div class="eng-italic">Pitcher</div>
                                <img src="{{ asset('storage/plus-circle.svg') }}" alt="+">
                            </div>
                            <div class="garnet-line w-full !h-0.5"></div>
                        </div>
                        <div id="pitcher_area" class="w-full flex flex-col gap-4 items-start h-0 overflow-hidden rounded-lg">
                            <div class="flex flex-col gap-1 items-start w-full">
                                <div class="text-xs">投球回数</div>
                                <div class="flex items-start justify-start w-full gap-4 pl-2">
                                    <div class="flex flex-col gap-1 items-start">
                                        <label class="flex items-center text-sm gap-2">
                                            <input id="inning" name="inning" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                            回
                                        </label>
                                    </div>
                                    <div>
                                        <select name="fine_inning" id="fine_inning" class="bg-transparent text-sm border border-gray-300 rounded-md w-32">
                                            <option value="0">0アウト</option>
                                            <option value="1">1アウト</option>
                                            <option value="2">2アウト</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="pitch_count" class="text-xs">投球数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="pitch_count" name="pitch_count" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>球</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="batter_count" class="text-xs">対戦打者数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="batter_count" name="batter_count" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>人</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="single_hits_allowed" class="text-xs">被単打数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="single_hits_allowed" name="single_hits_allowed" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>本</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="double_hits_allowed" class="text-xs">被二塁打数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="double_hits_allowed" name="double_hits_allowed" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>本</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="triple_hits_allowed" class="text-xs">被三塁打数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="triple_hits_allowed" name="triple_hits_allowed" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>本</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="homerun_allowed" class="text-xs">被本塁打数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="homerun_allowed" name="homerun_allowed" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>本</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="strikeout" class="text-xs">奪三振数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="strikeout" name="strikeout" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>回</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="base_on_balls" class="text-xs">四球数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="base_on_balls" name="base_on_balls" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>回</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="hit_by_pitch" class="text-xs">死球数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="hit_by_pitch" name="hit_by_pitch" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>回</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="ground_out" class="text-xs">ゴロアウト数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="ground_out" name="ground_out" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>回</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="fly_out" class="text-xs">フライアウト数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="fly_out" name="fly_out" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>回</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="line_out" class="text-xs">ライナーアウト数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="line_out" name="line_out" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>回</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="wild_pitch" class="text-xs">ワイルドピッチ</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="wild_pitch" name="wild_pitch" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>回</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="strike" class="text-xs">ストライク数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="strike" name="strike" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>球</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="point" class="text-xs">失点数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="point" name="point" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>点</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="earned_run" class="text-xs">自責点数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="earned_run" name="earned_run" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>点</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex gap-1 items-center w-full">
                                    <label for="win" class="text-xs whitespace-nowrap">勝ち投手</label>
                                    <input id="win" name="win" type="checkbox" class="rounded" value="1">
                                </div>
                                <div class="flex gap-1 items-center w-full">
                                    <label for="lose" class="text-xs whitespace-nowrap">負け投手</label>
                                    <input id="lose" name="lose" type="checkbox" class="rounded" value="1">
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex gap-1 items-center w-full">
                                    <label for="save" class="text-xs whitespace-nowrap">セーブ</label>
                                    <input id="save" name="save" type="checkbox" class="rounded" value="1">
                                </div>
                                <div class="flex gap-1 items-center w-full">
                                    <label for="hold" class="text-xs whitespace-nowrap">ホールド</label>
                                    <input id="hold" name="hold" type="checkbox" class="rounded" value="1">
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="no_walks" class="text-xs">無死球打者数(1人目の四死球を出すまでの打者数)</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="no_walks" name="no_walks" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>人</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="no_hits" class="text-xs">無安打打者数(1人目の安打を出すまでの打者数)</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="no_hits" name="no_hits" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>人</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="shutout" class="text-xs">無失点打者数(1点目を出すまでの打者数)</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="shutout" name="shutout" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div>人</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1 items-start w-full">
                                <label for="pitcher_comment" class="text-xs">コメント</label>
                                <div class="pl-2 w-full">
                                    <textarea name="pitcher_comment" id="pitcher_comment" rows="3" class="w-full bg-transparent text-sm border border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col gap-6 items-start">
                    <div class="w-full flex flex-col gap-4 items-start pl-2">
                        <div id="batter" class="w-full">
                            <div class="px-2 flex items-center justify-between">
                                <div class="eng-italic">Batter</div>
                                <img src="{{ asset('storage/plus-circle.svg') }}" alt="+">
                            </div>
                            <div class="garnet-line w-full !h-0.5"></div>
                        </div>
                        <div id="batter_area" class="w-full flex flex-col gap-4 items-start h-0 overflow-hidden rounded-lg">
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="hitting" class="text-xs">打席数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="hitting" name="hitting" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">打席</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="single_hits" class="text-xs">単打数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="single_hits" name="single_hits" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">本</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="double_hits" class="text-xs">二塁打数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="double_hits" name="double_hits" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">本</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="triple_hits" class="text-xs">三塁打数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="triple_hits" name="triple_hits" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">本</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="homerun" class="text-xs">本塁打数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="homerun" name="homerun" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">本</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="runs_batted_in" class="text-xs">打点数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="runs_batted_in" name="runs_batted_in" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">点</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="runs" class="text-xs">得点数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="runs" name="runs" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">点</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="times_on_base" class="text-xs">出塁数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="times_on_base" name="times_on_base" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="four_balls" class="text-xs">四球数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="four_balls" name="four_balls" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="dead_balls" class="text-xs">死球数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="dead_balls" name="dead_balls" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="strikeouts" class="text-xs">三振数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="strikeouts" name="strikeouts" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="stolen_bases" class="text-xs">盗塁数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="stolen_bases" name="stolen_bases" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="caught_stealing" class="text-xs">盗塁死数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="caught_stealing" name="caught_stealing" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="double_play_allowed" class="text-xs">併殺打数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="double_play_allowed" name="double_play_allowed" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">本</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="sacrifice_bunt" class="text-xs">犠打数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="sacrifice_bunt" name="sacrifice_bunt" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">本</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="sacrifice_fly" class="text-xs">犠飛数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="sacrifice_fly" name="sacrifice_fly" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">本</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1 items-start w-full">
                                <label for="batter_comment" class="text-xs">コメント</label>
                                <div class="pl-2 w-full">
                                    <textarea name="batter_comment" id="batter_comment" rows="3" class="w-full bg-transparent text-sm border border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col gap-6 items-start">
                    <div class="w-full flex flex-col gap-4 items-start pl-2">
                        <div id="defense" class="w-full">
                            <div class="px-2 flex items-center justify-between">
                                <div class="eng-italic">Defense</div>
                                <img src="{{ asset('storage/plus-circle.svg') }}" alt="+">
                            </div>
                            <div class="garnet-line w-full !h-0.5"></div>
                        </div>
                        <div id="defense_area" class="w-full flex flex-col gap-4 items-start h-0 overflow-hidden rounded-lg">
                            <div class="flex flex-col gap-1 items-start w-full">
                                <div class="text-xs">守備回数</div>
                                <div class="flex items-start justify-start w-full gap-4 pl-2">
                                    <div class="flex flex-col gap-1 items-start">
                                        <label class="flex items-center text-sm gap-2">
                                            <input id="defense_inning" name="defense_inning" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                            回
                                        </label>
                                    </div>
                                    <div>
                                        <select name="defense_fine_inning" id="defense_fine_inning" class="bg-transparent text-sm border border-gray-300 rounded-md w-32">
                                            <option value="0">0アウト</option>
                                            <option value="1">1アウト</option>
                                            <option value="2">2アウト</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="defense_chance" class="text-xs">守備機会</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="defense_chance" name="defense_chance" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="outs" class="text-xs">刺殺数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="outs" name="outs" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="assists" class="text-xs">捕殺数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="assists" name="assists" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="errors" class="text-xs">失策数(捕失)</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="errors" name="errors" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="errors_wild_pitch" class="text-xs">失策数(投失)</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="errors_wild_pitch" name="errors_wild_pitch" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="double_play" class="text-xs">併殺数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="double_play" name="double_play" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="passed_ball" class="text-xs">捕逸数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="passed_ball" name="passed_ball" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="steal_allowed" class="text-xs">盗塁数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="steal_allowed" name="steal_allowed" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 items-start w-full">
                                    <label for="steal_stopped" class="text-xs">盗塁阻止数</label>
                                    <div class="flex items-center gap-2 pl-2">
                                        <input id="steal_stopped" name="steal_stopped" type="tel" class="bg-transparent text-sm border border-gray-300 rounded-md w-20 text-center">
                                        <div class="text-sm whitespace-nowrap">回</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1 items-start w-full">
                                <label for="defense_comment" class="text-xs">コメント</label>
                                <div class="pl-2 w-full">
                                    <textarea name="defense_comment" id="defense_comment" rows="3" class="w-full bg-transparent text-sm border border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="entry-btn bottom-4 right-4 py-2 px-4 text-gray-600 garnet">Save</button>
            </form>
        </div>
    </div>
    <div class="hidden h-[60dvh] overflow-auto overflow-scroll"></div>
    <script>
        window.Laravel = {};
        window.Laravel.games = @json($games);
        console.log(window.Laravel);
    </script>
    @vite(['resources/js/score/score-new.js'])
</x-template>
