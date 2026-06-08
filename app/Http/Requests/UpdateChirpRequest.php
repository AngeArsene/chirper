<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

/**
 * Request object that validates an update to an existing Chirp.
 */
class UpdateChirpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @throws AuthorizationException When the user is not authorized
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->id === $this->route('chirp')->user_id;
    }

    /**
     * Validation rules for the update request.
     *
     * @return array<string, Rule|array<mixed>|string>
     *
     * @throws ValidationException When validation fails (handled by the framework)
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
            'message.required' => 'Please write something to chirp.',
            'message.max' => 'Chirps most be :max characters or less.',
            'message.min' => 'Chirps must be at least :min characters.',
            'message.different' => 'The new message must be different from the old message.',
        ];
    }

    /**
     * Attach additional validation after the base rules run.
     *
     * Adds a post-validation check to ensure the submitted `message` is
     * actually different from the existing chirp's `message` retrieved
     * from the route. If equal, a validation error will be added.
     *
     * @param  Validator  $validator  The validator instance used for this request
     *
     * @throws \RuntimeException If the route does not contain a `chirp` model
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $chirp = $this->route('chirp'); // get the chirp from the route
            if (! $chirp) {
                throw new \RuntimeException('Route parameter "chirp" is required for UpdateChirpRequest.');
            }

            if ($this->input('message') === $chirp->message) {
                $validator->errors()->add('message', 'The new message must be different from the old message.');
            }
        });
    }
}
