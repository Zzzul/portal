<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /// Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'event index']);
        Permission::create(['name' => 'event create']);
        Permission::create(['name' => 'event store']);
        Permission::create(['name' => 'event show']);
        Permission::create(['name' => 'event edit']);
        Permission::create(['name' => 'event update']);
        Permission::create(['name' => 'event delete']);

        Permission::create(['name' => 'event check payment status']);
        Permission::create(['name' => 'event update payment status']);
        Permission::create(['name' => 'event book']);
        Permission::create(['name' => 'event history']);

        Permission::create(['name' => 'category index']);
        Permission::create(['name' => 'category create']);
        Permission::create(['name' => 'category store']);
        Permission::create(['name' => 'category edit']);
        Permission::create(['name' => 'category update']);
        Permission::create(['name' => 'category delete']);

        Permission::create(['name' => 'performer index']);
        Permission::create(['name' => 'performer create']);
        Permission::create(['name' => 'performer store']);
        Permission::create(['name' => 'performer edit']);
        Permission::create(['name' => 'performer update']);
        Permission::create(['name' => 'performer delete']);

        Permission::create(['name' => 'user index']);
        Permission::create(['name' => 'user edit']);
        Permission::create(['name' => 'user update']);

        Permission::create(['name' => 'setting']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'organizer']);
        Role::create(['name' => 'audience']);
    }
}
