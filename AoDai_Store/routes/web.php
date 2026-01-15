<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminSupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
//login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/admin', function () {
    return view('admin.home'); // Blade admin
})->middleware(['auth']);
Route::get('/', function () {
 return view('client.home'); // Blade user
})->middleware('auth');
//register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/',[ProductController::class,'index'])->name('home');
Route::get('/aodai/{id}',[ProductController::class,'detail'])->name('product.detail');
Route::post('/cart/add/{id}',[CartController::class,'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}',[CartController::class,'removeFromCart'])->name('cart.remove');
Route::delete('/cart/clear',[CartController::class,'clearCart'])->name('cart.clear');
Route::get('/cart',[CartController::class,'viewCart'])->name('cart.index');
Route::post('/update-quantity', [CartController::class, 'updateQuantity'])->name('update.quantity');
Route::get('/category/{id}', [ProductController::class, 'showByCategory'])->name('category.show');
Route::get('/products/category', [ProductController::class, 'category']) ->name('products.category');
// Quản lý áo dài (sản phẩm)
Route::get('/admin', [AdminProductController::class, 'index'])->name('admin.home');
Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/edit/{MaSanPham}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/update/{MaSanPham}', [AdminProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/delete/{MaSanPham}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
Route::post('/admin/products/toggle-status/{id}', [AdminProductController::class, 'toggleStatus'])->name('admin.products.toggleStatus');


//check out 
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.home')->middleware('auth');

Route::get('/admin', [AdminCategoryController::class, 'index'])->name('admin.home');
Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
Route::post('/admin/categories/store', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
Route::get('/admin/categories/edit/{MaSanPham}', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('/admin/categories/update/{MaSanPham}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/categories/delete/{MaSanPham}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
Route::post('/admin/categories/toggle-status/{id}', [AdminCategoryController::class, 'toggleStatus'])->name('admin.categories.toggleStatus');


//promotion
Route::resource('/admin/promotions', App\Http\Controllers\Adminpromotion::class)->names('promotions');
//order
Route::resource('/admin/orders', App\Http\Controllers\AdminOrder::class)->names('orders');

Route::resource(('/order'), App\Http\Controllers\OrderController::class)->names('order');

//suppliers
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('suppliers', AdminSupplierController::class);

});

//promotion
