<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVarientController;
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