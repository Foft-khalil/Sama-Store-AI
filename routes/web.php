<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsAppWebhookController;
use App\Http\Controllers\StoreController;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WaveController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Vendeur
Route::get('/login', [DashboardController::class, 'showLogin'])->name('login');
Route::post('/login', [DashboardController::class, 'login'])->name('login.post');
Route::get('/register', [DashboardController::class, 'showLogin'])->name('register'); // Redirige vers login pour simplifier
Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

// Dashboard Vendeur
Route::middleware('subscription')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/orders/{id}/status', [DashboardController::class, 'updateOrderStatus'])->name('orders.update_status');
    
    // Subscription & Pricing
    Route::get('/dashboard/pricing', [DashboardController::class, 'pricing'])->name('dashboard.pricing');
    Route::post('/dashboard/upgrade', [DashboardController::class, 'upgrade'])->name('dashboard.upgrade');

    // Product Management (Web CMS)
    Route::post('/dashboard/products', [DashboardController::class, 'storeProduct'])->name('products.store');
    Route::get('/dashboard/products/{id}/edit', [DashboardController::class, 'editProduct'])->name('products.edit');
    Route::put('/dashboard/products/{id}', [DashboardController::class, 'updateProduct'])->name('products.update');
    Route::delete('/dashboard/products/{id}', [DashboardController::class, 'deleteProduct'])->name('products.delete');

    // Store Settings
    Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
    Route::post('/dashboard/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');

    // Visual Analytics
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

    // Wave Real Payments
    Route::post('/dashboard/pay/wave', [WaveController::class, 'initiatePayment'])->name('pay.wave');
});

// Wave Webhook (Moved to API)

// Front-end Stores routing
Route::middleware('subscription')->group(function () {
    Route::get('/s/{slug}', [StoreController::class, 'show'])->name('store.show');
});
Route::post('/s/{slug}/product/{productId}/checkout', [OrderController::class, 'store'])->name('order.store');

// WhatsApp Webhook (Moved to API)
