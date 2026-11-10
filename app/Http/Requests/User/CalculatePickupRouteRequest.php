<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CalculatePickupRouteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'origin_type' => [
                'required',
                Rule::in(['address', 'location']),
            ],
            'origin_address' => [
                'exclude_unless:origin_type,address',
                'required',
                'string',
                'max:255',
            ],
            'latitude' => [
                'exclude_unless:origin_type,location',
                'required',
                'numeric',
                'between:-90,90',
            ],
            'longitude' => [
                'exclude_unless:origin_type,location',
                'required',
                'numeric',
                'between:-180,180',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'origin_type.*' => __('pickup.invalid_origin'),
            'origin_address.*' => __('pickup.invalid_origin'),
            'latitude.*' => __('pickup.invalid_origin'),
            'longitude.*' => __('pickup.invalid_origin'),
        ];
    }
}