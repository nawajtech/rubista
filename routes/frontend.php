<?php

use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register frontend routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

// Frontend Home Routes
Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/category/{id}', [HomeController::class, 'categoryProducts'])->name('frontend.category.products');
Route::get('/product/{id}', [HomeController::class, 'productDetail'])->name('frontend.product.detail');
Route::get('/search', [HomeController::class, 'search'])->name('frontend.search');

// Static Pages
Route::get('/about-us', [PageController::class, 'about'])->name('frontend.about');
Route::get('/contact-us', [PageController::class, 'contact'])->name('frontend.contact');
Route::post('/contact-us', [PageController::class, 'contactSubmit'])->name('frontend.contact.submit');
Route::get('/faq', [PageController::class, 'faq'])->name('frontend.faq');
Route::get('/categories', [PageController::class, 'categories'])->name('frontend.categories');

// Frontend Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('frontend.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('frontend.register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('frontend.logout')->middleware('auth');

// Cart Routes (available to all users)
Route::get('/cart', [CartController::class, 'index'])->name('frontend.cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('frontend.cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('frontend.cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('frontend.cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('frontend.cart.clear');

// Wishlist Routes (available to all users)
Route::get('/wishlist', [WishlistController::class, 'index'])->name('frontend.wishlist');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('frontend.wishlist.toggle');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('frontend.wishlist.add');
Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('frontend.wishlist.remove');
Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('frontend.wishlist.clear');
Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])->name('frontend.wishlist.move-to-cart');

// Protected Frontend Routes (for logged in non-admin users)
Route::middleware(['frontend.user'])->group(function () {
    // Profile Routes
    Route::get('/profile', [\App\Http\Controllers\Frontend\ProfileController::class, 'index'])->name('frontend.profile');
    Route::post('/profile/update', [\App\Http\Controllers\Frontend\ProfileController::class, 'updateProfile'])->name('frontend.profile.update');
    Route::post('/profile/change-password', [\App\Http\Controllers\Frontend\ProfileController::class, 'updatePassword'])->name('frontend.profile.change-password');
    Route::post('/profile/update-address', [\App\Http\Controllers\Frontend\ProfileController::class, 'updateAddress'])->name('frontend.profile.update-address');
    
    // Order Routes
    Route::get('/orders', [\App\Http\Controllers\Frontend\OrderController::class, 'index'])->name('frontend.orders');
    Route::get('/checkout', [\App\Http\Controllers\Frontend\OrderController::class, 'create'])->name('frontend.checkout');
    Route::post('/checkout', [\App\Http\Controllers\Frontend\OrderController::class, 'store'])->name('frontend.checkout.store');
    Route::get('/orders/{order}', [\App\Http\Controllers\Frontend\OrderController::class, 'show'])->name('frontend.orders.show');
    Route::get('/orders/{order}/invoice', [\App\Http\Controllers\Frontend\OrderController::class, 'invoice'])->name('frontend.orders.invoice');
    Route::get('/orders/{order}/invoice/download', [\App\Http\Controllers\Frontend\OrderController::class, 'downloadInvoice'])->name('frontend.orders.invoice.download');
    Route::patch('/orders/{order}/cancel', [\App\Http\Controllers\Frontend\OrderController::class, 'cancel'])->name('frontend.orders.cancel');
}); 