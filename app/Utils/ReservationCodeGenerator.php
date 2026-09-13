<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Utility implementing unique numeric code generation for reservations.
 */

namespace App\Utils;

use App\Interfaces\ReservationCodeGeneratorInterface;
use App\Models\Reservation;

class ReservationCodeGenerator implements ReservationCodeGeneratorInterface
{
    public function generate(): int
    {
        do {
            $code = random_int(10000000, 99999999);
        } while (Reservation::query()->where('code', $code)->exists());

        return $code;
    }
}
