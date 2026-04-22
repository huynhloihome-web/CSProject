<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoopShopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopManageProductController;
use App\Http\Controllers\ShopSearchController;
use App\Http\Controllers\OrderStatusController;


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

Route::middleware(['auth', 'admin'])->prefix('quan-ly-san-pham')->group(function () {
    Route::get('/', [ShopManageProductController::class, 'index'])->name('coop-shop.manage.products.index');
    Route::get('/them-moi', [ShopManageProductController::class, 'create'])->name('coop-shop.manage.products.create');
    Route::post('/them-moi', [ShopManageProductController::class, 'store'])->name('coop-shop.manage.products.store');
    Route::post('/{id}/cap-nhat-ton-kho', [ShopManageProductController::class, 'updateStock'])->name('coop-shop.manage.products.update-stock');
    Route::get('/{id}', [ShopManageProductController::class, 'show'])->name('coop-shop.manage.products.show');
    Route::post('/{id}/xoa', [ShopManageProductController::class, 'destroy'])->name('coop-shop.manage.products.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/order-status', [OrderStatusController::class, 'index'])->name('order.status');
    Route::get('/order-status/{id}', [OrderStatusController::class, 'show'])->name('order.detail');
    Route::post('/order-status/{id}/received', [OrderStatusController::class, 'received'])->name('order.received');
    Route::post('/order-status/{id}/return', [OrderStatusController::class, 'submitReturn'])->name('order.return');});

use App\Http\Controllers\AdminOrderController;
Route::middleware(['auth','admin'])->group(function () {

    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');

    // XEM CHI TIẾT
    Route::get('/admin/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');

    // XỬ LÝ
    Route::post('/admin/orders/{id}/approve', [AdminOrderController::class, 'approve'])->name('admin.orders.approve');
    Route::post('/admin/orders/{id}/reject', [AdminOrderController::class, 'reject'])->name('admin.orders.reject');
    Route::post('/admin/orders/{id}/need-info', [AdminOrderController::class, 'needInfo'])->name('admin.orders.needInfo');

});
require __DIR__ . '/auth.php';
