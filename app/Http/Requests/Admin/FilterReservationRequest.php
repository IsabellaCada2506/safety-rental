<?php

/**
 * Author: Isabella Ocampo
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Request validation for filtering reservations by state in the admin area.
 */

namespace App\Http\Requests\Admin;

use App\Interfaces\UserServiceInterface;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user instanceof User && app(UserServiceInterface::class)->isAdmin($user);
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
