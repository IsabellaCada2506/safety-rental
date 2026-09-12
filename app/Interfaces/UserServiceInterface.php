<?php

/**
 * Author: Isabella Cadavid Posada
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Contract defining business operations for user profile and account management.
 */

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function getAll(): Collection;

    public function findOrFail(int $id): User;

    /**
     * @param  array<string, mixed>  $validatedData
     */
    public function updateFromValidated(User $user, array $validatedData): User;

    /**
     * @param  array<string, mixed>  $validatedData
     */
    public function updateByAdmin(User $user, array $validatedData): User;

    public function canChangeRole(User $user, string $newRole): bool;

    public function roleChangeDenialReason(User $user, string $newRole): string;

    public function canBeDeleted(User $user, User $actor): bool;

    public function deleteDenialReason(User $user, User $actor): string;

    public function delete(User $user): void;
}
