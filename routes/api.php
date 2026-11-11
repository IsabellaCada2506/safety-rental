<?php

/**
 * Author: Isabella Cadavid Posada
 * Author: Isabella Ocampo
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-11-04
 * Description: API routes for external client consumers and integrations.
 */

use App\Http\Controllers\Api\VehicleApiController;
use Illuminate\Support\Facades\Route;

$vehiclePath = '/cars';

Route::get($vehiclePath, [VehicleApiController::class, 'index'])->name('api.vehicles.index');
