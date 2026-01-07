<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class VehicleServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'driver' => ['required', 'exists:driver,id'],
            'kendaraan' => ['required', 'exists:vehicle,id'],
            'keterangan' => ['required', 'array'],
            'total_pengeluaran' => ['required', 'array'],
            'payment_method' => ['required', 'array', 'in:CASH,TRANSFER'],
            'cv_id' => ['nullable', 'exists:cv,id'],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Tanggal tidak boleh kosong!',
            'driver.required' => 'Driver tidak boleh kosong!',
            'kendaraan.required' => 'Kendaraan tidak boleh kosong!',
            'total_pengeluaran.required' => 'Total pengeluaran tidak boleh kosong!',
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'payment_method.required' => 'Jenis pembayaran tidak boleh kosong!',
            'payment_method.in' => 'Jenis pembayaran harus CASH atau TRANSFER!',
            'cv_id.exists' => 'Perusahaan tidak valid!',
        ];
    }
}
