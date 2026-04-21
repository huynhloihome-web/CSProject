<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoopShopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopManageProductController;
use App\Http\Controllers\ShopSearchController;

Route::get('/tim-kiem', [ShopSearchController::class, 'index'])->name('coop-shop.search');
use App\Http\Controllers\ShopCartController;
use App\Http\Controllers\ShopOrderController;
use App\Http\Controllers\ShopProductDetailController;
use App\Http\Controllers\ShopCartItemController;
use App\Http\Controllers\DonHangController;

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

Route::middleware(['auth', 'admin'])->prefix('quan-ly-san-pham')->group(function () {
    Route::get('/', [ShopManageProductController::class, 'index'])->name('coop-shop.manage.products.index');
    Route::get('/them-moi', [ShopManageProductController::class, 'create'])->name('coop-shop.manage.products.create');
    Route::post('/them-moi', [ShopManageProductController::class, 'store'])->name('coop-shop.manage.products.store');
    Route::post('/{id}/cap-nhat-ton-kho', [ShopManageProductController::class, 'updateStock'])->name('coop-shop.manage.products.update-stock');
    Route::get('/{id}', [ShopManageProductController::class, 'show'])->name('coop-shop.manage.products.show');
    Route::post('/{id}/xoa', [ShopManageProductController::class, 'destroy'])->name('coop-shop.manage.products.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/don-hang', [DonHangController::class, 'index'])->name('donhang.index');
    Route::post('/don-hang/{id}/received', [DonHangController::class, 'markAsReceived'])->name('donhang.received');
});

require __DIR__ . '/auth.php';
