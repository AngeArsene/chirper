<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateChirpCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('comment')) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'min:5', 'max:255', 'different:old_message'],
        ];
    }

    /**
     * Custom error messages for validation failures.
     *
     * @return array<string, string> Map of rule keys to messages
     *
     * @throws ValidationException When validation fails (handled by the framework)
     */
    public function messages(): array
    {
        return [
            'message.required' => 'Please write something to comment.',
            'message.max' => 'Comments must be :max characters or less.',
            'message.min' => 'Comments must be at least :min characters.',
            'message.different' => 'The new comment must be different from the old one.',
        ];
    }
}
