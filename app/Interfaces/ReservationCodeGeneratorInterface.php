<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Interface defining contract for generating unique reservation codes.
 */

namespace App\Interfaces;

interface ReservationCodeGeneratorInterface
{
    public function generate(): int;
}
