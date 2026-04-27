<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// HALAMAN ORDER
Route::get('/', function () {

    try {
        $usersRes = Http::timeout(3)->get("http://127.0.0.1:8001/api/users");
        $users = $usersRes->successful() ? $usersRes->json() : [];
    } catch (\Exception $e) {
        $users = [];
    }

    try {
        $prodsRes = Http::timeout(3)->get("http://127.0.0.1:8005/api/products");
        $products = $prodsRes->successful() ? $prodsRes->json() : [];
    } catch (\Exception $e) {
        $products = [];
    }

    return view('order', compact('users', 'products'));
});

// HALAMAN HISTORY
Route::get('/history', function () {
    $orders = session()->get('all_orders', []);
    return view('history', compact('orders'));
});

// BUAT ORDER
Route::post('/order', function (Request $request) {

    try {
        $userRes = Http::get("http://127.0.0.1:8001/api/users/" . $request->userId);
        $prodRes = Http::get("http://127.0.0.1:8005/api/products/" . $request->productId);
    } catch (\Exception $e) {
        return redirect('/')->with('error', 'Service tidak tersedia');
    }

    if ($userRes->successful() && $prodRes->successful()) {

        $newOrder = [
            'order_id' => 'BJMS-' . strtoupper(Str::random(5)),
            'customer_name' => $userRes->json()['name'] ?? 'Unknown',
            'product_name' => $prodRes->json()['name'] ?? 'Unknown',
            'price' => $prodRes->json()['price'] ?? 0,
            'date' => now()->format('d M Y, H:i'),
        ];

        $allOrders = session()->get('all_orders', []);
        array_unshift($allOrders, $newOrder);
        session()->put('all_orders', $allOrders);

        return redirect('/history')->with('success', 'Order berhasil dibuat!');
    }

    return redirect('/')->with('error', 'Gagal membuat order');
});