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
        DB::statement('create or replace view user_role_views as select x.id as id, x.name as user_name, x.icon as icon, a.role_id as role_id, c.name as role_name, b.permission_id as permission_id, d.name as permission_name from users as x left join model_has_roles as a on x.id = a.model_id left join role_has_permissions as b on a.role_id = b.role_id left join roles as c on a.role_id = c.id left join permissions as d on b.permission_id = d.id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role_views');
    }
};
