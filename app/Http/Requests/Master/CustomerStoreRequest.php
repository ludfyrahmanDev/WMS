<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'      => ['required'],
            'phone'     => ['required', 'numeric'],
            'ongkosan'  => ['required'],
            'borongan'  => ['required'],
            'address'   => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Nama customer tidak boleh kosong',
            'phone.required'    => 'No Handphone tidak boleh kosong',
            'phone.numeric'     => 'No Handphone hanya boleh angka',
            'ongkosan'          => 'Ongkosan tidak boleh kosong',
            'borongan'          => 'Borongan tidak boleh kosong',
            'address'           => 'Alamat tidak boleh kosong'
        ];
    }
}
