<?php

namespace App\Http\Controllers\Api\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Amenties\CTHDDV;
use App\Models\Amenties\DatPhong;
use App\Models\Amenties\DichVu;
use App\Models\Amenties\HoaDon;
use App\Models\Login\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    // Danh sách booking phục vụ checkout
    public function index(Request $request)
    {
        $dateStr = $request->query('date') ?: Carbon::today()->toDateString();
        $scope = $request->query('scope', 'due_today'); // due_today | inhouse | overdue | all
        $keyword = trim((string) $request->query('q', ''));

        // Parse date an toàn
        try {
            $date = Carbon::parse($dateStr)->toDateString(); // YYYY-MM-DD
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Invalid date: ' . $dateStr], 422);
        }

        $query = DatPhong::query()
            ->with([
                'phong:IDPhong,SoPhong,IDLoaiPhong,TrangThai,GiaCoBanMotDem',
                'phong.loaiPhong:IDLoaiPhong,TenLoaiPhong',
                'khachHang:IDKhachHang,HoTen,SoDienThoai,Email'
            ])
            ->whereIn('TrangThai', [0, 1, 2, 3, 4]);

        switch ($scope) {
            case 'inhouse':
            case 'in_house':
            case 'active_on_date':
                // Inclusive: đang sử dụng trong ngày => checkin <= date <= checkout
                // Chỉ lấy trạng thái 3 (đang sử dụng) như bạn yêu cầu
                $query->where('TrangThai', 3)
                    ->whereDate('NgayNhanPhong', '<=', $date)
                    ->whereDate('NgayTraPhong', '>=', $date);
                break;

            case 'overdue':
                // Quá hạn chưa trả (đang sử dụng)
                $query->where('TrangThai', 3)
                    ->whereDate('NgayTraPhong', '<', $date);
                break;

            case 'all':
                // không filter thêm
                break;

            case 'due_today':
            default:
                // Trả phòng đúng ngày
                $query->where('TrangThai', 3)
                    ->whereDate('NgayTraPhong', '=', $date);
                break;
        }

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('IDDatPhong', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('phong', function ($q2) use ($keyword) {
                        $q2->where('SoPhong', 'LIKE', "%{$keyword}%");
                    })
                    ->orWhereHas('khachHang', function ($q3) use ($keyword) {
                        $q3->where('HoTen', 'LIKE', "%{$keyword}%")
                            ->orWhere('SoDienThoai', 'LIKE', "%{$keyword}%");
                    });
            });
        }

        $items = $query->orderBy('NgayTraPhong')->get()->map(function ($dp) {
            return [
                'IDDatPhong' => $dp->IDDatPhong,
                'NgayNhanPhong' => (string) $dp->NgayNhanPhong,
                'NgayTraPhong' => (string) $dp->NgayTraPhong,
                'TrangThai' => (int) ($dp->TrangThai ?? 0),
                'TrangThaiThanhToan' => (int) ($dp->TrangThaiThanhToan ?? 0),
                'TongTien' => (float) ($dp->TongTien ?? 0),
                'TienCoc' => (float) ($dp->TienCoc ?? 0),
                'phong' => [
                    'IDPhong' => data_get($dp, 'phong.IDPhong'),
                    'SoPhong' => data_get($dp, 'phong.SoPhong'),
                    'TenLoaiPhong' => data_get($dp, 'phong.loaiPhong.TenLoaiPhong'),
                    'TrangThaiPhong' => data_get($dp, 'phong.TrangThai'),
                ],
                'khach_hang' => [
                    'IDKhachHang' => data_get($dp, 'khachHang.IDKhachHang'),
                    'HoTen' => data_get($dp, 'khachHang.HoTen'),
                    'SoDienThoai' => data_get($dp, 'khachHang.SoDienThoai'),
                    'Email' => data_get($dp, 'khachHang.Email'),
                ]
            ];
        })->values();

        return response()->json(['success' => true, 'data' => $items], 200);
    }

    // Chi tiết 1 booking
    public function show($idDatPhong)
    {
        $dp = DatPhong::with([
            'phong:IDPhong,SoPhong,IDLoaiPhong,GiaCoBanMotDem,TrangThai',
            'phong.loaiPhong:IDLoaiPhong,TenLoaiPhong',
            'khachHang:IDKhachHang,HoTen,SoDienThoai,Email',
            'hoaDon.cthddvs.dichVu'
        ])->where('IDDatPhong', $idDatPhong)->firstOrFail();

        $hoaDon = $dp->hoaDon;

        $roomTotal = (float) ($dp->TongTien ?? 0);
        $serviceTotal = 0.0;
        $lines = [];

        if ($hoaDon && $hoaDon->cthddvs) {
            foreach ($hoaDon->cthddvs as $ct) {
                // Lấy đơn giá fallback từ bảng DichVu (nếu cần)
                $unitFromDV = (float) data_get($ct, 'dichVu.TienDichVu', 0);

                // Tổng dòng: ưu tiên cột Tiendichvu của chi tiết; nếu 0 thì fallback đơn giá dịch vụ
                $lineTotal = (float) ($ct->Tiendichvu ?? 0);
                if ($lineTotal <= 0 && $unitFromDV > 0) {
                    $lineTotal = $unitFromDV; // thiếu SoLuong nên coi như 1
                }

                $serviceTotal += $lineTotal;

                $lines[] = [
                    'IDCTHDDV' => $ct->IDCTHDDV ?? null,
                    'IDDichVu' => $ct->IDDichVu,
                    'TenDichVu' => data_get($ct, 'dichVu.TenDichVu'),
                    // Alias cho FE cũ: trả TienDichVu = tổng dòng
                    'TienDichVu' => $lineTotal,
                    // Thêm các field chuẩn để FE mới dùng nếu có
                    'DonGia' => $unitFromDV,
                    'SoLuong' => 1,
                    'ThanhTien' => $lineTotal,
                    'ThoiGianThucHien' => (string) ($ct->ThoiGianThucHien ?? ''),
                ];
            }
        }

        $grandTotal = $roomTotal + $serviceTotal;
        $deposit = (float) ($dp->TienCoc ?? 0);
        $amountDue = max(0, $grandTotal - $deposit);

        return response()->json([
            'success' => true,
            'data' => [
                'booking' => [
                    'IDDatPhong' => $dp->IDDatPhong,
                    'NgayNhanPhong' => (string) $dp->NgayNhanPhong,
                    'NgayTraPhong' => (string) $dp->NgayTraPhong,
                    'SoDem' => (int) ($dp->SoDem ?? 0),
                    'GiaPhong' => (float) ($dp->GiaPhong ?? 0),
                    'TongTien' => (float) ($dp->TongTien ?? 0),
                    'TienCoc' => $deposit,
                    'TrangThai' => (int) ($dp->TrangThai ?? 0),
                    'TrangThaiThanhToan' => (int) ($dp->TrangThaiThanhToan ?? 0),
                ],
                'room' => [
                    'IDPhong' => data_get($dp, 'phong.IDPhong'),
                    'SoPhong' => data_get($dp, 'phong.SoPhong'),
                    'TenLoaiPhong' => data_get($dp, 'phong.loaiPhong.TenLoaiPhong'),
                    'GiaCoBanMotDem' => data_get($dp, 'phong.GiaCoBanMotDem'),
                    'TrangThaiPhong' => data_get($dp, 'phong.TrangThai'),
                ],
                'customer' => [
                    'IDKhachHang' => data_get($dp, 'khachHang.IDKhachHang'),
                    'HoTen' => data_get($dp, 'khachHang.HoTen'),
                    'SoDienThoai' => data_get($dp, 'khachHang.SoDienThoai'),
                    'Email' => data_get($dp, 'khachHang.Email'),
                ],
                'invoice' => [
                    'IDHoaDon' => data_get($hoaDon, 'IDHoaDon'),
                    'NgayLap' => (string) data_get($hoaDon, 'NgayLap'),
                    'GhiChu' => data_get($hoaDon, 'GhiChu'),
                    'TrangThaiThanhToan' => (int) data_get($hoaDon, 'TrangThaiThanhToan', 1),
                    'lines' => $lines
                ],
                'totals' => [
                    'room_total' => $roomTotal,
                    'service_total' => $serviceTotal,
                    'grand_total' => $grandTotal,
                    'deposit' => $deposit,
                    'amount_due' => $amountDue
                ]
            ]
        ], 200);
    }

    // Thêm dịch vụ
    public function addService(Request $request, $idDatPhong)
    {
        $request->validate([
            'IDDichVu' => 'required|string',
            'so_luong' => 'nullable|integer|min:1',
            'thoi_gian' => 'nullable|date'
        ]);

        $dp = DatPhong::where('IDDatPhong', $idDatPhong)->firstOrFail();

        if ((int) $dp->TrangThai === 4) {
            return response()->json(['success' => false, 'message' => 'Đặt phòng đã hoàn thành, không thể thêm dịch vụ'], 422);
        }

        // $today = Carbon::today();
        // $ngayTraPhong = Carbon::parse($dp->NgayTraPhong);
        // if (!$ngayTraPhong->isAfter($today)) {
        //     return response()->json(['success' => false, 'message' => 'Chỉ áp dụng cho đặt phòng có ngày trả trong tương lai'], 400);
        // }
        $today = Carbon::today();
        $ngayTraPhong = Carbon::parse($dp->NgayTraPhong);

        $dv = DichVu::where('IDDichVu', $request->IDDichVu)->firstOrFail();
        $qty = (int) ($request->so_luong ?? 1);
        $lineAmount = (float) ($dv->TienDichVu ?? 0) * $qty;
        $thoiGian = $request->thoi_gian ? Carbon::parse($request->thoi_gian) : Carbon::now();

        $hoaDon = HoaDon::where('IDDatPhong', $dp->IDDatPhong)->first();
        if (!$hoaDon) {
            $hoaDon = HoaDon::create([
                'IDHoaDon' => $this->newId('HD'),
                'IDDatPhong' => $dp->IDDatPhong,
                'NgayLap' => Carbon::now(),
                'TongTien' => 0,
                'TienCoc' => $dp->TienCoc ?? 0,
                'TienThanhToan' => 0,
                'TrangThaiThanhToan' => 1,
                'TrangThaiThanhToanMoi' => 1,
                'GhiChu' => null
            ]);
        }

        $ct = CTHDDV::create([
            'IDCTHDDV' => $this->newId('CT'),
            'IDHoaDon' => $hoaDon->IDHoaDon,
            'IDDichVu' => $dv->IDDichVu,
            'TienDichVu' => $lineAmount,
            'ThoiGianThucHien' => $thoiGian
        ]);
        if ($ngayTraPhong->isAfter($today)) {
            $newTrangThai = ($dp->TrangThaiThanhToan == 2) ? 3 : 1;
            $hoaDon->TrangThaiThanhToanMoi = $newTrangThai;
            $hoaDon->save();
        }

        return response()->json(['success' => true, 'message' => 'Đã thêm dịch vụ', 'data' => $ct], 200);
    }
    private function getServicePrice($iddv)
    {
        $service = DB::table('DichVu')->where('IDDichVu', $iddv)->first();
        return $service ? $service->TienDichVu : 0;
    }

    // Cập nhật ghi chú
    public function updateNote(Request $request, $idDatPhong)
    {
        $request->validate(['GhiChu' => 'nullable|string']);

        $hoaDon = HoaDon::where('IDDatPhong', $idDatPhong)->first();
        if (!$hoaDon) {
            return response()->json(['success' => false, 'message' => 'Chưa có hóa đơn'], 404);
        }
        $hoaDon->GhiChu = $request->GhiChu;
        $hoaDon->save();

        return response()->json(['success' => true, 'message' => 'Đã cập nhật ghi chú'], 200);
    }

    // Thu tiền
    public function pay(Request $request, $idDatPhong)
    {
        $dp = DatPhong::with('hoaDon.cthddvs')->where('IDDatPhong', $idDatPhong)->firstOrFail();

        $hoaDon = $dp->hoaDon;
        if (!$hoaDon) {
            $hoaDon = HoaDon::create([
                'IDHoaDon' => $this->newId('HD'),
                'IDDatPhong' => $dp->IDDatPhong,
                'NgayLap' => Carbon::now(),
                'TongTien' => 0,
                'TienCoc' => $dp->TienCoc ?? 0,
                'TienThanhToan' => 0,
                'TrangThaiThanhToan' => 1,
                'GhiChu' => null
            ]);
            $hoaDon->refresh();
        }

        $roomTotal = (float) ($dp->TongTien ?? 0);
        $serviceTotal = $hoaDon->cthddvs ? $hoaDon->cthddvs->sum('TienDichVu') : 0.0;
        $grandTotal = $roomTotal + $serviceTotal;
        $deposit = (float) ($dp->TienCoc ?? 0);
        $amountDue = max(0, $grandTotal - $deposit);

        DB::transaction(function () use ($hoaDon, $dp, $grandTotal, $deposit, $amountDue) {
            $hoaDon->TongTien = $grandTotal;
            $hoaDon->TienCoc = $deposit;
            $hoaDon->TienThanhToan = $amountDue;
            $hoaDon->TrangThaiThanhToan = 2; // đã TT
            $hoaDon->NgayLap = Carbon::now();
            $hoaDon->save();

            $dp->TrangThaiThanhToan = 2; // đã TT
            $dp->save();
        });

        return response()->json([
            'success' => true,
            'message' => 'Đã ghi nhận thanh toán',
            'data' => [
                'TongTien' => $grandTotal,
                'TienCoc' => $deposit,
                'TienThanhToan' => $amountDue
            ]
        ], 200);
    }

    // Hoàn tất
    public function complete(Request $request, $idDatPhong)
    {
        $dp = DatPhong::with(['hoaDon', 'phong'])->where('IDDatPhong', $idDatPhong)->firstOrFail();

        if (!$dp->hoaDon || (int) $dp->hoaDon->TrangThaiThanhToan !== 2) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng thu tiền/đánh dấu hóa đơn đã thanh toán trước khi trả phòng.'
            ], 422);
        }

        DB::transaction(function () use ($dp) {
            $dp->TrangThai = 4; // hoàn thành
            $dp->save();

            if ($dp->phong) {
                $dp->phong->TrangThai = 'Trống';
                $dp->phong->save();
            }
        });

        return response()->json(['success' => true, 'message' => 'Đã hoàn tất trả phòng'], 200);
    }

    private function newId($prefix = 'ID')
    {
        return $prefix . strtoupper(now()->format('YmdHis')) . Str::upper(Str::random(4));
    }

}