<?php

/**
 * Author: Wendy
 * Date: 09/09/2026
 * Description: Request validation for storing a new car in the inventory.
 */

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'plate' => ['required', 'string', 'unique:cars,plate'],
            'color' => ['required', 'string', 'max:50'],
            'soat' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'transit_license' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:1000'],
            'mileage' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
        ];
    }
}
