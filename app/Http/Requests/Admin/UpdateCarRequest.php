<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-11
 * Description: Request validation for updating an existing car with branch location.
 */

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $carId = (int) $this->route('id');

        return [
            'plate' => ['required', 'string', 'max:20', Rule::unique('cars', 'plate')->ignore($carId)],
            'color' => ['required', 'string', 'max:50'],
            'soat' => ['required', 'string', 'max:50'],
            'price' => ['required', 'integer', 'min:50000'],
            'transit_license' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:1000'],
            'mileage' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'url', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'location_id' => ['required', 'exists:locations,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'price.min' => __('car.price_min_error'),
        ];
    }
}
