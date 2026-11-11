<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-05
 * Description: Request validation for storing a new branch location.
 */

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'headquarters' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:100'],
        ];
    }
}
