<?php

/**
 * Author: Isabella Cadavid Posada
 * Author: Isabella Ocampo
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-12
 * Description: Web routes for the Safety Rental application, mapping HTTP requests to controller actions without closures.
 */

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CarRankingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\MetricsController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Authentication\ForgotPasswordController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\Authentication\ResetPasswordController;
use App\Http\Controllers\Authentication\VerificationController;
use App\Http\Controllers\User\CatalogController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\LocaleController;
use App\Http\Controllers\User\LocationController as UserLocationController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ReceiptController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\User\WelcomeController;
use Illuminate\Support\Facades\Route;

$basePath = '';

Route::get($basePath.'/', [WelcomeController::class, 'index'])->name('welcome.index');
Route::post($basePath.'/locale/{lang}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get($basePath.'/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post($basePath.'/login', [LoginController::class, 'authenticate'])->middleware('guest')->name('auth.login.authenticate');
Route::get($basePath.'/register', [RegisterController::class, 'index'])->middleware('guest')->name('register');
Route::post($basePath.'/register', [RegisterController::class, 'store'])->middleware('guest')->name('auth.register.store');
Route::get($basePath.'/password/request', [ForgotPasswordController::class, 'index'])->middleware('guest')->name('password.request');
Route::post($basePath.'/password/email', [ForgotPasswordController::class, 'sendResetLink'])->middleware('guest')->name('password.email');
Route::get($basePath.'/password/reset/{token}', [ResetPasswordController::class, 'index'])->middleware('guest')->name('password.reset');
Route::post($basePath.'/password/reset', [ResetPasswordController::class, 'update'])->middleware('guest')->name('password.update');

Route::post($basePath.'/logout', [LoginController::class, 'logout'])->middleware('auth')->name('auth.logout');
Route::get($basePath.'/email/verify', [VerificationController::class, 'index'])->middleware('auth')->name('verification.notice');
Route::get($basePath.'/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->whereNumber('id')->name('verification.verify');
Route::post($basePath.'/email/verification-notification', [VerificationController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get($basePath.'/home', [HomeController::class, 'index'])->middleware(['auth', 'verified', 'user'])->name('home.index');
Route::get($basePath.'/profile', [ProfileController::class, 'index'])->middleware(['auth', 'user'])->name('profile.index');
Route::get($basePath.'/profile/edit', [ProfileController::class, 'edit'])->middleware(['auth', 'user'])->name('profile.edit');
Route::put($basePath.'/profile', [ProfileController::class, 'update'])->middleware(['auth', 'user'])->name('profile.update');

Route::get($basePath.'/catalog', [CatalogController::class, 'index'])->middleware(['auth', 'verified', 'user'])->name('catalog.index');
Route::get($basePath.'/catalog/{id}', [CatalogController::class, 'show'])->middleware(['auth', 'verified', 'user'])->whereNumber('id')->name('catalog.show');

Route::get($basePath.'/locations', [UserLocationController::class, 'index'])->middleware(['auth', 'verified', 'user'])->name('locations.index');
Route::get($basePath.'/locations/{id}', [UserLocationController::class, 'show'])->middleware(['auth', 'verified', 'user'])->whereNumber('id')->name('locations.show');

Route::get($basePath.'/reservations', [ReservationController::class, 'index'])->middleware(['auth', 'verified', 'user'])->name('reservations.index');
Route::get($basePath.'/reservations/create', [ReservationController::class, 'create'])->middleware(['auth', 'verified', 'user'])->name('reservations.create');
Route::post($basePath.'/reservations', [ReservationController::class, 'store'])->middleware(['auth', 'verified', 'user'])->name('reservations.store');
Route::get($basePath.'/reservations/{id}', [ReservationController::class, 'show'])->middleware(['auth', 'verified', 'user'])->whereNumber('id')->name('reservations.show');
Route::patch($basePath.'/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->middleware(['auth', 'verified', 'user'])->whereNumber('id')->name('reservations.cancel');
Route::get($basePath.'/reservations/{id}/payment', [PaymentController::class, 'create'])->middleware(['auth', 'verified', 'user'])->whereNumber('id')->name('payments.create');
Route::post($basePath.'/reservations/{id}/payment', [PaymentController::class, 'store'])->middleware(['auth', 'verified', 'user'])->whereNumber('id')->name('payments.store');
Route::get($basePath.'/reservations/{id}/receipt', [ReceiptController::class, 'download'])->middleware(['auth', 'verified', 'user'])->whereNumber('id')->name('receipts.download');

Route::get($basePath.'/admin/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'admin'])->name('admin.dashboard.index');
Route::get($basePath.'/admin/cars', [CarController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.car.index');
Route::get($basePath.'/admin/cars/create', [CarController::class, 'create'])->middleware(['auth', 'admin'])->name('admin.car.create');
Route::post($basePath.'/admin/cars/store', [CarController::class, 'store'])->middleware(['auth', 'admin'])->name('admin.car.store');
Route::get($basePath.'/admin/cars/{id}/edit', [CarController::class, 'edit'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.car.edit');
Route::put($basePath.'/admin/cars/{id}/update', [CarController::class, 'update'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.car.update');
Route::patch($basePath.'/admin/cars/{id}/deactivate', [CarController::class, 'deactivate'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.car.deactivate');
Route::get($basePath.'/admin/car-ranking', [CarRankingController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.ranking.index');

Route::get($basePath.'/admin/categories', [CategoryController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.category.index');
Route::get($basePath.'/admin/categories/create', [CategoryController::class, 'create'])->middleware(['auth', 'admin'])->name('admin.category.create');
Route::post($basePath.'/admin/categories/store', [CategoryController::class, 'store'])->middleware(['auth', 'admin'])->name('admin.category.store');
Route::get($basePath.'/admin/categories/{id}/edit', [CategoryController::class, 'edit'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.category.edit');
Route::put($basePath.'/admin/categories/{id}/update', [CategoryController::class, 'update'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.category.update');
Route::delete($basePath.'/admin/categories/{id}/delete', [CategoryController::class, 'delete'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.category.delete');

Route::get($basePath.'/admin/locations', [AdminLocationController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.location.index');
Route::get($basePath.'/admin/locations/create', [AdminLocationController::class, 'create'])->middleware(['auth', 'admin'])->name('admin.location.create');
Route::post($basePath.'/admin/locations/store', [AdminLocationController::class, 'store'])->middleware(['auth', 'admin'])->name('admin.location.store');
Route::get($basePath.'/admin/locations/{id}/edit', [AdminLocationController::class, 'edit'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.location.edit');
Route::put($basePath.'/admin/locations/{id}/update', [AdminLocationController::class, 'update'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.location.update');
Route::delete($basePath.'/admin/locations/{id}/delete', [AdminLocationController::class, 'delete'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.location.delete');

Route::get($basePath.'/admin/reservations', [AdminReservationController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.reservation.index');
Route::get($basePath.'/admin/reservations/{id}', [AdminReservationController::class, 'show'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.reservation.show');
Route::patch($basePath.'/admin/reservations/{id}/confirm', [AdminReservationController::class, 'confirm'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.reservation.confirm');
Route::patch($basePath.'/admin/reservations/{id}/cancel', [AdminReservationController::class, 'cancel'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.reservation.cancel');

Route::get($basePath.'/admin/payments', [AdminPaymentController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.payment.index');
Route::get($basePath.'/admin/payments/{id}', [AdminPaymentController::class, 'show'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.payment.show');
Route::patch($basePath.'/admin/payments/{id}/refund', [AdminPaymentController::class, 'refund'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.payment.refund');
Route::get($basePath.'/admin/metrics', [MetricsController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.metrics.index');
Route::get($basePath.'/admin/users', [AdminUserController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.user.index');
Route::get($basePath.'/admin/users/{id}/edit', [AdminUserController::class, 'edit'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.user.edit');
Route::put($basePath.'/admin/users/{id}/update', [AdminUserController::class, 'update'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.user.update');
Route::delete($basePath.'/admin/users/{id}/delete', [AdminUserController::class, 'delete'])->middleware(['auth', 'admin'])->whereNumber('id')->name('admin.user.delete');
