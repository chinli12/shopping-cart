<?php

use App\Http\Controllers\Api\OrderController;
use App\Models\Product;

Route::prefix('v1')->group(function () {
    // Product routes
    Route::get('/products', function () {
        return response()->json([
            'success' => true,
            'data' => Product::all()
        ]);
    });

    // Order routes with full CRUD
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
});

// Health check endpoint
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'timestamp' => now()], 200);
});