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
            'ongkosan'  => ['required'],
            'borongan'  => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Nama customer tidak boleh kosong',
            'ongkosan'          => 'Ongkosan tidak boleh kosong',
            'borongan'          => 'Borongan tidak boleh kosong'
        ];
    }
}
