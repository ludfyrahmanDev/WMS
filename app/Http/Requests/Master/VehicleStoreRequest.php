<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class VehicleStoreRequest extends FormRequest
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
            'license_plate' => ['required'],
            'brand' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'license_plate.required' => 'Pelat Nomor tidak boleh kosong',
            'brand' => 'Brand tidak boleh kosong'
        ];
    }
}
