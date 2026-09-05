<?php

// Author: Isabella Cadavid Posada

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

$basePath = '';

$welcomePath = $basePath.'/';

$loginPath = $basePath.'/login';
$logoutPath = $basePath.'/logout';
$registerPath = $basePath.'/register';

$homePath = $basePath.'/home';

$profilePath = $basePath.'/profile';
$profileEditPath = $profilePath.'/edit';

$emailPath = $basePath.'/email';
$emailVerificationPath = $emailPath.'/verify';
$emailVerificationHandlerPath = $emailVerificationPath.'/{id}/{hash}';
$emailVerificationNotificationPath =
    $emailPath.'/verification-notification';

$passwordPath = $basePath.'/password';
$passwordRequestPath = $passwordPath.'/request';
$passwordEmailPath = $passwordPath.'/email';
$passwordResetPath = $passwordPath.'/reset/{token}';
$passwordUpdatePath = $passwordPath.'/reset';

$adminPath = $basePath.'/admin';
$adminDashboardPath = $adminPath.'/dashboard';

Route::get(
    $welcomePath,
    [WelcomeController::class, 'index']
)->name('welcome.index');

Route::middleware('guest')->group(
    function () use (
        $loginPath,
        $registerPath,
        $passwordRequestPath,
        $passwordEmailPath,
        $passwordResetPath,
        $passwordUpdatePath
    ): void {
        Route::get(
            $loginPath,
            [LoginController::class, 'index']
        )->name('login');

        Route::post(
            $loginPath,
            [LoginController::class, 'authenticate']
        )->name('auth.login.authenticate');

        Route::get(
            $registerPath,
            [RegisterController::class, 'index']
        )->name('register');

        Route::post(
            $registerPath,
            [RegisterController::class, 'store']
        )->name('auth.register.store');

        Route::get(
            $passwordRequestPath,
            [ForgotPasswordController::class, 'index']
        )->name('password.request');

        Route::post(
            $passwordEmailPath,
            [ForgotPasswordController::class, 'sendResetLink']
        )->name('password.email');

        Route::get(
            $passwordResetPath,
            [ResetPasswordController::class, 'index']
        )->name('password.reset');

        Route::post(
            $passwordUpdatePath,
            [ResetPasswordController::class, 'update']
        )->name('password.update');
    }
);

Route::middleware('auth')->group(
    function () use (
        $logoutPath,
        $homePath,
        $profilePath,
        $profileEditPath,
        $emailVerificationPath,
        $emailVerificationHandlerPath,
        $emailVerificationNotificationPath,
        $adminDashboardPath
    ): void {
        Route::post(
            $logoutPath,
            [LoginController::class, 'logout']
        )->name('auth.logout');

        Route::get(
            $emailVerificationPath,
            [VerificationController::class, 'index']
        )->name('verification.notice');

        Route::get(
            $emailVerificationHandlerPath,
            [VerificationController::class, 'verify']
        )
            ->middleware('signed')
            ->name('verification.verify');

        Route::post(
            $emailVerificationNotificationPath,
            [VerificationController::class, 'resend']
        )
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::get(
            $homePath,
            [HomeController::class, 'index']
        )
            ->middleware([
                'verified',
                'customer',
            ])
            ->name('home.index');

        Route::get(
            $profilePath,
            [ProfileController::class, 'index']
        )
            ->middleware('customer')
            ->name('profile.index');

        Route::get(
            $profileEditPath,
            [ProfileController::class, 'edit']
        )
            ->middleware('customer')
            ->name('profile.edit');

        Route::put(
            $profilePath,
            [ProfileController::class, 'update']
        )
            ->middleware('customer')
            ->name('profile.update');

        Route::get(
            $adminDashboardPath,
            [DashboardController::class, 'index']
        )
            ->middleware([
                'verified',
                'admin',
            ])
            ->name('admin.dashboard.index');
    }
);
