<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-06
 * Description: Seeder for creating an admin user and a customer user in the database.
 */

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminOne = User::query()
            ->where('email', 'admin@safetyrental.com')
            ->first() ?? new User;

        $adminOne->setName('Admin');
        $adminOne->setLastName('User');
        $adminOne->setEmail('admin@safetyrental.com');
        $adminOne->setPassword(bcrypt('admin12345'));
        $adminOne->setRole('admin');
        $adminOne->setBirthDate(Carbon::parse('1990-01-01'));
        $adminOne->setAddress('Main Street 123');
        $adminOne->setLicenseNumber(12345678);
        $adminOne->setEmergencyContact(3001234567);
        $adminOne->setEmergencyContactName('Emergency');
        $adminOne->setEmergencyContactLastName('Contact');
        $adminOne->setIdentificationNumber(10203040);
        $adminOne->setEps('Sura');
        $adminOne->save();

        $adminTwo = User::query()
            ->where('email', 'admin@safetyrental.test')
            ->first() ?? new User;

        $adminTwo->setRole(User::ROLE_ADMIN);
        $adminTwo->setName('Safety Rental');
        $adminTwo->setLastName('Administrator');
        $adminTwo->setBirthDate(Carbon::parse('1990-01-01'));
        $adminTwo->setAddress('Safety Rental Main Office');
        $adminTwo->setLicenseNumber(10000001);
        $adminTwo->setEmergencyContact(3000000001);
        $adminTwo->setIdentificationNumber(1000000001);
        $adminTwo->setEmergencyContactName('Emergency');
        $adminTwo->setEmergencyContactLastName('Contact');
        $adminTwo->setEps('Test EPS');
        $adminTwo->setEmail('admin@safetyrental.test');
        $adminTwo->setPassword(bcrypt('password'));
        $adminTwo->setEmailVerifiedAt(Carbon::now());
        $adminTwo->save();

        $user = User::query()
            ->where('email', 'customer@safetyrental.test')
            ->first() ?? new User;

        $user->setRole(User::ROLE_CUSTOMER);
        $user->setName('Safety Rental');
        $user->setLastName('Customer');
        $user->setBirthDate(Carbon::parse('2000-01-01'));
        $user->setAddress('Customer Test Address');
        $user->setLicenseNumber(10000002);
        $user->setEmergencyContact(3000000002);
        $user->setIdentificationNumber(1000000002);
        $user->setEmergencyContactName('Customer Emergency');
        $user->setEmergencyContactLastName('Contact');
        $user->setEps('Test EPS');
        $user->setEmail('customer@safetyrental.test');
        $user->setPassword(bcrypt('password'));
        $user->setEmailVerifiedAt(Carbon::now());
        $user->save();
    }
}
