<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-11
 * Description: Seeder for populating the database with initial car data.
 */

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $carsData = [
            [
                'brand' => 'Toyota',
                'model' => 'Corolla',
                'plate' => 'BKV-091',
                'color' => 'Pearl White',
                'soat' => 'SOAT-748392018',
                'transit_license' => 'TL-849302',
                'price' => 95000,
                'mileage' => 18500,
                'image' => 'https://http2.mlstatic.com/D_NQ_NP_2X_723032-MCO112948209774_072026-F.webp',
                'description' => 'Toyota Corolla 2023 Sedan. Hybrid engine, automatic transmission, 5 seats.',
                'status' => 'Active',
                'location_name' => 'Sede El Poblado',
            ],
            [
                'brand' => 'Mazda',
                'model' => 'CX-5',
                'plate' => 'FTJ-482',
                'color' => 'Soul Red',
                'soat' => 'SOAT-192837465',
                'transit_license' => 'TL-573829',
                'price' => 140000,
                'mileage' => 22400,
                'image' => 'https://http2.mlstatic.com/D_NQ_NP_2X_766846-MCO109557663136_042026-F.webp',
                'description' => 'Mazda CX-5 SUV. AWD, leather interior, sunroof, and automatic transmission.',
                'status' => 'Active',
                'location_name' => 'Sede Laureles',
            ],
            [
                'brand' => 'BMW',
                'model' => '3 Series',
                'plate' => 'MZN-773',
                'color' => 'Mineral Grey',
                'soat' => 'SOAT-998877665',
                'transit_license' => 'TL-112233',
                'price' => 210000,
                'mileage' => 12000,
                'image' => 'https://http2.mlstatic.com/D_NQ_NP_2X_861091-MCO115752059123_082026-F.webp',
                'description' => 'BMW 3 Series Sports Sedan. Turbocharged engine, sport seats, premium sound.',
                'status' => 'Active',
                'location_name' => 'Sede Laureles',
            ],
            [
                'brand' => 'Toyota',
                'model' => 'Hilux',
                'plate' => 'LPR-205',
                'color' => 'Metallic Silver',
                'soat' => 'SOAT-556644332',
                'transit_license' => 'TL-998877',
                'price' => 160000,
                'mileage' => 35200,
                'image' => 'https://http2.mlstatic.com/D_NQ_NP_2X_637693-MCO113837874462_072026-F.webp',
                'description' => 'Toyota Hilux Double Cab Pickup. 4x4 turbo diesel, high payload capacity.',
                'status' => 'Active',
                'location_name' => 'Sede Aeropuerto JMC',
            ],
            [
                'brand' => 'Chevrolet',
                'model' => 'Spark GT',
                'plate' => 'GHT-910',
                'color' => 'Flame Red',
                'soat' => 'SOAT-102938475',
                'transit_license' => 'TL-564738',
                'price' => 70000,
                'mileage' => 29100,
                'image' => 'https://http2.mlstatic.com/D_NQ_NP_2X_790998-MCO117093433001_092026-F.webp',
                'description' => 'Chevrolet Spark GT Compact Hatchback. Highly economical, manual transmission.',
                'status' => 'Active',
                'location_name' => 'Sede El Poblado',
            ],
            [
                'brand' => 'BMW',
                'model' => 'X5',
                'plate' => 'XYZ-112',
                'color' => 'Black Sapphire',
                'soat' => 'SOAT-564738291',
                'transit_license' => 'TL-342516',
                'price' => 260000,
                'mileage' => 15300,
                'image' => 'https://http2.mlstatic.com/D_NQ_NP_2X_833504-MCO117255572947_092026-F.webp',
                'description' => 'BMW X5 Luxury SUV. Panoramic roof, executive package, 4x4 all-wheel drive.',
                'status' => 'Active',
                'location_name' => 'Sede Aeropuerto JMC',
            ],
            [
                'brand' => 'Toyota',
                'model' => 'Corolla',
                'plate' => 'KJW-845',
                'color' => 'Midnight Black',
                'soat' => 'SOAT-657483920',
                'transit_license' => 'TL-748392',
                'price' => 95000,
                'mileage' => 21000,
                'image' => 'https://http2.mlstatic.com/D_NQ_NP_2X_788762-MCO113954999470_072026-F.webp',
                'description' => 'Toyota Corolla Sedan. Reliable city vehicle with comfortable interior.',
                'status' => 'Active',
                'location_name' => 'Sede Laureles',
            ],
            [
                'brand' => 'Mazda',
                'model' => 'CX-5',
                'plate' => 'PQR-339',
                'color' => 'Deep Crystal Blue',
                'soat' => 'SOAT-883377221',
                'transit_license' => 'TL-223344',
                'price' => 140000,
                'mileage' => 16800,
                'image' => 'https://http2.mlstatic.com/D_NQ_NP_2X_856759-MCO116029301425_082026-F.webp',
                'description' => 'Mazda CX-5 SUV. Spacious luggage area, automatic safety package.',
                'status' => 'Active',
                'location_name' => 'Sede Aeropuerto JMC',
            ],
            [
                'brand' => 'Toyota',
                'model' => 'Hilux',
                'plate' => 'DFG-567',
                'color' => 'Alpine White',
                'soat' => 'SOAT-445566778',
                'transit_license' => 'TL-556677',
                'price' => 160000,
                'mileage' => 41500,
                'image' => 'https://http2.mlstatic.com/D_NQ_NP_2X_808459-MCO117426139975_092026-F.webp',
                'description' => 'Toyota Hilux 4x4. Excellent performance for rugged terrain and heavy loads.',
                'status' => 'Active',
                'location_name' => 'Sede El Poblado',
            ],
            [
                'brand' => 'Chevrolet',
                'model' => 'Spark GT',
                'plate' => 'TYU-789',
                'color' => 'Silver Ice',
                'soat' => 'SOAT-991188227',
                'transit_license' => 'TL-889900',
                'price' => 70000,
                'mileage' => 38200,
                'image' => 'https://http2.mlstatic.com/D_NQ_NP_2X_701089-MCO115698502774_092026-F.webp',
                'description' => 'Chevrolet Spark GT Compact. Easy parking, fuel efficient city commuter.',
                'status' => 'Active',
                'location_name' => 'Sede Laureles',
            ],
        ];

        foreach ($carsData as $carData) {
            $category = Category::query()
                ->where('brand', $carData['brand'])
                ->where('model', $carData['model'])
                ->first();

            $location = Location::query()
                ->where('name', $carData['location_name'])
                ->first();

            $car = new Car;
            $car->setPlate($carData['plate']);
            $car->setColor($carData['color']);
            $car->setSoat($carData['soat']);
            $car->setTransitLicense($carData['transit_license']);
            $car->setPrice($carData['price']);
            $car->setMileage($carData['mileage']);
            $car->setImage($carData['image']);
            $car->setDescription($carData['description']);
            $car->setStatus($carData['status']);

            if ($category) {
                $car->setCategoryId($category->getId());
            }

            if ($location) {
                $car->setLocationId($location->getId());
            }

            $car->save();
        }
    }
}
