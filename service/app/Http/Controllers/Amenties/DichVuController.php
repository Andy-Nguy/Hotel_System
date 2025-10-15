<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenties\DichVu;

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
}
