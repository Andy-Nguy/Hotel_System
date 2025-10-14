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

class AuthController extends Controller
{
    // --- [1] Gửi OTP khi đăng ký ---
    public function register(Request $req)
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

            // Kiểm tra email đã tồn tại chưa trong KhachHang
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

            // Gửi email OTP (có thể comment khi test)
            Mail::raw("Mã xác nhận của bạn là: $otp\nMã này có hiệu lực trong 5 phút.", function ($message) use ($email) {
                $message->to($email)->subject('Mã xác nhận đăng ký tài khoản');
            });

            return response()->json([
                'message' => 'Đã gửi mã xác nhận qua email!',
                'debug_otp' => $otp // Test frontend, xóa khi production
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Lỗi server: ' . $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    // --- [2] Xác thực OTP ---
    public function verifyOtp(Request $req)
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

            // --- Tạo bản ghi KhachHang ---
            $idKhachHang = DB::table('KhachHang')->insertGetId([
                'HoTen' => $pending->hoten,
                'Email' => $pending->email,
                'SoDienThoai' => $pending->sodienthoai,
                'NgaySinh' => $pending->ngaysinh,
                'NgayDangKy' => now(),
            ]);

            // --- Tạo TaiKhoanNguoiDung ---
            DB::table('TaiKhoanNguoiDung')->insert([
                'IDKhachHang' => $idKhachHang,
                'MatKhau' => $pending->password,
                'VaiTro' => 1, // 1 = Khách hàng
            ]);

            // Xóa pending
            DB::table('pending_users')->where('email', $email)->delete();

            return response()->json(['message' => 'Đăng ký thành công!'], 200);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Lỗi xác nhận: ' . $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    // --- [3] Đăng nhập ---
    public function login(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'Email' => 'required|email',
                'MatKhau' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = $req->Email;
            $password = $req->MatKhau;

            $user = DB::table('KhachHang')
                ->join('TaiKhoanNguoiDung', 'KhachHang.IDKhachHang', '=', 'TaiKhoanNguoiDung.IDKhachHang')
                ->where('KhachHang.Email', $email)
                ->select('KhachHang.HoTen', 'TaiKhoanNguoiDung.MatKhau', 'TaiKhoanNguoiDung.VaiTro')
                ->first();

            if (!$user || !Hash::check($password, $user->MatKhau)) {
                return response()->json(['message' => 'Sai thông tin đăng nhập!'], 401);
            }

            return response()->json([
                'message' => 'Đăng nhập thành công!',
                'role' => $user->VaiTro,
                'hoTen' => $user->HoTen
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Lỗi đăng nhập: ' . $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
        
    }
    // --- [4] Trang tài khoản (khách hàng) ---
    public function taikhoan(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        $email = session('email') ?? $request->input('email'); // Lấy email từ session hoặc request
        if (!$email) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để truy cập trang tài khoản.');
        }

        // Lấy thông tin khách hàng từ database
        $user = DB::table('KhachHang')
            ->join('TaiKhoanNguoiDung', 'KhachHang.IDKhachHang', '=', 'TaiKhoanNguoiDung.IDKhachHang')
            ->where('KhachHang.Email', $email)
            ->select('KhachHang.HoTen', 'KhachHang.Email', 'KhachHang.SoDienThoai', 'KhachHang.NgaySinh', 'TaiKhoanNguoiDung.VaiTro')
            ->first();

        if (!$user || $user->VaiTro != 1) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập trang này.');
        }

        // Trả về view taikhoan với thông tin người dùng
        return view('taikhoan', ['user' => $user]);
    }

    // --- [5] Cập nhật thông tin tài khoản (POST /taikhoan) ---
    public function updateProfile(Request $request)
    {
        // Debug: log session and CSRF related info to help diagnose 419 Page Expired
        try {
            $sid = session()->getId();
            $sessionToken = session('_token');
            $requestToken = $request->input('_token') ?? $request->header('X-CSRF-TOKEN');
            $sessionEmail = session('email');
            $cookies = $request->cookies->all();
            Log::info('updateProfile debug', [
                'session_id' => $sid,
                'session_token' => $sessionToken,
                'request_token' => $requestToken,
                'session_email' => $sessionEmail,
                'cookies' => $cookies,
                'headers_csrf' => $request->header('X-CSRF-TOKEN'),
            ]);
        } catch (Throwable $e) {
            // if logging fails, don't break the request
            Log::warning('updateProfile debug logging failed: ' . $e->getMessage());
        }

        $email = session('email') ?? $request->input('email');
        if (!$email) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để truy cập trang tài khoản.');
        }

        $validator = Validator::make($request->all(), [
            'HoTen' => 'required|string|max:100',
            'SoDienThoai' => 'nullable|string|max:15',
            'NgaySinh' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::table('KhachHang')
                ->where('Email', $email)
                ->update([
                    'HoTen' => $request->input('HoTen'),
                    'SoDienThoai' => $request->input('SoDienThoai'),
                    'NgaySinh' => $request->input('NgaySinh'),
                ]);

            // If request expects JSON (AJAX), return JSON with updated data so client JS can update in-place.
            if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
                $updated = [
                    'HoTen' => $request->input('HoTen'),
                    'SoDienThoai' => $request->input('SoDienThoai'),
                    'NgaySinh' => $request->input('NgaySinh'),
                ];
                return response()->json(['success' => true, 'data' => $updated]);
            }

            return redirect()->route('taikhoan')->with('success', 'Cập nhật thông tin thành công.');
        } catch (Throwable $e) {
            if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Lỗi khi cập nhật: ' . $e->getMessage());
        }
    }

    // API-friendly update (stateless) - POST /api/taikhoan
    public function updateProfileApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'HoTen' => 'required|string|max:100',
            'SoDienThoai' => 'nullable|string|max:15',
            'NgaySinh' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        try {
            $email = $request->input('email');
            $exists = DB::table('KhachHang')->where('Email', $email)->exists();
            if (!$exists) return response()->json(['success' => false, 'message' => 'User not found'], 404);

            DB::table('KhachHang')->where('Email', $email)->update([
                'HoTen' => $request->input('HoTen'),
                'SoDienThoai' => $request->input('SoDienThoai'),
                'NgaySinh' => $request->input('NgaySinh'),
            ]);

            return response()->json(['success' => true, 'data' => [
                'HoTen' => $request->input('HoTen'),
                'SoDienThoai' => $request->input('SoDienThoai'),
                'NgaySinh' => $request->input('NgaySinh'),
            ]]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
