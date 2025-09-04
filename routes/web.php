<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class,'dashboard'])->name('dashboard');

Route::get('/login', [UserController::class, 'loginPage'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/products', function(){
    return view('products');
});

Route::get('/products/{transaction}', function(){
    return view('detailProduct');
});

Route::get('/cart', function(){
    return view('cart');
});


Route::get('/transaction', function(){
    return view('transaction');
});

Route::get('/transaction/{transaction}', function(){
    return view('detailTransaction');
});


// admin

Route::get('/admin/dashboard', [UserController::class,'dashboardAdmin'])->name('dashboard.admin');

