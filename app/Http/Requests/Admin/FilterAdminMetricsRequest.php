<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Request validation for the administrator metrics date range filter.
 */

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FilterAdminMetricsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.after_or_equal' => __('metrics.end_date_order_error'),
        ];
    }
}
