<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isLogin;
use App\Http\Middleware\isAdmin;

Route::get('/login', [UserController::class, 'loginPage'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// isLogin & is Siswa
Route::name('student.')->middleware([isLogin::class])->group(function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [UserController::class, 'products'])->name('products');

    Route::get('/products/{product}', [UserController::class, 'detailProduct'])->name('detail-product');

    Route::get('/cart', [UserController::class, 'cart'])->name('cart');
    Route::put('/cart/{cart}', [UserController::class, 'updateCart'])->name('update-cart');
    Route::delete('/cart/{cart}', [UserController::class, 'deleteCart'])->name('delete-cart');

    Route::get('/transctions', [UserController::class, 'transactions'])->name('transactions');
    Route::post('/transctions', [UserController::class, 'storeTransaction'])->name('store-transaction');
    Route::get('/transctions/{transaction}', [UserController::class, 'detailTransaction'])->name('detail-transaction');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile/{profile}', [UserController::class, 'profile'])->name('profile');
});


// admin
Route::name('admin.')->prefix('admin')->middleware([isLogin::class, isAdmin::class])->group(function () {
    Route::get('/dashboard', [ AdminController::class, 'dashboard' ])->name('dashboard');

    Route::get('/products', [ AdminController::class, 'products' ])->name('products');
    Route::get('/products/{product}', [ AdminController::class, 'detailProduct' ])->name('detail-product');
    Route::post('/products', [ AdminController::class, 'storeProduct' ])->name('store-product');
    Route::put('/products/{product}', [ AdminController::class, 'updateProduct' ])->name('update-product');
    Route::delete('/products/{product}', [ AdminController::class, 'deleteProduct' ])->name('delete-product');

    Route::get('/transactions', [ AdminController::class, 'transactions' ])->name('transactions');
    Route::get('/transactions/{transaction}', [ AdminController::class, 'detailTransaction' ])->name('detail-transaction');
    Route::post('/transactions', [ AdminController::class, 'storeTransaction' ])->name('store-transaction');
    Route::put('/transactions/{transaction}', [ AdminController::class, 'updateTransaction' ])->name('update-transaction');
    Route::delete('/transactions/{transaction}', [ AdminController::class, 'deleteTransaction' ])->name('delete-transaction');

    Route::get('/accounts', [ AdminController::class, 'accounts' ])->name('accounts');
    Route::get('/accounts/{account}', [ AdminController::class, 'detailAccount' ])->name('detail-account');
    Route::post('/accounts', [ AdminController::class, 'storeAccount' ])->name('store-account');
    Route::put('/accounts/{account}', [ AdminController::class, 'updateAccount' ])->name('update-account');
    Route::delete('/accounts/{account}', [ AdminController::class, 'deleteAccount' ])->name('delete-account');

    Route::get('/profile', [ AdminController::class, 'profile' ])->name('profile');
    Route::put('/profile/{profile}', [ AdminController::class, 'updateProfile' ])->name('update-profile');
});


