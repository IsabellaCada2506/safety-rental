<?php

// Author: Isabella Cadavid Posada

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ];
    }

    public function getToken(): string
    {
        return (string) $this->validated('token');
    }

    public function getEmail(): string
    {
        return (string) $this->validated('email');
    }

    public function getPassword(): string
    {
        return (string) $this->validated('password');
    }
}
