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
            // 'dashboard' => [
            //     'icon' => 'home',
            //     'title' => 'Dashboard',
            //     'sub_menu' => [
            //         'dashboard-overview-1' => [
            //             'icon' => 'activity',
            //             'route_name' => 'dashboard-overview-1',
            //             'params' => [
            //                 'layout' => 'side-menu',
            //             ],
            //             'title' => 'Overview 1'
            //         ],
            //         'dashboard-overview-2' => [
            //             'icon' => 'activity',
            //             'route_name' => 'dashboard-overview-2',
            //             'params' => [
            //                 'layout' => 'side-menu',
            //             ],
            //             'title' => 'Overview 2'
            //         ],
            //         'dashboard-overview-3' => [
            //             'icon' => 'activity',
            //             'route_name' => 'dashboard-overview-3',
            //             'params' => [
            //                 'layout' => 'side-menu',
            //             ],
            //             'title' => 'Overview 3'
            //         ],
            //         'dashboard-overview-4' => [
            //             'icon' => 'activity',
            //             'route_name' => 'dashboard-overview-4',
            //             'params' => [
            //                 'layout' => 'side-menu',
            //             ],
            //             'title' => 'Overview 4'
            //         ]
            //     ]
            // ],
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
                        'icon' => 'activity',
                        'route_name' => 'users.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'User'
                    ],
                    'users-layout-2' => [
                        'icon' => 'activity',
                        'route_name' => 'users-layout-2',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Jabatan'
                    ],
                    'users-layout-3' => [
                        'icon' => 'activity',
                        'route_name' => 'driver.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Driver'
                    ]
                ]
            ],
            'menu-layout' => [
                'icon' => 'box',
                'title' => 'Produk',
                'sub_menu' => [
                    'side-menu' => [
                        'icon' => 'box',
                        'route_name' => 'product-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Kategori Produk'
                    ],
                    'simple-menu' => [
                        'icon' => 'box',
                        'route_name' => 'product-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Produk'
                    ],
                ]
            ],
            'master' => [
                'icon' => 'users',
                'title' => 'Master Data',
                'sub_menu' => [
                    'users-layout-1' => [
                        'icon' => 'activity',
                        'route_name' => 'users-layout-1',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Kendaraan'
                    ],
                    'users-layout-2' => [
                        'icon' => 'activity',
                        'route_name' => 'users-layout-2',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Supplier'
                    ],
                    'users-layout-3' => [
                        'icon' => 'activity',
                        'route_name' => 'users-layout-3',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Customer'
                    ]
                ]
            ],
            'divider',
            'transaction' => [
                'icon' => 'shopping-bag',
                'title' => 'Transaksi',
                'sub_menu' => [
                    'categories' => [
                        'icon' => 'activity',
                        'route_name' => 'categories',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Kategori Pengeluaran'
                    ],


                    'purchases' => [
                        'icon' => 'activity',
                        'title' => 'Pembelian',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'transaction-list',
                    ],
                    'sellings' => [
                        'icon' => 'activity',
                        'title' => 'Penjualan',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'transaction-list',
                    ],
                    'sellings' => [
                        'icon' => 'activity',
                        'title' => 'Transaksi Lain Lain',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'transaction-list',
                    ],
                ]
            ],
        ];
    }
}
