<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * Validate profile password-change submissions.
 */
class UpdatePasswordRequest extends FormRequest
{
    /**
     * Allow the authenticated user to change their password.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules for the password-change form.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', Password::defaults(), 'current_password'],
            'password' => ['required', 'string', 'confirmed', Password::defaults(), 'different:current_password'],
        ];
    }

    /**
     * Get the validation messages for password change errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'current_password.current_password' => 'The provided password does not match your current password.',
            'password.different' => 'The new password must be different from the current password.',
        ];
    }
}
