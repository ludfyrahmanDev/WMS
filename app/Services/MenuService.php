<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Main\SideMenu;

class MenuService
{
    /**
     * Get filtered menu based on user permissions
     */
    public static function getFilteredMenu(): array
    {
        $user = Auth::user();
        $allMenus = SideMenu::menu();
        
        // If user is not authenticated, return empty menu
        if (!$user || !$user->role) {
            return [];
        }
        
        // If user has super_admin role, return all menus
        if ($user->role->name === 'super_admin') {
            return $allMenus;
        }
        
        $filteredMenus = [];
        
        foreach ($allMenus as $menuKey => $menu) {
            // Handle dividers
            if ($menu === 'divider') {
                $filteredMenus[$menuKey] = $menu;
                continue;
            }
            
            // Check if menu has sub_menu
            if (isset($menu['sub_menu'])) {
                $filteredSubMenus = [];
                
                foreach ($menu['sub_menu'] as $subMenuKey => $subMenu) {
                    if (self::canAccessMenu($subMenu, $user)) {
                        $filteredSubMenus[$subMenuKey] = $subMenu;
                    }
                }
                
                // If user has access to any sub menu, include the parent menu
                if (!empty($filteredSubMenus)) {
                    $menu['sub_menu'] = $filteredSubMenus;
                    $filteredMenus[$menuKey] = $menu;
                }
            } else {
                // Check single menu item
                if (self::canAccessMenu($menu, $user)) {
                    $filteredMenus[$menuKey] = $menu;
                }
            }
        }
        
        return $filteredMenus;
    }
    
    /**
     * Check if user can access a menu item
     */
    private static function canAccessMenu(array $menu, $user): bool
    {
        // Map route names to required permissions
        $routePermissions = [
            // Dashboard
            'dashboard' => 'dashboard.view',
            
            // Users & Roles
            'users.index' => 'users.view',
            'role.index' => 'roles.view',
            
            // Products
            'product.index' => 'products.view',
            'category.index' => 'categories.view',
            'stockIndex' => 'stock.view',
            
            // Master Data
            'vehicle.index' => 'vehicles.view',
            'driver.index' => 'drivers.view',
            'supplier.index' => 'suppliers.view',
            'customer.index' => 'customers.view',
            'spendingCategory.index' => 'spending_categories.view',
            'tax.index' => 'tax.view',
            'cv.index' => 'cv.view',
            
            // Transactions
            'spending.create' => 'spending.create',
            'delivery_order.create' => 'delivery_orders.create',
            'selling.create' => 'selling.create',
            'vehicle_service.create' => 'vehicle_services.create',
            
            // Reports
            'spending.index' => 'spending.view',
            'delivery_order.index' => 'delivery_orders.view',
            'selling.index' => 'selling.view',
            'vehicle_service.index' => 'vehicle_services.view',
            'transport.index' => 'transport.view',
            
            // Closing
            'closing.index' => 'closing.view',
        ];
        
        // Get required permission for this route
        if (!isset($menu['route_name'])) {
            return true; // Allow access if no route specified
        }
        
        $routeName = $menu['route_name'];
        $requiredPermission = $routePermissions[$routeName] ?? null;
        
        // If no specific permission required, allow access
        if (!$requiredPermission) {
            return true;
        }
        
        // Check if user has the required permission
        return $user->hasPermission($requiredPermission);
    }
}
