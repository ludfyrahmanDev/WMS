<?php

namespace App\Main;

class SideMenu
{
    /**
     * List of side menu items.
     */
    public static function menu(): array
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'route_name' => 'dashboard',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Dashboard'
            ],
            'users' => [
                'icon' => 'users',
                'title' => 'Users',
                'sub_menu' => [
                    'users-layout-1' => [
                        'icon' => 'users',
                        'route_name' => 'users.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'User'
                    ],
                    // 'users-layout-2' => [
                    //     'icon' => 'activity',
                    //     'route_name' => 'role.index',
                    //     'params' => [
                    //         'layout' => 'side-menu'
                    //     ],
                    //     'title' => 'Jabatan'
                    // ],
                    'users-layout-3' => [
                        'icon' => 'car',
                        'route_name' => 'driver.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Driver'
                    ]
                ]
            ],
            'product' => [
                'icon' => 'box',
                'title' => 'Produk',
                'sub_menu' => [

                    'product-layout-1' => [
                        'icon' => 'folder',
                        'route_name' => 'category.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Kategori Produk'
                    ],
                    'product-layout-2' => [
                        'icon' => 'box',
                        'route_name' => 'product.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Produk'
                    ],
                    'product-layout-3' => [
                        'icon' => 'list',
                        'route_name' => 'stockIndex',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Stok'
                    ],
                ]
            ],
            'master' => [
                'icon' => 'book',
                'title' => 'Master Data',
                'sub_menu' => [
                    'users-layout-1' => [
                        'icon' => 'car',
                        'route_name' => 'vehicle.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Kendaraan'
                    ],
                    'users-layout-2' => [
                        'icon' => 'truck',
                        'route_name' => 'supplier.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Supplier'
                    ],
                    'users-layout-3' => [
                        'icon' => 'user',
                        'route_name' => 'customer.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Customer'
                    ],
                    'users-layout-4' => [
                        'icon' => 'folders',
                        'route_name' => 'spendingCategory.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Kategori Transaksi Lain Lain'
                    ]
                ]
            ],
            'divider',
            'transaction' => [
                'icon' => 'shopping-bag',
                'title' => 'Transaksi',
                'sub_menu' => [
                    'spending' => [
                        'icon' => 'layout-list',
                        'route_name' => 'spending.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Lain Lain'
                    ],
                    'purchases' => [
                        'icon' => 'shopping-bag',
                        'title' => 'Pembelian',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'delivery_order.create',
                    ],
                    'sellings' => [
                        'icon' => 'shopping-cart',
                        'title' => 'Penjualan',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'selling.create',
                    ],
                    'vehicle_service' => [
                        'icon' => 'bus',
                        'title' => 'Servis Kendaraan',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'vehicle_service.create',
                    ],
                ]
            ],
            'report' => [
                'icon' => 'file',
                'title' => 'Laporan',
                'sub_menu' => [
                    'spending' => [
                        'icon' => 'file-bar-chart',
                        'route_name' => 'spending.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Laporan Pengeluaran'
                    ],
                    'sellings' => [
                        'icon' => 'file-line-chart',
                        'title' => 'Laporan Penjualan',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'selling.index',
                    ],
                    'delivery_order' => [
                        'icon' => 'file-box',
                        'title' => 'Laporan Pembelian',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'delivery_order.index',
                    ],
                    'vehicle_service' => [
                        'icon' => 'file-box',
                        'title' => 'Laporan Servis Kendaraan',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'vehicle_service.index',
                    ],
                    'vehicle_service' => [
                        'icon' => 'file-box',
                        'title' => 'Laporan Angkutan',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'transport.index',
                    ],
                ]
            ],
            'Closing' => [
                'icon' => 'x-octagon',
                'route_name' => 'closing.index',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Closing'
            ],
        ];
    }
}
