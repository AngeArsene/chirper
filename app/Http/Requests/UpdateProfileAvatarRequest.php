<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validate avatar uploads for a user profile update.
 */
class UpdateProfileAvatarRequest extends FormRequest
{
    /**
     * Determine whether the current request is authorized for an authenticated user.
     *
     * @return bool True when a logged-in user is present.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Define the validation rules for the uploaded profile avatar.
     *
     * @return array<string, ValidationRule|array<mixed>|string> Validation metadata for the avatar field.
     */
    public function rules(): array
    {
        return [
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
        ];
    }

    /**
     * Provide custom validation messages for profile avatar upload errors.
     *
     * @return array<string, string> Human-readable validation messages keyed by field rule.
     */
    public function messages(): array
    {
        return [
            'avatar.required' => 'Please choose an image to upload.',
            'avatar.image' => 'The file must be an image.',
            'avatar.mimes' => 'Please upload a JPG, PNG, or WEBP image.',
            'avatar.max' => 'Image must be smaller than 1MB.',
        ];
    }
}
