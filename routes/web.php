<?php

use App\Http\Controllers\AuthAdminController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return ['Laravel' => app()->version()];
// });
Route::get('/', function () {
    return view('index');
});

// Route::get('/login', [AuthAdminController::class, 'showLogin'])->name('login');
// Route::post('/login', [AuthAdminController::class, 'login']);

// Route::get('/register', [AuthAdminController::class, 'showRegister'])->name('register');
// Route::post('/register', [AuthAdminController::class, 'register']);
Route::get('/auth/login', function () {
    return view('login');
});
Route::get('/auth/register', function () {
    return view('register');
});
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
Route::get('/products/product', function () {
    return view('products.product');
});
Route::get('/products/varient', function () {
    return view('varient.varient');
});
Route::get('/categories/category', function () {
    return view('categories.category');
});
Route::get('/inventory/inventories', function () {
    return view('inventory.inventories');
});
Route::get('/auth', function () {
    return view('layouts.auth');
});

Route::get('/app', function () {
    return view('layouts.app');
});

// User Routes 
Route::get('/', function () {
    return view('dashboard.products');
});
Route::get('/variants/{id}', function ($id) {
    return view('dashboard.variants');
});
Route::get('/userdash', function () {
    return view('layouts.userdash');
});
Route::get('/authuser', function () {
    return view('layouts.authuser');
});

Route::get('/authuser/login', function () {
    return view('users.login');
});
Route::get('/authuser/register', function () {
    return view('users.register');
});
// Route::middleware(['auth:sanctum'])->get('/dashboard', function () {
//     return view('dashboard');
// });

// require __DIR__.'/auth.php';
