<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestRoleSeeder extends Seeder
{
    public function run()
    {
        // Create a test role with limited permissions
        $testRole = Role::create([
            'name' => 'test_user',
            'display_name' => 'Test User',
            'description' => 'Test role with limited permissions',
            'is_active' => true
        ]);

        // Give only dashboard and users view permissions
        $permissions = Permission::whereIn('name', [
            'dashboard.view',
            'users.view'
        ])->get();

        $testRole->permissions()->attach($permissions->pluck('id'));

        // Create a test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@wms.com',
            'password' => Hash::make('password'),
            'role_id' => $testRole->id,
            'gender' => 'male',
            'active' => 1
        ]);

        $this->command->info('Test user created successfully!');
        $this->command->info('Email: test@wms.com');
        $this->command->info('Password: password');
        $this->command->info('Permissions: Dashboard View, Users View only');
    }
}
