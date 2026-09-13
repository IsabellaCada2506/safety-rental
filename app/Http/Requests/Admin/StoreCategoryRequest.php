<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-10
 * Description: Request validation for storing a new category.
 */

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'model' => ['required', 'string', 'max:100'],
            'brand' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'max:100'],
            'passenger_capacity' => ['required', 'integer', 'min:1'],
            'luggage_capacity' => ['required', 'integer', 'min:0'],
        ];
    }
}
