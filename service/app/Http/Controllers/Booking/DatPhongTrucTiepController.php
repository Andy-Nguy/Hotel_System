<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Amenties\DatPhong;
use App\Models\Amenties\HoaDon;
use Illuminate\Http\Request;
use App\Models\Amenties\Phong;
use App\Models\Login\KhachHang;
use App\Models\Amenties\DichVu;
use App\Models\Amenties\CTHDDV;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Exception;

class DatPhongTrucTiepController extends Controller
{
    /**
     * Hiển thị form đặt phòng trực tiếp cho nhân viên.
     * Yêu cầu 1: Kiểm tra danh sách phòng trống.
     */
    public function create()
    {
        // 1. Lấy danh sách các phòng có trạng thái 'Trống'
        // Chúng ta cũng nên lấy thông tin loại phòng để hiển thị
        $danhSachPhongTrong = Phong::where('TrangThai', 'Trống')
            ->with('loaiPhong') // Giả sử bạn có relationship 'loaiPhong' trong model Phong
            ->get();

        // Lấy danh sách dịch vụ để nhân viên có thể chọn thêm
        $danhSachDichVu = DichVu::all();

        return view('statistics.bookingtructiep', [
            'danhSachPhongTrong' => $danhSachPhongTrong,
            'danhSachDichVu' => $danhSachDichVu,
        ]);
    }

    /**
     * Generate next sequential ID for a table column with a given prefix.
     * Example: prefix='DP' will return 'DP001', 'DP002', ...
     * This scans existing IDs that start with the prefix and finds the largest trailing number.
     */
    private function nextSequenceId(string $table, string $column, string $prefix, int $digits = 3)
    {
        $rows = DB::table($table)->where($column, 'like', $prefix . '%')->pluck($column);
        $max = 0;
        foreach ($rows as $id) {
            // Remove the prefix portion
            $suffix = substr($id, strlen($prefix));
            // Extract trailing number
            if (preg_match('/(\d+)$/', $suffix, $m)) {
                $num = intval($m[1]);
                if ($num > $max) $max = $num;
            }
        }
        $next = $max + 1;
        return $prefix . str_pad($next, $digits, '0', STR_PAD_LEFT);
    }

