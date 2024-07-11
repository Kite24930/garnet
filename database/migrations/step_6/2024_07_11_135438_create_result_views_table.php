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
        DB::statement('create or replace view result_views as select x.date as date, x.user_id as user_id, y.name as name, x.task_id as task_id, a.rank_id as rank_id, a.rank_name as rank_name, a.rank_eng_name as rank_eng_name, a.rank_icon as rank_icon, a.category_id as category_id, a.category_name as category_name, a.category_eng_name as category_eng_name, a.group_id as group_id, a.group_name as group_name, a.group_eng_name as group_eng_name, a.item_id as item_id, a.item_name as item_name, a.text as text, a.task_count as task_count, a.category_count as category_count, a.group_count as group_count from results as x left join users as y on x.user_id = y.id left join task_views as a on x.task_id = a.task_id;;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_views');
    }
};
