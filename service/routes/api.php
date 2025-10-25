<?php
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\Login\RegisterChoiceController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Amenties\DichVuController;
use App\Http\Controllers\Amenties\TTDichVuController;

use App\Http\Controllers\Amenties\PhongTienNghiController;
use App\Http\Controllers\Amenties\TienNghiController;
use App\Http\Controllers\Amenties\PhongController;
use App\Http\Controllers\Amenties\LoaiPhongController;
use App\Http\Controllers\Rooms\RoomController;
use App\Http\Controllers\Booking\BookingController;

use App\Http\Controllers\Api\Checkout\CheckoutController;

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

Route::prefix('rooms')->group(function () {
    Route::get('/available', [RoomController::class, 'getAvailableRooms']);
    Route::get('/available/by_type', [RoomController::class, 'getAvailableRoomsByType']);
    Route::get('/available/by_room', [RoomController::class, 'getAvailableRoomById']);
});

// === API mới cho 2 lựa chọn đăng ký ===
// Lựa chọn 1: Tạo tài khoản (có xác nhận OTP)
Route::post('/register-with-account', [RegisterChoiceController::class, 'registerWithAccount']);
// Lựa chọn 2: Không tạo tài khoản (chỉ lưu khách hàng)
Route::post('/register-guest', [RegisterChoiceController::class, 'registerGuest']);
// Xác nhận OTP và tạo tài khoản (gửi email thông tin)
Route::post('/verify-otp-account', [RegisterChoiceController::class, 'verifyOtpAndCreateAccount']);



// CRUD Tiện nghi
Route::get('/tien-nghi', [TienNghiController::class, 'index']);
Route::post('/tien-nghi', [TienNghiController::class, 'store']);
Route::put('/tien-nghi/{tienNghi}', [TienNghiController::class, 'update']);
Route::delete('/tien-nghi/{tienNghi}', [TienNghiController::class, 'destroy']);

Route::get('phong/{phong}/tien-nghi', [PhongTienNghiController::class, 'show']);
Route::put('phong/{phong}/tien-nghi', [PhongTienNghiController::class, 'update']);

// Loại phòng (dropdown cho CRUD phòng)
Route::get('/loai-phong', [LoaiPhongController::class, 'index']);

// Phòng + gán tiện nghi
// Main CRUD for rooms
Route::get('/phong', [PhongController::class, 'index']); // ?with=tiennghi để lấy kèm tiện nghi
Route::post('/phong', [PhongController::class, 'store']);
Route::put('/phong/{phong}', [PhongController::class, 'update']);
Route::delete('/phong/{phong}', [PhongController::class, 'destroy']);

// Amenity-specific endpoints handled by PhongTienNghiController (single source of truth)
Route::get('phong/{phong}/tien-nghi', [PhongTienNghiController::class, 'show']);
Route::put('phong/{phong}/tien-nghi', [PhongTienNghiController::class, 'update']);

Route::get('/phongs', [PhongController::class, 'index1']);
Route::apiResource('phongs', PhongController::class)->except(methods: ['index']);
Route::get('/loaiphongs', [LoaiPhongController::class, 'index1']);
Route::apiResource('loaiphongs', LoaiPhongController::class)->except(['index']);
Route::get('phongs/loai/{maLoai}', [PhongController::class, 'searchByLoai']);

// Update profile via API (ajax-friendly, stateless)
Route::post('/taikhoan', [AuthController::class, 'updateProfileApi']);
// Explicit route: use index1 for listing phongs


// Booking API
Route::post('/datphong', [BookingController::class, 'store']);

// Booking API: fetch bookings by email or idkhachhang
Route::get('/datphong', [App\Http\Controllers\Amenties\DatPhongController::class, 'index']);
// Admin booking list with filters (from, to on NgayDatPhong; status on TrangThai; q search)
Route::get('/datphong/list', [App\Http\Controllers\Amenties\DatPhongController::class, 'adminIndex']);
// Top booked rooms (exclude cancelled)
Route::get('/datphong/top-rooms', [App\Http\Controllers\Amenties\DatPhongController::class, 'topRooms']);
// Booking details: include HoaDon and used services
Route::get('/datphong/{iddatphong}', [App\Http\Controllers\Amenties\DatPhongController::class, 'show']);
// Cancel a booking (set TrangThai = 0)
Route::post('/datphong/{iddatphong}/cancel', [App\Http\Controllers\Amenties\DatPhongController::class, 'cancel']);
// Confirm a booking (set TrangThai = 2)
Route::post('/datphong/{iddatphong}/confirm', [App\Http\Controllers\Amenties\DatPhongController::class, 'confirm']);

