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
Route::name('student.')->middleware([])->group(function () {
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

    Route::get('/news', [AdminController::class, 'news'])->name('news');
    Route::get('/news-create', [AdminController::class, 'createNews'])->name('create-news');
    Route::post('/news-create', [AdminController::class, 'storeNews'])->name('store-news');
    Route::get('/news/{news}', [AdminController::class, 'detailNews'])->name('detail-news');
    Route::put('/news/{news}', [AdminController::class, 'updateNews'])->name('update-news');
    Route::delete('/news/{news}', [AdminController::class, 'deleteNews'])->name('delete-news');

    Route::get('/media', [AdminController::class, 'media'])->name('media');
    Route::get('/media-create', [AdminController::class, 'createMedia'])->name('create-media');
    Route::post('/media-create', [AdminController::class, 'storeMedia'])->name('store-media');
    Route::get('/media/{media}', [AdminController::class, 'detailMedia'])->name('detail-media');
    Route::put('/media/{media}', [AdminController::class, 'updateMedia'])->name('update-media');
    Route::delete('/media/{media}', [AdminController::class, 'deleteMedia'])->name('delete-media');

    Route::get('/achievement', [AdminController::class, 'achievement'])->name('achievement');
    Route::get('/achievement-create', [AdminController::class, 'createAchievement'])->name('create-achievement');
    Route::post('/achievement-create', [AdminController::class, 'storeAchievement'])->name('store-achievement');
    Route::get('/achievement/{achievement}', [AdminController::class, 'detailAchievement'])->name('detail-achievement');
    Route::put('/achievement/{achievement}', [AdminController::class, 'updateAchievement'])->name('update-achievement');
    Route::delete('/achievement/{achievement}', [AdminController::class, 'deleteAchievement'])->name('delete-achievement');

    Route::get('/portfolio', [AdminController::class, 'portfolio'])->name('portfolio');
    Route::get('/portfolio-create', [AdminController::class, 'createPortfolio'])->name('create-portfolio');
    Route::post('/portfolio-create', [AdminController::class, 'storePortfolio'])->name('store-portfolio');
    Route::get('/portfolio/{portfolio}', [AdminController::class, 'detailPortfolio'])->name('detail-portfolio');
    Route::put('/portfolio/{portfolio}', [AdminController::class, 'updatePortfolio'])->name('update-portfolio');
    Route::delete('/portfolio/{portfolio}', [AdminController::class, 'deletePortfolio'])->name('delete-portfolio');

    Route::get('/facility', [AdminController::class, 'facility'])->name('facility');
    Route::get('/facility-create', [AdminController::class, 'createFacility'])->name('create-facility');
    Route::post('/facility-create', [AdminController::class, 'storeFacility'])->name('store-facility');
    Route::get('/facility/{facility}', [AdminController::class, 'detailFacility'])->name('detail-facility');
    Route::put('/facility/{facility}', [AdminController::class, 'updateFacility'])->name('update-facility');
    Route::delete('/facility/{facility}', [AdminController::class, 'deleteFacility'])->name('delete-facility');

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('update-settings');
});


Route::name('midtrans.')->prefix('midtrans')->middleware([isLogin::class])->group(function () {
    // URL ==> http://127.0.0.1:8000/midtrans/payment-notification
    Route::post('/payment-notification', [MidtransController::class, 'paymentNotification'])->name('payment-notification');
});

