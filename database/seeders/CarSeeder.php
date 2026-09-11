<?php

/**
 * Author: Wendy Atehortua
 * Date: 09/09/2026
 * Description: Seeder for populating the database with initial data, including users and cars.
 */

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $carsData = [
            [
                'plate' => 'BKV-091',
                'color' => 'Midnight Black',
                'soat' => 'SOAT-748392018',
                'transit_license' => 'TL-849302',
                'price_per_day' => 95000,
                'mileage' => 24500,
                'image' => 'https://images.unsplash.com/photo-1550426735-c33c7ec32a0c?auto=format&fit=crop&q=80&w=800',
                'description' => 'Toyota Corolla 2023. Automatic transmission, hybrid engine.',
                'status' => 'Active',
            ],
            [
                'plate' => 'FTJ-482',
                'color' => 'Graphite Grey',
                'soat' => 'SOAT-192837465',
                'transit_license' => 'TL-573829',
                'price_per_day' => 135000,
                'mileage' => 12300,
                'image' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&q=80&w=800',
                'description' => 'Mazda CX-5. SUV with AWD, leather interior, and sunroof.',
                'status' => 'Active',
            ],
            [
                'plate' => 'MZN-773',
                'color' => 'Ruby Red',
                'soat' => 'SOAT-998877665',
                'transit_license' => 'TL-112233',
                'price_per_day' => 75000,
                'mileage' => 48000,
                'image' => 'https://images.unsplash.com/photo-1609521263047-f8f205293f24?auto=format&fit=crop&q=80&w=800',
                'description' => 'Chevrolet Spark GT. Manual transmission, highly economical.',
                'status' => 'Active',
            ],
            [
                'plate' => 'LPR-205',
                'color' => 'Alpine White',
                'soat' => 'SOAT-556644332',
                'transit_license' => 'TL-998877',
                'price_per_day' => 110000,
                'mileage' => 31000,
                'image' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=800',
                'description' => 'Kia Sportage. Spacious trunk, automatic transmission.',
                'status' => 'Active',
            ],
            [
                'plate' => 'GHT-910',
                'color' => 'Silver Metallic',
                'soat' => 'SOAT-102938475',
                'transit_license' => 'TL-564738',
                'price_per_day' => 85000,
                'mileage' => 28500,
                'image' => 'https://images.unsplash.com/photo-1518987048-93e29699e79a?auto=format&fit=crop&q=80&w=800',
                'description' => 'Renault Logan. Family sedan, manual transmission.',
                'status' => 'Active',
            ],
            [
                'plate' => 'XYZ-112',
                'color' => 'Electric Blue',
                'soat' => 'SOAT-564738291',
                'transit_license' => 'TL-342516',
                'price_per_day' => 180000,
                'mileage' => 8500,
                'image' => 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?auto=format&fit=crop&q=80&w=800',
                'description' => 'BMW 3 Series. Premium sedan, sports package.',
                'status' => 'Deactivated',
            ],
            [
                'plate' => 'KJW-845',
                'color' => 'Desert Sand',
                'soat' => 'SOAT-657483920',
                'transit_license' => 'TL-748392',
                'price_per_day' => 155000,
                'mileage' => 62000,
                'image' => 'https://images.unsplash.com/photo-1520050206274-a1ae44613e6d?auto=format&fit=crop&q=80&w=800',
                'description' => 'Toyota Hilux Double Cab. 4x4 diesel engine.',
                'status' => 'Active',
            ],
            [
                'plate' => 'PQR-339',
                'color' => 'Sunset Orange',
                'soat' => 'SOAT-883377221',
                'transit_license' => 'TL-223344',
                'price_per_day' => 65000,
                'mileage' => 54000,
                'image' => 'https://images.unsplash.com/photo-1567818735868-e71b99932e29?auto=format&fit=crop&q=80&w=800',
                'description' => 'Suzuki Swift. Compact hatchback, great city maneuverability.',
                'status' => 'Active',
            ],
            [
                'plate' => 'DFG-567',
                'color' => 'Ocean Blue',
                'soat' => 'SOAT-445566778',
                'transit_license' => 'TL-556677',
                'price_per_day' => 125000,
                'mileage' => 19000,
                'image' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&q=80&w=800',
                'description' => 'Ford Escape. Hybrid SUV, Apple CarPlay.',
                'status' => 'Active',
            ],
            [
                'plate' => 'TYU-789',
                'color' => 'Classic Black',
                'soat' => 'SOAT-991188227',
                'transit_license' => 'TL-889900',
                'price_per_day' => 90000,
                'mileage' => 41000,
                'image' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&q=80&w=800',
                'description' => 'Volkswagen Jetta. Automatic, spacious trunk.',
                'status' => 'Active',
            ],
        ];

        foreach ($carsData as $data) {
            $car = new Car;
            $car->setPlate($data['plate']);
            $car->setColor($data['color']);
            $car->setSoat($data['soat']);
            $car->setTransitLicense($data['transit_license']);
            $car->setPricePerDay($data['price_per_day']);
            $car->setMileage($data['mileage']);
            $car->setImage($data['image']);
            $car->setDescription($data['description']);
            $car->setStatus($data['status']);
            $car->save();
        }
    }
}
