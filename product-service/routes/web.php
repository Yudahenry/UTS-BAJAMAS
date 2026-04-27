<?php

use Illuminate\Support\Facades\Route;

// Kita satukan semua rute ke satu jalur untuk tes
Route::get('/', function () {
    return "Product Service Aktif";
});

Route::get('/api/products', function () {
    return response()->json([
        ["id" => 1, "name" => "Kemasan Kertas Organik", "price" => 5000],
        ["id" => 2, "name" => "Kemasan Daun Pisang", "price" => 3000]
    ]);
});

// Paksa Laravel menangkap apapun yang salah
Route::fallback(function () {
    return "Rute tidak ditemukan! Coba ketik php artisan route:clear di terminal.";
});