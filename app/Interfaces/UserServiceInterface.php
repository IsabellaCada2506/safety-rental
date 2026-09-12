<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-11
 * Description: Contract defining business operations for user profile and account management.
 */

namespace App\Interfaces;

use App\Models\User;

interface UserServiceInterface
{
    /**
     * @param  array<string, mixed>  $validatedData
     */
    public function updateFromValidated(User $user, array $validatedData): User;
}
