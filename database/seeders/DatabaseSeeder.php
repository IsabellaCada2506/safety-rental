<?php

/**
 * Author: Wendy Atehortua
 * Date: 09/09/2026
 * Description: Seeder for populating the database with initial data, including users and cars.
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CarSeeder::class,
        ]);
    }
}
