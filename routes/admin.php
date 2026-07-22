<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeHeroSlideController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.store');
    });

    Route::middleware('admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('products', ProductController::class)->except(['show']);
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('subcategories', SubCategoryController::class)->except(['show']);
        Route::resource('admins', AdminUserController::class)->except(['show']);

        Route::get('home-page', [HomePageController::class, 'index'])->name('home-page.index');
        Route::put('home-page/settings', [HomePageController::class, 'updateSettings'])->name('home-page.settings.update');
        Route::resource('home-hero-slides', HomeHeroSlideController::class)->except(['show', 'index']);
        Route::resource('home-sections', HomeSectionController::class)->except(['show', 'index']);
    });
});
