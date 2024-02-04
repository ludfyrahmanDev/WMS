<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class VehicleServiceStoreRequest extends FormRequest
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
        return [
            'tanggal' => ['required'],
            'driver' => ['required'],
            'kendaraan' => ['required'],
            'keterangan' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'tanggal.required' => 'Tanggal tidak boleh kosong!',
            'driver.required' => 'Driver tidak boleh kosong!',
            'kendaraan.required' => 'Kendaraan tidak boleh kosong!',
            'keterangan.required' => 'Tabel Pengeluaran wajib ada data minimal 1!'
        ];
    }
}
