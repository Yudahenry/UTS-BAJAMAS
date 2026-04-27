<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - User Service
|--------------------------------------------------------------------------
*/

Route::get('/users', function () {
    return response()->json([
        ["id" => 1, "name" => "Yuda"],
        ["id" => 2, "name" => "Budi"],
        ["id" => 3, "name" => "Siti"]
    ]);
});

Route::get('/users/{id}', function ($id) {
    $users = [
        ["id" => 1, "name" => "Yuda"],
        ["id" => 2, "name" => "Budi"],
        ["id" => 3, "name" => "Siti"]
    ];

    $user = collect($users)->firstWhere('id', (int)$id);

    if (!$user) {
        return response()->json([
            "message" => "User tidak ditemukan"
        ], 404);
    }

    return response()->json($user);
});