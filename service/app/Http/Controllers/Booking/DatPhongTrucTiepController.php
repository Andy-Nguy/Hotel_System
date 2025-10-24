<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenties\DatPhong;
use App\Models\Login\KhachHang;
use App\Models\Amenties\Phong;
use App\Models\Amenties\HoaDon;
use App\Models\Amenties\DichVu;
use App\Models\Amenties\CTHDDV;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash; // Thêm Hash
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class DatPhongTrucTiepController extends Controller
{
    /**
     * Create a new direct booking (DatPhongTrucTiep)
     * Checks for existing customer or creates a new one.
     * Includes selected services in the booking.
     * Accepts both camel/lower form field names from Blade and API-style keys.
     * POST /api/datphongtructiep
     */
public function store(Request $request)
    {
        // 0) Normalize incoming payload to expected keys
        $data = $request->all();
        // Map frontend form names to API keys if present
        if (!isset($data['HoTen']) && isset($data['hoTen'])) {
            $data['HoTen'] = $data['hoTen'];
        }
        if (!isset($data['Email']) && isset($data['email'])) {
            $data['Email'] = $data['email'];
        }
        if (!isset($data['SoDienThoai']) && isset($data['soDienThoai'])) {
            $data['SoDienThoai'] = $data['soDienThoai'];
        }
        // Convert dich_vu[] to services[] with default quantity = 1
        if (!isset($data['services']) && isset($data['dich_vu']) && is_array($data['dich_vu'])) {
            $data['services'] = array_map(function($id){
                return [
                    'IDDichVu' => $id,
                    'SoLuong' => 1,
                ];
            }, $data['dich_vu']);
        }

        $today = Carbon::today()->toDateString(); // Lấy ngày hôm nay dưới dạng 'Y-m-d'

    $validator = Validator::make($data, [
            // Customer info
            'HoTen' => 'required|string|max:255',
            'Email' => 'required|email|max:255',
            'SoDienThoai' => 'required|string|max:20',
            'CCCD' => 'nullable|string|max:20',

            // Booking info
            'IDPhong' => 'required|string|exists:Phong,IDPhong',
            // NgayNhanPhong được mặc định là hôm nay, không cần validate
            'NgayTraPhong' => 'required|date|after:' . $today, // Phải sau ngày hôm nay
            'TienCoc' => 'nullable|numeric|min:0',

            // Services info
            'services' => 'nullable|array',
            'services.*.IDDichVu' => 'required_with:services|string|exists:DichVu,IDDichVu',
            'services.*.SoLuong' => 'required_with:services|integer|min:1',
        ], [
            'NgayTraPhong.after' => 'Ngày trả phòng phải sau ngày hôm nay.'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Gán ngày nhận phòng là hôm nay
        $ngayNhan = Carbon::today();
        $ngayTra = Carbon::parse($data['NgayTraPhong']);

        // 1. Check Room Availability
        $isBooked = DatPhong::where('IDPhong', $data['IDPhong'])
            ->where('TrangThai', '!=', 0) // Exclude cancelled
            ->where(function ($query) use ($ngayNhan, $ngayTra) {
                $query->where(function($q) use ($ngayNhan, $ngayTra) {
                    // Starts during the period (exclusive of end date)
                    $q->where('NgayNhanPhong', '>=', $ngayNhan)
                      ->where('NgayNhanPhong', '<', $ngayTra);
                })->orWhere(function($q) use ($ngayNhan, $ngayTra) {
                    // Ends during the period (exclusive of start date)
                    $q->where('NgayTraPhong', '>', $ngayNhan)
                      ->where('NgayTraPhong', '<=', $ngayTra);
                })->orWhere(function($q) use ($ngayNhan, $ngayTra) {
                    // Spans the entire period
                    $q->where('NgayNhanPhong', '<=', $ngayNhan)
                      ->where('NgayTraPhong', '>=', $ngayTra);
                });
            })->exists();

        if ($isBooked) {
            return response()->json(['error' => 'Phòng đã được đặt trong khoảng thời gian này.'], 409); // 409 Conflict
        }

        // 2. Find or Create Customer
        $khachHang = KhachHang::where('Email', $data['Email'])
                             ->orWhere('SoDienThoai', $data['SoDienThoai'])
                             ->first();

        if (!$khachHang) {
            $khachHang = KhachHang::create([
                'HoTen' => $data['HoTen'],
                'Email' => $data['Email'],
                'SoDienThoai' => $data['SoDienThoai'],
                'CCCD' => $data['CCCD'] ?? null,
            ]);
        }

        // 3. Start Transaction
        DB::beginTransaction();
        try {
            // 4. Calculate Room Price
            $phong = Phong::find($data['IDPhong']);
            // Prefer GiaCoBanMotDem, fallback to Gia if present
            $giaPhong = $phong->GiaCoBanMotDem ?? ($phong->Gia ?? 0);
            $soNgay = max(1, $ngayNhan->diffInDays($ngayTra));
            $tongTienPhong = $soNgay * $giaPhong;
            $tienCoc = isset($data['TienCoc']) && is_numeric($data['TienCoc']) ? (float)$data['TienCoc'] : 0;

            // Generate IDs for non-incrementing tables with required formats
            $idDatPhong = $this->nextDatPhongId(); // e.g., DP001

            // 5. Create DatPhong
            $datPhong = DatPhong::create([
                'IDDatPhong' => $idDatPhong,
                'IDKhachHang' => $khachHang->IDKhachHang,
                'IDPhong' => $phong->IDPhong,
                'NgayDatPhong' => Carbon::now(),
                'NgayNhanPhong' => $ngayNhan,
                'NgayTraPhong' => $ngayTra,
                'SoDem' => $soNgay,
                'GiaPhong' => $giaPhong,
                'TongTien' => $tongTienPhong, // This is just the room total
                'TienCoc' => $tienCoc,
                'TienConLai' => $tongTienPhong - $tienCoc,
                'TrangThai' => 3, // 3 = Đang sử dụng (vì là check-in ngay)
                'TrangThaiThanhToan' => ($tienCoc > 0) ? 0 : -1, // 0 = Đã cọc, -1 = Chưa cọc
            ]);

            // 6. Create HoaDon
            $hoaDon = HoaDon::create([
                'IDHoaDon' => $this->nextHoaDonId(), // e.g., HD000001
                'IDDatPhong' => $datPhong->IDDatPhong,
                'NgayLap' => Carbon::now(),
                'TongTien' => $tongTienPhong, // Start with room total
                'TienCoc' => $datPhong->TienCoc,
                // Map: invoice paid amount equals booking deposit at creation time
                'TienThanhToan' => $datPhong->TienCoc,
                'TrangThaiThanhToan' => 1, // 1 = Chưa thanh toán
                'GhiChu' => 'Hóa đơn đặt phòng trực tiếp.',
            ]);

            // 7. Add Services
            $tongTienDichVu = 0;
            if (!empty($data['services']) && is_array($data['services'])) {
                $thoiGianThucHien = Carbon::now(); // Dịch vụ thực hiện ngay
                foreach ($data['services'] as $service) {
                    $dichVu = DichVu::find($service['IDDichVu']);
                    $soLuong = max(1, intval($service['SoLuong'] ?? 1));
                    $tienDV = ($dichVu->TienDichVu ?? 0) * $soLuong;
                    $tongTienDichVu += $tienDV;

                    CTHDDV::create([
                        'IDCTHDDV' => $this->generateId('CT'),
                        'IDHoaDon' => $hoaDon->IDHoaDon,
                        'IDDichVu' => $dichVu->IDDichVu,
                        // The CTHDDV table stores the money per service; quantity can be represented by repeated entries or encoded in TienDichVu
                        // If your schema supports quantity, adjust the model and migration accordingly.
                        'TienDichVu' => $tienDV,
                        'ThoiGianThucHien' => $thoiGianThucHien,
                    ]);
                }
            }

            // 8. Update HoaDon Total and payment status
            $tongTienHoaDon = $tongTienPhong + $tongTienDichVu;
            $hoaDon->TongTien = $tongTienHoaDon;
            // If deposit covers total, mark as paid (2). Otherwise, unpaid (1)
            $hoaDon->TrangThaiThanhToan = ($tienCoc >= $tongTienHoaDon) ? 2 : 1;
            $hoaDon->save();

            // 9. Commit
            DB::commit();

            // 10. Return a success response that the frontend expects
            return response()->json([
                'success' => true,
                'IDDatPhong' => $datPhong->IDDatPhong,
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error('Failed to create direct booking: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi máy chủ, không thể tạo đặt phòng.', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Return booking details for a specific IDDatPhong including invoice and services used
     * GET /api/datphong/{iddatphong}
     */
    public function show($iddatphong)
    {
        $dp = DatPhong::with(['phong', 'khachHang', 'hoaDon.cthddvs.dichVu'])
            ->where('IDDatPhong', $iddatphong)
            ->first();

        if (!$dp) {
            return response()->json(['error' => 'Not found'], 404);
        }
        $payStatus1 = [
            1 => 'Chưa thanh toán',
            2 => 'Đã thanh toán',
        ];
        $hoaDon = null;
        if ($dp->hoaDon) {
            $hoaDon = [
                'IDHoaDon' => $dp->hoaDon->IDHoaDon,
                'NgayLap' => $dp->hoaDon->NgayLap ? $dp->hoaDon->NgayLap->format('Y-m-d H:i:s') : null,
                'TongTienHoaDon' => (float) $dp->hoaDon->TongTien,
                'TienCoc' => (float) $dp->hoaDon->TienCoc,
                'TienThanhToan' => (float) $dp->hoaDon->TienThanhToan,
                'TrangThaiThanhToan' => $dp->hoaDon->TrangThaiThanhToan,
                'TrangThaiThanhToanLabel' => $payStatus1[$dp->hoaDon->TrangThaiThanhToan] ?? 'Không xác định',
                'GhiChu' => $dp->hoaDon->GhiChu,
                'DichVus' => $dp->hoaDon->cthddvs->map(function ($c) {
                    return [
                        'TenDichVu' => $c->dichVu ? $c->dichVu->TenDichVu : null,
                        // use the price recorded on the invoice item (CTHDDV)
                        'TienDichVu' => (float) $c->TienDichVu,
                        'ThoiGianThucHien' => $c->ThoiGianThucHien ? $c->ThoiGianThucHien->format('Y-m-d H:i:s') : null,
                    ];
                })->values(),
            ];
        }
        $statusLabels = [
            1 => 'Chờ xác nhận',
            2 => 'Đã xác nhận',
            0 => 'Đã hủy',
            3 => 'Đang sử dụng',
            4 => 'Hoàn thành',
        ];
        $payStatus2 = [
            1 => 'Chưa thanh toán',
            2 => 'Đã thanh toán',
            0 => 'Đã cọc',
            -1 => 'Chưa cọc',
        ];
        $result = [
            'IDDatPhong' => $dp->IDDatPhong,
            'SoPhong' => $dp->phong ? $dp->phong->SoPhong : null,
            'TenPhong' => $dp->phong ? $dp->phong->TenPhong : null,
            'GiaPhong' => (float) $dp->GiaPhong,
            'NgayDatPhong' => $dp->NgayDatPhong ? $dp->NgayDatPhong->format('Y-m-d') : null,
            'NgayNhanPhong' => $dp->NgayNhanPhong ? $dp->NgayNhanPhong->format('Y-m-d') : null,
            'NgayTraPhong' => $dp->NgayTraPhong ? $dp->NgayTraPhong->format('Y-m-d') : null,
            'TongTienPhong' => (float) $dp->TongTien,
            'TrangThaiDatPhong' => $dp->TrangThai,
            'TrangThaiDatPhongLabel' => $statusLabels[$dp->TrangThai] ?? 'Không xác định',
            'TrangThaiThanhToan' => $dp->TrangThaiThanhToan,
            'TrangThaiThanhToanLabel' => $payStatus2[$dp->TrangThaiThanhToan] ?? 'Không xác định',
            'HoaDon' => $hoaDon,
        ];

        return response()->json($result);
    }

    /**
     * Cancel a booking by setting TrangThai = 0
     * POST /api/datphong/{iddatphong}/cancel
     */
    public function cancel(Request $request, $iddatphong)
    {
        $dp = DatPhong::where('IDDatPhong', $iddatphong)->first();
        if (!$dp) {
            return response()->json(['error' => 'Not found'], 404);
        }

        // Only update if not already cancelled
        if ((int) $dp->TrangThai === 0) {
            return response()->json(['message' => 'Already cancelled', 'IDDatPhong' => $dp->IDDatPhong, 'TrangThai' => $dp->TrangThai]);
        }

        $dp->TrangThai = 0;
        try {
            $dp->save();
        } catch (\Throwable $e) {
            logger()->error('Failed to cancel booking ' . $iddatphong . ': ' . $e->getMessage());
            return response()->json(['error' => 'failed_to_update'], 500);
        }

        return response()->json(['message' => 'Cancelled', 'IDDatPhong' => $dp->IDDatPhong, 'TrangThai' => $dp->TrangThai]);
    }

    /**
     * Admin confirm booking: set TrangThai = 2 (confirmed)
     * POST /api/datphong/{iddatphong}/confirm
     */
    public function confirm(Request $request, $iddatphong)
    {
        $dp = DatPhong::where('IDDatPhong', $iddatphong)->first();
        if (!$dp) {
            return response()->json(['error' => 'Not found'], 404);
        }

        // Only update if not already confirmed
        if ((int) $dp->TrangThai === 2) {
            return response()->json(['message' => 'Already confirmed', 'IDDatPhong' => $dp->IDDatPhong, 'TrangThai' => $dp->TrangThai]);
        }

        $dp->TrangThai = 2;
        try {
            $dp->save();
        } catch (\Throwable $e) {
            logger()->error('Failed to confirm booking ' . $iddatphong . ': ' . $e->getMessage());
            return response()->json(['error' => 'failed_to_update'], 500);
        }

        return response()->json(['message' => 'Confirmed', 'IDDatPhong' => $dp->IDDatPhong, 'TrangThai' => $dp->TrangThai]);
    }

    /**
     * Admin list endpoint: supports filtering by NgayDatPhong (from/to), TrangThai, q (IDDatPhong or TenPhong), pagination
     * GET /api/datphong/list?from=YYYY-MM-DD&to=YYYY-MM-DD&status=&q=&page=&per_page=
     */
    public function adminIndex(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');
        $status = $request->query('status');
        $q = $request->query('q');
        $perPage = intval($request->query('per_page', 10)) ?: 10;

        // include customer info (left join so we still list bookings without customer)
        $query = DatPhong::query()
            ->join('Phong as p', 'DatPhong.IDPhong', '=', 'p.IDPhong')
            ->leftJoin('KhachHang as k', 'DatPhong.IDKhachHang', '=', 'k.IDKhachHang')
            ->select([
                'DatPhong.IDDatPhong as IDDatPhong',
                'p.SoPhong as SoPhong',
                'p.TenPhong as TenPhong',
                'DatPhong.NgayDatPhong',
                'DatPhong.NgayNhanPhong',
                'DatPhong.NgayTraPhong',
                'DatPhong.TongTien',
                'DatPhong.TienCoc',
                'DatPhong.TrangThai',
                'DatPhong.TrangThaiThanhToan',
                'k.HoTen as KhachHangHoTen',
                'k.Email as KhachHangEmail',
                'k.SoDienThoai as KhachHangPhone',
            ]);

        if ($from) {
            $query->whereDate('DatPhong.NgayDatPhong', '>=', $from);
        }
        if ($to) {
            // include whole day
            $query->whereDate('DatPhong.NgayDatPhong', '<=', $to);
        }

        if ($status !== null && $status !== '') {
            // allow status = -1 to mean all
            if (strval($status) !== '-1') {
                $query->where('DatPhong.TrangThai', $status);
            }
        }

        if ($q) {
            $query->where(function($qq) use ($q) {
                $qq->where('DatPhong.IDDatPhong', 'like', '%' . $q . '%')
                   ->orWhere('p.TenPhong', 'like', '%' . $q . '%');
            });
        }

        $query->orderByDesc('DatPhong.NgayDatPhong');

        $paginated = $query->paginate($perPage);

        return response()->json($paginated);
    }

    /**
     * Return top booked rooms (exclude TrangThai = 0) aggregated by count of bookings.
     * GET /api/datphong/top-rooms?limit=3
     */
    public function topRooms(Request $request)
    {
        $limit = intval($request->query('limit', 3));
        // count bookings per room, exclude cancelled (TrangThai = 0)
        $rows = DatPhong::query()
            ->where('DatPhong.TrangThai', '!=', 0)
            ->join('Phong as p', 'DatPhong.IDPhong', '=', 'p.IDPhong')
            ->selectRaw('p.TenPhong as TenPhong, COUNT(*) as bookings')
            ->groupBy('p.TenPhong')
            ->orderByDesc('bookings')
            ->get();

        $total = $rows->sum('bookings');
        $top = $rows->take($limit);
        $othersCount = max(0, $total - $top->sum('bookings'));

        $data = $top->map(function($r){ return ['label' => $r->TenPhong, 'value' => (int)$r->bookings]; })->values()->toArray();
        if ($othersCount > 0) {
            $data[] = ['label' => 'Khác', 'value' => (int)$othersCount];
        }

        return response()->json(['data' => $data, 'total' => (int)$total]);
    }

    public function showDatPhongTrucTiep()
    {
        // Trả về file Blade tại: resources/views/statistics/bookingtructiep.blade.php
        return view('statistics.bookingtructiep');
    }

    private function generateId(string $prefix): string
    {
        // Ensure ID length well below 50 chars, unique enough
        return $prefix . strtoupper(dechex(time())) . strtoupper(bin2hex(random_bytes(3)));
    }

    private function nextDatPhongId(): string
    {
        // Find the max numeric part of IDs like DPxxx and increment
        $maxNum = DatPhong::query()
            ->where('IDDatPhong', 'like', 'DP%')
            ->select(DB::raw("MAX(CAST(SUBSTRING(IDDatPhong, 3) AS UNSIGNED)) as maxnum"))
            ->value('maxnum');
        $next = intval($maxNum) + 1;
        return 'DP' . str_pad((string)$next, 3, '0', STR_PAD_LEFT); // DP001
    }

    private function nextHoaDonId(): string
    {
        // Find the max numeric part of IDs like HDxxxxxx and increment
        $maxNum = HoaDon::query()
            ->where('IDHoaDon', 'like', 'HD%')
            ->select(DB::raw("MAX(CAST(SUBSTRING(IDHoaDon, 3) AS UNSIGNED)) as maxnum"))
            ->value('maxnum');
        $next = intval($maxNum) + 1;
        return 'HD' . str_pad((string)$next, 6, '0', STR_PAD_LEFT); // HD000001
    }
}
