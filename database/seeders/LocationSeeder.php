<?php

/**
 * Author: Isabella Ocampo
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
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
                'latitude' => 6.2088000,
                'longitude' => -75.5674000,
            ],
            [
                'name' => 'Sede Laureles',
                'address' => 'Avenida Nutibara # 73-20',
                'headquarters' => 'Sede Occidente',
                'telephone' => '+57 604 444 3344',
                'city' => 'Medellín',
                'latitude' => 6.2447000,
                'longitude' => -75.5896000,
            ],
            [
                'name' => 'Sede Aeropuerto JMC',
                'address' => 'Aeropuerto Internacional José María Córdova, Módulo 2',
                'headquarters' => 'Sede Aeroportuaria Rionegro',
                'telephone' => '+57 604 444 5566',
                'city' => 'Rionegro',
                'latitude' => 6.1646000,
                'longitude' => -75.4231000,
            ],
        ];

        foreach ($locations as $data) {
            $location = Location::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
            $location->setLatitude($data['latitude']);
            $location->setLongitude($data['longitude']);
            $location->save();
        }
    }
}
