<?php

use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminSupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminMaterialController;
use App\Http\Controllers\AdminColorController;
use App\Http\Controllers\AdminContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminInfoWebController;
//login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware(['auth']);
Route::post('/admin/dashboard', [AdminInfoWebController::class, 'update'])->name('admin.dashboard.update');
//register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
//material
Route::get('/admin/materials', [AdminMaterialController::class, 'index'])->name('admin.materials.index');
Route::get('/admin/materials/create', [AdminMaterialController::class, 'create'])->name('admin.materials.create');
Route::post('/admin/materials/store', [AdminMaterialController::class, 'store'])->name('admin.materials.store');
Route::get('/admin/materials/edit/{MaChatLieu}', [AdminMaterialController::class, 'edit'])->name('admin.materials.edit');
Route::put('/admin/materials/update/{MaChatLieu}', [AdminMaterialController::class, 'update'])->name('admin.materials.update');
Route::delete('/admin/materials/delete/{MaChatLieu}', [AdminMaterialController::class, 'destroy'])->name('admin.materials.destroy');
//color
Route::get('/admin/colors', [AdminColorController::class, 'index'])->name('admin.colors.index');
Route::get('/admin/colors/create', [AdminColorController::class, 'create'])->name('admin.colors.create');
Route::post('/admin/colors/store', [AdminColorController::class, 'store'])->name('admin.colors.store');
Route::get('/admin/colors/edit/{MaLoaiMau}', [AdminColorController::class, 'edit'])->name('admin.colors.edit');
Route::put('/admin/colors/update/{MaLoaiMau}', [AdminColorController::class, 'update'])->name('admin.colors.update');
Route::delete('/admin/colors/delete/{MaLoaiMau}', [AdminColorController::class, 'destroy'])->name('admin.colors.destroy');
//account
Route::get('/admin/accounts', [AdminAccountController::class, 'index'])->name('admin.accounts.index');
Route::get('/admin/accounts/edit/{MaTaiKhoan}', [AdminAccountController::class, 'edit'])->name('admin.accounts.edit');
Route::post('/admin/accounts/update/{MaTaiKhoan}', [AdminAccountController::class, 'update'])->name('admin.accounts.update');
Route::post('/admin/accounts/lock/{MaTaiKhoan}', [AdminAccountController::class, 'lock'])->name('admin.accounts.lock');
//contact admin
Route::get('/admin/contacts', [AdminContactController::class, 'index'])->name('admin.contacts.index');
Route::get('/admin/contacts/{MaLienHe}/edit', [AdminContactController::class, 'edit'])->name('admin.contacts.edit');
Route::put('/admin/contacts/{MaLienHe}', [AdminContactController::class, 'update'])->name('admin.contacts.update');
Route::delete('/admin/contacts/{MaLienHe}', [AdminContactController::class, 'destroy'])->name('admin.contacts.destroy');
//product client
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'productList'])->name('products.index');
Route::get('/aodai/{id}',[ProductController::class,'detail'])->name('product.detail');
Route::post('/cart/add/{id}',[CartController::class,'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}',[CartController::class,'removeFromCart'])->name('cart.remove');
Route::delete('/cart/clear',[CartController::class,'clearCart'])->name('cart.clear');
Route::get('/cart',[CartController::class,'viewCart'])->name('cart.index');
Route::post('/update-quantity', [CartController::class, 'updateQuantity'])->name('update.quantity');
Route::get('/category/{id}', [ProductController::class, 'showByCategory'])->name('category.show');
Route::get('/products/category', [ProductController::class, 'category']) ->name('products.category');
// Quản lý áo dài (sản phẩm)
// Route::get('/admin', [AdminProductController::class, 'index'])->name('admin.home');
Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/edit/{MaSanPham}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/update/{MaSanPham}', [AdminProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/delete/{MaSanPham}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

//check out
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.home')->middleware('auth');

// Route::get('/admin', [AdminCategoryController::class, 'index'])->name('admin.home');
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

Route::resource(('/order'), App\Http\Controllers\OrderController::class)->names('order');

//suppliers
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('suppliers', AdminSupplierController::class);

});


//contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
//profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');