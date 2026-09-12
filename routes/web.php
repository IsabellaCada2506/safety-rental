<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Web routes for the Safety Rental application, mapping HTTP requests to controller actions without closures.
 */

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

$basePath = '';

$welcomePath = $basePath.'/';
$localePath = $basePath.'/locale/{lang}';

$loginPath = $basePath.'/login';
$logoutPath = $basePath.'/logout';
$registerPath = $basePath.'/register';

$homePath = $basePath.'/home';

$profilePath = $basePath.'/profile';
$profileEditPath = $profilePath.'/edit';

$emailPath = $basePath.'/email';
$emailVerificationPath = $emailPath.'/verify';
$emailVerificationHandlerPath = $emailVerificationPath.'/{id}/{hash}';
$emailVerificationNotificationPath = $emailPath.'/verification-notification';

$passwordPath = $basePath.'/password';
$passwordRequestPath = $passwordPath.'/request';
$passwordEmailPath = $passwordPath.'/email';
$passwordResetPath = $passwordPath.'/reset/{token}';
$passwordUpdatePath = $passwordPath.'/reset';

$adminPath = $basePath.'/admin';
$adminDashboardPath = $adminPath.'/dashboard';

$adminCarPath = $adminPath.'/cars';
$adminCarCreatePath = $adminCarPath.'/create';
$adminCarStorePath = $adminCarPath.'/store';
$adminCarEditPath = $adminCarPath.'/{id}/edit';
$adminCarUpdatePath = $adminCarPath.'/{id}/update';
$adminCarDeactivatePath = $adminCarPath.'/{id}/deactivate';

$adminCategoryPath = $adminPath.'/categories';
$adminCategoryCreatePath = $adminCategoryPath.'/create';
$adminCategoryStorePath = $adminCategoryPath.'/store';
$adminCategoryEditPath = $adminCategoryPath.'/{id}/edit';
$adminCategoryUpdatePath = $adminCategoryPath.'/{id}/update';
$adminCategoryDeletePath = $adminCategoryPath.'/{id}/delete';

$adminReservationPath = $adminPath.'/reservations';
$adminReservationShowPath = $adminReservationPath.'/{id}';
$adminReservationConfirmPath = $adminReservationPath.'/{id}/confirm';
$adminReservationCancelPath = $adminReservationPath.'/{id}/cancel';

$reservationPath = $basePath.'/reservations';
$reservationCreatePath = $reservationPath.'/create';
$reservationStorePath = $reservationPath;
$reservationShowPath = $reservationPath.'/{id}';
$reservationCancelPath = $reservationPath.'/{id}/cancel';

$catalogPath = $basePath.'/catalog';
$catalogShowPath = $catalogPath.'/{id}';

$adminLocationPath = $adminPath.'/locations';
$adminLocationCreatePath = $adminLocationPath.'/create';
$adminLocationStorePath = $adminLocationPath.'/store';
$adminLocationEditPath = $adminLocationPath.'/{id}/edit';
$adminLocationUpdatePath = $adminLocationPath.'/{id}/update';
$adminLocationDeletePath = $adminLocationPath.'/{id}/delete';

$locationPath = $basePath.'/locations';
$locationShowPath = $locationPath.'/{id}';

Route::get($welcomePath, [WelcomeController::class, 'index'])->name('welcome.index');
Route::get($localePath, [LocaleController::class, 'switch'])->name('locale.switch');

