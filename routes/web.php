<?php

use App\Http\Controllers\AuthAdminController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return ['Laravel' => app()->version()];
// });
Route::get('/', function () {
    return view('index');
});

Route::get('/login', [AuthAdminController::class, 'showLogin'])->name('login');
// Route::post('/login', [AuthAdminController::class, 'login']);

Route::get('/register', [AuthAdminController::class, 'showRegister'])->name('register');
// Route::post('/register', [AuthAdminController::class, 'register']);

// Route::post('/logout', [AuthAdminController::class, 'logout'])->name('logout');
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/products/clothes', function () {
    return view('products.clothes');
});
Route::get('/products/wallets', function () {
    return view('products.wallets');
});
Route::get('/products/shoes', function () {
    return view('products.shoes');
});
Route::get('/products/bags', function () {
    return view('products.bags');
});
Route::get('/categories/category', function () {
    return view('categories.category');
});
Route::get('/app', function () {
    return view('layouts.app');
});
// Route::middleware(['auth:sanctum'])->get('/dashboard', function () {
//     return view('dashboard');
// });

// require __DIR__.'/auth.php';
