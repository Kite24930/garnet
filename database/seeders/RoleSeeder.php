<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accessToAdmin = Permission::create(['name' => 'access to admin']);
        $accessToUser = Permission::create(['name' => 'access to user']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo($accessToAdmin);

        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo($accessToUser);
    }
}