Route::get($loginPath, [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post($loginPath, [LoginController::class, 'authenticate'])->middleware('guest')->name('auth.login.authenticate');
Route::get($registerPath, [RegisterController::class, 'index'])->middleware('guest')->name('register');
Route::post($registerPath, [RegisterController::class, 'store'])->middleware('guest')->name('auth.register.store');
Route::get($passwordRequestPath, [ForgotPasswordController::class, 'index'])->middleware('guest')->name('password.request');
Route::post($passwordEmailPath, [ForgotPasswordController::class, 'sendResetLink'])->middleware('guest')->name('password.email');
Route::get($passwordResetPath, [ResetPasswordController::class, 'index'])->middleware('guest')->name('password.reset');
Route::post($passwordUpdatePath, [ResetPasswordController::class, 'update'])->middleware('guest')->name('password.update');

Route::post($logoutPath, [LoginController::class, 'logout'])->middleware('auth')->name('auth.logout');
Route::get($emailVerificationPath, [VerificationController::class, 'index'])->middleware('auth')->name('verification.notice');
Route::get($emailVerificationHandlerPath, [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->whereNumber('id')->name('verification.verify');
Route::post($emailVerificationNotificationPath, [VerificationController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get($homePath, [HomeController::class, 'index'])->middleware(['auth', 'verified', 'customer'])->name('home.index');
Route::get($profilePath, [ProfileController::class, 'index'])->middleware(['auth', 'customer'])->name('profile.index');
Route::get($profileEditPath, [ProfileController::class, 'edit'])->middleware(['auth', 'customer'])->name('profile.edit');
Route::put($profilePath, [ProfileController::class, 'update'])->middleware(['auth', 'customer'])->name('profile.update');

Route::get($catalogPath, [CatalogController::class, 'index'])->middleware(['auth', 'verified', 'customer'])->name('catalog.index');
Route::get($catalogShowPath, [CatalogController::class, 'show'])->middleware(['auth', 'verified', 'customer'])->whereNumber('id')->name('catalog.show');

Route::get($locationPath, [LocationController::class, 'index'])->middleware(['auth', 'verified', 'customer'])->name('locations.index');
Route::get($locationShowPath, [LocationController::class, 'show'])->middleware(['auth', 'verified', 'customer'])->whereNumber('id')->name('locations.show');

Route::get($reservationPath, [ReservationController::class, 'index'])->middleware(['auth', 'verified', 'customer'])->name('reservations.index');
Route::get($reservationCreatePath, [ReservationController::class, 'create'])->middleware(['auth', 'verified', 'customer'])->name('reservations.create');
Route::post($reservationStorePath, [ReservationController::class, 'store'])->middleware(['auth', 'verified', 'customer'])->name('reservations.store');
Route::get($reservationShowPath, [ReservationController::class, 'show'])->middleware(['auth', 'verified', 'customer'])->whereNumber('id')->name('reservations.show');
Route::patch($reservationCancelPath, [ReservationController::class, 'cancel'])->middleware(['auth', 'verified', 'customer'])->whereNumber('id')->name('reservations.cancel');

Route::get($adminDashboardPath, [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'admin'])->name('admin.dashboard.index');
Route::get($adminCarPath, [CarController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.car.index');
Route::get($adminCarCreatePath, [CarController::class, 'create'])->middleware(['auth', 'admin'])->name('admin.car.create');
Route::post($adminCarStorePath, [CarController::class, 'store'])->middleware(['auth', 'admin'])->name('admin.car.store');
Route::get($adminCarEditPath, [CarController::class, 'edit'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.car.edit');
Route::put($adminCarUpdatePath, [CarController::class, 'update'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.car.update');
Route::patch($adminCarDeactivatePath, [CarController::class, 'deactivate'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.car.deactivate');

Route::get($adminCategoryPath, [CategoryController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.category.index');
Route::get($adminCategoryCreatePath, [CategoryController::class, 'create'])->middleware(['auth', 'admin'])->name('admin.category.create');
Route::post($adminCategoryStorePath, [CategoryController::class, 'store'])->middleware(['auth', 'admin'])->name('admin.category.store');
Route::get($adminCategoryEditPath, [CategoryController::class, 'edit'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.category.edit');
Route::put($adminCategoryUpdatePath, [CategoryController::class, 'update'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.category.update');
Route::delete($adminCategoryDeletePath, [CategoryController::class, 'delete'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.category.delete');

Route::get($adminLocationPath, [AdminLocationController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.location.index');
Route::get($adminLocationCreatePath, [AdminLocationController::class, 'create'])->middleware(['auth', 'admin'])->name('admin.location.create');
Route::post($adminLocationStorePath, [AdminLocationController::class, 'store'])->middleware(['auth', 'admin'])->name('admin.location.store');
Route::get($adminLocationEditPath, [AdminLocationController::class, 'edit'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.location.edit');
Route::put($adminLocationUpdatePath, [AdminLocationController::class, 'update'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.location.update');
Route::delete($adminLocationDeletePath, [AdminLocationController::class, 'delete'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.location.delete');

Route::get($adminReservationPath, [AdminReservationController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.reservation.index');
Route::get($adminReservationShowPath, [AdminReservationController::class, 'show'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.reservation.show');
Route::patch($adminReservationConfirmPath, [AdminReservationController::class, 'confirm'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.reservation.confirm');
Route::patch($adminReservationCancelPath, [AdminReservationController::class, 'cancel'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.reservation.cancel');
