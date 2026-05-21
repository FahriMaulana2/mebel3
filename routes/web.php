<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController as FrontendOrderController;

// ================= HOME =================
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// ================= PRODUCTS =================
Route::get('/products', [FrontendProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/{slug}', [FrontendProductController::class, 'show'])
    ->name('products.show');

// ================= CART =================
Route::prefix('cart')
    ->name('cart.')
    ->group(function () {

    Route::get('/', [CartController::class, 'index'])
        ->name('index');

    Route::post('/add', [CartController::class, 'add'])
        ->name('add');

    Route::put('/update/{id}', [CartController::class, 'update'])
        ->name('update');

    Route::delete('/remove/{id}', [CartController::class, 'remove'])
        ->name('remove');

    Route::delete('/clear', [CartController::class, 'clear'])
        ->name('clear');
});

// ================= CHECKOUT =================
Route::middleware(['auth'])->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    // APPLY VOUCHER
    Route::post('/checkout/apply-voucher', [CheckoutController::class, 'applyVoucher'])
        ->name('checkout.apply-voucher');

    Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])
        ->name('checkout.success');

});

// ================= USER ORDERS =================
Route::middleware(['auth'])
    ->prefix('orders')
    ->name('orders.')
    ->group(function () {

    Route::get('/', [FrontendOrderController::class, 'index'])
        ->name('index');

    Route::get('/{orderNumber}', [FrontendOrderController::class, 'show'])
        ->name('show');
});

// ================= AUTH =================
Auth::routes();

// ================= TEST WHATSAPP =================
Route::get('/test-wa', function () {

    $response = Http::withHeaders([
        'Authorization' => env('FONNTE_TOKEN'),
    ])->post('https://api.fonnte.com/send', [
        'target' => '083138756049',
        'message' => 'WhatsApp otomatis dari website Kiana Furniture berhasil!',
        'countryCode' => '62',
    ]);

    return $response->body();
});

// ================= TEST EMAIL =================
Route::get('/test-email', function () {

    Mail::raw('Test email dari Kiana Furniture berhasil dikirim.', function ($message) {

        $message->to('rriba270@gmail.com')
                ->subject('Test Email Kiana Furniture');
    });

    return 'Email berhasil dikirim';
});

// ================= REDIRECT HOME =================
Route::redirect('/home', '/');