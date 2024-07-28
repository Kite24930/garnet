<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Score;
use App\Models\ScoreView;
use App\Models\User;
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
}
