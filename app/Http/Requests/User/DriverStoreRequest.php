<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class DriverStoreRequest extends FormRequest
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
            'name' => ['required'],
            'address' => ['required'],
            'phone' => ['max:13', 'required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'address.required' => 'Alamat tidak boleh kosong',
            'phone.max' => 'No Telp maksimal 13 angka',
            'phone.required' => 'No Telp tidak boleh kosong',
        ];
    }
}
