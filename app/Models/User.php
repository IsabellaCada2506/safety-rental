<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-06
 * Description: User model representing registered application users (customers and admins).
 */

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

/**
 * Database attributes:
 *
 * @property int $id
 * @property string $role
 * @property string $name
 * @property string|null $last_name
 * @property Carbon|null $birth_date
 * @property string|null $address
 * @property int|null $license_number
 * @property int|null $emergency_contact
 * @property int|null $identification_number
 * @property string|null $emergency_contact_name
 * @property string|null $emergency_contact_last_name
 * @property string|null $eps
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_CUSTOMER = 'customer';

    public $timestamps = true;

    protected $fillable = [
        'role',
        'name',
        'last_name',
        'birth_date',
        'address',
        'license_number',
        'emergency_contact',
        'identification_number',
        'emergency_contact_name',
        'emergency_contact_last_name',
        'eps',
        'email',
        'password',
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function getId(): ?int
    {
        return isset($this->attributes['id']) ? (int) $this->attributes['id'] : null;
    }

    public function getRole(): string
    {
        return $this->attributes['role'];
    }

    public function setRole(string $role): void
    {
        $this->attributes['role'] = $role;
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getLastName(): ?string
    {
        return $this->attributes['last_name'] ?? null;
    }

    public function setLastName(?string $lastName): void
    {
        $this->attributes['last_name'] = $lastName;
    }

    public function getBirthDate(): ?Carbon
    {
        return isset($this->attributes['birth_date'])
            ? Carbon::parse($this->attributes['birth_date'])
            : null;
    }

    public function setBirthDate(?Carbon $birthDate): void
    {
        $this->attributes['birth_date'] = $birthDate?->toDateString();
    }

    public function getAddress(): ?string
    {
        return $this->attributes['address'] ?? null;
    }

    public function setAddress(?string $address): void
    {
        $this->attributes['address'] = $address;
    }

    public function getLicenseNumber(): ?int
    {
        return isset($this->attributes['license_number']) ? (int) $this->attributes['license_number'] : null;
    }

    public function setLicenseNumber(?int $licenseNumber): void
    {
        $this->attributes['license_number'] = $licenseNumber;
    }

    public function getEmergencyContact(): ?int
    {
        return isset($this->attributes['emergency_contact']) ? (int) $this->attributes['emergency_contact'] : null;
    }

    public function setEmergencyContact(?int $emergencyContact): void
    {
        $this->attributes['emergency_contact'] = $emergencyContact;
    }

    public function getIdentificationNumber(): ?int
    {
        return isset($this->attributes['identification_number']) ? (int) $this->attributes['identification_number'] : null;
    }

    public function setIdentificationNumber(?int $identificationNumber): void
    {
        $this->attributes['identification_number'] = $identificationNumber;
    }

    public function getEmergencyContactName(): ?string
    {
        return $this->attributes['emergency_contact_name'] ?? null;
    }

    public function setEmergencyContactName(
        ?string $emergencyContactName
    ): void {
        $this->attributes['emergency_contact_name'] = $emergencyContactName;
    }

    public function getEmergencyContactLastName(): ?string
    {
        return $this->attributes['emergency_contact_last_name'] ?? null;
    }

    public function setEmergencyContactLastName(
        ?string $emergencyContactLastName
    ): void {
        $this->attributes['emergency_contact_last_name'] = $emergencyContactLastName;
    }

    public function getEps(): ?string
    {
        return $this->attributes['eps'] ?? null;
    }

    public function setEps(?string $eps): void
    {
        $this->attributes['eps'] = $eps;
    }

    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    public function setEmail(string $email): void
    {
        $this->attributes['email'] = $email;
    }

    public function setPassword(string $password): void
    {
        $this->attributes['password'] = Hash::isHashed($password)
            ? $password
            : Hash::make($password);
    }

    public function getEmailVerifiedAt(): ?Carbon
    {
        return isset($this->attributes['email_verified_at'])
            ? Carbon::parse($this->attributes['email_verified_at'])
            : null;
    }

    public function setEmailVerifiedAt(?Carbon $emailVerifiedAt): void
    {
        $this->attributes['email_verified_at'] = $emailVerifiedAt?->toDateTimeString();
    }

    public function getRememberTokenValue(): ?string
    {
        return $this->attributes['remember_token'] ?? null;
    }

    public function setRememberTokenValue(?string $rememberToken): void
    {
        $this->attributes['remember_token'] = $rememberToken;
    }

    public function getCreatedAt(): ?Carbon
    {
        return isset($this->attributes['created_at'])
            ? Carbon::parse($this->attributes['created_at'])
            : null;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return isset($this->attributes['updated_at'])
            ? Carbon::parse($this->attributes['updated_at'])
            : null;
    }

    public function isAdmin(): bool
    {
        return $this->getRole() === self::ROLE_ADMIN;
    }

    public function calculateAge(): ?int
    {
        return $this->getBirthDate()?->age;
    }
}
