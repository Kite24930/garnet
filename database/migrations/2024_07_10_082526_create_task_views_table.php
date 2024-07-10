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
        DB::statement('create or replace view task_views as select x.id as task_id, x.rank_id as rank_id, a.name as rank_name, a.eng_name as rank_eng_name, a.icon as rank_icon, x.category_id as category_id, b.name as category_name, b.eng_name as category_eng_name, x.group_id as group_id, c.name as group_name, c.eng_name as group_eng_name, x.item_id as item_id, d.name as item_name, x.text as text from tasks as x left join ranks as a on x.rank_id = a.id left join categories as b on x.category_id = b.id left join `groups` as c on x.group_id = c.id left join items as d on x.item_id = d.id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_views');
    }
};
