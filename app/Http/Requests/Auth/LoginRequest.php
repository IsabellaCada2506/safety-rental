<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-06
 * Description: Form request for validating and authenticating login credentials.
 */

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
            'remember' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    public function authenticate(): void
    {
        if (! Auth::attempt($this->credentials(), $this->shouldRemember())) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
    }

    private function credentials(): array
    {
        return [
            'email' => (string) $this->validated('email'),
            'password' => (string) $this->validated('password'),
        ];
    }

    private function shouldRemember(): bool
    {
        return $this->boolean('remember');
    }
}
