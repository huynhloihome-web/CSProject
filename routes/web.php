<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoopShopController;
use App\Http\Controllers\ShopProductDetailController;
use App\Http\Controllers\ShopCartItemController;

Route::get('/san-pham/{id}', [ShopProductDetailController::class, 'show'])->name('coop-shop.detail');
Route::post('/gio-hang/them', [ShopCartItemController::class, 'store'])->name('coop-shop.cart.add');

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

require __DIR__.'/auth.php';