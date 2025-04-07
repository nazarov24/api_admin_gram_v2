<?php

namespace App\Http\Requests\EmployeeRequest;

use App\Models\Division;
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'patronymic' => 'nullable|string',
            'phone' => ['required', 'regex:/^992[0-9]{3,14}$/', 'min:12', 'max:12'],
            'second_phone' => 'nullable|regex:/^992[0-9]{3,14}$/|min:12|max:12',
            'birth_date' => 'nullable|date|before:',
            'gender' => 'nullable|in:0,1',
            'email' => ['required', 'email'],
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'role' => 'required|string|exists:roles,name' 
        ];
    }
}
