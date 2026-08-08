<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

/**
 * Validates a password-change submission inside the profile security flow.
 */
class UserPasswordUpdateRequest extends FormRequest
{
    /**
     * Authorizes the authenticated user to submit a password-change request.
     *
     * @return bool Always `true` because the route is already guarded as a profile action.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Defines the password-change validation contract for the profile form.
     *
     * @return array<string, ValidationRule|array<mixed>|string> The keyed validation rules for the
     *                                                           current password and replacement password fields.
     *
     * @throws ValidationException If either required field is absent or fails the
     *                             configured password and current-password rules.
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', Password::defaults(), 'current_password'],
            'password' => ['required', 'string', 'confirmed', Password::defaults(), 'different:current_password'],
        ];
    }

    /**
     * Provides custom error messages for the security-sensitive profile update form.
     *
     * @return array<string, string> A keyed message map for validation error messages shown to the user.
     */
    public function messages(): array
    {
        return [
            'current_password.current_password' => 'The provided password does not match your current password.',
            'password.different' => 'The new password must be different from the current password.',
        ];
    }
}
