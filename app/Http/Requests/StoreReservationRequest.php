<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Request validation for creating a new car rental reservation.
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'car_id' => ['required', 'integer', 'exists:cars,id'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.after_or_equal' => __('reservation.start_date_past_error'),
            'end_date.after' => __('reservation.end_date_order_error'),
            'car_id.exists' => __('reservation.car_not_found'),
            'location_id.exists' => __('reservation.location_not_found'),
        ];
    }
}
