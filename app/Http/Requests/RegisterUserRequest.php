<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() === null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'accepted' => ['accepted'],
            'name'     => ['required', 'string', 'max:255', 'min:4'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required', 'string', Password::min(8)->max(255)->letters()->mixedCase()->numbers()->symbols()->uncompromised()
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'accepted.accepted' => 'You must accept the Terms and Conditions.',
        ];
    }
}
