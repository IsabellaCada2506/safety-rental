<?php

/**
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Request validation for the administrator car ranking date range filter.
 */

namespace App\Http\Requests\Admin;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class FilterCarRankingRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user instanceof User && app(UserServiceInterface::class)->isAdmin($user);
    }

    public function rules(): array
    {
        return [
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.after_or_equal' => __('ranking.end_date_order_error'),
        ];
    }
}
