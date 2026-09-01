<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\OrderVerificationController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    URL::forceScheme('https');
}

// Public Storefront Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/audios', [AudioController::class, 'index'])->name('audios.index');
Route::get('/product/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

// Shopping Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout & Payment Gateway Routes
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/paystack/callback', [CheckoutController::class, 'paystackCallback'])->name('paystack.callback');

Route::get('/orders/{orderNumber}/success', function($orderNumber) {
    $order = \App\Models\Order::where('order_number', $orderNumber)->firstOrFail();
    return view('storefront.order_success', compact('order'));
})->name('checkout.success');

// Customer Auth Routes (Guest Only)
Route::middleware('guest')->group(function() {
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login']);
});

// Customer Account & Order History (Auth Required)
Route::middleware('auth')->prefix('account')->name('account.')->group(function() {
    Route::get('/', [AccountController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{orderNumber}', [AccountController::class, 'showOrder'])->name('orders.show');
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
});

// Admin Panel Routes (/admin) - Secured with Auth & Admin Middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/', [OrderVerificationController::class, 'index'])->name('dashboard');
    Route::get('/verifications', [OrderVerificationController::class, 'index'])->name('verifications');
    Route::post('/verifications/{id}/approve', [OrderVerificationController::class, 'approve'])->name('verifications.approve');
    Route::post('/verifications/{id}/reject', [OrderVerificationController::class, 'reject'])->name('verifications.reject');
    Route::post('/orders/{id}/status', [OrderVerificationController::class, 'updateStatus'])->name('orders.updateStatus');

    // Product Management Resource Routes
    Route::resource('products', AdminProductController::class);

    // Admin & Staff Logins Management Routes
    Route::resource('users', AdminUserController::class)->except(['create', 'edit', 'show']);
});
