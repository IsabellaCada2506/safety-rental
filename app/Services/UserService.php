<?php

/**
 * Author: Isabella Cadavid Posada
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Business logic service handling user profile updates and account operations.
 */

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserServiceInterface
{
    public function getAll(): Collection
    {
        return User::query()
            ->withCount('reservations')
            ->orderBy('name')
            ->orderBy('id')
            ->get();
    }

    public function findOrFail(int $id): User
    {
        return User::query()
            ->withCount('reservations')
            ->findOrFail($id);
    }

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

    /**
     * @param  array<string, mixed>  $validatedData
     */
    public function updateByAdmin(User $user, array $validatedData): User
    {
        $this->updateFromValidated($user, $validatedData);
        $user->setRole((string) $validatedData['role']);

        if (! empty($validatedData['password'])) {
            $user->setPassword((string) $validatedData['password']);
        }

        $user->save();

        return $user;
    }

    public function canChangeRole(User $user, string $newRole): bool
    {
        return $this->roleChangeDenialReason($user, $newRole) === '';
    }

    public function roleChangeDenialReason(User $user, string $newRole): string
    {
        if ($this->isAdmin($user) && $newRole === User::ROLE_CUSTOMER && $this->adminCount() <= 1) {
            return __('user.update_error_last_admin');
        }

        return '';
    }

    public function canBeDeleted(User $user, User $actor): bool
    {
        return $this->deleteDenialReason($user, $actor) === '';
    }

    public function deleteDenialReason(User $user, User $actor): string
    {
        if ($user->getId() === $actor->getId()) {
            return __('user.delete_error_self');
        }

        if ($this->isAdmin($user) && $this->adminCount() <= 1) {
            return __('user.delete_error_last_admin');
        }

        if ($user->getReservationsCount() > 0) {
            return __('user.delete_error_reservations');
        }

        return '';
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function isAdmin(User $user): bool
    {
        return $user->getRole() === User::ROLE_ADMIN;
    }

    public function calculateAge(User $user): ?int
    {
        return $user->getBirthDate()?->age;
    }

    private function adminCount(): int
    {
        return User::query()
            ->where('role', User::ROLE_ADMIN)
            ->count();
    }
}
