<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-11
 * Description: Root seeder orchestrating the database seeding order.
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            LocationSeeder::class,
            CarSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
