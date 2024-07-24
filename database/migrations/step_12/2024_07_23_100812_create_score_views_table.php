<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('create or replace view score_views as select x.id as score_id, x.user_id as user_id, y.name as user_name, y.icon as user_icon, x.game_id as game_id, z.date as date, z.opponent as opponent, z.place as place, z.match_number as match_number, z.score_us as score_us, z.score_opponent as score_opponent, z.result as result, z.comment as comment, z.game_score_book_1 as game_score_book_1, z.game_score_book_2 as game_score_book_2, x.inning as inning, x.fine_inning as fine_inning, x.pitch_count as pitch_count, x.batter_count as batter_count, x.single_hits_allowed as single_hits_allowed, x.double_hits_allowed as double_hits_allowed, x.triple_hits_allowed as triple_hits_allowed, x.homerun_allowed as homerun_allowed, x.strikeout as strikeout, x.base_on_balls as base_on_balls, x.hit_by_pitch as hit_by_pitch, x.ground_out as ground_out, x.fly_out as fly_out, x.line_out as line_out, x.wild_pitch as wild_pitch, x.strike as strike, x.point as point, x.earned_run as earned_run, x.win as win, x.lose as lose, x.save as save, x.hold as hold, x.no_walks as no_walks, x.no_hits as no_hits, x.shutout as shutout, x.pitcher_comment as pitcher_comment, x.hitting as hitting, x.single_hits as single_hits, x.double_hits as double_hits, x.triple_hits as triple_hits, x.homerun as homerun, x.runs_batted_in as runs_batted_in, x.runs as runs, x.times_on_base as times_on_base, x.four_balls as four_balls, x.dead_balls as dead_balls, x.strikeouts as strikeouts, x.stolen_bases as stolen_bases, x.caught_stealing as caught_stealing, x.double_play_allowed as double_play_allowed, x.sacrifice_bunt as sacrifice_bunt, x.sacrifice_fly as sacrifice_fly, x.batter_comment, x.defense_inning as defense_inning, x.defense_fine_inning as defense_fine_inning, x.defense_chance as defense_chance, x.outs as outs, x.assists as assists, x.errors as errors, x.errors_wild_pitch as errors_wild_pitch, x.double_play as double_play, x.passed_ball as passed_ball, x.steal_allowed as steal_allowed, x.steal_stopped as steal_stopped, x.defense_comment as defense_comment from scores as x left join users as y on x.user_id = y.id left join games as z on x.game_id = z.id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('score_views');
    }
};
