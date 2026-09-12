<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Request validation for administrator deletion of a user account.
 */

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [];
    }
}
