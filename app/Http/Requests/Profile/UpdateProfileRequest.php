<?php

// Author: Isabella Cadavid Posada

namespace App\Http\Requests\Profile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user instanceof User && ! $user->isAdmin();
    }

    public function rules(): array
    {
        /** @var User $user */
        $user = $this->user();

        return [
            'name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date', 'before_or_equal:-18 years'],
            'address' => ['required', 'string', 'max:255'],
            'license_number' => ['required', 'integer', 'min:1', Rule::unique('users', 'license_number')->ignore($user->getId())],
            'emergency_contact' => ['required', 'integer', 'min:1'],
            'identification_number' => ['required', 'integer', 'min:1', Rule::unique('users', 'identification_number')->ignore($user->getId())],
            'emergency_contact_name' => ['required', 'string', 'max:100'],
            'emergency_contact_last_name' => ['required', 'string', 'max:100'],
            'eps' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->getId())],
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

    public function attributes(): array
    {
        return [
            'name' => __('authentication.first_name'),
            'last_name' => __('authentication.last_name'),
            'birth_date' => __('authentication.birth_date'),
            'address' => __('authentication.address'),
            'license_number' => __('authentication.driver_license_number'),
            'emergency_contact' => __('authentication.emergency_contact_phone'),
            'identification_number' => __('authentication.identification_number'),
            'emergency_contact_name' => __('authentication.emergency_contact_first_name'),
            'emergency_contact_last_name' => __('authentication.emergency_contact_last_name'),
            'eps' => __('authentication.health_provider'),
            'email' => __('authentication.email'),
        ];
    }

    public function getName(): string
    {
        return (string) $this->validated('name');
    }

    public function getLastName(): string
    {
        return (string) $this->validated('last_name');
    }

    public function getBirthDate(): string
    {
        return (string) $this->validated('birth_date');
    }

    public function getAddress(): string
    {
        return (string) $this->validated('address');
    }

    public function getLicenseNumber(): int
    {
        return (int) $this->validated('license_number');
    }

    public function getEmergencyContact(): int
    {
        return (int) $this->validated('emergency_contact');
    }

    public function getIdentificationNumber(): int
    {
        return (int) $this->validated('identification_number');
    }

    public function getEmergencyContactName(): string
    {
        return (string) $this->validated('emergency_contact_name');
    }

    public function getEmergencyContactLastName(): string
    {
        return (string) $this->validated('emergency_contact_last_name');
    }

    public function getEps(): string
    {
        return (string) $this->validated('eps');
    }

    public function getEmail(): string
    {
        return (string) $this->validated('email');
    }
}
