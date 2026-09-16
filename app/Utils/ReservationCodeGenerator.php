<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Utility implementing unique numeric code generation for reservations.
 */

namespace App\Utils;

use App\Models\Reservation;

class ReservationCodeGenerator
{
    public function generate(): int
    {
        do {
            $code = random_int(10000000, 99999999);
        } while (Reservation::query()->where('code', $code)->exists());

        return $code;
    }
}
