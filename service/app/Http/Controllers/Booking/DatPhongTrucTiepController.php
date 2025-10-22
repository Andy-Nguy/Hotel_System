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

            // --- Yêu cầu 5 & 7: Thêm mới Đặt phòng ---
            $datPhong = DatPhong::create([
                'IDDatPhong' => 'DP_' . uniqid(), // Tạo ID duy nhất
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
                'TrangThaiThanhToan' => ($tienConLai <= 0) ? 1 : 0 // 1 = Đã thanh toán, 0 = Chưa
            ]);

            // --- Yêu cầu 5: Update trạng thái phòng ---
            $phong->update(['TrangThai' => 'Phòng đang sử dụng']);

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

            // --- Yêu cầu 5 & 6 & 8: Tạo Hóa đơn ---
            $tongTienHoaDon = $tongTienPhong + $tongTienDichVu;
            $tienThanhToanConLai = $tongTienHoaDon - $tienCoc;

            $hoaDon = HoaDon::create([
                'IDHoaDon' => 'HD_' . uniqid(), // ID duy nhất
                'IDDatPhong' => $datPhong->IDDatPhong,
                'NgayLap' => now(),
                'TongTien' => $tongTienHoaDon,
                'TienCoc' => $tienCoc,
                'TienThanhToan' => $tienThanhToanConLai,
                'TrangThaiThanhToan' => ($tienThanhToanConLai <= 0) ? 1 : 0, // 1 = Đã TT, 0 = Chưa
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

            // Chuyển hướng về trang chi tiết đặt phòng hoặc danh sách
            return redirect()->route('datphong.show', $datPhong->IDDatPhong) // Giả sử bạn có route 'datphong.show'
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
