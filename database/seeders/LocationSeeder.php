<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Seeder for physical branch locations of Safety Rental.
 */

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Sede El Poblado',
                'address' => 'Carrera 43A # 1-50',
                'headquarters' => 'Sede Principal Medellín',
                'telephone' => '+57 604 444 1122',
                'city' => 'Medellín',
            ],
            [
                'name' => 'Sede Laureles',
                'address' => 'Avenida Nutibara # 73-20',
                'headquarters' => 'Sede Occidente',
                'telephone' => '+57 604 444 3344',
                'city' => 'Medellín',
            ],
            [
                'name' => 'Sede Aeropuerto JMC',
                'address' => 'Aeropuerto Internacional José María Córdova, Módulo 2',
                'headquarters' => 'Sede Aeroportuaria Rionegro',
                'telephone' => '+57 604 444 5566',
                'city' => 'Rionegro',
            ],
        ];

        foreach ($locations as $data) {
            Location::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
