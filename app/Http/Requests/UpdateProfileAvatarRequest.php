<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UpdateProfileAvatarRequest extends FormRequest
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
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
        ];
    }

    #[Override]
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
