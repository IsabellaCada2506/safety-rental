<?php

/**
 * Description: Web routes for the Safety Rental application, including authentication, profile management, and admin dashboard access.
 */

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CatalogController;
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

$catalogPath = $basePath.'/catalog';
$catalogShowPath = $catalogPath.'/{id}';

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
        $adminDashboardPath,
        $adminCarPath,
        $adminCarCreatePath,
        $adminCarStorePath,
        $adminCarEditPath,
        $adminCarUpdatePath,
        $adminCarDeactivatePath,
        $adminCategoryPath,
        $adminCategoryCreatePath,
        $adminCategoryStorePath,
        $adminCategoryEditPath,
        $adminCategoryUpdatePath,
        $adminCategoryDeletePath,
        $catalogPath,
        $catalogShowPath
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
            ->whereNumber('id')
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

        Route::get(
            $adminCarPath,
            [CarController::class, 'index']
        )
            ->middleware('admin')
            ->name('admin.car.index');

        Route::get(
            $adminCarCreatePath,
            [CarController::class, 'create']
        )
            ->middleware('admin')
            ->name('admin.car.create');

        Route::post(
            $adminCarStorePath,
            [CarController::class, 'store']
        )
            ->middleware('admin')
            ->name('admin.car.store');

        Route::get(
            $adminCarEditPath,
            [CarController::class, 'edit']
        )
            ->middleware('admin')
            ->whereNumber('id')
            ->name('admin.car.edit');

        Route::put(
            $adminCarUpdatePath,
            [CarController::class, 'update']
        )
            ->middleware('admin')
            ->whereNumber('id')
            ->name('admin.car.update');

        Route::patch(
            $adminCarDeactivatePath,
            [CarController::class, 'deactivate']
        )
            ->middleware('admin')
            ->whereNumber('id')
            ->name('admin.car.deactivate');

        Route::get(
            $adminCategoryPath,
            [CategoryController::class, 'index']
        )
            ->middleware('admin')
            ->name('admin.category.index');

        Route::get(
            $adminCategoryCreatePath,
            [CategoryController::class, 'create']
        )
            ->middleware('admin')
            ->name('admin.category.create');

        Route::post(
            $adminCategoryStorePath,
            [CategoryController::class, 'store']
        )
            ->middleware('admin')
            ->name('admin.category.store');

        Route::get(
            $adminCategoryEditPath,
            [CategoryController::class, 'edit']
        )
            ->middleware('admin')
            ->whereNumber('id')
            ->name('admin.category.edit');

        Route::put(
            $adminCategoryUpdatePath,
            [CategoryController::class, 'update']
        )
            ->middleware('admin')
            ->whereNumber('id')
            ->name('admin.category.update');

        Route::delete(
            $adminCategoryDeletePath,
            [CategoryController::class, 'delete']
        )
            ->middleware('admin')
            ->whereNumber('id')
            ->name('admin.category.delete');

        Route::get(
            $catalogPath,
            [CatalogController::class, 'index']
        )
            ->middleware(['verified', 'customer'])
            ->name('catalog.index');

        Route::get(
            $catalogShowPath,
            [CatalogController::class, 'show']
        )
            ->middleware(['verified', 'customer'])
            ->whereNumber('id')
            ->name('catalog.show');
    }
);
