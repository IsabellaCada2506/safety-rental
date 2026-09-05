<?php

// Autor: Isabella Cadavid Posada

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        return $this->id;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $lastName): void
    {
        $this->last_name = $lastName;
    }

    public function getBirthDate(): ?Carbon
    {
        return $this->birth_date;
    }

    public function setBirthDate(?Carbon $birthDate): void
    {
        $this->birth_date = $birthDate;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getLicenseNumber(): ?int
    {
        return $this->license_number;
    }

    public function setLicenseNumber(?int $licenseNumber): void
    {
        $this->license_number = $licenseNumber;
    }

    public function getEmergencyContact(): ?int
    {
        return $this->emergency_contact;
    }

    public function setEmergencyContact(?int $emergencyContact): void
    {
        $this->emergency_contact = $emergencyContact;
    }

    public function getIdentificationNumber(): ?int
    {
        return $this->identification_number;
    }

    public function setIdentificationNumber(?int $identificationNumber): void
    {
        $this->identification_number = $identificationNumber;
    }

    public function getEmergencyContactName(): ?string
    {
        return $this->emergency_contact_name;
    }

    public function setEmergencyContactName(
        ?string $emergencyContactName
    ): void {
        $this->emergency_contact_name = $emergencyContactName;
    }

    public function getEmergencyContactLastName(): ?string
    {
        return $this->emergency_contact_last_name;
    }

    public function setEmergencyContactLastName(
        ?string $emergencyContactLastName
    ): void {
        $this->emergency_contact_last_name = $emergencyContactLastName;
    }

    public function getEps(): ?string
    {
        return $this->eps;
    }

    public function setEps(?string $eps): void
    {
        $this->eps = $eps;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmailVerifiedAt(): ?Carbon
    {
        return $this->email_verified_at;
    }

    public function setEmailVerifiedAt(?Carbon $emailVerifiedAt): void
    {
        $this->email_verified_at = $emailVerifiedAt;
    }

    public function getRememberTokenValue(): ?string
    {
        return $this->remember_token;
    }

    public function setRememberTokenValue(?string $rememberToken): void
    {
        $this->remember_token = $rememberToken;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
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
