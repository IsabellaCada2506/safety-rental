<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-13
 * Description: Request validation for displaying the password reset form with an optional email query parameter.
 */

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class ShowResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['nullable', 'string', 'email'],
        ];
    }
}
