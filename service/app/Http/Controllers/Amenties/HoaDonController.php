<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenties\HoaDon;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    /**
     * Return aggregated income stats.
     * Query params:
     *  - mode: 'week' or 'month' (default 'week')
     *  - from: start date (YYYY-MM-DD)
     *  - to: end date (YYYY-MM-DD)
     *  - status: optional status filter like index()
     */
    public function stats(Request $request)
    {
        $mode = $request->query('mode', 'week');
        $from = $request->query('from');
        $to = $request->query('to');
        $status = $request->query('status');

        $query = HoaDon::query();
        if ($from) $query->where('NgayLap', '>=', $from);
        if ($to) $query->where('NgayLap', '<=', $to . ' 23:59:59');
        if ($status !== null && $status !== '') {
            if ($status == '1') $query->where('TrangThaiThanhToan', 1);
            elseif ($status == '2') $query->where('TrangThaiThanhToan', 2);
        }

        // support quick recent ranges: last_months, last_years
        $range = (int) $request->query('range', 5);
    if ($mode === 'last_months') {
            $now = Carbon::now();
            $labels = [];
            for ($i = $range - 1; $i >= 0; $i--) {
                $labels[] = $now->copy()->subMonths($i)->format('Y-m');
            }
            // limit query to the date window
            $start = Carbon::createFromFormat('Y-m', $labels[0])->startOfMonth()->toDateString();
            $end = Carbon::createFromFormat('Y-m', $labels[count($labels)-1])->endOfMonth()->endOfDay()->toDateTimeString();
            $rows = $query->whereBetween('NgayLap', [$start, $end])
                          ->select(DB::raw("DATE_FORMAT(NgayLap, '%Y-%m') as period"), DB::raw('SUM(TongTien) as total'))
                          ->groupBy('period')
                          ->orderBy('period')
                          ->get();
            $map = $rows->pluck('total', 'period')->toArray();
            $data = collect($labels)->map(function($lab) use ($map){ return ['label' => $lab, 'total' => isset($map[$lab]) ? (float)$map[$lab] : 0.0]; })->values();
        } elseif ($mode === 'last_years') {
            $now = Carbon::now();
            $labels = [];
            for ($i = $range - 1; $i >= 0; $i--) {
                $labels[] = $now->copy()->subYears($i)->format('Y');
            }
            $start = Carbon::createFromFormat('Y', $labels[0])->startOfYear()->toDateString();
            $end = Carbon::createFromFormat('Y', $labels[count($labels)-1])->endOfYear()->endOfDay()->toDateTimeString();
            $rows = $query->whereBetween('NgayLap', [$start, $end])
                          ->select(DB::raw("YEAR(NgayLap) as period"), DB::raw('SUM(TongTien) as total'))
                          ->groupBy('period')
                          ->orderBy('period')
                          ->get();
            $map = $rows->pluck('total', 'period')->toArray();
            $data = collect($labels)->map(function($lab) use ($map){ return ['label' => $lab, 'total' => isset($map[$lab]) ? (float)$map[$lab] : 0.0]; })->values();
        } elseif ($mode === 'month') {
            // group by year-month
            $rows = $query->select(DB::raw("DATE_FORMAT(NgayLap, '%Y-%m') as period"), DB::raw('SUM(TongTien) as total'))
                          ->groupBy('period')
                          ->orderBy('period')
                          ->get();
            $data = $rows->map(function($r){ return ['label' => $r->period, 'total' => (float)$r->total]; });
    } else {
            // default: week grouping (ISO week of year)
            // use YEARWEEK to get year+week key
            // if caller requested last_weeks, build labels for last N ISO weeks and fill zeros
            if ($mode === 'last_weeks') {
                $now = Carbon::now();
                $items = [];
                // prepare list of weeks with ISO year-week key and start-of-week label
                for ($i = $range - 1; $i >= 0; $i--) {
                    $dt = $now->copy()->subWeeks($i);
                    $startOfWeek = $dt->copy()->startOfWeek();
                    $ywKey = $dt->format('o') . str_pad($dt->format('W'), 2, '0', STR_PAD_LEFT);
                    $items[] = ['key' => $ywKey, 'label' => $startOfWeek->format('d/m/Y')];
                }
                // query between first week's monday and last week's sunday
                $start = $now->copy()->subWeeks($range - 1)->startOfWeek()->toDateString();
                $end = $now->copy()->endOfWeek()->toDateTimeString();
                $rows = $query->whereBetween('NgayLap', [$start, $end])
                              ->select(DB::raw("YEARWEEK(NgayLap, 3) as yw"), DB::raw('SUM(TongTien) as total'))
                              ->groupBy('yw')
                              ->orderBy('yw')
                              ->get();
                $map = $rows->pluck('total', 'yw')->toArray();
                $data = collect($items)->map(function($it) use ($map){
                    $key = $it['key'];
                    return ['label' => $it['label'], 'total' => isset($map[$key]) ? (float)$map[$key] : 0.0];
                })->values();
            } else {
                $rows = $query->select(DB::raw("YEARWEEK(NgayLap, 3) as yw"), DB::raw('SUM(TongTien) as total'))
                              ->groupBy('yw')
                              ->orderBy('yw')
                              ->get();
                $data = $rows->map(function($r){
                    $yw = (string)$r->yw;
                    $year = substr($yw, 0, 4);
                    $week = substr($yw, 4);
                    return ['label' => $year . '-W' . ltrim($week, '0'), 'total' => (float)$r->total];
                });
            }
        }

        return response()->json(['mode' => $mode, 'data' => $data]);
    }
}
