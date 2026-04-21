<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoopShopController;
use App\Http\Controllers\ShopCartController;
use App\Http\Controllers\ShopOrderController;

Route::get('/', [CoopShopController::class, 'index'])->name('coop-shop.home');
Route::get('/danh-muc/{id}', [CoopShopController::class, 'category'])->name('coop-shop.category');

/*
|--------------------------------------------------------------------------
| Cart / Order
|--------------------------------------------------------------------------
*/

Route::get('/gio-hang', [ShopCartController::class, 'index'])->name('coop-shop.cart');
Route::post('/gio-hang/xoa', [ShopCartController::class, 'remove'])->name('coop-shop.cart.remove');

Route::middleware('auth')->group(function () {
    Route::post('/dat-hang', [ShopOrderController::class, 'store'])->name('coop-shop.order.store');
});

/*
|--------------------------------------------------------------------------
| Laravel Auth
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';