<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenties\DatPhong;
use App\Models\Login\KhachHang;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;

class DatPhongController extends Controller
{
    /**
     * Return bookings for a customer where NgayTraPhong <= today
     * Accepts ?email= or ?idkhachhang=
     */
    //GET:/api/datphong?idkhachhang= or ?email=
    public function index(Request $request)
    {
        $email = $request->query('email');
        $idKh = $request->query('idkhachhang');

        if ($email) {
            $kh = KhachHang::where('Email', $email)->first();
            if (!$kh) return response()->json(['history' => [], 'current' => null]);
            $idKh = $kh->IDKhachHang;
        }

        if (!$idKh) {
            return response()->json(['history' => [], 'current' => null]);
        }

        $today = date('Y-m-d');

        $rows = DatPhong::query()
            ->where('IDKhachHang', $idKh)
            ->where(function ($q) use ($today) {
                $q->whereDate('DatPhong.NgayTraPhong', '<=', $today)
                  ->orWhere('DatPhong.TrangThai', 0);
            })
            ->join('Phong as p', 'DatPhong.IDPhong', '=', 'p.IDPhong')
            ->orderByDesc('DatPhong.NgayTraPhong')
            ->get([
                'DatPhong.IDDatPhong as IDDatPhong',
                'p.SoPhong as SoPhong',
                'p.TenPhong as TenPhong',
                'DatPhong.NgayDatPhong',
                'DatPhong.NgayNhanPhong',
                'DatPhong.NgayTraPhong',
                'DatPhong.TongTien',
                'DatPhong.TrangThai',
                'DatPhong.TrangThaiThanhToan',
            ]);

        // map numeric statuses to labels
        $statusLabels = [
            1 => 'Chờ xác nhận',
            2 => 'Đã xác nhận',
            0 => 'Đã hủy',
            3 => 'Đang sử dụng',
            4 => 'Hoàn thành',
        ];
        $payStatus = [
            1 => 'Chưa thanh toán',
            2 => 'Đã thanh toán',
            0 => 'Đã cọc',
            -1 => 'Chưa cọc',
        ];

        $history = $rows->map(function ($r) use ($statusLabels, $payStatus) {
            return [
                'IDDatPhong' => $r->IDDatPhong,
                'SoPhong' => $r->SoPhong,
                'TenPhong' => $r->TenPhong,
                'NgayDatPhong' => $r->NgayDatPhong ? $r->NgayDatPhong->format('Y-m-d') : null,
                'NgayNhanPhong' => $r->NgayNhanPhong ? $r->NgayNhanPhong->format('Y-m-d') : null,
                'NgayTraPhong' => $r->NgayTraPhong ? $r->NgayTraPhong->format('Y-m-d') : null,
                'TongTien' => (float) $r->TongTien,
                'TrangThai' => $r->TrangThai,
                'TrangThaiLabel' => $statusLabels[$r->TrangThai] ?? 'Không xác định',
                'TrangThaiThanhToan' => $r->TrangThaiThanhToan,
                'TrangThaiThanhToanLabel' => $payStatus[$r->TrangThaiThanhToan] ?? 'Không xác định',
            ];
        });

        // current: all bookings that are NOT history
        // i.e. NOT (NgayTraPhong <= today OR TrangThai = 0)
        $currentRows = DatPhong::query()
            ->where('IDKhachHang', $idKh)
            // exclude history: require NgayTraPhong > today AND TrangThai != 0
            ->whereDate('DatPhong.NgayTraPhong', '>', $today)
            ->where('DatPhong.TrangThai', '!=', 0)
            ->join('Phong as p', 'DatPhong.IDPhong', '=', 'p.IDPhong')
            ->orderBy('DatPhong.NgayNhanPhong')
            ->get([
                'DatPhong.IDDatPhong as IDDatPhong',
                'p.SoPhong as SoPhong',
                'p.TenPhong as TenPhong',
                'DatPhong.NgayDatPhong',
                'DatPhong.NgayNhanPhong',
                'DatPhong.NgayTraPhong',
                'DatPhong.TongTien',
                'DatPhong.TrangThai',
                'DatPhong.TrangThaiThanhToan',
            ]);

        $current = $currentRows->map(function ($r) use ($statusLabels, $payStatus) {
            return [
                'IDDatPhong' => $r->IDDatPhong,
                'SoPhong' => $r->SoPhong,
                'TenPhong' => $r->TenPhong,
                'NgayDatPhong' => $r->NgayDatPhong ? $r->NgayDatPhong->format('Y-m-d') : null,
                'NgayNhanPhong' => $r->NgayNhanPhong ? $r->NgayNhanPhong->format('Y-m-d') : null,
                'NgayTraPhong' => $r->NgayTraPhong ? $r->NgayTraPhong->format('Y-m-d') : null,
                'TongTien' => (float) $r->TongTien,
                'TrangThai' => $r->TrangThai,
                'TrangThaiLabel' => $statusLabels[$r->TrangThai] ?? 'Không xác định',
                'TrangThaiThanhToan' => $r->TrangThaiThanhToan,
                'TrangThaiThanhToanLabel' => $payStatus[$r->TrangThaiThanhToan] ?? 'Không xác định',
            ];
        });

        return response()->json([
            'history' => $history,
            'current' => $current,
        ]);
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
            // send notification email to customer if we have email
            try {
                // reload with relations to get phong and khachHang
                $dpFull = DatPhong::with(['phong', 'khachHang'])->where('IDDatPhong', $dp->IDDatPhong)->first();
                $kh = $dpFull->khachHang ?? null;
                $recipientEmail = $kh->Email ?? null;
                $recipientName = $kh->HoTen ?? null;
                if ($recipientEmail) {
                    $mailData = [
                        'IDDatPhong' => $dpFull->IDDatPhong,
                        'IDPhong' => $dpFull->IDPhong,
                        'TenPhong' => $dpFull->phong->TenPhong ?? null,
                        'NgayNhanPhong' => $dpFull->NgayNhanPhong ? $dpFull->NgayNhanPhong->format('Y-m-d') : null,
                        'NgayTraPhong' => $dpFull->NgayTraPhong ? $dpFull->NgayTraPhong->format('Y-m-d') : null,
                        'SoDem' => $dpFull->SoDem,
                        'GiaPhong' => (float) $dpFull->GiaPhong,
                        'TongTien' => (float) $dpFull->TongTien,
                        'TrangThai' => $dpFull->TrangThai,
                        'Message' => 'Yêu cầu hủy đặt phòng của bạn đã được xử lý.'
                    ];
                    Mail::to($recipientEmail)->send((new BookingConfirmation($mailData, ['HoTen' => $recipientName, 'Email' => $recipientEmail]))->subject('Hủy đặt phòng - ' . $dpFull->IDDatPhong));
                }
            } catch (\Throwable $mailEx) {
                logger()->error('Failed to send cancel email for booking ' . $iddatphong . ': ' . $mailEx->getMessage());
            }
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
            // send notification email to customer if we have email
            try {
                // reload with relations to get phong and khachHang
                $dpFull = DatPhong::with(['phong', 'khachHang'])->where('IDDatPhong', $dp->IDDatPhong)->first();
                $kh = $dpFull->khachHang ?? null;
                $recipientEmail = $kh->Email ?? null;
                $recipientName = $kh->HoTen ?? null;
                if ($recipientEmail) {
                    $mailData = [
                        'IDDatPhong' => $dpFull->IDDatPhong,
                        'IDPhong' => $dpFull->IDPhong,
                        'TenPhong' => $dpFull->phong->TenPhong ?? null,
                        'NgayNhanPhong' => $dpFull->NgayNhanPhong ? $dpFull->NgayNhanPhong->format('Y-m-d') : null,
                        'NgayTraPhong' => $dpFull->NgayTraPhong ? $dpFull->NgayTraPhong->format('Y-m-d') : null,
                        'SoDem' => $dpFull->SoDem,
                        'GiaPhong' => (float) $dpFull->GiaPhong,
                        'TongTien' => (float) $dpFull->TongTien,
                        'TrangThai' => $dpFull->TrangThai,
                        'Message' => 'Đặt phòng của bạn đã được xác nhận.'
                    ];
                    Mail::to($recipientEmail)->send((new BookingConfirmation($mailData, ['HoTen' => $recipientName, 'Email' => $recipientEmail]))->subject('Xác nhận đặt phòng - ' . $dpFull->IDDatPhong));
                }
            } catch (\Throwable $mailEx) {
                logger()->error('Failed to send confirm email for booking ' . $iddatphong . ': ' . $mailEx->getMessage());
            }
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
}
