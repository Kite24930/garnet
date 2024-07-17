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
        DB::statement('create or replace view mission_views as select x.id as id, x.user_id as user_id, y.name as user_name, y.icon as user_icon, x.message as message, x.start_date as start_date, x.due_date as due_date, x.sent_from as sent_from, z.name as sent_name, z.icon as sent_icon from missions as x left join users as y on x.user_id = y.id left join users as z on x.sent_from = z.id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
