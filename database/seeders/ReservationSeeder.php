<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Seeder for populating realistic test reservations across customers.
 */

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Location;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $cars = Car::all();
        $locations = Location::all();

        if ($cars->isEmpty() || $locations->isEmpty()) {
            return;
        }

        $loc1 = $locations->get(0);
        $loc2 = $locations->count() > 1 ? $locations->get(1) : $loc1;
        $loc3 = $locations->count() > 2 ? $locations->get(2) : $loc1;

        $isa = User::query()->where('email', 'isa@gmail.com')->first();
        $carlos = User::query()->where('email', 'carlos@gmail.com')->first();
        $customer = User::query()->where('email', 'customer@safetyrental.test')->first();

        // 1. Reservations for Isabella (isa@gmail.com)
        if ($isa) {
            $car1 = $cars->get(0);
            $startDate1 = Carbon::now()->addDays(2);
            $endDate1 = Carbon::now()->addDays(6);
            $days1 = $startDate1->diffInDays($endDate1);
            $amount1 = $car1->getPrice() * $days1;

            $payment1 = Payment::firstOrCreate(
                ['code' => 9001001],
                [
                    'amount' => $amount1,
                    'method' => 'Credit Card',
                    'transaction_code' => 8819201,
                    'status' => Payment::STATUS_COMPLETED,
                    'date' => Carbon::now()->toDateString(),
                ]
            );

            Reservation::firstOrCreate(
                ['code' => 84920184],
                [
                    'state' => Reservation::STATE_CONFIRMED,
                    'start_date' => $startDate1->toDateString(),
                    'end_date' => $endDate1->toDateString(),
                    'user_id' => $isa->getId(),
                    'car_id' => $car1->getId(),
                    'location_id' => $loc1->getId(),
                    'payment_id' => $payment1->getId(),
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

        // 2. Reservations for Carlos (carlos@gmail.com)
        if ($carlos) {
            $car3 = $cars->count() > 2 ? $cars->get(2) : $cars->first();
            $startDate3 = Carbon::now()->addDays(1);
            $endDate3 = Carbon::now()->addDays(5);
            $days3 = $startDate3->diffInDays($endDate3);
            $amount3 = $car3->getPrice() * $days3;

            $payment3 = Payment::firstOrCreate(
                ['code' => 9001002],
                [
                    'amount' => $amount3,
                    'method' => 'PSE Debit',
                    'transaction_code' => 8819202,
                    'status' => Payment::STATUS_COMPLETED,
                    'date' => Carbon::now()->toDateString(),
                ]
            );

            Reservation::firstOrCreate(
                ['code' => 73910245],
                [
                    'state' => Reservation::STATE_CONFIRMED,
                    'start_date' => $startDate3->toDateString(),
                    'end_date' => $endDate3->toDateString(),
                    'user_id' => $carlos->getId(),
                    'car_id' => $car3->getId(),
                    'location_id' => $loc2->getId(),
                    'payment_id' => $payment3->getId(),
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

        // 3. Reservations for Test Customer (customer@safetyrental.test)
        if ($customer) {
            $car5 = $cars->count() > 4 ? $cars->get(4) : $cars->first();
            $startDate5 = Carbon::now()->addDays(7);
            $endDate5 = Carbon::now()->addDays(11);
            $days5 = $startDate5->diffInDays($endDate5);
            $amount5 = $car5->getPrice() * $days5;

            $payment5 = Payment::firstOrCreate(
                ['code' => 9001003],
                [
                    'amount' => $amount5,
                    'method' => 'Credit Card',
                    'transaction_code' => 8819203,
                    'status' => Payment::STATUS_COMPLETED,
                    'date' => Carbon::now()->toDateString(),
                ]
            );

            Reservation::firstOrCreate(
                ['code' => 19283746],
                [
                    'state' => Reservation::STATE_CONFIRMED,
                    'start_date' => $startDate5->toDateString(),
                    'end_date' => $endDate5->toDateString(),
                    'user_id' => $customer->getId(),
                    'car_id' => $car5->getId(),
                    'location_id' => $loc1->getId(),
                    'payment_id' => $payment5->getId(),
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
                        'user_id' => $customer->getId(),
                        'car_id' => $car6->getId(),
                        'location_id' => $loc3->getId(),
                    ]
                );
            }
        }
    }
}
