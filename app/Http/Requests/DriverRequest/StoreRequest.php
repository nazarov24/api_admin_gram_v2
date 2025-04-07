<?php

namespace App\Http\Requests\DriverRequest;

use App\Models\Division;
use App\Models\PerformerTransport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                 'division_id' => ['required', Rule::exists(Division::class, 'id')],
                 'first_name' => 'required|string|min:2|max:50',
                 'last_name' => 'required|string|min:2|max:50',
                 'patronymic' => 'string|min:2|max:50',
                 'phone' => [
                     'required',
                     'regex:/^992[0-9]{3,14}$/',
                     'min:12',
                     'max:12'
                 ],
                 'email' => ['nullable', 'email'],
                 'date_of_birth' => 'required|date_format:Y-m-d',
                 'serials_number' => ['nullable', 'string', 'regex:/[A-Z]{2}[0-9]{7}/', 'min:9', 'max:9', 'unique:mysql_performer.performers'],
                 'expirated_driver_license' => 'nullable|date_format:Y-m-d',
                 'gender' => 'required|boolean:0,1',
                 'serial_number_passport' => 'string|min:9|max:9|unique:mysql_performer.performers',
                 'expirated_passport' => 'string|date_format:Y-m-d',
                 'address' => 'string|min:2|max:100',
                 'dop_info' => 'nullable|string',
                 'car_id' => [Rule::exists(PerformerTransport::class, 'id')]
        ];
    }
}
