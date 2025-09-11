<?php

namespace App\Services;

class PermissionTranslationService
{
    /**
     * Translate permission names to Indonesian
     */
    public static function translate(string $permission): string
    {
        $translations = [
            // Dashboard
            'dashboard.view' => 'Lihat Dashboard',
            
            // Users
            'users.view' => 'Lihat Pengguna',
            'users.create' => 'Tambah Pengguna',
            'users.edit' => 'Edit Pengguna',
            'users.delete' => 'Hapus Pengguna',
            
            // Roles
            'roles.view' => 'Lihat Role',
            'roles.create' => 'Tambah Role',
            'roles.edit' => 'Edit Role',
            'roles.delete' => 'Hapus Role',
            
            // Products
            'products.view' => 'Lihat Produk',
            'products.create' => 'Tambah Produk',
            'products.edit' => 'Edit Produk',
            'products.delete' => 'Hapus Produk',
            
            // Categories
            'categories.view' => 'Lihat Kategori',
            'categories.create' => 'Tambah Kategori',
            'categories.edit' => 'Edit Kategori',
            'categories.delete' => 'Hapus Kategori',
            
            // Stock
            'stock.view' => 'Lihat Stok',
            'stock.edit' => 'Edit Stok',
            
            // Sales
            'sales.view' => 'Lihat Penjualan',
            'sales.create' => 'Tambah Penjualan',
            'sales.edit' => 'Edit Penjualan',
            'sales.delete' => 'Hapus Penjualan',
            
            // Customers
            'customers.view' => 'Lihat Customer',
            'customers.create' => 'Tambah Customer',
            'customers.edit' => 'Edit Customer',
            'customers.delete' => 'Hapus Customer',
            
            // Suppliers
            'suppliers.view' => 'Lihat Supplier',
            'suppliers.create' => 'Tambah Supplier',
            'suppliers.edit' => 'Edit Supplier',
            'suppliers.delete' => 'Hapus Supplier',
            
            // Vehicles
            'vehicles.view' => 'Lihat Kendaraan',
            'vehicles.create' => 'Tambah Kendaraan',
            'vehicles.edit' => 'Edit Kendaraan',
            'vehicles.delete' => 'Hapus Kendaraan',
            
            // Drivers
            'drivers.view' => 'Lihat Driver',
            'drivers.create' => 'Tambah Driver',
            'drivers.edit' => 'Edit Driver',
            'drivers.delete' => 'Hapus Driver',
            
            // Delivery Orders
            'delivery_orders.view' => 'Lihat Pembelian',
            'delivery_orders.create' => 'Tambah Pembelian',
            'delivery_orders.edit' => 'Edit Pembelian',
            'delivery_orders.delete' => 'Hapus Pembelian',
            
            // Vehicle Services
            'vehicle_services.view' => 'Lihat Servis Kendaraan',
            'vehicle_services.create' => 'Tambah Servis Kendaraan',
            'vehicle_services.edit' => 'Edit Servis Kendaraan',
            'vehicle_services.delete' => 'Hapus Servis Kendaraan',
            
            // Spending
            'spending.view' => 'Lihat Transaksi Lain',
            'spending.create' => 'Tambah Transaksi Lain',
            'spending.edit' => 'Edit Transaksi Lain',
            'spending.delete' => 'Hapus Transaksi Lain',
            
            // Spending Categories
            'spending_categories.view' => 'Lihat Kategori Transaksi',
            'spending_categories.create' => 'Tambah Kategori Transaksi',
            'spending_categories.edit' => 'Edit Kategori Transaksi',
            'spending_categories.delete' => 'Hapus Kategori Transaksi',
            
            // Transport
            'transport.view' => 'Lihat Angkutan',
            'transport.create' => 'Tambah Angkutan',
            'transport.edit' => 'Edit Angkutan',
            'transport.delete' => 'Hapus Angkutan',
            
            // Tax
            'tax.view' => 'Lihat Pajak',
            'tax.create' => 'Tambah Pajak',
            'tax.edit' => 'Edit Pajak',
            'tax.delete' => 'Hapus Pajak',
            
            // Closing
            'closing.view' => 'Lihat Closing',
            'closing.create' => 'Tambah Closing',
            'closing.edit' => 'Edit Closing',
            'closing.delete' => 'Hapus Closing',
        ];
        
        return $translations[$permission] ?? ucfirst(str_replace(['_', '.'], [' ', ' '], $permission));
    }
    
    /**
     * Translate multiple permissions
     */
    public static function translateMultiple(array $permissions): array
    {
        return array_map([self::class, 'translate'], $permissions);
    }
}
