<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MidtransController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isLogin;
use App\Http\Middleware\isAdmin;

Route::get('/login', [UserController::class, 'loginPage'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login-action');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::put('/profile', [UserController::class, 'updateProfile'])->name('updateProfile');

// isLogin & is Siswa
Route::name('student.')->middleware([isLogin::class])->group(function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/about', [UserController::class, 'about'])->name('about');
    Route::get('/products', [UserController::class, 'products'])->name('products');

    Route::get('/products/{product}', [UserController::class, 'detailProduct'])->name('detail-product');

    Route::get('/cart', [UserController::class, 'cart'])->name('cart');
    Route::post('/cart', [UserController::class, 'storeCart'])->name('store-cart');
    Route::put('/cart/{cart}', [UserController::class, 'updateCart'])->name('update-cart');
    Route::delete('/cart/{cart}', [UserController::class, 'deleteCart'])->name('delete-cart');
    Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/success', [UserController::class, 'checkoutSuccess'])->name('checkout-success');

    Route::get('/transactions', [UserController::class, 'transactions'])->name('transactions');
    Route::get('/transactions/{transaction}', [UserController::class, 'detailTransaction'])->name('detail-transaction');
    Route::post('/transactions', [UserController::class, 'storeTransaction'])->name('store-transaction');
});


// admin
Route::name('admin.')->prefix('admin')->middleware([isLogin::class, isAdmin::class])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/{product}', [AdminController::class, 'detailProduct'])->name('detail-product');
    Route::get('/products-add', [AdminController::class, 'storeProductPage'])->name('add-product');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('store-product');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('update-product');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('delete-product');

    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
    Route::get('/transactions/{transaction}', [AdminController::class, 'detailTransaction'])->name('detail-transaction');
    Route::get('/transactions-add', [AdminController::class, 'storeTransactionPage'])->name('add-transaction');
    Route::post('/transactions', [AdminController::class, 'storeTransaction'])->name('store-transaction');
    Route::put('/transactions/{transaction}', [AdminController::class, 'updateTransaction'])->name('update-transaction');
    Route::delete('/transactions/{transaction}', [AdminController::class, 'deleteTransaction'])->name('delete-transaction');

    Route::get('/accounts', [AdminController::class, 'accounts'])->name('accounts');
    Route::get('/accounts-create', [AdminController::class, 'createAccount'])->name('create-account');
    Route::post('/accounts-create', [AdminController::class, 'storeAccount'])->name('store-account');
    Route::get('/accounts/{account}', [AdminController::class, 'detailAccount'])->name('detail-account');
    Route::put('/accounts/{account}', [AdminController::class, 'updateAccount'])->name('update-account');
    Route::delete('/accounts/{account}', [AdminController::class, 'deleteAccount'])->name('delete-account');

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('update-settings');
});


Route::name('midtrans.')->prefix('midtrans')->middleware([isLogin::class])->group(function () {
    // URL ==> http://127.0.0.1:8000/midtrans/payment-notification
    Route::post('/payment-notification', [MidtransController::class, 'paymentNotification'])->name('payment-notification');
});

