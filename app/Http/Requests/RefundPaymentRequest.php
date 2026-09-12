<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Request validation for applying a simulated payment refund.
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefundPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [];
    }
}
