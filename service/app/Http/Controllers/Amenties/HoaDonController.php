<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenties\HoaDon;

class HoaDonController extends Controller
{
    /**
     * List invoices with filters: from, to, status (0 all,1 unpaid,2 paid), q search (IDHoaDon or GhiChu)
     */
    public function index(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');
        $status = $request->query('status');
        $q = $request->query('q');

    $perPage = (int) $request->query('per_page', 10);

        $query = HoaDon::query();

        // Date range filter (NgayLap)
        if ($from) {
            $query->where('NgayLap', '>=', $from);
        }
        if ($to) {
            // include entire day if only date provided
            $query->where('NgayLap', '<=', $to . ' 23:59:59');
        }

        // Status filter
        if ($status !== null && $status !== '') {
            // '0' means all -> no filter
            if ($status == '1') {
                // '1' in UI means 'Chưa thanh toán' and DB stores 1 = Chưa TT
                $query->where('TrangThaiThanhToan', 1);
            } elseif ($status == '2') {
                // '2' means 'Đã thanh toán'
                $query->where('TrangThaiThanhToan', 2);
            }
        }

        // Search q on IDHoaDon or GhiChu
        if ($q) {
            $query->where(function($qq) use ($q) {
                $qq->where('IDHoaDon', 'like', '%' . $q . '%')
                   ->orWhere('GhiChu', 'like', '%' . $q . '%');
            });
        }

        // Order by date desc
        $query->orderBy('NgayLap', 'desc');

        $result = $query->paginate($perPage)->appends($request->query());

        return response()->json($result);
    }
}
