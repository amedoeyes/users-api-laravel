<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
            'phone_number' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore(auth()->id())],
            'password' => ['nullable', Password::min(8), 'confirmed'],
            'password_confirmation' => ['required_with:password', Password::min(8)],
        ];
    }
}
