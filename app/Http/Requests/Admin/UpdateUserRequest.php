<?php

/**
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Request validation for administrator updates to an existing user account.
 */

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user instanceof User && $user->isAdmin();
    }

    public function rules(): array
    {
        $userId = (int) $this->route('id');

        return [
            'name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date', 'before_or_equal:-18 years'],
            'address' => ['required', 'string', 'max:255'],
            'license_number' => ['required', 'integer', 'min:1', Rule::unique('users', 'license_number')->ignore($userId)],
            'emergency_contact' => ['required', 'integer', 'min:1'],
            'identification_number' => ['required', 'integer', 'min:1', Rule::unique('users', 'identification_number')->ignore($userId)],
            'emergency_contact_name' => ['required', 'string', 'max:100'],
            'emergency_contact_last_name' => ['required', 'string', 'max:100'],
            'eps' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'role' => ['required', 'string', Rule::in([User::ROLE_ADMIN, User::ROLE_CUSTOMER])],
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
        ];
    }

    public function messages(): array
    {
        return [
            'birth_date.before_or_equal' => __('authentication.validation_adult'),
            'email.unique' => __('authentication.validation_email_unique'),
            'license_number.unique' => __('authentication.validation_license_unique'),
            'identification_number.unique' => __('authentication.validation_identification_unique'),
        ];
    }
}
