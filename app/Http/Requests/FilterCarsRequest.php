<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Form request for validating search, category, location, and date range filters in the vehicle catalog.
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterCarsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'location_id' => ['nullable', 'integer', 'exists:locations,id'],
            'start_date' => ['nullable', 'date', 'after_or_equal:today'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'end_date.after' => __('catalog.validation_end_date_after'),
            'start_date.after_or_equal' => __('catalog.validation_start_date_after_or_equal'),
            'category_id.exists' => __('catalog.validation_category_not_found'),
            'location_id.exists' => __('catalog.validation_location_not_found'),
        ];
    }
}
