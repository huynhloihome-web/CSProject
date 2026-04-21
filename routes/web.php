<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoopShopController;
use App\Http\Controllers\ShopSearchController;

Route::get('/tim-kiem', [ShopSearchController::class, 'index'])->name('coop-shop.search');
use App\Http\Controllers\ShopCartController;
use App\Http\Controllers\ShopOrderController;
use App\Http\Controllers\ShopProductDetailController;
use App\Http\Controllers\ShopCartItemController;

Route::get('/san-pham/{id}', [ShopProductDetailController::class, 'show'])->name('coop-shop.detail');
Route::post('/gio-hang/them', [ShopCartItemController::class, 'store'])->name('coop-shop.cart.add');

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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';