<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// Hiển thị danh sách người dùng

Route::group(['prefix' => 'admin'], function () {
    Route::get('/users', [UserController::class, 'index']);           // Lấy danh sách người dùng
    Route::post('/users', [UserController::class, 'store']);          // Thêm người dùng mới
    Route::get('/users/{id}', [UserController::class, 'show']);       // Lấy thông tin chi tiết người dùng
    Route::post('/users/{id}', [UserController::class, 'update']);     // Cập nhật thông tin người dùng
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Xóa người dùng
});
