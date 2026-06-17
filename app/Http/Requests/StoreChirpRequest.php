<?php

namespace App\Http\Requests;

use App\Models\Chirp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChirpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', Chirp::class) ?? false;
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
            'idempotency_key' => ['required', 'uuid', Rule::unique('chirps', 'idempotency_key')],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'message.required' => 'Please write something to chirp.',
            'message.max' => 'Chirps most be :max characters or less.',
            'message.min' => 'Chirps must be at least :min characters.',
            'idempotency_key.unique' => 'It looks like this chirp was already submitted.',
        ];
    }
}
