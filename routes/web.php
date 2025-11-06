<?php

use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\EsewaController;
use Illuminate\Http\Request;
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
Route::get('/order', function () {
    return view('dashboard.order');
});
Route::get('/userdash', function () {
    return view('layouts.userdash');
});
Route::get('/authuser', function () {
    return view('layouts.authuser');
});
// User set
// Carts
Route::get('/mycarts', function () {
    return view('dashboard.my-carts');
});
//Profile
Route::get('/profile', function () {
    return view('dashboard.profile');
});
//My orders
Route::get('/my-orders', function () {
    return view('dashboard.my-orders');
});
// //My Payments
Route::get('/my-payments', function () {
    return view('dashboard.my-payments');
});

// Route::get('/proceed-to-payment', function () {
//     return view('layouts.payment');
// });
Route::get('/esewa/payment', function (Request $request) {
    return view('layouts.payment', [
        'order_id' => $request->query('order_id'),
        'amount' => $request->query('amount'),
        'tax_amount' => $request->query('tax_amount'),
        'total_amount' => $request->query('total_amount'),
        'transaction_uuid' => $request->query('transaction_uuid'),
        'product_code' => $request->query('product_code'),
        'success_url' => $request->query('success_url'),
        'failure_url' => $request->query('failure_url'),
        'signature' => $request->query('signature'),
    ]);
})->name('esewa.paymentPage');
Route::get('/proceed-to-payment', [EsewaController::class, 'initiate'])->name('esewa.initiate');
Route::get('/esewa/success', [EsewaController::class, 'verify'])->name('esewa.verify');
Route::get('/esewa/failure', [EsewaController::class, 'failure'])->name('esewa.failure');
// Route::get('/payment-success', function () {
//     return view('esewa.success');
// });

Route::get('/payment-failure', function () {
    return view('esewa.failure');
});

//My Reset Password
Route::get('/user/reset-password', function () {
    return view('dashboard.reset-password');
});
//My orders
Route::get('/settings', function () {
    return view('dashboard.settings');
});
// USer
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
