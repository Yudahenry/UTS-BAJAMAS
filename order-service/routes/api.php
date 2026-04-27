<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes - Order Service
|--------------------------------------------------------------------------
*/

// Simpan order sementara (in-memory)
$orders = [];

/*
|--------------------------------------------------------------------------
| CREATE ORDER
|--------------------------------------------------------------------------
*/
Route::post('/orders', function (Request $request) use (&$orders) {

    $userId = $request->input('userId');
    $productId = $request->input('productId');

    try {
        // Ambil data user dari UserService
        $userResponse = Http::get("http://localhost:8001/api/users/$userId");

        if ($userResponse->failed()) {
            return response()->json([
                "message" => "User tidak ditemukan di UserService"
            ], 404);
        }

        $user = $userResponse->json();

        // Ambil data produk dari ProductService
        $productResponse = Http::get("http://localhost:8005/api/products/$productId");

        if ($productResponse->failed()) {
            return response()->json([
                "message" => "Product tidak ditemukan di ProductService"
            ], 404);
        }

        $product = $productResponse->json();

        // Buat order
        $order = [
            "id" => count($orders) + 1,
            "user" => $user,
            "product" => $product,
            "created_at" => now()
        ];

        // Simpan order
        $orders[] = $order;

        return response()->json([
            "message" => "Order berhasil dibuat",
            "order" => $order
        ]);

    } catch (\Exception $e) {
        return response()->json([
            "message" => "Gagal komunikasi antar service",
            "error" => $e->getMessage()
        ], 500);
    }
});

/*
|--------------------------------------------------------------------------
| GET ALL ORDERS
|--------------------------------------------------------------------------
*/
Route::get('/orders', function () use (&$orders) {
    return response()->json($orders);
});