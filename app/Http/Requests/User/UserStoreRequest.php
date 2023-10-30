<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'email'     => ['email', 'required', 'unique:users'],
            'role'      => ['required'],
            'gender'    => ['required'],
            'password'  => ['required', 'min:8', 'confirmed'],
            'file'     => ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
