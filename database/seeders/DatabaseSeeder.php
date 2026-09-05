<?php

// Autor: Isabella Cadavid Posada

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()
            ->where('email', 'admin@safetyrental.test')
            ->first() ?? new User;

        $admin->setRole(User::ROLE_ADMIN);
        $admin->setName('Safety Rental');
        $admin->setLastName('Administrator');
        $admin->setBirthDate(Carbon::parse('1990-01-01'));
        $admin->setAddress('Safety Rental Main Office');
        $admin->setLicenseNumber(10000001);
        $admin->setEmergencyContact(3000000001);
        $admin->setIdentificationNumber(1000000001);
        $admin->setEmergencyContactName('Emergency');
        $admin->setEmergencyContactLastName('Contact');
        $admin->setEps('Test EPS');
        $admin->setEmail('admin@safetyrental.test');
        $admin->setPassword('password');
        $admin->setEmailVerifiedAt(Carbon::now());
        $admin->save();

        $customer = User::query()
            ->where('email', 'customer@safetyrental.test')
            ->first() ?? new User;

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
        $customer->setPassword('password');
        $customer->setEmailVerifiedAt(Carbon::now());
        $customer->save();
    }
}
