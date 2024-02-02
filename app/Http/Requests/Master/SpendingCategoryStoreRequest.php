<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class SpendingCategoryStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'spending_category'  => ['required']
            // 'spending_types'     => ['required']
        ];
    }

    public function messages()
    {
        return [
            'spending_category.required' => 'Kategori pengeluaran tidak boleh kosong'
            // 'spending_types.required'    => 'Tipe pengeluaran tidak boleh kosong'
        ];
    }
}
