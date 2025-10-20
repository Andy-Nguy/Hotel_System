<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Throwable;

class RegisterChoiceController extends Controller
{
    /**
     * API 1: Lựa chọn 1 - Tạo tài khoản (có xác nhận OTP)
     * POST /api/register-with-account
     * 
     * Request:
     *   - HoTen (required)
     *   - Email (required)
     *   - MatKhau (required, min 6)
     *   - SoDienThoai (optional)
     *   - NgaySinh (optional)
     * 
     * Response: 200 với OTP (gửi qua email)
     */
    public function registerWithAccount(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'HoTen' => 'required|string|max:100',
                'Email' => 'required|email',
                'MatKhau' => 'required|min:6',
                'SoDienThoai' => 'nullable|string|max:15',
                'NgaySinh' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = $req->Email;

            // Kiểm tra email đã tồn tại chưa
            if (DB::table('KhachHang')->where('Email', $email)->exists()) {
                return response()->json(['message' => 'Email đã tồn tại!'], 400);
            }

            // Tạo OTP 6 số
            $otp = rand(100000, 999999);

            // Lưu thông tin tạm thời vào pending_users
            DB::table('pending_users')->updateOrInsert(
                ['email' => $email],
                [
                    'hoten' => $req->HoTen,
                    'password' => Hash::make($req->MatKhau),
                    'sodienthoai' => $req->SoDienThoai,
                    'ngaysinh' => $req->NgaySinh,
                    'otp' => $otp,
                    'otp_expired_at' => now()->addMinutes(5),
                    'created_at' => now()
                ]
            );

            // Gửi email OTP
            Mail::raw("Mã xác nhận của bạn là: $otp\nMã này có hiệu lực trong 5 phút.", function ($message) use ($email) {
                $message->to($email)->subject('Mã xác nhận đăng ký tài khoản');
            });

            return response()->json([
                'message' => 'Đã gửi mã xác nhận qua email! Vui lòng kiểm tra email để xác nhận tài khoản.',
                'debug_otp' => $otp // Test frontend, xóa khi production
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Lỗi server: ' . $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * API 2: Lựa chọn 2 - Không tạo tài khoản (chỉ lưu khách hàng)
     * POST /api/register-guest
     * 
     * Request:
     *   - HoTen (required)
     *   - Email (required)
     *   - SoDienThoai (optional)
     *   - NgaySinh (optional)
     * 
     * Response: 201 lưu trực tiếp vào KhachHang
     */
    public function registerGuest(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'HoTen' => 'required|string|max:100',
                'Email' => 'required|email',
                'SoDienThoai' => 'nullable|string|max:15',
                'NgaySinh' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = $req->Email;

            // Kiểm tra email đã tồn tại chưa
            if (DB::table('KhachHang')->where('Email', $email)->exists()) {
                return response()->json(['message' => 'Email đã tồn tại!'], 400);
            }

            // Lưu khách hàng trực tiếp (không tạo tài khoản)
            $idKhachHang = DB::table('KhachHang')->insertGetId([
                'HoTen' => $req->HoTen,
                'Email' => $email,
                'SoDienThoai' => $req->SoDienThoai,
                'NgaySinh' => $req->NgaySinh,
                'NgayDangKy' => now(),
            ]);

            // Gửi email thông tin khách hàng
            try {
                $emailBody = "Chúc mừng! Thông tin khách hàng của bạn đã được lưu thành công.\n\n";
                $emailBody .= "Thông tin khách hàng:\n";
                $emailBody .= "Họ tên: {$req->HoTen}\n";
                $emailBody .= "Email: {$email}\n";
                if ($req->SoDienThoai) {
                    $emailBody .= "Số điện thoại: {$req->SoDienThoai}\n";
                }
                if ($req->NgaySinh) {
                    $emailBody .= "Ngày sinh: {$req->NgaySinh}\n";
                }
                $emailBody .= "\nCảm ơn bạn đã sử dụng dịch vụ của chúng tôi!";

                Mail::raw($emailBody, function ($message) use ($email) {
                    $message->to($email)->subject('Thông tin khách hàng');
                });
            } catch (Throwable $e) {
                // Nếu gửi email thất bại, không làm gián đoạn flow
                Log::warning('Failed to send guest info email: ' . $e->getMessage());
            }

            return response()->json([
                'message' => 'Đã lưu thông tin khách hàng thành công!',
                'data' => [
                    'IDKhachHang' => $idKhachHang,
                    'HoTen' => $req->HoTen,
                    'Email' => $email
                ]
            ], 201);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Lỗi server: ' . $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * API 3: Xác nhận OTP và tạo tài khoản (kèm gửi email thông tin)
     * POST /api/verify-otp-account
     * 
     * Request:
     *   - Email (required)
     *   - Otp (required, 6 digits)
     * 
     * Response: 200 tạo account + gửi email thông tin tài khoản
     */
    public function verifyOtpAndCreateAccount(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'Email' => 'required|email',
                'Otp' => 'required|numeric|digits:6'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = $req->Email;
            $otp = $req->Otp;

            $pending = DB::table('pending_users')
                ->where('email', $email)
                ->where('otp', $otp)
                ->where('otp_expired_at', '>', now())
                ->first();

            if (!$pending) {
                return response()->json(['message' => 'OTP không hợp lệ hoặc đã hết hạn!'], 400);
            }

            // Tạo bản ghi KhachHang
            $idKhachHang = DB::table('KhachHang')->insertGetId([
                'HoTen' => $pending->hoten,
                'Email' => $pending->email,
                'SoDienThoai' => $pending->sodienthoai,
                'NgaySinh' => $pending->ngaysinh,
                'NgayDangKy' => now(),
            ]);

            // Tạo TaiKhoanNguoiDung
            DB::table('TaiKhoanNguoiDung')->insert([
                'IDKhachHang' => $idKhachHang,
                'MatKhau' => $pending->password,
                'VaiTro' => 1, // 1 = Khách hàng
            ]);

            // Gửi email thông tin tài khoản
            try {
                $loginUrl = url('/login');
                $emailBody = "Chúc mừng! Tài khoản của bạn đã được tạo thành công.\n\n";
                $emailBody .= "========== THÔNG TIN TÀI KHOẢN ==========\n";
                $emailBody .= "Họ tên: {$pending->hoten}\n";
                $emailBody .= "Email: {$pending->email}\n";
                if ($pending->sodienthoai) {
                    $emailBody .= "Số điện thoại: {$pending->sodienthoai}\n";
                }
                if ($pending->ngaysinh) {
                    $emailBody .= "Ngày sinh: {$pending->ngaysinh}\n";
                }
                $emailBody .= "\n========== THÔNG TIN ĐĂNG NHẬP ==========\n";
                $emailBody .= "Email: {$pending->email}\n";
                $emailBody .= "Mật khẩu: 123456\n";
                $emailBody .= "Link đăng nhập: {$loginUrl}\n";
                $emailBody .= "\nLưu ý: Vui lòng đổi mật khẩu ngay lần đăng nhập đầu tiên.\n";
                $emailBody .= "Nếu quên mật khẩu, sử dụng chức năng 'Quên mật khẩu' trên trang đăng nhập.\n\n";
                $emailBody .= "Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!";

                Mail::raw($emailBody, function ($message) use ($email) {
                    $message->to($email)->subject('Thông tin tài khoản và khách hàng');
                });
            } catch (Throwable $e) {
                // Nếu gửi email thất bại, không làm gián đoạn flow
                Log::warning('Failed to send account info email: ' . $e->getMessage());
            }

            // Xóa pending
            DB::table('pending_users')->where('email', $email)->delete();

            return response()->json([
                'message' => 'Đăng ký thành công! Vui lòng kiểm tra email để xem thông tin tài khoản.',
                'data' => [
                    'IDKhachHang' => $idKhachHang,
                    'HoTen' => $pending->hoten,
                    'Email' => $pending->email
                ]
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Lỗi xác nhận: ' . $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }
}