// Services API
Route::get('/dichvu', [App\Http\Controllers\Amenties\DichVuController::class, 'index']);

Route::get('/dichvu/top-used', [App\Http\Controllers\Amenties\DichVuController::class, 'topUsed']);
Route::get('/public-services', [DichVuController::class, 'getPublicServices']);
Route::get('/public-services/updates', [DichVuController::class, 'updates']);


Route::resource('dichvu.chitiet', TTDichVuController::class)->except(['create', 'edit']);
Route::resource('dichvu', DichVuController::class)->except(['create', 'edit']);
// Customers
Route::get('/khachhang', [App\Http\Controllers\Login\KhachHangController::class, 'index']);
Route::post('/khachhang', [App\Http\Controllers\Login\KhachHangController::class, 'store']);
Route::put('/khachhang/{id}', [App\Http\Controllers\Login\KhachHangController::class, 'update']);

// Invoices API (hoadon) - supports filtering by date range, status and search
Route::get('/hoadon', [App\Http\Controllers\Amenties\HoaDonController::class, 'index']);
// Create invoice (HoaDon) - called by admin UI when saving an invoice for a booking
Route::post('/hoadon', [App\Http\Controllers\Amenties\HoaDonController::class, 'store']);
// Invoice stats: weekly/monthly aggregates for reporting
Route::get('/hoadon/stats', [App\Http\Controllers\Amenties\HoaDonController::class, 'stats']);


use App\Http\Controllers\Booking\DatPhongTrucTiepController;
use App\Http\Controllers\Login\KhachHangController; // (Cần cho việc search)

// Route để TẠO MỚI (JavaScript sẽ gọi khi submit)
Route::post('/datphongtructiep', [DatPhongTrucTiepController::class, 'store'])
     ->name('api.datphongtructiep.store');
// Alias route name and slug to match frontend usage
Route::post('/datphong-truc-tiep', [DatPhongTrucTiepController::class, 'store'])
    ->name('api.datphong.truc_tiep.store');

// Route để TÌM KHÁCH HÀNG (JavaScript sẽ gọi khi nhấn nút "Tìm")
Route::get('/khach-hang/search', [KhachHangController::class, 'search'])
     ->name('api.khachhang.search');

use App\Http\Controllers\Amenties\UploadController;
// --- CỤM ROUTE CHO TRANG QUẢN LÝ PHÒNG (Room Management Page) ---
Route::get('/phongs', [PhongController::class, 'index3']);
Route::get('/phong', [PhongController::class, 'index2']);
Route::match(['put', 'patch'], '/phongs/{key}', [PhongController::class, 'update1']);
Route::post('/upload', [UploadController::class, 'store'])->name('api.upload');
Route::delete('/upload', [UploadController::class, 'destroy'])->name('api.upload.delete');


Route::get('/services', [DichVuController::class, 'index']);

// Checkout flows
    Route::prefix('checkout')->group(function () {
    // List các booking phục vụ trả phòng
    // scope: due_today | inhouse | overdue | all
    Route::get('/list', [CheckoutController::class, 'index']);

    // Chi tiết 1 booking (hiển thị đủ thông tin checkout)
    Route::get('/{idDatPhong}', [CheckoutController::class, 'show']);

    // Thêm dịch vụ (tạo Hóa Đơn nháp nếu chưa có)
    Route::post('/{idDatPhong}/add-service', [CheckoutController::class, 'addService']);

    // Cập nhật ghi chú hóa đơn
    Route::put('/{idDatPhong}/note', [CheckoutController::class, 'updateNote']);

    // Thu tiền (đánh dấu đã thanh toán hóa đơn)
    Route::post('/{idDatPhong}/pay', [CheckoutController::class, 'pay']);

    // Hoàn tất trả phòng (yêu cầu đã thanh toán)
    Route::post('/{idDatPhong}/complete', [CheckoutController::class, 'complete']);
    Route::get('/checkout/{id}', [CheckoutController::class, 'show']); // optional: cho modal chi tiết
    Route::post('/checkout/{id}/add-service', [CheckoutController::class, 'addService']);
    Route::put('/checkout/{id}/note', [CheckoutController::class, 'updateNote']);
    Route::post('/checkout/{id}/pay', [CheckoutController::class, 'pay']);
    Route::post('/checkout/{id}/complete', [CheckoutController::class, 'complete']);
});
