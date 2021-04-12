<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('admin');
        $user->givePermissionTo(Permission::all());

        $user = User::create([
            'name' => 'Organizer',
            'email' => 'organizer@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('organizer');
        $user->givePermissionTo([
            'event create', 'event store', 'event edit', 'event update', 'event delete', 'event check payment status', 'event detail', 'event register', 'event history',
            'performer create', 'performer store', 'performer edit', 'performer update', 'performer delete', 'setting'
        ]);

        $user = User::create([
            'name' => 'Audience',
            'email' => 'audience@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('audience');
        $user->givePermissionTo(['event detail', 'event register', 'event history', 'setting']);
    }
}
