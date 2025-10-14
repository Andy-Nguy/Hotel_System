<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenties\DatPhong;
use App\Models\Login\KhachHang;

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
}
