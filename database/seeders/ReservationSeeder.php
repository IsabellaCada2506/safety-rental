<?php

/**
 * Author: Isabella Ocampo
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Seeder for populating realistic test reservations across customers.
 */

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $cars = Car::query()->orderBy('id')->get();
        $locations = Location::query()->orderBy('id')->get();

        if ($cars->isEmpty() || $locations->isEmpty()) {
            return;
        }

        $loc1 = $locations->get(0);
        $loc2 = $locations->count() > 1 ? $locations->get(1) : $loc1;
        $loc3 = $locations->count() > 2 ? $locations->get(2) : $loc1;

        $isa = User::query()->where('email', 'isa@gmail.com')->first();
        $carlos = User::query()->where('email', 'carlos@gmail.com')->first();
        $user = User::query()->where('email', 'customer@safetyrental.test')->first();

        if ($isa) {
            $car1 = $cars->get(0);
            $startDate1 = Carbon::now()->addDays(2);
            $endDate1 = Carbon::now()->addDays(6);

            Reservation::firstOrCreate(
                ['code' => 84920184],
                [
                    'state' => Reservation::STATE_CONFIRMED,
                    'start_date' => $startDate1->toDateString(),
                    'end_date' => $endDate1->toDateString(),
                    'user_id' => $isa->getId(),
                    'car_id' => $car1->getId(),
                    'location_id' => $loc1->getId(),
                ]
            );

            if ($cars->count() > 1) {
                $car2 = $cars->get(1);
                Reservation::firstOrCreate(
                    ['code' => 84920185],
                    [
                        'state' => Reservation::STATE_PENDING,
                        'start_date' => Carbon::now()->addDays(10)->toDateString(),
                        'end_date' => Carbon::now()->addDays(14)->toDateString(),
                        'user_id' => $isa->getId(),
                        'car_id' => $car2->getId(),
                        'location_id' => $loc2->getId(),
                    ]
                );
            }
        }

        if ($carlos) {
            $car3 = $cars->count() > 2 ? $cars->get(2) : $cars->first();
            $startDate3 = Carbon::now()->addDays(1);
            $endDate3 = Carbon::now()->addDays(5);

            Reservation::firstOrCreate(
                ['code' => 73910245],
                [
                    'state' => Reservation::STATE_CONFIRMED,
                    'start_date' => $startDate3->toDateString(),
                    'end_date' => $endDate3->toDateString(),
                    'user_id' => $carlos->getId(),
                    'car_id' => $car3->getId(),
                    'location_id' => $loc2->getId(),
                ]
            );

            if ($cars->count() > 3) {
                $car4 = $cars->get(3);
                Reservation::firstOrCreate(
                    ['code' => 73910246],
                    [
                        'state' => Reservation::STATE_CANCELLED,
                        'start_date' => Carbon::now()->subDays(10)->toDateString(),
                        'end_date' => Carbon::now()->subDays(6)->toDateString(),
                        'user_id' => $carlos->getId(),
                        'car_id' => $car4->getId(),
                        'location_id' => $loc3->getId(),
                    ]
                );
            }
        }

        if ($user) {
            $car5 = $cars->count() > 4 ? $cars->get(4) : $cars->first();
            $startDate5 = Carbon::now()->addDays(7);
            $endDate5 = Carbon::now()->addDays(11);

            Reservation::firstOrCreate(
                ['code' => 19283746],
                [
                    'state' => Reservation::STATE_CONFIRMED,
                    'start_date' => $startDate5->toDateString(),
                    'end_date' => $endDate5->toDateString(),
                    'user_id' => $user->getId(),
                    'car_id' => $car5->getId(),
                    'location_id' => $loc1->getId(),
                ]
            );

            if ($cars->count() > 5) {
                $car6 = $cars->get(5);
                Reservation::firstOrCreate(
                    ['code' => 19283747],
                    [
                        'state' => Reservation::STATE_PENDING,
                        'start_date' => Carbon::now()->addDays(15)->toDateString(),
                        'end_date' => Carbon::now()->addDays(18)->toDateString(),
                        'user_id' => $user->getId(),
                        'car_id' => $car6->getId(),
                        'location_id' => $loc3->getId(),
                    ]
                );
            }
        }
    }
}
