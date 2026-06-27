<label class="floating-label mb-2">
    <input type="password"
           name="password"
           placeholder="••••••••"
           class="input input-bordered @error('password') input-error @enderror"
           minLength="8"
           maxLength="255"
           required>
    <span>{{ __('Password') }}</span>
</label>
@error('password')
    <div class="mt-2 mb-4 p-4 text-sm text-error whitespace-normal break-words">
        {{ __($message) }}
    </div>
@else
    <div class="mb-4 p-3 bg-base-200 rounded text-sm space-y-1">
        <p class="font-semibold text-xs uppercase text-base-content opacity-70">Password Requirements:</p>
        <ul class="list-disc list-inside space-y-1 text-xs text-base-content opacity-80">
            <li>{{ __('At least 8 characters') }}</li>
            <li>{{ __('Mixed case letters (uppercase & lowercase)') }}</li>
            <li>{{ __('At least one number') }}</li>
            <li>{{ __('At least one symbol (!@#$%^&*)') }}</li>
        </ul>
    </div>
@enderror
