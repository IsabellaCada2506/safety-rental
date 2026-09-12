<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-11
 * Description: Business logic service handling user profile updates and account operations.
 */

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Carbon\Carbon;

class UserService implements UserServiceInterface
{
    /**
     * @param  array<string, mixed>  $validatedData
     */
    public function updateFromValidated(User $user, array $validatedData): User
    {
        $user->setName((string) $validatedData['name']);
        $user->setLastName((string) $validatedData['last_name']);
        $user->setBirthDate(
            Carbon::parse((string) $validatedData['birth_date'])
        );
        $user->setAddress((string) $validatedData['address']);
        $user->setLicenseNumber((int) $validatedData['license_number']);
        $user->setEmergencyContact(
            (int) $validatedData['emergency_contact']
        );
        $user->setIdentificationNumber(
            (int) $validatedData['identification_number']
        );
        $user->setEmergencyContactName(
            (string) $validatedData['emergency_contact_name']
        );
        $user->setEmergencyContactLastName(
            (string) $validatedData['emergency_contact_last_name']
        );
        $user->setEps((string) $validatedData['eps']);
        $user->setEmail((string) $validatedData['email']);
        $user->save();

        return $user;
    }
}
