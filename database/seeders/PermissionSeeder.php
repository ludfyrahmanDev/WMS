<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard
            ['name' => 'dashboard.view', 'display_name' => 'View Dashboard', 'description' => 'Can view dashboard', 'group' => 'Dashboard'],
            
            // Users Management
            ['name' => 'users.view', 'display_name' => 'View Users', 'description' => 'Can view users list', 'group' => 'Users'],
            ['name' => 'users.create', 'display_name' => 'Create User', 'description' => 'Can create new users', 'group' => 'Users'],
            ['name' => 'users.edit', 'display_name' => 'Edit User', 'description' => 'Can edit existing users', 'group' => 'Users'],
            ['name' => 'users.delete', 'display_name' => 'Delete User', 'description' => 'Can delete users', 'group' => 'Users'],
            
            // Roles Management
            ['name' => 'roles.view', 'display_name' => 'View Roles', 'description' => 'Can view roles list', 'group' => 'Roles'],
            ['name' => 'roles.create', 'display_name' => 'Create Role', 'description' => 'Can create new roles', 'group' => 'Roles'],
            ['name' => 'roles.edit', 'display_name' => 'Edit Role', 'description' => 'Can edit existing roles', 'group' => 'Roles'],
            ['name' => 'roles.delete', 'display_name' => 'Delete Role', 'description' => 'Can delete roles', 'group' => 'Roles'],
            
            // Products Management
            ['name' => 'products.view', 'display_name' => 'View Products', 'description' => 'Can view products list', 'group' => 'Products'],
            ['name' => 'products.create', 'display_name' => 'Create Product', 'description' => 'Can create new products', 'group' => 'Products'],
            ['name' => 'products.edit', 'display_name' => 'Edit Product', 'description' => 'Can edit existing products', 'group' => 'Products'],
            ['name' => 'products.delete', 'display_name' => 'Delete Product', 'description' => 'Can delete products', 'group' => 'Products'],
            
            // Categories Management
            ['name' => 'categories.view', 'display_name' => 'View Categories', 'description' => 'Can view categories list', 'group' => 'Categories'],
            ['name' => 'categories.create', 'display_name' => 'Create Category', 'description' => 'Can create new categories', 'group' => 'Categories'],
            ['name' => 'categories.edit', 'display_name' => 'Edit Category', 'description' => 'Can edit existing categories', 'group' => 'Categories'],
            ['name' => 'categories.delete', 'display_name' => 'Delete Category', 'description' => 'Can delete categories', 'group' => 'Categories'],
            
            // Stock Management
            ['name' => 'stock.view', 'display_name' => 'View Stock', 'description' => 'Can view stock information', 'group' => 'Stock'],
            ['name' => 'stock.export', 'display_name' => 'Export Stock', 'description' => 'Can export stock reports', 'group' => 'Stock'],
            
            // Sales Management
            ['name' => 'selling.view', 'display_name' => 'View Sales', 'description' => 'Can view sales list', 'group' => 'Sales'],
            ['name' => 'selling.create', 'display_name' => 'Create Sale', 'description' => 'Can create new sales', 'group' => 'Sales'],
            ['name' => 'selling.edit', 'display_name' => 'Edit Sale', 'description' => 'Can edit existing sales', 'group' => 'Sales'],
            ['name' => 'selling.delete', 'display_name' => 'Delete Sale', 'description' => 'Can delete sales', 'group' => 'Sales'],
            ['name' => 'selling.export', 'display_name' => 'Export Sales', 'description' => 'Can export sales reports', 'group' => 'Sales'],
            
            // Customers Management
            ['name' => 'customers.view', 'display_name' => 'View Customers', 'description' => 'Can view customers list', 'group' => 'Customers'],
            ['name' => 'customers.create', 'display_name' => 'Create Customer', 'description' => 'Can create new customers', 'group' => 'Customers'],
            ['name' => 'customers.edit', 'display_name' => 'Edit Customer', 'description' => 'Can edit existing customers', 'group' => 'Customers'],
            ['name' => 'customers.delete', 'display_name' => 'Delete Customer', 'description' => 'Can delete customers', 'group' => 'Customers'],
            
            // Suppliers Management
            ['name' => 'suppliers.view', 'display_name' => 'View Suppliers', 'description' => 'Can view suppliers list', 'group' => 'Suppliers'],
            ['name' => 'suppliers.create', 'display_name' => 'Create Supplier', 'description' => 'Can create new suppliers', 'group' => 'Suppliers'],
            ['name' => 'suppliers.edit', 'display_name' => 'Edit Supplier', 'description' => 'Can edit existing suppliers', 'group' => 'Suppliers'],
            ['name' => 'suppliers.delete', 'display_name' => 'Delete Supplier', 'description' => 'Can delete suppliers', 'group' => 'Suppliers'],
            
            // Delivery Orders Management
            ['name' => 'delivery_orders.view', 'display_name' => 'View Delivery Orders', 'description' => 'Can view delivery orders list', 'group' => 'Delivery Orders'],
            ['name' => 'delivery_orders.create', 'display_name' => 'Create Delivery Order', 'description' => 'Can create new delivery orders', 'group' => 'Delivery Orders'],
            ['name' => 'delivery_orders.edit', 'display_name' => 'Edit Delivery Order', 'description' => 'Can edit existing delivery orders', 'group' => 'Delivery Orders'],
            ['name' => 'delivery_orders.delete', 'display_name' => 'Delete Delivery Order', 'description' => 'Can delete delivery orders', 'group' => 'Delivery Orders'],
            ['name' => 'delivery_orders.export', 'display_name' => 'Export Delivery Orders', 'description' => 'Can export delivery orders reports', 'group' => 'Delivery Orders'],
            
            // Vehicle Service Management
            ['name' => 'vehicle_services.view', 'display_name' => 'View Vehicle Services', 'description' => 'Can view vehicle services list', 'group' => 'Vehicle Services'],
            ['name' => 'vehicle_services.create', 'display_name' => 'Create Vehicle Service', 'description' => 'Can create new vehicle services', 'group' => 'Vehicle Services'],
            ['name' => 'vehicle_services.edit', 'display_name' => 'Edit Vehicle Service', 'description' => 'Can edit existing vehicle services', 'group' => 'Vehicle Services'],
            ['name' => 'vehicle_services.delete', 'display_name' => 'Delete Vehicle Service', 'description' => 'Can delete vehicle services', 'group' => 'Vehicle Services'],
            ['name' => 'vehicle_services.export', 'display_name' => 'Export Vehicle Services', 'description' => 'Can export vehicle services reports', 'group' => 'Vehicle Services'],
            
            // Vehicles Management
            ['name' => 'vehicles.view', 'display_name' => 'View Vehicles', 'description' => 'Can view vehicles list', 'group' => 'Vehicles'],
            ['name' => 'vehicles.create', 'display_name' => 'Create Vehicle', 'description' => 'Can create new vehicles', 'group' => 'Vehicles'],
            ['name' => 'vehicles.edit', 'display_name' => 'Edit Vehicle', 'description' => 'Can edit existing vehicles', 'group' => 'Vehicles'],
            ['name' => 'vehicles.delete', 'display_name' => 'Delete Vehicle', 'description' => 'Can delete vehicles', 'group' => 'Vehicles'],
            
            // Drivers Management
            ['name' => 'drivers.view', 'display_name' => 'View Drivers', 'description' => 'Can view drivers list', 'group' => 'Drivers'],
            ['name' => 'drivers.create', 'display_name' => 'Create Driver', 'description' => 'Can create new drivers', 'group' => 'Drivers'],
            ['name' => 'drivers.edit', 'display_name' => 'Edit Driver', 'description' => 'Can edit existing drivers', 'group' => 'Drivers'],
            ['name' => 'drivers.delete', 'display_name' => 'Delete Driver', 'description' => 'Can delete drivers', 'group' => 'Drivers'],
            
            // Transport Management
            ['name' => 'transport.view', 'display_name' => 'View Transport', 'description' => 'Can view transport list', 'group' => 'Transport'],
            ['name' => 'transport.create', 'display_name' => 'Create Transport', 'description' => 'Can create new transport', 'group' => 'Transport'],
            ['name' => 'transport.edit', 'display_name' => 'Edit Transport', 'description' => 'Can edit existing transport', 'group' => 'Transport'],
            ['name' => 'transport.delete', 'display_name' => 'Delete Transport', 'description' => 'Can delete transport', 'group' => 'Transport'],
            ['name' => 'transport.export', 'display_name' => 'Export Transport', 'description' => 'Can export transport reports', 'group' => 'Transport'],
            
            // Spending Management
            ['name' => 'spending.view', 'display_name' => 'View Cash Flow', 'description' => 'Can view spending/cash flow', 'group' => 'Cash Flow'],
            ['name' => 'spending.create', 'display_name' => 'Create Spending', 'description' => 'Can create new spending records', 'group' => 'Cash Flow'],
            ['name' => 'spending.edit', 'display_name' => 'Edit Spending', 'description' => 'Can edit existing spending records', 'group' => 'Cash Flow'],
            ['name' => 'spending.delete', 'display_name' => 'Delete Spending', 'description' => 'Can delete spending records', 'group' => 'Cash Flow'],
            ['name' => 'spending.export', 'display_name' => 'Export Cash Flow', 'description' => 'Can export cash flow reports', 'group' => 'Cash Flow'],
            
            // Spending Categories Management
            ['name' => 'spending_categories.view', 'display_name' => 'View Spending Categories', 'description' => 'Can view spending categories', 'group' => 'Spending Categories'],
            ['name' => 'spending_categories.create', 'display_name' => 'Create Spending Category', 'description' => 'Can create new spending categories', 'group' => 'Spending Categories'],
            ['name' => 'spending_categories.edit', 'display_name' => 'Edit Spending Category', 'description' => 'Can edit existing spending categories', 'group' => 'Spending Categories'],
            ['name' => 'spending_categories.delete', 'display_name' => 'Delete Spending Category', 'description' => 'Can delete spending categories', 'group' => 'Spending Categories'],
            
            // Tax Management
            ['name' => 'tax.view', 'display_name' => 'View Tax', 'description' => 'Can view tax settings', 'group' => 'Tax'],
            ['name' => 'tax.create', 'display_name' => 'Create Tax', 'description' => 'Can create new tax settings', 'group' => 'Tax'],
            ['name' => 'tax.edit', 'display_name' => 'Edit Tax', 'description' => 'Can edit existing tax settings', 'group' => 'Tax'],
            ['name' => 'tax.delete', 'display_name' => 'Delete Tax', 'description' => 'Can delete tax settings', 'group' => 'Tax'],
            
            // Closing Management
            ['name' => 'closing.view', 'display_name' => 'View Closing', 'description' => 'Can view closing reports', 'group' => 'Closing'],
            ['name' => 'closing.create', 'display_name' => 'Create Closing', 'description' => 'Can create closing reports', 'group' => 'Closing'],
            ['name' => 'closing.edit', 'display_name' => 'Edit Closing', 'description' => 'Can edit closing reports', 'group' => 'Closing'],
            ['name' => 'closing.delete', 'display_name' => 'Delete Closing', 'description' => 'Can delete closing reports', 'group' => 'Closing'],
            ['name' => 'closing.export', 'display_name' => 'Export Closing', 'description' => 'Can export closing reports', 'group' => 'Closing'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']], 
                $permission
            );
        }
    }
}
