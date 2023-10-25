<?php
namespace App\Enums;

use BenSampo\Enum\Enum;

final class Account extends Enum
{
    const AKTIVA = [
        [
            'code'  => '11',
            'name'  => 'AKTIVA LANCAR',
            'value' => 0,
            'child' => [
                [
                    'code'  => '1101.01',
                    'name'  => 'Kas',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1101.02',
                    'name'  => 'Kas Cabang',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1101.03',
                    'name'  => 'Kas Kasir',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1102.01',
                    'name'  => 'Bank',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1103.01',
                    'name'  => 'Piutang Usaha',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1103.02',
                    'name'  => 'Piutang Dagang (penjualan yg statusnya cicilan)',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1103.03',
                    'name'  => 'Piutang Reseller',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1103.04',
                    'name'  => 'Piutang Antar Cabang',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1104.01',
                    'name'  => 'Persediaan Barang Dagang',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1104.02',
                    'name'  => 'Persediaan Gudang',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1104.03',
                    'name'  => 'Persediaan Konsinyasi',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1105.01',
                    'name'  => 'Perlengkapan',
                    'value' => 0,
                    'addition' => true
                ],
            ]
        ],
    ];
    const AKTIVA_TETAP = [
        [
            'code'  => '12',
            'name'  => 'AKTIVA TETAP',
            'value' => 0,
            'child' => [
                [
                    'code'  => '1201.01',
                    'name'  => 'Tanah',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1202.01',
                    'name'  => 'Gedung',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1202.02',
                    'name'  => 'Akumulasi Penyusutan Gedung',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1203.01',
                    'name'  => 'Peralatan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '1203.02',
                    'name'  => 'Akumulasi Penyusutan Peralatan',
                    'value' => 0,
                    'addition' => true
                ],
            ]
        ],
    ];
    const AKTIVA_LAIN_LAIN = [
        [
            'code'  => '13',
            'name'  => 'AKTIVA LAIN LAIN',
            'value' => 0,
            'child' => []
        ],
    ];
    const AKTIVA_ANTAR_CABANG = [
        [
            'code'  => '14',
            'name'  => 'AKTIVA ANTAR CABANG',
            'value' => 0,
            'child' => []
        ],
    ];
    const KEWAJIBAN_JANGKA_PENDEK = [
        [
            'code'  => '21',
            'name'  => 'KEWAJIBAN JANGKA PENDEK',
            'value' => 0,
            'child' => [
                [
                    'code'  => '2102.01',
                    'name'  => 'Hutang Usaha',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '2102.02',
                    'name'  => 'Hutang Dagang',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '2103.03',
                    'name'  => 'Hutang Pajak',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '2101.04',
                    'name'  => 'Simpanan KWB',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '2101.05',
                    'name'  => 'Hutang Konsinyasi',
                    'value' => 0,
                    'addition' => true
                ],
            ]
        ],
    ];
    const KEWAJIBAN_JANGKA_PANJANG = [
        [
            'code'  => '22',
            'name'  => 'KEWAJIBAN JANGKA PANJANG',
            'value' => 0,
            'child' => []
        ],
    ];
    const KEWAJIBAN_ANTAR_CABANG = [
        [
            'code'  => '23',
            'name'  => 'KEWAJIBAN ANTAR CABANG',
            'value' => 0,
            'child' => [
                [
                    'code'  => '2301.01',
                    'name'  => 'Hutang Antar Cabang',
                    'value' => 0,
                    'addition' => true
                ],

            ]
        ],
    ];
    const MODAL = [
        [
            'code'  => '31',
            'name'  => 'MODAL',
            'value' => 0,
            'child' => [
                [
                    'code'  => '3101.01',
                    'name'  => 'Modal Penyertaan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '3191.00',
                    'name'  => 'R/L Ditahan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '3199.00',
                    'name'  => 'R/L Berjalan',
                    'value' => 0,
                    'addition' => true
                ],
            ]
        ],
    ];
    const SELLING = [
        [
            'code'  => '41',
            'name'  => 'PENJUALAN',
            'value' => 0,
            'child' => [
                [
                    'code'  => '4101.00',
                    'name'  => 'Penjualan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '4101.02',
                    'name'  => 'Penjualan Konsinyasi',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '4102.00',
                    'name'  => 'Potongan Pembelian',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '4103.00',
                    'name'  => 'Pendapatan Penjualan Lainnya',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '4104.00',
                    'name'  => 'Retur Penjualan',
                    'value' => 0,
                    'addition' => false
                ],
            ]
        ],
    ];
    const MUTASI_KE_ANTAR_CABANG = [
        [
            'code'  => '42',
            'name'  => 'MUTASI KE ANTAR CABANG',
            'value' => 0,
            'child' => []
        ],
    ];
    const PURCHASE = [
        [
            'code'  => '51',
            'name'  => 'HARGA POKOK PEMBELIAN',
            'value' => 0,
            'child' => [
                [
                    'code'  => '5101.01',
                    'name'  => 'Harga Pokok Penjualan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '5102.00',
                    'name'  => 'Beban Selisih Persediaan (Opname)',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '5103.00',
                    'name'  => 'Potongan Penjualan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '5104.00',
                    'name'  => 'Retur Pembelian',
                    'value' => 0,
                    'addition' => false
                ],
            ]
        ],
    ];
    const MUTASI_DARI_ANTAR_CABANG = [
        [
            'code'  => '52',
            'name'  => 'MUTASI DARI ANTAR CABANG',
            'value' => 0,
            'child' => [
                [
                    'code'  => '5201.00',
                    'name'  => 'Terima Dari Cabang Lain',
                    'value' => 0,
                    'addition' => true
                ],
            ]
        ],
    ];
    const OPERATING = [
        [
            'code'  => '61',
            'name'  => 'BEBAN USAHA',
            'value' => 0,
            'child' => [
                [
                    'code'  => '6111.01',
                    'name'  => 'Beban Prive / PKS',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6111.02',
                    'name'  => 'Beban Administrasi Bank',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6111.03',
                    'name'  => 'Beban Pajak Bank',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6112.01',
                    'name'  => 'Beban Transport',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6112.02',
                    'name'  => 'Beban Angkut Pembelian',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6112.03',
                    'name'  => 'Beban Angkut Penjualan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6113.01',
                    'name'  => 'Beban Gaji Karyawan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6113.02',
                    'name'  => 'Beban Insentif Kinerja',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6113.03',
                    'name'  => 'Beban Asuransi Karyawan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6114.01',
                    'name'  => 'Beban Sewa Peralatan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6114.02',
                    'name'  => 'Beban Sewa Gedung',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6115.01',
                    'name'  => 'Beban Operasional Toko',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6115.02',
                    'name'  => 'Beban Pemeliharaan Peralatan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6115.03',
                    'name'  => 'Beban Pemeliharaan Gedung',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6115.04',
                    'name'  => 'Beban Langganan Daya Jasa',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6115.05',
                    'name'  => 'Beban Perlengkapan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6116.01',
                    'name'  => 'Beban Iklan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6116.02',
                    'name'  => 'Beban Promosi',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6117.01',
                    'name'  => 'Beban ZIS',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6118.01',
                    'name'  => 'Beban Penyusutan Peralatan',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6118.02',
                    'name'  => 'Beban Penyusutan Gedung',
                    'value' => 0,
                    'addition' => true
                ],
                [
                    'code'  => '6119.09',
                    'name'  => 'Beban Usaha lainnya',
                    'value' => 0,
                    'addition' => true
                ],
            ]
        ],
    ];