    /**
     * Xác nhận đặt phòng (API endpoint)
     * Lưu DatPhong, tạo HoaDon, cập nhật trạng thái phòng và trả về JSON kết quả.
     */
    public function confirm(Request $request)
    {
        // Reuse similar validation as store
        $validator = Validator::make($request->all(), [
            'IDPhong' => 'required|exists:Phong,IDPhong',
            'NgayTraPhong' => 'required|date|after:today',
            'TienCoc' => 'required|numeric|min:0',
            'soDienThoai' => 'nullable|string|max:20',
            'hoTen' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'dich_vu' => 'nullable|array',
            'dich_vu.*' => 'exists:DichVu,IDDichVu',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        try {
            // Khách hàng
            $khachHang = null;
            if ($request->filled('soDienThoai')) {
                $khachHang = KhachHang::firstOrCreate(
                    ['SoDienThoai' => $request->soDienThoai],
                    [
                        'HoTen' => $request->hoTen ?? 'Khách vãng lai',
                        'Email' => $request->email,
                        'NgayDangKy' => now()->toDateString()
                    ]
                );
            } else {
                $khachHang = KhachHang::firstOrCreate(
                    ['SoDienThoai' => '000'],
                    [
                        'HoTen' => 'Khách lẻ 000',
                        'NgayDangKy' => now()->toDateString()
                    ]
                );
            }

            $phong = Phong::findOrFail($request->IDPhong);
            if ($phong->TrangThai !== 'Trống') {
                return response()->json(['success' => false, 'message' => 'Phòng này vừa được đặt. Vui lòng chọn phòng khác.'], 409);
            }

            $ngayNhanPhong = Carbon::now();
            $ngayTraPhong = Carbon::parse($request->NgayTraPhong);
            $soDem = $ngayNhanPhong->copy()->startOfDay()->diffInDays($ngayTraPhong->copy()->startOfDay());
            if ($soDem <= 0) {
                $soDem = 1;
            }

            $giaPhongMotDem = $phong->GiaCoBanMotDem;
            $tongTienPhong = $giaPhongMotDem * $soDem;
            $tienCoc = $request->TienCoc;

            // Dịch vụ
            $tongTienDichVu = 0;
            $chiTietDichVuList = [];
            if ($request->has('dich_vu') && is_array($request->dich_vu)) {
                $dichVuDaChon = DichVu::whereIn('IDDichVu', $request->dich_vu)->get();
                foreach ($dichVuDaChon as $dv) {
                    $tongTienDichVu += $dv->TienDichVu;
                    $chiTietDichVuList[] = [
                        'IDCTHDDV' => 'CTDV_' . uniqid(),
                        'IDDichVu' => $dv->IDDichVu,
                        'TienDichVu' => $dv->TienDichVu,
                        'ThoiGianThucHien' => now(),
                    ];
                }
            }

            $tongTienHoaDon = $tongTienPhong + $tongTienDichVu;
            $tienConLai = $tongTienHoaDon - $tienCoc;

            // Payment status: 2 => Đã thanh toán (full), 1 => Chưa thanh toán (partial or none)
            $payStatusCode = ($tienCoc >= $tongTienHoaDon) ? 2 : 1;

            $datPhong = DatPhong::create([
                'IDDatPhong' => $this->nextSequenceId('DatPhong', 'IDDatPhong', 'DP', 3),
                'IDKhachHang' => $khachHang->IDKhachHang,
                'IDPhong' => $phong->IDPhong,
                'NgayDatPhong' => $ngayNhanPhong->toDateString(),
                'NgayNhanPhong' => $ngayNhanPhong->toDateString(),
                'NgayTraPhong' => $ngayTraPhong->toDateString(),
                'SoDem' => $soDem,
                'GiaPhong' => $giaPhongMotDem,
                'TongTien' => $tongTienPhong,
                'TienCoc' => $tienCoc,
                'TienConLai' => $tienConLai,
                'TrangThai' => 1,
                'TrangThaiThanhToan' => $payStatusCode,
            ]);

            // Update room status
            $phong->update(['TrangThai' => 'Phòng đang sử dụng']);

            // Tạo hoá đơn
            $hoaDon = HoaDon::create([
                'IDHoaDon' => $this->nextSequenceId('HoaDon', 'IDHoaDon', 'HD', 3),
                'IDDatPhong' => $datPhong->IDDatPhong,
                'NgayLap' => now(),
                'TongTien' => $tongTienHoaDon,
                'TienCoc' => $tienCoc,
                'TienThanhToan' => $tienCoc,
                'TrangThaiThanhToan' => $payStatusCode,
                'GhiChu' => 'Hóa đơn tạo lúc nhận phòng trực tiếp.'
            ]);

            if (!empty($chiTietDichVuList)) {
                foreach ($chiTietDichVuList as &$ctdv) {
                    $ctdv['IDHoaDon'] = $hoaDon->IDHoaDon;
                }
                CTHDDV::insert($chiTietDichVuList);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đặt phòng thành công.',
                'IDDatPhong' => $datPhong->IDDatPhong,
                'IDHoaDon' => $hoaDon->IDHoaDon,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Lưu thông tin đặt phòng trực tiếp vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        // --- Validation (Kiểm tra dữ liệu đầu vào) ---
        $validator = Validator::make($request->all(), [
            'IDPhong' => 'required|exists:Phong,IDPhong',
            'NgayTraPhong' => 'required|date|after:today',
            'TienCoc' => 'required|numeric|min:0',
            'soDienThoai' => 'nullable|string|max:20',
            'hoTen' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'dich_vu' => 'nullable|array', // Danh sách ID dịch vụ
            'dich_vu.*' => 'exists:DichVu,IDDichVu', // Kiểm tra mỗi ID dịch vụ có tồn tại
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Bắt đầu một Transaction để đảm bảo toàn vẹn dữ liệu
        // Nếu một trong các bước lỗi, tất cả sẽ được rollback
        DB::beginTransaction();

        try {
            // --- Yêu cầu 2: Kiểm tra hoặc tạo khách hàng ---
            $khachHang = null;
            if ($request->filled('soDienThoai')) {
                // Tìm hoặc tạo mới khách hàng nếu có SĐT
                $khachHang = KhachHang::firstOrCreate(
                    ['SoDienThoai' => $request->soDienThoai],
                    [
                        'HoTen' => $request->hoTen ?? 'Khách vãng lai',
                        'Email' => $request->email,
                        'NgayDangKy' => now()->toDateString()
                    ]
                );
            } else {
                // Nếu không có SĐT, dùng hoặc tạo khách "Khách lẻ 000"
                $khachHang = KhachHang::firstOrCreate(
                    ['SoDienThoai' => '000'], // Dùng SĐT '000' làm mã định danh
                    [
                        'HoTen' => 'Khách lẻ 000',
                        'NgayDangKy' => now()->toDateString()
                    ]
                );
            }

            // --- Lấy thông tin phòng ---
            $phong = Phong::findOrFail($request->IDPhong);

            // Kiểm tra lần nữa xem phòng có thực sự trống không (phòng trường hợp 2 nhân viên đặt cùng lúc)
            if ($phong->TrangThai !== 'Trống') {
                throw new Exception('Phòng này vừa được đặt. Vui lòng chọn phòng khác.');
            }

            // --- Yêu cầu 3 & 4: Tính toán ngày và tổng tiền phòng ---
            $ngayNhanPhong = Carbon::now(); // Đặt trực tiếp là nhận phòng ngay
            $ngayTraPhong = Carbon::parse($request->NgayTraPhong);

            // Tính số đêm. Ví dụ: check-in 20/10, check-out 21/10 -> 1 đêm
            $soDem = $ngayNhanPhong->copy()->startOfDay()->diffInDays($ngayTraPhong->copy()->startOfDay());
            if ($soDem <= 0) {
                $soDem = 1; // Tối thiểu 1 đêm
            }

            $giaPhongMotDem = $phong->GiaCoBanMotDem;
            $tongTienPhong = $giaPhongMotDem * $soDem;
            $tienCoc = $request->TienCoc;
            $tienConLai = $tongTienPhong - $tienCoc;

            // --- Yêu cầu 5 & 7: Xử lý dịch vụ (nếu có) ---
            $tongTienDichVu = 0;
            $chiTietDichVuList = [];

            if ($request->has('dich_vu') && is_array($request->dich_vu)) {
                $dichVuDaChon = DichVu::whereIn('IDDichVu', $request->dich_vu)->get();

                foreach ($dichVuDaChon as $dv) {
                    $tongTienDichVu += $dv->TienDichVu;
                    $chiTietDichVuList[] = [
                        'IDCTHDDV' => 'CTDV_' . uniqid(), // ID duy nhất
                        'IDDichVu' => $dv->IDDichVu,
                        'TienDichVu' => $dv->TienDichVu,
                        'ThoiGianThucHien' => now(),
                    ];
                }
            }

            // --- Tính tổng hoá đơn và số tiền còn lại (áp dụng cả dịch vụ) ---
            $tongTienHoaDon = $tongTienPhong + $tongTienDichVu;
            $tienConLai = $tongTienHoaDon - $tienCoc;

            // Payment status: 2 => Đã thanh toán (full), 1 => Chưa thanh toán (partial or none)
            $payStatusCode = ($tienCoc >= $tongTienHoaDon) ? 2 : 1;

            // --- Yêu cầu 5 & 7: Thêm mới Đặt phòng ---
            $datPhong = DatPhong::create([
                'IDDatPhong' => $this->nextSequenceId('DatPhong', 'IDDatPhong', 'DP', 3), // Tạo ID duy nhất
                'IDKhachHang' => $khachHang->IDKhachHang,
                'IDPhong' => $phong->IDPhong,
                'NgayDatPhong' => $ngayNhanPhong->toDateString(),
                'NgayNhanPhong' => $ngayNhanPhong->toDateString(),
                'NgayTraPhong' => $ngayTraPhong->toDateString(),
                'SoDem' => $soDem,
                'GiaPhong' => $giaPhongMotDem,
                'TongTien' => $tongTienPhong,
                'TienCoc' => $tienCoc,
                'TienConLai' => $tienConLai,
                'TrangThai' => 1, // 1 = Đã nhận phòng (Phòng đang sử dụng)
                'TrangThaiThanhToan' => $payStatusCode
            ]);

            // --- Yêu cầu 5: Update trạng thái phòng ---
            $phong->update(['TrangThai' => 'Phòng đang sử dụng']);

            // --- Yêu cầu 5 & 6 & 8: Tạo Hóa đơn ---
            $hoaDon = HoaDon::create([
                'IDHoaDon' => $this->nextSequenceId('HoaDon', 'IDHoaDon', 'HD', 3), // ID duy nhất
                'IDDatPhong' => $datPhong->IDDatPhong,
                'NgayLap' => now(),
                'TongTien' => $tongTienHoaDon,
                'TienCoc' => $tienCoc,
                // Store the actual amount paid at creation time
                'TienThanhToan' => $tienCoc,
                'TrangThaiThanhToan' => $payStatusCode,
                'GhiChu' => 'Hóa đơn tạo lúc nhận phòng trực tiếp.'
            ]);

            // --- Yêu cầu 7: Gắn chi tiết dịch vụ vào Hóa đơn ---
            if (!empty($chiTietDichVuList)) {
                // Gán IDHoaDon cho từng chi tiết dịch vụ
                foreach ($chiTietDichVuList as &$ctdv) {
                    $ctdv['IDHoaDon'] = $hoaDon->IDHoaDon;
                }
                // Insert hàng loạt vào bảng CTHDDV
                CTHDDV::insert($chiTietDichVuList);
            }

            // Nếu mọi thứ thành công, commit transaction
            DB::commit();

            // If request expects JSON (AJAX), return JSON. Otherwise redirect explicitly
            // to the booking detail URL so the browser stays on /datphong/{id}.
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đặt phòng trực tiếp thành công.',
                    'IDDatPhong' => $datPhong->IDDatPhong,
                    'IDHoaDon' => $hoaDon->IDHoaDon ?? null,
                ]);
            }

            return redirect(url('/datphong'))
                ->with('success', 'Đặt phòng trực tiếp thành công cho phòng ' . $phong->TenPhong);
        } catch (Exception $e) {
            // Nếu có lỗi, rollback tất cả thay đổi
            DB::rollBack();

            // Ghi log lỗi (quan trọng)
            // Log::error('Lỗi đặt phòng trực tiếp: ' . $e->getMessage());

            // Trả về thông báo lỗi
            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())->withInput();
        }
    }
}
