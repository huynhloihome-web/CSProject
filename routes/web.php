<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoopShopController;
use App\Http\Controllers\ShopManageProductController;

Route::get('/', [CoopShopController::class, 'index'])->name('coop-shop.home');
Route::get('/danh-muc/{id}', [CoopShopController::class, 'category'])->name('coop-shop.category');

Route::get('/dang-nhap', [CoopShopController::class, 'login'])->name('coop-shop.login');
Route::get('/gio-hang', [CoopShopController::class, 'cart'])->name('coop-shop.cart');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('quan-ly-san-pham')->group(function () {
    Route::get('/', [ShopManageProductController::class, 'index'])->name('coop-shop.manage.products.index');
    Route::get('/{id}', [ShopManageProductController::class, 'show'])->name('coop-shop.manage.products.show');
    Route::post('/{id}/xoa', [ShopManageProductController::class, 'destroy'])->name('coop-shop.manage.products.destroy');
});

require __DIR__ . '/auth.php';
