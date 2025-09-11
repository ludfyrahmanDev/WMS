<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin Role
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin'
        ], [
            'display_name' => 'Super Administrator',
            'description' => 'Has access to all system features and can manage everything',
            'is_active' => true
        ]);

        // Assign all permissions to Super Admin
        $allPermissions = Permission::all();
        $superAdminRole->permissions()->sync($allPermissions->pluck('id'));

        // Create default Admin Role
        $adminRole = Role::firstOrCreate([
            'name' => 'admin'
        ], [
            'display_name' => 'Administrator',
            'description' => 'Has access to most system features',
            'is_active' => true
        ]);

        // Create Manager Role
        $managerRole = Role::firstOrCreate([
            'name' => 'manager'
        ], [
            'display_name' => 'Manager',
            'description' => 'Can manage sales, products, and view reports',
            'is_active' => true
        ]);

        // Create Staff Role
        $staffRole = Role::firstOrCreate([
            'name' => 'staff'
        ], [
            'display_name' => 'Staff',
            'description' => 'Basic access to sales and customer management',
            'is_active' => true
        ]);

        // Assign permissions to Manager
        $managerPermissions = Permission::whereIn('name', [
            'dashboard.view',
            'products.view', 'products.create', 'products.edit',
            'categories.view', 'categories.create', 'categories.edit',
            'stock.view',
            'selling.view', 'selling.create', 'selling.edit', 'selling.export',
            'customers.view', 'customers.create', 'customers.edit',
            'delivery_orders.view', 'delivery_orders.create', 'delivery_orders.edit',
            'transport.view', 'transport.create', 'transport.edit',
            'spending.view', 'spending.export',
        ])->get();
        $managerRole->permissions()->sync($managerPermissions->pluck('id'));

        // Assign permissions to Staff
        $staffPermissions = Permission::whereIn('name', [
            'dashboard.view',
            'products.view',
            'stock.view',
            'selling.view', 'selling.create',
            'customers.view', 'customers.create', 'customers.edit',
            'delivery_orders.view',
        ])->get();
        $staffRole->permissions()->sync($staffPermissions->pluck('id'));

        // Create Super Admin User
        $superAdmin = User::firstOrCreate([
            'email' => 'superadmin@wms.com'
        ], [
            'name' => 'Super Administrator',
            'password' => Hash::make('password'),
            'role_id' => $superAdminRole->id,
            'gender' => 'L', // Add default gender
            'active' => 1    // Add active status
        ]);

        // Create Admin User
        $admin = User::firstOrCreate([
            'email' => 'admin@wms.com'
        ], [
            'name' => 'Administrator',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'gender' => 'L', // Add default gender
            'active' => 1    // Add active status
        ]);

        $this->command->info('Super Admin created successfully!');
        $this->command->info('Email: superadmin@wms.com');
        $this->command->info('Password: password');
        $this->command->info('');
        $this->command->info('Admin created successfully!');
        $this->command->info('Email: admin@wms.com');
        $this->command->info('Password: password');
    }
}
