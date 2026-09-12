<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Contract for generating rental payment receipt PDF documents.
 */

namespace App\Interfaces;

use App\Models\Reservation;
use Illuminate\Http\Response;

interface ReceiptServiceInterface
{
    public function downloadPaidReceipt(Reservation $reservation): Response;
}
