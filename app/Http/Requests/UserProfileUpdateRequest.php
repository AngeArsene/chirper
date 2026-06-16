<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
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
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'current_password' => ['required', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'max:255', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.confirmed'        => __('The New password field does not match the Confirm new password field.'),
            'current_password.required' => __('Please enter your current password to confirm changes.'),
        ];
    }
}
