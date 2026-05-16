<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VoucherController;

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| BRAND
|--------------------------------------------------------------------------
*/

Route::resource('brands', BrandController::class);

/*
|--------------------------------------------------------------------------
| PRODUCT
|--------------------------------------------------------------------------
*/

Route::resource('products', ProductController::class);

/*
|--------------------------------------------------------------------------
| VOUCHER
|--------------------------------------------------------------------------
*/

Route::resource('vouchers', VoucherController::class);

/*
|--------------------------------------------------------------------------
| ORDER
|--------------------------------------------------------------------------
*/

Route::resource('orders', OrderController::class);

Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])
    ->name('orders.update-status');

/*
|--------------------------------------------------------------------------
| PAYMENT
|--------------------------------------------------------------------------
*/

Route::prefix('payments')
    ->name('payments.')
    ->group(function () {

        // list payment
        Route::get('/', [PaymentController::class, 'index'])
            ->name('index');

        // detail payment
        Route::get('/{payment}', [PaymentController::class, 'show'])
            ->name('show');

        // verify payment
        Route::post('/{payment}/verify', [PaymentController::class, 'verify'])
            ->name('verify');

        // reject payment
        Route::post('/{payment}/reject', [PaymentController::class, 'reject'])
            ->name('reject');

    });

/*
|--------------------------------------------------------------------------
| SHIPMENT
|--------------------------------------------------------------------------
*/

Route::resource('shipments', ShipmentController::class);

Route::put(
    'shipments/{shipment}/tracking',
    [ShipmentController::class, 'updateTracking']
)->name('shipments.update-tracking');

Route::post(
    'shipments/{shipment}/shipped',
    [ShipmentController::class, 'markAsShipped']
)->name('shipments.shipped');

Route::post(
    'shipments/{shipment}/delivered',
    [ShipmentController::class, 'markAsDelivered']
)->name('shipments.delivered');

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {

    Auth::logout();

    return redirect('/login');

})->name('logout');