<?php
/**
 * Author: Isabella Cadavid Posada
 * Date: 06/09/2026
 * Description: Seeder for creating an admin user and a customer user in the database.
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminOne = User::query()
            ->where('email', 'admin@safetyrental.com')
            ->first() ?? new User();

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
            ->first() ?? new User();

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

        $customer = User::query()
            ->where('email', 'customer@safetyrental.test')
            ->first() ?? new User();

        $customer->setRole(User::ROLE_CUSTOMER);
        $customer->setName('Safety Rental');
        $customer->setLastName('Customer');
        $customer->setBirthDate(Carbon::parse('2000-01-01'));
        $customer->setAddress('Customer Test Address');
        $customer->setLicenseNumber(10000002);
        $customer->setEmergencyContact(3000000002);
        $customer->setIdentificationNumber(1000000002);
        $customer->setEmergencyContactName('Customer Emergency');
        $customer->setEmergencyContactLastName('Contact');
        $customer->setEps('Test EPS');
        $customer->setEmail('customer@safetyrental.test');
        $customer->setPassword(bcrypt('password'));
        $customer->setEmailVerifiedAt(Carbon::now());
        $customer->save();
    }
}