<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class SellingStoreRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->input('mode') === 'Konfirmasi Lunas') {
            return [];
        }
        
        if ($this->input('mode') === 'angsuran') {
            return [
                'angsuran' => ['required']
            ];
        }

        return [
            'tgl_jual' => ['required'],
            'customer' => ['required'],
            'driver' => ['required'],
            'kendaraan' => ['required'],
            'uang_saku' => ['required'],
            'tipe_pembelian' => ['required'],
            'tipe_pembayaran' => ['required'],
            'total_bayar' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'tgl_jual.required' => 'Tanggal Penjualan tidak boleh kosong!',
            'customer.required' => 'Pelanggan tidak boleh kosong!',
            'driver.required' => 'Driver tidak boleh kosong!',
            'kendaraan.required' => 'Kendaraan tidak boleh kosong!',
            'uang_saku.required' => 'Uang Saku tidak boleh kosong!',
            'tipe_pembelian.required' => 'Tipe Pembelian tidak boleh kosong!',
            'tipe_pembayaran.required' => 'Tipe Pembayaran tidak boleh kosong!',
            'total_bayar.required' => 'Total Bayar tidak boleh kosong!',
            'angsuran.required' => 'Angsuran tidak boleh kosong!'
        ];
    }
}
