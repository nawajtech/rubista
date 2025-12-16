<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\HomepageContentController;
use App\Http\Controllers\Admin\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/frontend.php';

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin Authentication routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Admin Dashboard and Management - Only accessible by admin users
    Route::middleware(['auth', 'admin'])->group(function () {
        // Dashboard
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        // Core Management
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::post('products/update-sort-order', [ProductController::class, 'updateSortOrder'])->name('products.update-sort-order');
        Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
        Route::patch('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::resource('cms', CmsController::class);
        Route::resource('homepage-content', HomepageContentController::class);
        Route::patch('homepage-content/{homepageContent}/toggle-status', [HomepageContentController::class, 'toggleStatus'])->name('homepage-content.toggle-status');
        // Reviews Management
        Route::resource('reviews', ReviewController::class);
        Route::patch('reviews/{review}/toggle-status', [ReviewController::class, 'toggleStatus'])->name('reviews.toggle-status');
        Route::delete('reviews/{review}/delete-photo', [ReviewController::class, 'deletePhoto'])->name('reviews.delete-photo');
        Route::delete('reviews/{review}/delete-video', [ReviewController::class, 'deleteVideo'])->name('reviews.delete-video');
        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::post('/settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');
    });
});
