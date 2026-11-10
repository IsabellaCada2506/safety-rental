<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-11-04
 * Description: API routes for external client consumers and integrations.
 */

use App\Http\Controllers\Api\VehicleApiController;
use Illuminate\Support\Facades\Route;

$vehiclePath = '/vehiculos';

Route::get($vehiclePath, [VehicleApiController::class, 'index'])->name('api.vehicles.index');
