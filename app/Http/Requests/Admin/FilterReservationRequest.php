<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-13
 * Description: Request validation for filtering reservations by state in the admin area.
 */

namespace App\Http\Requests\Admin;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'state' => [
                'nullable',
                'string',
                Rule::in([
                    Reservation::STATE_PENDING,
                    Reservation::STATE_CONFIRMED,
                    Reservation::STATE_CANCELLED,
                    Reservation::STATE_COMPLETED,
                ]),
            ],
        ];
    }
}
