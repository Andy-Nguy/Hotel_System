<?php
use App\Http\Controllers\Login\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Amenties\TienNghiController;
use App\Http\Controllers\Amenties\PhongController;
use App\Http\Controllers\Amenties\LoaiPhongController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('session')->get('/auth/check-role', [AuthController::class, 'checkRole']);


// CRUD Tiện nghi
Route::get('/tien-nghi', [TienNghiController::class, 'index']);
Route::post('/tien-nghi', [TienNghiController::class, 'store']);
Route::put('/tien-nghi/{tienNghi}', [TienNghiController::class, 'update']);
Route::delete('/tien-nghi/{tienNghi}', [TienNghiController::class, 'destroy']);

// Loại phòng (dropdown cho CRUD phòng)
Route::get('/loai-phong', [LoaiPhongController::class, 'index']);

// Phòng + gán tiện nghi
Route::get('/phong', [PhongController::class, 'index']); // ?with=tiennghi để lấy kèm tiện nghi
Route::post('/phong', [PhongController::class, 'store']);
Route::put('/phong/{phong}', [PhongController::class, 'update']);
Route::delete('/phong/{phong}', [PhongController::class, 'destroy']);

Route::get('/phong/{phong}/tien-nghi', [PhongController::class, 'tienNghiIds']);
Route::put('/phong/{phong}/tien-nghi', [PhongController::class, 'syncTienNghi']);



Route::get('/phongs', [PhongController::class, 'index1']);
Route::apiResource('phongs', PhongController::class)->except(['index']);
Route::get('/loaiphongs', [LoaiPhongController::class, 'index1']);
Route::apiResource('loaiphongs', LoaiPhongController::class)->except(['index']);
Route::get('phongs/loai/{maLoai}', [PhongController::class, 'searchByLoai']);
// Explicit route: use index1 for listing phongs
