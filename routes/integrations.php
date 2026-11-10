<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-11-07
 * Description: Integration routes for partners, external vehicle view, and route calculations.
 */

use App\Http\Controllers\User\PartnerController;
use App\Http\Controllers\User\PickupRouteController;
use App\Http\Controllers\User\VehicleController;
use Illuminate\Support\Facades\Route;

$partnerPath = '/partners';
$vehiclePath = '/vehicles';
$pickupRoutePath = '/catalog/{id}/pickup-route';

Route::get($partnerPath, [PartnerController::class, 'index'])->name('partner.index');
Route::get($vehiclePath.'/{id}', [VehicleController::class, 'show'])->whereNumber('id')->name('vehicles.show');
Route::get($pickupRoutePath, [PickupRouteController::class, 'index'])->middleware(['auth', 'verified', 'user'])->whereNumber('id')->name('pickupRoutes.index');
Route::post($pickupRoutePath, [PickupRouteController::class, 'calculate'])->middleware(['auth', 'verified', 'user', 'throttle:10,1'])->whereNumber('id')->name('pickupRoutes.calculate');
