<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderedItemController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVarientController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\ClothController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('admin')->group((function () {
    // Clothes Routes
    Route::get('cloths', [ClothController::class, 'index']);
    Route::get('cloths/{cloth}', [ClothController::class, 'show']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('cloths', [ClothController::class, 'store']);
        Route::put('cloths/{cloth}', [ClothController::class, 'update']);
        Route::delete('cloths/{cloth}', [ClothController::class, 'destroy']);
    });
    // Categories Creation
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    });

    // Products Creation
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{product}', [ProductController::class, 'show']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('products', [ProductController::class, 'store']);
        Route::put('products/{product}', [ProductController::class, 'update']);
        Route::delete('products/{product}', [ProductController::class, 'destroy']);
    });
    // Product Varients Creation
    Route::get('productVarients', [ProductVarientController::class, 'index']);
    Route::get('productVarients/{productVarient}', [ProductVarientController::class, 'show']);
    Route::get('getByProductId/{productId}', [ProductVarientController::class, 'getByProductId']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('productVarients', [ProductVarientController::class, 'store']);
        Route::put('productVarients/{productVarient}', [ProductVarientController::class, 'update']);
        Route::delete('productVarients/{productVarient}', [ProductVarientController::class, 'destroy']);
    });
    // Inventory Routes
    Route::get('inventories', [InventoryController::class, 'index']);
    Route::get('inventories/{inventory}', [InventoryController::class, 'show']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('inventories', [InventoryController::class, 'store']);
        Route::put('inventories/{inventory}', [InventoryController::class, 'update']);
        Route::delete('inventories/{inventory}', [InventoryController::class, 'destroy']);
    });


}));
Route::prefix('customer')->group((function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('showCustomers', [CustomerController::class, 'index']);
        Route::delete('delete/{customer}', [CustomerController::class, 'destroy']);

        // Customer Address
        Route::get('userAddress', [UserAddressController::class, 'index']);
        Route::get('userAddress/{userAddress}', [UserAddressController::class, 'show']);

        // Protected routes
        Route::middleware('auth:sanctum')->group(function () {
                    Route::get('auth/userAddress', [UserAddressController::class, 'showDetailsToAuthUsers']);
            Route::post('userAddress', [UserAddressController::class, 'store']);
            Route::put('userAddress/{userAddress}', [UserAddressController::class, 'update']);
            Route::delete('userAddress/{userAddress}', [UserAddressController::class, 'destroy']);
        });
        // Order Item
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/{order}', [OrderController::class, 'show']);

        // Protected routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('orders', [OrderController::class, 'store']);
            Route::put('orders/{order}', [OrderController::class, 'update']);
            Route::delete('orders/{order}', [OrderController::class, 'destroy']);
        });
        // Order Item
        Route::get('orderedItems', [OrderedItemController::class, 'index']);
        Route::get('orderedItems/{orderedItem}', [OrderedItemController::class, 'show']);

        // Protected routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('orderedItems', [OrderedItemController::class, 'store']);
            Route::put('orderedItems/{orderedItem}', [OrderedItemController::class, 'update']);
            Route::delete('orderedItems/{orderedItem}', [OrderedItemController::class, 'destroy']);
        });
        // Cart Item
        Route::get('carts', [CartController::class, 'index']);
        Route::get('carts/{cart}', [CartController::class, 'show']);

        // Protected routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('carts', [CartController::class, 'store']);
            Route::put('carts/{cart}', [CartController::class, 'update']);
            Route::delete('carts/{cart}', [CartController::class, 'destroy']);
        });
        // Payments
        Route::get('payments', [PaymentController::class, 'index']);
        Route::get('payments/{payment}', [PaymentController::class, 'show']);

        // Protected routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('payments', [PaymentController::class, 'store']);
            Route::put('payments/{payment}', [PaymentController::class, 'update']);
            Route::delete('payments/{payment}', [PaymentController::class, 'destroy']);
        });

        // Reviews
        Route::get('reviews', [ReviewController::class, 'index']);
        Route::get('reviews/{review}', [ReviewController::class, 'show']);

        // Protected routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('reviews', [ReviewController::class, 'store']);
            Route::put('reviews/{review}', [ReviewController::class, 'update']);
            Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);
        });
    });
    // Customer Verify OTP
    Route::post('/send-otp', [OTPController::class, 'sendOtp']);
    Route::post('/verify-otp', [OTPController::class, 'verifyOtp']);
}));

Route::prefix('customer')->group((function () {
    Route::post('/registers', [AuthController::class, 'registers']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware(['auth:sanctum', 'token.expiry']);
}));

Route::prefix('admin')->group((function () {
    Route::post('/registers', [UserAuthController::class, 'registers']);
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout'])
        ->middleware(['auth:sanctum', 'token.expiry']);
}));

// Route::prefix('admin')->group((function () {
//     // Route::post('/registers', [UserAuthController::class, 'registers']);
//     Route::post('/login', [UserAuthController::class, 'login']);
//     // Route::post('/logout', [UserAuthController::class, 'logout'])
//         // ->middleware(['auth:sanctum', 'token.expiry']);
// }));