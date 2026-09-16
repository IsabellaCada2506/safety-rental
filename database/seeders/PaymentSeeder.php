<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-13
 * Description: Seeder for populating realistic test payments linked to reservations.
 */

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $reservation1 = Reservation::query()->where('code', 84920184)->first();
        if ($reservation1 && $reservation1->getCar()) {
            $days = $reservation1->getStartDate()->diffInDays($reservation1->getEndDate());
            $amount = $reservation1->getCar()->getPrice() * $days;

            $payment1 = Payment::firstOrCreate(
                ['code' => 9001001],
                [
                    'reservation_id' => $reservation1->getId(),
                    'amount' => $amount,
                    'method' => 'Credit Card',
                    'transaction_code' => 8819201,
                    'status' => Payment::STATUS_COMPLETED,
                    'date' => Carbon::now()->toDateString(),
                ]
            );

            $reservation1->setPaymentId($payment1->getId());
            $reservation1->save();
        }

        $reservation3 = Reservation::query()->where('code', 73910245)->first();
        if ($reservation3 && $reservation3->getCar()) {
            $days = $reservation3->getStartDate()->diffInDays($reservation3->getEndDate());
            $amount = $reservation3->getCar()->getPrice() * $days;

            $payment3 = Payment::firstOrCreate(
                ['code' => 9001002],
                [
                    'reservation_id' => $reservation3->getId(),
                    'amount' => $amount,
                    'method' => 'PSE Debit',
                    'transaction_code' => 8819202,
                    'status' => Payment::STATUS_COMPLETED,
                    'date' => Carbon::now()->toDateString(),
                ]
            );

            $reservation3->setPaymentId($payment3->getId());
            $reservation3->save();
        }

        $reservation5 = Reservation::query()->where('code', 19283746)->first();
        if ($reservation5 && $reservation5->getCar()) {
            $days = $reservation5->getStartDate()->diffInDays($reservation5->getEndDate());
            $amount = $reservation5->getCar()->getPrice() * $days;

            $payment5 = Payment::firstOrCreate(
                ['code' => 9001003],
                [
                    'reservation_id' => $reservation5->getId(),
                    'amount' => $amount,
                    'method' => 'Credit Card',
                    'transaction_code' => 8819203,
                    'status' => Payment::STATUS_COMPLETED,
                    'date' => Carbon::now()->toDateString(),
                ]
            );

            $reservation5->setPaymentId($payment5->getId());
            $reservation5->save();
        }
    }
}
