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
        DB::statement('create or replace view message_views as select x.id as id, x.user_id as user_id, y.name as user_name, y.icon as user_icon, x.title as title, x.message as message, x.is_read as is_read, x.read_at as read_at, x.sent_from as sent_from, z.name as sent_name, z.icon as sent_icon, x.is_hidden as is_hidden, x.created_at as created_at, x.updated_at as updated_at from messages as x left join users as y on x.user_id = y.id left join users as z on x.sent_from = z.id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_views');
    }
};
