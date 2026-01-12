<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/',[ProductController::class,'index'])->name('home');
Route::get('/aodai/{id}',[ProductController::class,'detail'])->name('product.detail');
Route::post('/cart/add/{id}',[CartController::class,'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}',[CartController::class,'removeFromCart'])->name('cart.remove');
Route::get('/cart',[CartController::class,'viewCart'])->name('cart.index');
Route::post('/update-quantity', [CartController::class, 'updateQuantity'])->name('update.quantity');
// Quản lý áo dài (sản phẩm)
Route::get('/admin', [AdminProductController::class, 'index'])->name('admin.home');
Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/edit/{MaSanPham}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/update/{MaSanPham}', [AdminProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/delete/{MaSanPham}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');


//check out 
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.home');

Route::get('/admin', [AdminCategoryController::class, 'index'])->name('admin.home');
Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
Route::post('/admin/categories/store', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
Route::get('/admin/categories/edit/{MaSanPham}', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('/admin/categories/update/{MaSanPham}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/categories/delete/{MaSanPham}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

//promotion
Route::resource('/admin/promotions', App\Http\Controllers\Adminpromotion::class)->names('promotions');
//order
Route::resource('/admin/orders', App\Http\Controllers\AdminOrder::class)->names('orders');