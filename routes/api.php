<?php

use App\Http\Controllers\Api\VehicleApiController;
use Illuminate\Support\Facades\Route;

$vehiclePath = '/vehiculos';

Route::get($vehiclePath, [VehicleApiController::class, 'index'])->name('api.vehicles.index');
