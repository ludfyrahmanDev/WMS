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
            'name'      => ['string', 'required'],
            'phone'     => ['string', 'required'],
            'ongkosan'  => ['required'],
            'borongan'  => ['required'],
            'address'   => ['string', 'required']
        ];
    }
}
