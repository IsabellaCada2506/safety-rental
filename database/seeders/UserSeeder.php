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
            ->where('email', 'isa@gmail.com')
            ->first() ?? new User;

        $user->setRole(User::ROLE_CUSTOMER);
        $user->setName('Isabella');
        $user->setLastName('Ocampo');
        $user->setBirthDate(Carbon::parse('2000-01-01'));
        $user->setAddress('Urbanizacion laurel');
        $user->setLicenseNumber(223300002);
        $user->setEmergencyContact(31245676554);
        $user->setIdentificationNumber(134456600000002);
        $user->setEmergencyContactName('Luz');
        $user->setEmergencyContactLastName('Ocampo');
        $user->setEps('Sura');
        $user->setEmail('isa@gmail.com');
        $user->setPassword(bcrypt('b12345678'));
        $user->setEmailVerifiedAt(Carbon::now());
        $user->save();

        $user2 = User::query()
            ->where('email', 'carlos@gmail.com')
            ->first() ?? new User;

        $user2->setRole(User::ROLE_CUSTOMER);
        $user2->setName('Carlos');
        $user2->setLastName('Rueda');
        $user2->setBirthDate(Carbon::parse('2000-01-01'));
        $user2->setAddress('Urbanizacion laureles');
        $user2->setLicenseNumber(123300002);
        $user2->setEmergencyContact(33245676554);
        $user2->setIdentificationNumber(134336600000002);
        $user2->setEmergencyContactName('Alex');
        $user2->setEmergencyContactLastName('Ruiz');
        $user2->setEps('Sura');
        $user2->setEmail('carlos@gmail.com');
        $user2->setPassword(bcrypt('c12345678'));
        $user2->setEmailVerifiedAt(Carbon::now());
        $user2->save();

        $userp = User::query()
            ->where('email', 'customer@safetyrental.test')
            ->first() ?? new User;

        $userp->setRole(User::ROLE_CUSTOMER);
        $userp->setName('Safety Rental');
        $userp->setLastName('Customer');
        $userp->setBirthDate(Carbon::parse('2000-01-01'));
        $userp->setAddress('Customer Test Address');
        $userp->setLicenseNumber(10000002);
        $userp->setEmergencyContact(3000000002);
        $userp->setIdentificationNumber(1000000002);
        $userp->setEmergencyContactName('Customer Emergency');
        $userp->setEmergencyContactLastName('Contact');
        $userp->setEps('Test EPS');
        $userp->setEmail('customer@safetyrental.test');
        $userp->setPassword(bcrypt('password'));
        $userp->setEmailVerifiedAt(Carbon::now());
        $userp->save();
    }
}
