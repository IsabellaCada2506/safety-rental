<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Form request validating the customer origin coordinates used to estimate a driving route.
 */

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EstimateRouteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'origin_latitude' => ['required', 'numeric', 'between:-90,90'],
            'origin_longitude' => ['required', 'numeric', 'between:-180,180'],
        ];
    }

    public function messages(): array
    {
        return [
            'location_id.required' => __('maps.validation_location_required'),
            'location_id.exists' => __('maps.validation_location_not_found'),
            'origin_latitude.required' => __('maps.validation_origin_required'),
            'origin_longitude.required' => __('maps.validation_origin_required'),
            'origin_latitude.between' => __('maps.validation_origin_invalid'),
            'origin_longitude.between' => __('maps.validation_origin_invalid'),
        ];
    }
}
