<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Order Service - Dashboard Integrasi Bajamas
|--------------------------------------------------------------------------
*/

// 1. TAMPILAN DASHBOARD (Halaman Utama)
Route::get('/', function () {
    try {
        // Mengambil data dari User Service (8001) dan Product Service (8005)
        $usersRes = Http::timeout(3)->get("http://127.0.0.1:8001/api/users");
        $prodsRes = Http::timeout(3)->get("http://127.0.0.1:8005/api/products");

        $users = $usersRes->successful() ? $usersRes->json() : [];
        $products = $prodsRes->successful() ? $prodsRes->json() : [];

        // Mengambil daftar order yang tersimpan di session (jika ada)
        $orders = session()->get('all_orders', []);

        return view('order', compact('users', 'products', 'orders'));
    } catch (\Exception $e) {
        return "Koneksi Gagal: Pastikan Port 8001 & 8005 sudah menyala! <br> Error: " . $e->getMessage();
    }
});

// 2. PROSES SIMULASI ORDER (Menambah Data Ke List)
Route::post('/order', function (Request $request) {
    // Ambil data detail dari masing-masing service
    $userRes = Http::get("http://127.0.0.1:8001/api/users/" . $request->userId);
    $prodRes = Http::get("http://127.0.0.1:8005/api/products/" . $request->productId);

    if ($userRes->successful() && $prodRes->successful()) {
        $userData = $userRes->json();
        $prodData = $prodRes->json();

        // Buat objek order baru
        $newOrder = [
            'order_id' => 'BJMS-' . strtoupper(Str::random(5)),
            'customer_name' => $userData['name'] ?? 'Unknown',
            'product_name' => $prodData['name'] ?? 'Unknown',
            'price' => $prodData['price'] ?? 0,
            'date' => now()->format('d M Y, H:i'),
            'status' => 'Integrated'
        ];

        // Simpan ke dalam Session agar list bertambah (tidak tertimpa)
        $allOrders = session()->get('all_orders', []);
        array_unshift($allOrders, $newOrder); // Menambah order baru ke urutan paling atas
        session()->put('all_orders', $allOrders);

        return redirect('/')->with('success', 'Pesanan berhasil ditambahkan!');
    }

    return redirect('/')->with('error', 'Gagal memproses pesanan.');
});

// 3. FITUR TAMBAHAN: RESET ORDER (Jika ingin menghapus semua list)
Route::get('/reset-orders', function () {
    session()->forget('all_orders');
    return redirect('/');
});