    const PENDAPATAN_LAIN_LAIN = [
        [
            'code'  => '71',
            'name'  => 'PENDAPATAN LAIN-LAIN',
            'value' => 0,
            'child' => [
                [
                    'code'  => '7101.01',
                    'name'  => 'Pendapatan Jasa Bank',
                    'value' => 0,
                    'addition'=> true,
                ],
                [
                    'code'  => '7101.02',
                    'name'  => 'Pendapatan lain-lain',
                    'value' => 0,
                    'addition'=> true,
                ],
                [
                    'code'  => '7102.01',
                    'name'  => 'Keuntungan Penjualan Aset Tetap',
                    'value' => 0,
                    'addition'=> true,
                ],
            ]
        ],
    ];

    const ADDITIONAL_COST = [
        [
            'code'  => '81',
            'name'  => 'BIAYA LAIN-LAIN',
            'value' => 0,
            'child' => [
                [
                    'code'  => '8101.01',
                    'name'  => 'Kerugian Penghapusan Piutang Tak Tertagih',
                    'value' => 0,
                    'addition'=> true,
                ],
                [
                    'code'  => '8102.02',
                    'name'  => 'Kerugian Penghapusan Aset Tetap',
                    'value' => 0,
                    'addition'=> true,
                ],
            ]
        ],
    ];


}

?>
