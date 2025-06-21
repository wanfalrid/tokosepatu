<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Auth\AuthController as CustomerAuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Default login route (Laravel expects this)
Route::get('/login', function() {
    return redirect()->route('auth.login');
})->name('login');

// Add POST route for login to handle form submissions
Route::post('/login', function() {
    return redirect()->route('auth.login');
});

// Produk routes
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.detail');
Route::get('/search', [ProdukController::class, 'search'])->name('produk.search');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout routes - memerlukan login customer
Route::middleware(['customer'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

// Checkout success page - bisa diakses tanpa login untuk melihat konfirmasi
Route::get('/checkout/success/{orderId}', [CheckoutController::class, 'success'])->name('checkout.success');

// Customer Authentication routes
Route::prefix('auth')->name('auth.')->group(function () {
    // Guest routes (not authenticated) - hanya untuk customer yang belum login
    Route::middleware('guest.customer')->group(function () {
        Route::get('login', [CustomerAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [CustomerAuthController::class, 'login'])->name('authenticate');
        Route::get('register', [CustomerAuthController::class, 'showRegister'])->name('register');
        Route::post('register', [CustomerAuthController::class, 'register'])->name('store');
    });
    
    // Customer routes (authenticated) - hanya untuk customer yang sudah login
    Route::middleware(['customer'])->group(function () {
        Route::post('logout', [CustomerAuthController::class, 'logout'])->name('logout');
        Route::get('profile', [CustomerAuthController::class, 'profile'])->name('profile');
        Route::put('profile', [CustomerAuthController::class, 'updateProfile'])->name('profile.update');
        
        // Customer order history
        Route::get('orders', [CustomerAuthController::class, 'orders'])->name('orders');
        Route::get('orders/{id}', [CustomerAuthController::class, 'orderDetail'])->name('orders.detail');
        Route::get('orders/{id}/tracking', [CustomerAuthController::class, 'orderTracking'])->name('orders.tracking');
    });
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // Protected admin routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Product management
        Route::resource('produk', AdminProdukController::class);
        
        // Order management
        Route::get('pesanan', [PesananController::class, 'index'])->name('pesanan.index');
        Route::get('pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
        Route::put('pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    });
});