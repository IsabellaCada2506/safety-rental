<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-13
 * Description: Request validation for displaying the customer reservation creation form.
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'car_id' => ['required', 'integer', 'exists:cars,id'],
        ];
    }
}
