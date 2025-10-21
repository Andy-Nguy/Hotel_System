<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\Amenties\LoaiPhongController;
use App\Http\Controllers\Amenties\PhongController;
use App\Http\Controllers\Amenties\TienNghiController;
use App\Http\Controllers\Amenties\PhongTienNghiController; // fixed back to Amenties
use App\Http\Controllers\Booking\DatPhongTrucTiepController;
use App\Http\Controllers\User\KhachHangController;
use App\Http\Controllers\Booking\DatPhongController;
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

use App\Http\Controllers\Services\DichVuController;
use App\Http\Controllers\Services\TTDichVuController;
Route::resource('dichvu', DichVuController::class)->names('dichvu');
Route::resource('dichvu/{dichvu}/chitiet', TTDichVuController::class)->names('chitiet');

Route::resource('khachhang', KhachHangController::class)->names('khachhang');

// --- CỤM ROUTE ĐẶT PHÒNG TRỰC TIẾP ---

// Route GET để hiển thị form đặt phòng
Route::get('/dat-phong-truc-tiep', [DatPhongTrucTiepController::class, 'create'])
     ->name('datphong.truc_tiep.create');

// Route POST để xử lý lưu đặt phòng
Route::post('/dat-phong-truc-tiep', [DatPhongTrucTiepController::class, 'store'])
     ->name('datphong.truc_tiep.store');

// Route::get('/dat-phong', [DatPhongController::class, 'index'])->name('datphong.index');

// // Trang hiển thị chi tiết 1 lượt đặt phòng (mà controller cũ redirect tới)
// Route::get('/dat-phong/{id}', [DatPhongController::class, 'show'])->name('datphong.show');

// danh sach phong
use App\Http\Controllers\Room\Phong2Controller;
Route::get('/quan-ly-phong', [Phong2Controller::class, 'showRoomManagementPage'])
    ->name('room.index');
