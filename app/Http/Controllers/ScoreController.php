<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Rank;
use App\Models\ResultView;
use App\Models\Score;
use App\Models\ScoreView;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function score ($user = null) {
        $exclusions = ['score_id', 'user_id', 'user_name', 'user_icon', 'game_id', 'date', 'opponent', 'place', 'match_number', 'score_us', 'score_opponent', 'result', 'comment', 'game_score_book_1', 'game_score_book_2', 'pitcher_comment', 'batter_comment', 'defense_comment'];
        if (!$user) {
            $user = auth()->id();
        }
        $all_scores = ScoreView::where('user_id', $user)->orderBy('date', 'desc')->get();
        $game_count = $all_scores->count();
        $all_data = [];
        foreach ($all_scores as $score) {
            foreach($score->toArray() as $key => $item) {
                if (!in_array($key, $exclusions)) {
                    if (!isset($all_data[$key])) {
                        $all_data[$key] = 0;
                    }
                    if (is_numeric($item)) {
                        $all_data[$key] += $item;
                    } elseif (is_null($item)) {
                        $all_data[$key] += 0;
                    }
                }
            }
        }
        $users = User::all();
        $userRow = User::find($user);
        $data = [
            'scores' => $all_scores,
            'game_count' => $game_count,
            'all_data' => $all_data,
            'users' => $users,
            'user' => $userRow,
        ];
        return view('score.score', $data);
    }

    public function scoreNew () {
        $games = Game::all();
        $users = User::all();
        $data = [
            'games' => $games,
            'users' => $users,
        ];
        return view('score.new', $data);
    }

    public function scoreStore (Request $request) {
        $validated_data = $request->validate([
            'game_id' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $game_id = 0;
            if ($request->game_id == 0) {
                $game = Game::create([
                    'date' => $request->date,
                    'opponent' => $request->opponent,
                    'place' => $request->place,
                    'match_number' => $request->match_number,
                    'score_us' => $request->score_us,
                    'score_opponent' => $request->score_opponent,
                    'result' => $request->result,
                    'comment' => $request->comment,
                ]);
                if ($request->hasFile('game_score_book_1')) {
                    $file = $request->file('game_score_book_1');
                    $file_name = $file->getClientOriginalName();
                    $path = $file->storeAs('game_score_book/'.$game->id, $file_name, 'public');
                    if ($path) {
                        $game->game_score_book_1 = $file_name;
                        $game->save();
                    }
                }
                if ($request->hasFile('game_score_book_2')) {
                    $file = $request->file('game_score_book_2');
                    $file_name = $file->getClientOriginalName();
                    $path = $file->storeAs('game_score_book/'.$game->id, $file_name, 'public');
                    if ($path) {
                        $game->game_score_book_2 = $file_name;
                        $game->save();
                    }
                }
                $game_id = $game->id;
            } else {
                $game_id = $request->game_id;
            }
            $user_id = auth()->id();
            if ($request->has('user_id')) {
                $user_id = $request->user_id;
            }
            $score = Score::create([
                'user_id' => $user_id,
                'game_id' => $game_id,
                'inning' => $request->inning,
                'fine_inning' => $request->fine_inning,
                'pitch_count' => $request->pitch_count,
                'batter_count' => $request->batter_count,
                'single_hits_allowed' => $request->single_hits_allowed,
                'double_hits_allowed' => $request->double_hits_allowed,
                'triple_hits_allowed' => $request->triple_hits_allowed,
                'homerun_allowed' => $request->homerun_allowed,
                'strikeout' => $request->strikeout,
                'base_on_balls' => $request->base_on_balls,
                'hit_by_pitch' => $request->hit_by_pitch,
                'ground_out' => $request->ground_out,
                'fly_out' => $request->fly_out,
                'line_out' => $request->line_out,
                'wild_pitch' => $request->wild_pitch,
                'strike' => $request->strike,
                'point' => $request->point,
                'earned_run' => $request->earned_run,
                'win' => $request->win,
                'lose' => $request->lose,
                'save' => $request->save,
                'hold' => $request->hold,
                'no_walks' => $request->no_walks,
                'no_hits' => $request->no_hits,
                'shutout' => $request->shutout,
                'pitcher_comment' => $request->pitcher_comment,
                'hitting' => $request->hitting,
                'single_hits' => $request->single_hits,
                'double_hits' => $request->double_hits,
                'triple_hits' => $request->triple_hits,
                'homerun' => $request->homerun,
                'runs_batted_in' => $request->runs_batted_in,
                'runs' => $request->runs,
                'times_on_base' => $request->times_on_base,
                'four_balls' => $request->four_balls,
                'dead_balls' => $request->dead_balls,
                'strikeouts' => $request->strikeouts,
                'stolen_bases' => $request->stolen_bases,
                'caught_stealing' => $request->caught_stealing,
                'double_play_allowed' => $request->double_play_allowed,
                'sacrifice_bunt' => $request->sacrifice_bunt,
                'sacrifice_fly' => $request->sacrifice_fly,
                'batter_comment' => $request->batter_comment,
                'defense_inning' => $request->defense_inning,
                'defense_fine_inning' => $request->defense_fine_inning,
                'defense_chance' => $request->defense_chance,
                'outs' => $request->outs,
                'assists' => $request->assists,
                'errors' => $request->errors,
                'errors_wild_pitch' => $request->errors_wild_pitch,
                'double_play' => $request->double_play,
                'passed_ball' => $request->passed_ball,
                'steal_allowed' => $request->steal_allowed,
                'steal_stopped' => $request->steal_stopped,
                'defense_comment' => $request->defense_comment,
            ]);
            DB::commit();
            return redirect()->route('score');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'エラーが発生しました。')->with('message', $e->getMessage());
        }
    }

    public function scoreEdit ($score) {
        $score = ScoreView::where('score_id', $score)->first();
        $users = User::all();
        $games = Game::all();
        $data = [
            'score' => $score,
            'users' => $users,
            'games' => $games,
        ];
        return view('score.edit', $data);
    }

    public function scoreUpdate (Request $request, $score) {
        try {
            DB::beginTransaction();
            $game_id = 0;
            if ($request->game_id == 0) {
                $game = Game::create([
                    'date' => $request->date,
                    'opponent' => $request->opponent,
                    'place' => $request->place,
                    'match_number' => $request->match_number,
                    'score_us' => $request->score_us,
                    'score_opponent' => $request->score_opponent,
                    'result' => $request->result,
                    'comment' => $request->comment,
                ]);
                if ($request->hasFile('game_score_book_1')) {
                    $file = $request->file('game_score_book_1');
                    $file_name = $file->getClientOriginalName();
                    $path = $file->storeAs('game_score_book/'.$game->id, $file_name, 'public');
                    if ($path) {
                        $game->game_score_book_1 = $file_name;
                        $game->save();
                    }
                }
                if ($request->hasFile('game_score_book_2')) {
                    $file = $request->file('game_score_book_2');
                    $file_name = $file->getClientOriginalName();
                    $path = $file->storeAs('game_score_book/'.$game->id, $file_name, 'public');
                    if ($path) {
                        $game->game_score_book_2 = $file_name;
                        $game->save();
                    }
                }
                $game_id = $game->id;
            } else {
                Game::find($request->game_id)->update([
                    'date' => $request->date,
                    'opponent' => $request->opponent,
                    'place' => $request->place,
                    'match_number' => $request->match_number,
                    'score_us' => $request->score_us,
                    'score_opponent' => $request->score_opponent,
                    'result' => $request->result,
                    'comment' => $request->comment,
                ]);
                $game_id = $request->game_id;
            }
            $user_id = auth()->id();
            if ($request->has('user_id')) {
                $user_id = $request->user_id;
            }
            $scoreRow = Score::find($score)->update([
                'user_id' => $user_id,
                'game_id' => $game_id,
                'inning' => $request->inning,
                'fine_inning' => $request->fine_inning,
                'pitch_count' => $request->pitch_count,
                'batter_count' => $request->batter_count,
                'single_hits_allowed' => $request->single_hits_allowed,
                'double_hits_allowed' => $request->double_hits_allowed,
                'triple_hits_allowed' => $request->triple_hits_allowed,
                'homerun_allowed' => $request->homerun_allowed,
                'strikeout' => $request->strikeout,
                'base_on_balls' => $request->base_on_balls,
                'hit_by_pitch' => $request->hit_by_pitch,
                'ground_out' => $request->ground_out,
                'fly_out' => $request->fly_out,
                'line_out' => $request->line_out,
                'wild_pitch' => $request->wild_pitch,
                'strike' => $request->strike,
                'point' => $request->point,
                'earned_run' => $request->earned_run,
                'win' => $request->win,
                'lose' => $request->lose,
                'save' => $request->save,
                'hold' => $request->hold,
                'no_walks' => $request->no_walks,
                'no_hits' => $request->no_hits,
                'shutout' => $request->shutout,
                'pitcher_comment' => $request->pitcher_comment,
                'hitting' => $request->hitting,
                'single_hits' => $request->single_hits,
                'double_hits' => $request->double_hits,
                'triple_hits' => $request->triple_hits,
                'homerun' => $request->homerun,
                'runs_batted_in' => $request->runs_batted_in,
                'runs' => $request->runs,
                'times_on_base' => $request->times_on_base,
                'four_balls' => $request->four_balls,
                'dead_balls' => $request->dead_balls,
                'strikeouts' => $request->strikeouts,
                'stolen_bases' => $request->stolen_bases,
                'caught_stealing' => $request->caught_stealing,
                'double_play_allowed' => $request->double_play_allowed,
                'sacrifice_bunt' => $request->sacrifice_bunt,
                'sacrifice_fly' => $request->sacrifice_fly,
                'batter_comment' => $request->batter_comment,
                'defense_inning' => $request->defense_inning,
                'defense_fine_inning' => $request->defense_fine_inning,
                'defense_chance' => $request->defense_chance,
                'outs' => $request->outs,
                'assists' => $request->assists,
                'errors' => $request->errors,
                'errors_wild_pitch' => $request->errors_wild_pitch,
                'double_play' => $request->double_play,
                'passed_ball' => $request->passed_ball,
                'steal_allowed' => $request->steal_allowed,
                'steal_stopped' => $request->steal_stopped,
                'defense_comment' => $request->defense_comment,
            ]);
            DB::commit();
            return redirect()->route('score.view', $score)->with('success', '更新しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'エラーが発生しました。')->with('message', $e->getMessage());
        }
    }

    public function scoreDestroy ($score) {
        try {
            DB::beginTransaction();
            Score::find($score)->delete();
            DB::commit();
            return redirect()->route('score')->with('success', '削除しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'エラーが発生しました。')->with('message', $e->getMessage());
        }
    }

    public function scoreView ($score) {
        $score = ScoreView::where('score_id', $score)->first();
        $data = [
            'score' => $score,
        ];
        return view('score.view', $data);
    }

    public function totalRanking () {
        $exclusions = ['score_id', 'user_id', 'user_name', 'user_icon', 'game_id', 'date', 'opponent', 'place', 'match_number', 'score_us', 'score_opponent', 'result', 'comment', 'game_score_book_1', 'game_score_book_2', 'pitcher_comment', 'batter_comment', 'defense_comment'];
        $ranking_label = [
            'era' => '防御率',
            'k_9' => '奪三振率',
            'whip' => 'WHIP',
            'avg' => '打率',
            'obp' => '出塁率',
            'slg' => '長打率',
            'ops' => 'OPS',
            'rbi' => '打点',
            'sb' => '盗塁数',
            'iso' => 'ISO',
            'fpct' => '守備率',
            'rf' => 'レンジファクター',
        ];
        $descItem = ['k_9', 'avg', 'obp', 'slg', 'ops', 'rbi', 'sb', 'iso', 'fpct', 'rf'];
        $integerItem = ['rbi', 'sb'];
        /*
         * era: 防御率(自責点*9/投球回)
         * k_9: 奪三振率(奪三振数/対戦打者数)
         * whip: WHIP(与四球数+被安打数/投球回)
         * avg: 打率(安打数/打数)
         * obp: 出塁率(四球数+死球数+安打数/打数+四球数+死球数+犠飛数)
         * slg: 長打率((単打数+2*二塁打数+3*三塁打数+4*本塁打数)/打数)
         * ops: OPS(出塁率+長打率)
         * rbi: 打点(打点)
         * sb: 盗塁(盗塁数)
         * iso: ISO(長打率-打率)
         * fpct: 守備率(刺殺数+補殺数/刺殺数+補殺数+失策数)
         * rf: レンジファクター(刺殺数+補殺数/守備イニング)
        */
        // ソート関数
        function sortByItem($array, $itemName, $descItem) {
            // 空の要素やnullを削除
            $filteredArray = array_filter($array, function($item) use ($itemName) {
                return isset($item[$itemName]);
            });

            // ソート
            usort($filteredArray, function($a, $b) use ($itemName, $descItem) {
                if (in_array($itemName, $descItem)) {
                    return $b[$itemName] <=> $a[$itemName];
                }
                return $a[$itemName] <=> $b[$itemName];
            });

            return $filteredArray;
        }
        function sortByRank($array, $itemName, $rankName) {
            // 空の要素やnullを削除
            $filteredArray = array_filter($array, function($item) use ($itemName, $rankName) {
                return isset($item[$itemName][$rankName]);
            });

            // ソート
            usort($filteredArray, function($a, $b) use ($itemName, $rankName) {
                return $b[$itemName][$rankName] <=> $a[$itemName][$rankName];
            });

            return $filteredArray;
        }
        $users = User::all();
        foreach ($users as $user) {
            $scores = ScoreView::where('user_id', $user->id)->get();
            $all_data = [];
            foreach ($scores as $score) {
                foreach($score->toArray() as $key => $item) {
                    if (!in_array($key, $exclusions)) {
                        if (!isset($all_data[$key])) {
                            $all_data[$key] = 0;
                        }
                        if (is_numeric($item)) {
                            $all_data[$key] += $item;
                        } elseif (is_null($item)) {
                            $all_data[$key] += 0;
                        }
                    }
                }
            }
            if (count($all_data) !== 0) {
                if (($all_data['inning'] + ($all_data['fine_inning'] / 3)) !== 0) {
                    $all_data['era'] = $all_data['earned_run'] * 9 / ($all_data['inning'] + ($all_data['fine_inning'] / 3));
                } else {
                    $all_data['era'] = null;
                }
                if ($all_data['batter_count'] !== 0) {
                    $all_data['k_9'] = $all_data['strikeout'] / $all_data['batter_count'];
                } else {
                    $all_data['k_9'] = null;
                }
                if (($all_data['inning'] + ($all_data['fine_inning'] / 3)) !== 0) {
                    $all_data['whip'] = ($all_data['base_on_balls'] + $all_data['single_hits_allowed'] + $all_data['double_hits_allowed'] + $all_data['triple_hits_allowed'] + $all_data['homerun_allowed']) / ($all_data['inning'] + ($all_data['fine_inning'] / 3));
                } else {
                    $all_data['whip'] = null;
                }
                if (($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])) !== 0) {
                    $all_data['avg'] = ($all_data['single_hits'] + $all_data['double_hits'] + $all_data['triple_hits'] + $all_data['homerun']) / ($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly']));
                } else {
                    $all_data['avg'] = null;
                }
                if (($all_data['hitting'] - ($all_data['sacrifice_bunt'])) !== 0) {
                    $all_data['obp'] = ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['single_hits'] + $all_data['double_hits'] + $all_data['triple_hits'] + $all_data['homerun']) / ($all_data['hitting'] - ($all_data['sacrifice_bunt']));
                } else {
                    $all_data['obp'] = null;
                }
                if (($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])) !== 0) {
                    $all_data['slg'] = ($all_data['single_hits'] + 2 * $all_data['double_hits'] + 3 * $all_data['triple_hits'] + 4 * $all_data['homerun']) / ($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly']));
                } else {
                    $all_data['slg'] = null;
                }
                $all_data['ops'] = $all_data['obp'] + $all_data['slg'];
                $all_data['rbi'] = $all_data['runs_batted_in'];
                $all_data['sb'] = $all_data['stolen_bases'];
                $all_data['iso'] = $all_data['slg'] - $all_data['avg'];
                if (($all_data['assists'] + $all_data['outs'] + $all_data['errors']) !== 0) {
                    $all_data['fpct'] = ($all_data['assists'] + $all_data['outs']) / ($all_data['assists'] + $all_data['outs'] + $all_data['errors']);
                } else {
                    $all_data['fpct'] = null;
                }
                if (($all_data['defense_inning'] + ($all_data['defense_fine_inning'] / 3)) !== 0) {
                    $all_data['rf'] = ($all_data['assists'] + $all_data['outs']) / ($all_data['defense_inning'] + ($all_data['defense_fine_inning'] / 3));
                } else {
                    $all_data['rf'] = null;
                }
            }
            $result = ResultView::where('user_id', $user->id)->get();
            $rank = Rank::all();
            $start_date = Carbon::parse(ResultView::min('date'));
            $end_date = Carbon::parse(ResultView::max('date'));
            if ($result->count() !== 0) {
                foreach ($rank as $item) {
                    $rank_count[$item->eng_name] = 0;
                    $day_rank_count[$item->eng_name] = 0;
                }
                $rank_count['all'] = 0;
                $day_rank_count['all'] = 0;
                foreach ($result as $item) {
                    $rank_count[$item->rank_eng_name] += 1;
                    $rank_count['all'] += $item->rank_id;
                }
                $current_date = $start_date->copy();
                while ($current_date->lte($end_date)) {
                    $result_counts = ResultView::where('date', $current_date)->where('user_id', $user->id)->count();
                    if ($result_counts === 0) {
                        $current_date->addDay();
                        continue;
                    }
                    $results = ResultView::where('date', $current_date)->where('user_id', $user->id)->orderBy('rank_id', 'desc')->get();
                    $rank_counts = ResultView::select('rank_id', DB::raw('count(*) as count'))->where('date', $current_date)->where('user_id', $user->id)->groupBy('rank_id')->orderBy('rank_id', 'desc')->get();
                    $target_rank = 1;
                    $addition = 0;
                    foreach($rank_counts as $rank_count) {
                        $judging = $addition + $rank_count->count;
                        if ($judging > 1) {
                            $target_rank = $rank_count->rank_id;
                            break;
                        }
                        $addition += $rank_count->count;
                    }
                    $get_rank = Rank::find($target_rank);
                    $day_rank_count['all'] += $target_rank;
                    $day_rank_count[$get_rank->eng_name] += 1;
                    $current_date->addDay();
                }
                $all_data['rank_count'] = $rank_count;
                $all_data['day_rank_count'] = $day_rank_count;
            }
            $all_data['user'] = $user;
            $calc_scores[$user->id] = $all_data;
        }
        $ranking = [];
        foreach ($ranking_label as $key => $item) {
            $ranking[$key] = sortByItem($calc_scores, $key, $descItem);
            $ranking[$key]['label'] = $item;
        }
        $ranks = Rank::orderBy('id', 'desc')->get();
        $badge_ranking = [];
        foreach ($ranks as $rank) {
            $badge_ranking['rank_count'][$rank->eng_name] = sortByRank($calc_scores, 'rank_count', $rank->eng_name);
            $badge_ranking['rank_count'][$rank->eng_name]['label'] = $rank->eng_name;
            $badge_ranking['day_rank_count'][$rank->eng_name] = sortByRank($calc_scores, 'day_rank_count', $rank->eng_name);
            $badge_ranking['day_rank_count'][$rank->eng_name]['label'] = $rank->eng_name;
        }
        $badge_ranking['rank_count']['all'] = sortByRank($calc_scores, 'rank_count', 'all');
        $badge_ranking['rank_count']['all']['label'] = 'all';
        $badge_ranking['day_rank_count']['all'] = sortByRank($calc_scores, 'day_rank_count', 'all');
        $badge_ranking['day_rank_count']['all']['label'] = 'all';
        $data = [
            'scores' => $calc_scores,
            'ranking' => $ranking,
            'badge_ranking' => $badge_ranking,
            'ranking_label' => $ranking_label,
            'type' => 'total',
        ];
        return view('ranking.view', $data);
    }

    public function monthlyRanking ($month = null) {
        if ($month) {
            $month = date('Y-m', strtotime($month));
        } else {
            $month = date('Y-m');
        }
        $start_date = Carbon::parse($month . '-01');
        $end_date = Carbon::parse($month . '-01')->endOfMonth();
        $exclusions = ['score_id', 'user_id', 'user_name', 'user_icon', 'game_id', 'date', 'opponent', 'place', 'match_number', 'score_us', 'score_opponent', 'result', 'comment', 'game_score_book_1', 'game_score_book_2', 'pitcher_comment', 'batter_comment', 'defense_comment'];
        $ranking_label = [
            'era' => '防御率',
            'k_9' => '奪三振率',
            'whip' => 'WHIP',
            'avg' => '打率',
            'obp' => '出塁率',
            'slg' => '長打率',
            'ops' => 'OPS',
            'rbi' => '打点',
            'sb' => '盗塁数',
            'iso' => 'ISO',
            'fpct' => '守備率',
            'rf' => 'レンジファクター',
        ];
        $descItem = ['k_9', 'avg', 'obp', 'slg', 'ops', 'rbi', 'sb', 'iso', 'fpct', 'rf'];
        $integerItem = ['rbi', 'sb'];
        /*
         * era: 防御率(自責点*9/投球回)
         * k_9: 奪三振率(奪三振数/対戦打者数)
         * whip: WHIP(与四球数+被安打数/投球回)
         * avg: 打率(安打数/打数)
         * obp: 出塁率(四球数+死球数+安打数/打数+四球数+死球数+犠飛数)
         * slg: 長打率((単打数+2*二塁打数+3*三塁打数+4*本塁打数)/打数)
         * ops: OPS(出塁率+長打率)
         * rbi: 打点(打点)
         * sb: 盗塁(盗塁数)
         * iso: ISO(長打率-打率)
         * fpct: 守備率(刺殺数+補殺数/刺殺数+補殺数+失策数)
         * rf: レンジファクター(刺殺数+補殺数/守備イニング)
        */
        // ソート関数
        function sortByItem($array, $itemName, $descItem) {
            // 空の要素やnullを削除
            $filteredArray = array_filter($array, function($item) use ($itemName) {
                return isset($item[$itemName]);
            });

            // ソート
            usort($filteredArray, function($a, $b) use ($itemName, $descItem) {
                if (in_array($itemName, $descItem)) {
                    return $b[$itemName] <=> $a[$itemName];
                }
                return $a[$itemName] <=> $b[$itemName];
            });

            return $filteredArray;
        }
        function sortByRank($array, $itemName, $rankName) {
            // 空の要素やnullを削除
            $filteredArray = array_filter($array, function($item) use ($itemName, $rankName) {
                return isset($item[$itemName][$rankName]);
            });

            // ソート
            usort($filteredArray, function($a, $b) use ($itemName, $rankName) {
                return $b[$itemName][$rankName] <=> $a[$itemName][$rankName];
            });

            return $filteredArray;
        }
        $users = User::all();
        foreach ($users as $user) {
            $scores = ScoreView::where('user_id', $user->id)->whereBetween('date', [$start_date, $end_date])->get();
            $all_data = [];
            foreach ($scores as $score) {
                foreach($score->toArray() as $key => $item) {
                    if (!in_array($key, $exclusions)) {
                        if (!isset($all_data[$key])) {
                            $all_data[$key] = 0;
                        }
                        if (is_numeric($item)) {
                            $all_data[$key] += $item;
                        } elseif (is_null($item)) {
                            $all_data[$key] += 0;
                        }
                    }
                }
            }
            if (count($all_data) !== 0) {
                if (($all_data['inning'] + ($all_data['fine_inning'] / 3)) !== 0) {
                    $all_data['era'] = $all_data['earned_run'] * 9 / ($all_data['inning'] + ($all_data['fine_inning'] / 3));
                } else {
                    $all_data['era'] = null;
                }
                if ($all_data['batter_count'] !== 0) {
                    $all_data['k_9'] = $all_data['strikeout'] / $all_data['batter_count'];
                } else {
                    $all_data['k_9'] = null;
                }
                if (($all_data['inning'] + ($all_data['fine_inning'] / 3)) !== 0) {
                    $all_data['whip'] = ($all_data['base_on_balls'] + $all_data['single_hits_allowed'] + $all_data['double_hits_allowed'] + $all_data['triple_hits_allowed'] + $all_data['homerun_allowed']) / ($all_data['inning'] + ($all_data['fine_inning'] / 3));
                } else {
                    $all_data['whip'] = null;
                }
                if (($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])) !== 0) {
                    $all_data['avg'] = ($all_data['single_hits'] + $all_data['double_hits'] + $all_data['triple_hits'] + $all_data['homerun']) / ($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly']));
                } else {
                    $all_data['avg'] = null;
                }
                if (($all_data['hitting'] - ($all_data['sacrifice_bunt'])) !== 0) {
                    $all_data['obp'] = ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['single_hits'] + $all_data['double_hits'] + $all_data['triple_hits'] + $all_data['homerun']) / ($all_data['hitting'] - ($all_data['sacrifice_bunt']));
                } else {
                    $all_data['obp'] = null;
                }
                if (($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly'])) !== 0) {
                    $all_data['slg'] = ($all_data['single_hits'] + 2 * $all_data['double_hits'] + 3 * $all_data['triple_hits'] + 4 * $all_data['homerun']) / ($all_data['hitting'] - ($all_data['four_balls'] + $all_data['dead_balls'] + $all_data['sacrifice_bunt'] + $all_data['sacrifice_fly']));
                } else {
                    $all_data['slg'] = null;
                }
                $all_data['ops'] = $all_data['obp'] + $all_data['slg'];
                $all_data['rbi'] = $all_data['runs_batted_in'];
                $all_data['sb'] = $all_data['stolen_bases'];
                $all_data['iso'] = $all_data['slg'] - $all_data['avg'];
                if (($all_data['assists'] + $all_data['outs'] + $all_data['errors']) !== 0) {
                    $all_data['fpct'] = ($all_data['assists'] + $all_data['outs']) / ($all_data['assists'] + $all_data['outs'] + $all_data['errors']);
                } else {
                    $all_data['fpct'] = null;
                }
                if (($all_data['defense_inning'] + ($all_data['defense_fine_inning'] / 3)) !== 0) {
                    $all_data['rf'] = ($all_data['assists'] + $all_data['outs']) / ($all_data['defense_inning'] + ($all_data['defense_fine_inning'] / 3));
                } else {
                    $all_data['rf'] = null;
                }
            }
            $result = ResultView::where('user_id', $user->id)->whereBetween('date', [$start_date, $end_date])->get();
            $rank = Rank::all();
            if ($result->count() !== 0) {
                foreach ($rank as $item) {
                    $rank_count[$item->eng_name] = 0;
                    $day_rank_count[$item->eng_name] = 0;
                }
                $rank_count['all'] = 0;
                $day_rank_count['all'] = 0;
                foreach ($result as $item) {
                    $rank_count[$item->rank_eng_name] += 1;
                    $rank_count['all'] += $item->rank_id;
                }
                $current_date = $start_date->copy();
                while ($current_date->lte($end_date)) {
                    $result_counts = ResultView::where('date', $current_date)->where('user_id', $user->id)->count();
                    if ($result_counts === 0) {
                        $current_date->addDay();
                        continue;
                    }
                    $results = ResultView::where('date', $current_date)->where('user_id', $user->id)->whereBetween('date', [$start_date, $end_date])->orderBy('rank_id', 'desc')->get();
                    $rank_counts = ResultView::select('rank_id', DB::raw('count(*) as count'))->where('date', $current_date)->where('user_id', $user->id)->whereBetween('date', [$start_date, $end_date])->groupBy('rank_id')->orderBy('rank_id', 'desc')->get();
                    $target_rank = 1;
                    $addition = 0;
                    foreach($rank_counts as $rank_count) {
                        $judging = $addition + $rank_count->count;
                        if ($judging > 1) {
                            $target_rank = $rank_count->rank_id;
                            break;
                        }
                        $addition += $rank_count->count;
                    }
                    $get_rank = Rank::find($target_rank);
                    $day_rank_count['all'] += $target_rank;
                    $day_rank_count[$get_rank->eng_name] += 1;
                    $current_date->addDay();
                }
                $all_data['rank_count'] = $rank_count;
                $all_data['day_rank_count'] = $day_rank_count;
            }
            $all_data['user'] = $user;
            $calc_scores[$user->id] = $all_data;
        }
        $ranking = [];
        foreach ($ranking_label as $key => $item) {
            $ranking[$key] = sortByItem($calc_scores, $key, $descItem);
            $ranking[$key]['label'] = $item;
        }
        $ranks = Rank::orderBy('id', 'desc')->get();
        $badge_ranking = [];
        foreach ($ranks as $rank) {
            $badge_ranking['rank_count'][$rank->eng_name] = sortByRank($calc_scores, 'rank_count', $rank->eng_name);
            $badge_ranking['rank_count'][$rank->eng_name]['label'] = $rank->eng_name;
            $badge_ranking['day_rank_count'][$rank->eng_name] = sortByRank($calc_scores, 'day_rank_count', $rank->eng_name);
            $badge_ranking['day_rank_count'][$rank->eng_name]['label'] = $rank->eng_name;
        }
        $badge_ranking['rank_count']['all'] = sortByRank($calc_scores, 'rank_count', 'all');
        $badge_ranking['rank_count']['all']['label'] = 'all';
        $badge_ranking['day_rank_count']['all'] = sortByRank($calc_scores, 'day_rank_count', 'all');
        $badge_ranking['day_rank_count']['all']['label'] = 'all';
        $data = [
            'month' => $month,
            'scores' => $calc_scores,
            'ranking' => $ranking,
            'badge_ranking' => $badge_ranking,
            'ranking_label' => $ranking_label,
            'type' => 'monthly',
        ];
        return view('ranking.view', $data);
    }
}
