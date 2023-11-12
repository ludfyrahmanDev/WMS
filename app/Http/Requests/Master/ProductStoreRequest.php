<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
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
        ];
    }

    public function messages()
    {
        return [
            'spending_category.required' => 'Kategori Pengeluaran tidak boleh kosong',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'nominal' => 'Nominal tidak boleh kosong'
        ];
    }
}
