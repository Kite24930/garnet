<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->integer('inning')->nullable()->comment('投球回数');
            $table->integer('fine_inning')->nullable()->comment('投球回数(回途中、max3)');
            $table->integer('pitch_count')->nullable()->comment('投球数');
            $table->integer('batter_count')->nullable()->comment('対戦打者数');
            $table->integer('single_hits_allowed')->nullable()->comment('被単打数');
            $table->integer('double_hits_allowed')->nullable()->comment('被二塁打数');
            $table->integer('triple_hits_allowed')->nullable()->comment('被三塁打数');
            $table->integer('homerun_allowed')->nullable()->comment('被本塁打数');
            $table->integer('strikeout')->nullable()->comment('奪三振数');
            $table->integer('base_on_balls')->nullable()->comment('四球数');
            $table->integer('hit_by_pitch')->nullable()->comment('死球数');
            $table->integer('ground_out')->nullable()->comment('ゴロアウト数');
            $table->integer('fly_out')->nullable()->comment('フライアウト数');
            $table->integer('line_out')->nullable()->comment('ライナーアウト数');
            $table->integer('wild_pitch')->nullable()->comment('暴投数');
            $table->integer('strike')->nullable()->comment('ストライク数');
            $table->integer('point')->nullable()->comment('失点数');
            $table->integer('earned_run')->nullable()->comment('自責点数');
            $table->integer('win')->nullable()->comment('勝利数');
            $table->integer('lose')->nullable()->comment('敗戦数');
            $table->integer('save')->nullable()->comment('セーブ数');
            $table->integer('hold')->nullable()->comment('ホールド数');
            $table->integer('no_walks')->nullable()->comment('無四球打者数(1人目の四死球を出すまで)');
            $table->integer('no_hits')->nullable()->comment('無安打数(一本目のヒットを打たれるまで)');
            $table->integer('shutout')->nullable()->comment('完封数(1点目を取られるまでの回)');
            $table->string('pitcher_comment')->nullable()->comment('投手コメント');

            $table->integer('hitting')->nullable()->comment('打席数');
            $table->integer('single_hits')->nullable()->comment('単打数');
            $table->integer('double_hits')->nullable()->comment('二塁打数');
            $table->integer('triple_hits')->nullable()->comment('三塁打数');
            $table->integer('homerun')->nullable()->comment('本塁打数');
            $table->integer('runs_batted_in')->nullable()->comment('打点数');
            $table->integer('runs')->nullable()->comment('得点数');
            $table->integer('times_on_base')->nullable()->comment('出塁数');
            $table->integer('four_balls')->nullable()->comment('四球数');
            $table->integer('dead_balls')->nullable()->comment('死球数');
            $table->integer('strikeouts')->nullable()->comment('三振数');
            $table->integer('stolen_bases')->nullable()->comment('盗塁数');
            $table->integer('caught_stealing')->nullable()->comment('盗塁死数');
            $table->integer('double_play_allowed')->nullable()->comment('併殺打数');
            $table->integer('sacrifice_bunt')->nullable()->comment('犠打数');
            $table->integer('sacrifice_fly')->nullable()->comment('犠飛数');
            $table->string('batter_comment')->nullable()->comment('打者コメント');

            $table->integer('defense_inning')->nullable()->comment('守備回数');
            $table->integer('defense_fine_inning')->nullable()->comment('守備回数(回途中、max3)');
            $table->integer('defense_chance')->nullable()->comment('守備機会数');
            $table->integer('outs')->nullable()->comment('刺殺数');
            $table->integer('assists')->nullable()->comment('補殺数');
            $table->integer('errors')->nullable()->comment('失策数(キャッチミス)');
            $table->integer('errors_wild_pitch')->nullable()->comment('失策数(暴投)');
            $table->integer('double_play')->nullable()->comment('併殺数');
            $table->integer('passed_ball')->nullable()->comment('捕逸数');
            $table->integer('steal_allowed')->nullable()->comment('盗塁数(許した数)');
            $table->integer('steal_stopped')->nullable()->comment('盗塁数(阻止数)');
            $table->string('defense_comment')->nullable()->comment('守備コメント');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
