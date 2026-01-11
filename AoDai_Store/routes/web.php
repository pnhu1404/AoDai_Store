<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;
use Illuminate\Support\Facades\Route;

Route::get('/',[ProductController::class,'index'])->name('home');
Route::get('/aodai/{id}',[ProductController::class,'detail'])->name('product.detail');
Route::post('/cart/add/{id}',[CartController::class,'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}',[CartController::class,'removeFromCart'])->name('cart.remove');
Route::get('/cart',[CartController::class,'viewCart'])->name('cart.index');

// Quản lý áo dài (sản phẩm)
Route::get('/admin', [AdminProductController::class, 'index'])->name('admin.home');
Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/edit/{MaSanPham}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/update/{MaSanPham}', [AdminProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/delete/{MaSanPham}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
