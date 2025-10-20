<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenties\DichVu;
use Illuminate\Support\Facades\DB;

class DichVuController extends Controller
{
    /**
     * Return list of all services with their details
     */
    //GET /api/dichvu
    public function index(Request $request)
    {
        $services = DichVu::with('thongTin')->get();

        $result = $services->map(function ($s) {
            return [
                'IDDichVu' => $s->IDDichVu,
                'TenDichVu' => $s->TenDichVu,
                'TienDichVu' => $s->TienDichVu,
                'HinhDichVu' => $s->HinhDichVu,
                'ThongTin' => $s->thongTin->map(function ($t) {
                    return [
                        'IDTTDichVu' => $t->IDTTDichVu,
                        'ThongTinDV' => $t->ThongTinDV,
                    ];
                })->values()->all(),
            ];
        });

        // return raw array of services (no wrapper)
        return response()->json($result->values()->all());
    }

    /**
     * Return top used services from CTHDDV (counts)
     * GET /api/dichvu/top-used?limit=5
     */
    public function topUsed(Request $request)
    {
        $limit = intval($request->query('limit', 5));
        // join CTHDDV -> DichVu and count occurrences
        $rows = DB::table('CTHDDV as c')
            ->join('DichVu as d', 'c.IDDichVu', '=', 'd.IDDichVu')
            ->selectRaw('d.TenDichVu as label, COUNT(*) as cnt')
            ->groupBy('d.TenDichVu')
            ->orderByDesc('cnt')
            ->get();

        $total = $rows->sum('cnt');
        $top = $rows->take($limit)->map(function($r){ return ['label' => $r->label, 'value' => (int)$r->cnt]; })->values();
        $others = max(0, $total - $top->sum('value'));
        $data = $top->toArray();
        if ($others > 0) $data[] = ['label' => 'Khác', 'value' => (int)$others];

        return response()->json(['data' => $data, 'total' => (int)$total]);
    }
}
