<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-10
 * Description: Seeder for populating the database with initial car data.
 */

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Category;
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
                'price' => 95000,
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
                'price' => 135000,
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
                'price' => 75000,
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
                'price' => 110000,
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
                'price' => 85000,
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
                'price' => 180000,
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
                'price' => 155000,
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
                'price' => 65000,
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
                'price' => 125000,
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
                'price' => 90000,
                'mileage' => 41000,
                'image' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&q=80&w=800',
                'description' => 'Volkswagen Jetta. Automatic, spacious trunk.',
                'status' => 'Active',
            ],
        ];

        $categories = Category::all();

        if ($categories->isEmpty()) {
            return;
        }

        foreach ($carsData as $index => $carData) {
            $category = $categories[$index % $categories->count()];

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
            $car->setCategoryId($category->getId());
            $car->save();
        }
    }
}
