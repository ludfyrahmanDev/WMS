<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class TransportStoreRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->input('mode') === 'Konfirmasi') {
            return [];
        }

        return [
            'tgl_jual' => ['required'],
            'vehicle' => ['required'],
            'driver' => ['required'],
            'product' => ['required'],
            'customer' => ['required'],
            'weight' => ['required'],
            'ongkosan' => ['required'],
            'cv_id' => ['nullable', 'exists:cv,id'],
            'drivers_pocket_money' => ['required'],
            'setoran' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'tgl_jual.required' => 'Tanggal Penjualan tidak boleh kosong!',
            'vehicle.required' => 'Kendaraan tidak boleh kosong!',
            'driver.required' => 'Driver tidak boleh kosong!',
            'product.required' => 'Produk tidak boleh kosong!',
            'customer.required' => 'Customer tidak boleh kosong!',
            'weight.required' => 'Berat tidak boleh kosong!',
            'ongkosan.required' => 'Ongkosan tidak boleh kosong!',
            'cv_id.exists' => 'CV yang dipilih tidak valid!',
            'drivers_pocket_money.required' => 'Uang saku driver tidak boleh kosong!',
            'setoran.required' => 'Setoran tidak boleh kosong!',
        ];
    }
}
