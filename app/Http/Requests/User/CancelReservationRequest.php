<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-11-06
 * Description: Request validation for customer reservation cancellation including reason.
 */

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CancelReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reason' => ['required', 'string', 'max:255'],
        ];
    }
}
