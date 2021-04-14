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
            'name' => 'Ini Organizer',
            'email' => 'organizer@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('organizer');
        $user->givePermissionTo([
            'event index', 'event create', 'event store', 'event show', 'event edit', 'event update', 'event delete', 'event check payment status', 'event update payment status', 'event book', 'event history',
            'performer index', 'performer create', 'performer store', 'performer edit', 'performer update', 'performer delete',
            'setting'
        ]);

        $user = User::create([
            'name' => 'Ini Audience',
            'email' => 'audience@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('audience');
        $user->givePermissionTo(['event book', 'event history', 'setting']);
    }
}
