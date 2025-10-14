<?php
use App\Http\Controllers\Login\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Amenties\PhongTienNghiController;
use App\Http\Controllers\Amenties\TienNghiController;
use App\Http\Controllers\Room\PhongController;
use App\Http\Controllers\Room\LoaiPhongController;
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

// API cho PhongController
Route::get('/phongs', [PhongController::class, 'index1']);
Route::apiResource('phongs', PhongController::class)->except(['index']);

Route::apiResource('tien-nghi', TienNghiController::class);
Route::apiResource('loai-phong', LoaiPhongController::class)->only(['index']);

// Wrapper GET /phong
Route::get('/phong', function (Request $request, PhongController $controller) {
    try {
        return $controller->index($request);
    } catch (\Throwable $e) {
        Log::error('GET /api/phong failed', [
            'with' => $request->query('with'),
            'error' => $e->getMessage(),
        ]);
        return response()->json([
            'message' => 'Query failed. Check the with parameter and relationships.',
            'error' => $e->getMessage(),
        ], 400);
    }
});

// Quan hệ phòng - tiện nghi
Route::get('phong/{phong}/tien-nghi', [PhongTienNghiController::class, 'show']);
Route::put('phong/{phong}/tien-nghi', [PhongTienNghiController::class, 'update']);

use App\Http\Controllers\Services\TTDichVuController;
use App\Http\Controllers\Services\DichVuController;

Route::resource('dichvu.chitiet', TTDichVuController::class)->except(['create', 'edit']);
Route::resource('dichvu', DichVuController::class)->except(['create', 'edit']);
