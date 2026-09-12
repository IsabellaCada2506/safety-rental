<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Request validation for recording a simulated reservation payment.
 */

namespace App\Http\Requests;

use App\Models\Payment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'method' => [
                'required',
                'string',
                Rule::in(Payment::availableMethods()),
            ],
            'simulated_result' => [
                'required',
                'string',
                Rule::in([
                    Payment::SIMULATED_RESULT_SUCCESS,
                    Payment::SIMULATED_RESULT_FAILURE,
                ]),
            ],
            'amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ];
    }
}
