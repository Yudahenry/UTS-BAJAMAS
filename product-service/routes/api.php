<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Product Service
|--------------------------------------------------------------------------
*/

// TARUH DI SINI
Route::get('/products', function () {
    $products = [
        ["id" => 1, "name" => "Kemasan Kertas", "price" => 5000],
        ["id" => 2, "name" => "Kemasan Daun", "price" => 3000],
        ["id" => 3, "name" => "Kemasan Bambu", "price" => 7000]
    ];
    
    return response()->json($products);
});

// Tambahkan juga rute untuk mengambil SATU produk berdasarkan ID (untuk proses checkout)
Route::get('/products/{id}', function ($id) {
    $products = [
        ["id" => 1, "name" => "Kemasan Kertas", "price" => 5000],
        ["id" => 2, "name" => "Kemasan Daun", "price" => 3000],
        ["id" => 3, "name" => "Kemasan Bambu", "price" => 7000]
    ];

    $product = collect($products)->firstWhere('id', (int)$id);

    return $product 
        ? response()->json($product) 
        : response()->json(["message" => "Produk tidak ditemukan"], 404);
});