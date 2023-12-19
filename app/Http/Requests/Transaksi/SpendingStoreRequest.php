<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class SpendingStoreRequest extends FormRequest
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
            'spending_category' => ['required'],
            'description' => ['required'],
            'nominal' => ['required'],
            'tanggal' => ['required'],
            'mutasi' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'spending_category.required' => 'Kategori Pengeluaran tidak boleh kosong',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'nominal' => 'Nominal tidak boleh kosong',
            'tanggal' => 'Tanggal tidak boleh kosong',
            'mutasi' => 'Mutasi tidak boleh kosong'
        ];
    }
}
