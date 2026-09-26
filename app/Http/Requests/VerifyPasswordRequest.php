<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * Validate password confirmation requests.
 */
class VerifyPasswordRequest extends FormRequest
{
    /**
     * Allow the user to confirm their password.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules for the password confirmation form.
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
     * Get the validation messages for password confirmation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.required' => 'Please enter your password.',
            'password.string' => 'The password must be a valid string.',
            'password.current_password' => 'The password you entered is incorrect.',
        ];
    }
}
