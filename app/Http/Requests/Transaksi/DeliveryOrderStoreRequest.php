<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryOrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->input('mode') === 'confirm') {
            return [];
        }

        return [
            'tanggal_pembelian' => ['required'],
            'tanggal_pengambilan' => ['required'],
            'supplier' => ['required'],
            'driver' => ['required'],
            'kendaraan' => ['required'],
            'produk_id' => ['required'],
            'total_bayar' => ['required'],
            'tipe_pembelian' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'tanggal_pembelian.required' => 'Tanggal Pembelian tidak boleh kosong!',
            'tanggal_pengambilan.required' => 'Tanggal Pengambilan tidak boleh kosong!',
            'supplier.required' => 'Supplier tidak boleh kosong!',
            'driver.required' => 'Driver tidak boleh kosong!',
            'kendaraan.required' => 'Kendaraan tidak boleh kosong!',
            'produk_id.required' => 'Tabel Produk wajib ada data minimal 1!',
            'total_bayar.required' => 'Total Bayar tidak boleh kosong!',
            'tipe_pembelian.required' => 'Tipe Pembelian tidak boleh kosong!',
        ];
    }
    
}
