<?php

namespace App\Http\Requests;

use App\Models\ChirpComment;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreChirpCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', ChirpComment::class) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:255', 'min:5'],
            'idempotency_key' => ['required', 'uuid', 'unique:chirps'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'message.required' => 'Please write something to comment.',
            'message.max' => 'Comments must be :max characters or less.',
            'message.min' => 'Comments must be at least :min characters.',
            'idempotency_key.unique' => 'It looks like this comment was already submitted.',
        ];
    }
}
