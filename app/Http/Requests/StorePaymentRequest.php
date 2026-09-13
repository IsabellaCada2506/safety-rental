<?php

/**
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Request validation for recording a simulated reservation payment.
 */

namespace App\Http\Requests;

use App\Interfaces\PaymentServiceInterface;
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
                Rule::in(app(PaymentServiceInterface::class)->availableMethods()),
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
