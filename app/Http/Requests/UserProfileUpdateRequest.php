<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:4'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user()?->id)],
            'current_password' => ['required', 'current_password'],
            'password' => ['nullable', 'string', 'confirmed', Password::default()],
        ];
    }

    public function messages(): array
    {
        return [
            'password.confirmed'                => 'The New password field does not match the Confirm new password field.',
            'current_password.required'         => 'Please enter your current password to confirm changes.',
            'current_password.current_password' => 'The provided current password is incorrect.',
        ];
    }
}
