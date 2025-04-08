<?php

namespace App\Http\Requests\PerformerRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:255',
            'division_id' => 'nullable|exists:divisions,id',
            'city_id' => 'nullable|exists:cities,id',
            'promo_code' => 'nullable|string|max:255',
            'passport_serials' => 'nullable|string|max:9',
            'driver_license_serials' => 'nullable|date',
            'expirated_driver_license' => 'nullable|date',
            'expirated_passport' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'fcm_token' => 'nullable|string|max:255',
            'register_from' => 'nullable|string|max:255',
            'dop_info' => 'nullable|string',
        ];
    }
}
