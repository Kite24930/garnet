<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'inning',
        'fine_inning',
        'pitch_count',
        'batter_count',
        'single_hits_allowed',
        'double_hits_allowed',
        'triple_hits_allowed',
        'homerun_allowed',
        'strikeout',
        'base_on_balls',
        'hit_by_pitch',
        'ground_out',
        'fly_out',
        'line_out',
        'wild_pitch',
        'strike',
        'point',
        'earned_run',
        'win',
        'lose',
        'save',
        'hold',
        'no_walks',
        'no_hits',
        'shutout',
        'pitcher_comment',
        'hitting',
        'single_hits',
        'double_hits',
        'triple_hits',
        'homerun',
        'runs_batted_in',
        'runs',
        'times_on_base',
        'four_balls',
        'dead_balls',
        'strikeouts',
        'stolen_bases',
        'caught_stealing',
        'double_play_allowed',
        'sacrifice_bunt',
        'sacrifice_fly',
        'batter_comment',
        'defense_inning',
        'defense_chance',
        'outs',
        'assists',
        'errors',
        'errors_wild_pitch',
        'double_play',
        'passed_ball',
        'steal_allowed',
        'steal_stopped',
        'defense_comment',
    ];
}
