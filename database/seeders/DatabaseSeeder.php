<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Role::create(['name' => 'admin', 'guard_name' => 'api']);
        // Role::create(['name' => 'user', 'guard_name' => 'api']);

        // Permission::create(['name' => 'edit posts', 'guard_name' => 'api']);
        // Permission::create(['name' => 'delete posts', 'guard_name' => 'api']);

        // $admin = Role::findByName('admin');
        // $admin->givePermissionTo('edit posts');
        // $admin->givePermissionTo('delete posts');

        // $user = Role::findByName('user');
        // $user->givePermissionTo('edit posts');
    }
}
