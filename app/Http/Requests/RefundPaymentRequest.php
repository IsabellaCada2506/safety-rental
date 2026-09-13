<?php

/**
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Request validation for applying a simulated payment refund.
 */

namespace App\Http\Requests;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RefundPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user instanceof User && app(UserServiceInterface::class)->isAdmin($user);
    }

    public function rules(): array
    {
        return [];
    }
}
