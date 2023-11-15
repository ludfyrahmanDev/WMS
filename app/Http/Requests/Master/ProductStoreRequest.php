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
            'product_category'  => ['required'],
            'product'           => ['required'],
            'price'             => ['required'],
            'price_sell'        => ['required']
        ];
    }

    public function messages()
    {
        return [
            'product_category.required' => 'Kategori produk tidak boleh kosong',
            'product.required'          => 'Nama produk tidak boleh kosong',
            'price'                     => 'Harga/KG tidak boleh kosong',
            'price_sell'                => 'Harga jual tidak boleh kosong'
        ];
    }
}
