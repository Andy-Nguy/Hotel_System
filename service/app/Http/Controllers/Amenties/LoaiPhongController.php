<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use App\Models\Amenties\LoaiPhong;

class LoaiPhongController extends Controller
{
    // GET /api/loai-phong
    public function index()
    {
        $data = LoaiPhong::orderBy('TenLoaiPhong')
            ->get(['IDLoaiPhong', 'TenLoaiPhong']);
        return response()->json(['success' => true, 'data' => $data]);
    }
}
