<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordVerifyRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', Password::defaults(), 'current_password'],
        ];
    }

    /**
     * Get the custom error messages for validation failures.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function messages()
    {
        return [
            'password.required' => 'Please enter your password.',
            'password.string' => 'The password must be a valid string.',
            'password.current_password' => 'The password you entered is incorrect.',
        ];
    }
}
