<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\Room\LoaiPhongController;
use App\Http\Controllers\Room\PhongController;
use App\Http\Controllers\Amenties\TienNghiController;
use App\Http\Controllers\Amenties\PhongTienNghiController; // fixed back to Amenties

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Trang chính
Route::get('/', function () {
    return view('welcome');
});

// --- CỤM ROUTE ĐĂNG KÝ ---
// Route GET để hiển thị form đăng ký
Route::get('/register', function () {
    return view('login_auth.register');
})->name('register.form');

// Route POST để xử lý việc gửi OTP
Route::post('/register', [AuthController::class, 'register'])->name('register.action');

// Route POST để xác thực OTP và tạo tài khoản
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.action');


// --- CỤM ROUTE ĐĂNG NHẬP ---
Route::get('/login', function () {
    return view('login_auth.login');
})->name('login.form');

// (Bạn có thể thêm route POST cho login ở đây sau)

require __DIR__.'/auth.php';

Route::get('/tiennghi', function () {
    return view('amenties.tiennghi2');
})->name('tiennghi2.index');

Route::get('/room', function () {
    return view('room.room');
})->name('room.index');
