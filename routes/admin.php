<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

    // ================= DASHBOARD =================
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ================= BRAND =================
    Route::resource('brands', BrandController::class);

    // ================= PRODUCT =================
    Route::resource('products', ProductController::class);

    // ================= ORDER =================
    Route::resource('orders', OrderController::class);

    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.update-status');

    // ================= PAYMENT =================
    Route::resource('payments', PaymentController::class);

    // verify payment (SET PAID)
    Route::post('payments/{payment}/verify', [PaymentController::class, 'verify'])
        ->name('payments.verify');

    // reject payment
    Route::post('payments/{payment}/reject', [PaymentController::class, 'reject'])
        ->name('payments.reject');

    // ================= SHIPMENT =================
    Route::resource('shipments', ShipmentController::class);

    Route::put('shipments/{shipment}/tracking', [ShipmentController::class, 'updateTracking'])
        ->name('shipments.update-tracking');

    Route::post('shipments/{shipment}/shipped', [ShipmentController::class, 'markAsShipped'])
        ->name('shipments.shipped');

    Route::post('shipments/{shipment}/delivered', [ShipmentController::class, 'markAsDelivered'])
        ->name('shipments.delivered');

    // ================= LOGOUT =================
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');

});