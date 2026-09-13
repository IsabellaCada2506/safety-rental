<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Form request for validating rental location updates by administrators.
 */

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'headquarters' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:100'],
        ];
    }
}
