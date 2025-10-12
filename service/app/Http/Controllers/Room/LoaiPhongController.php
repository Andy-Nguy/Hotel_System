<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\Room\LoaiPhong;
use Illuminate\Http\Request;

class LoaiPhongController extends Controller
{
    /**
     * Lấy danh sách tất cả loại phòng
     * GET /api/loai-phong
     */
    public function index()
    {
        $data = LoaiPhong::orderBy('TenLoaiPhong', 'asc')
            ->get([
                'IDLoaiPhong',
                'TenLoaiPhong',
                'MoTa',
                'SoNguoiToiDa',
                'GiaCoBanMotDem',
                'UrlAnhLoaiPhong',
                'UuTienChinh'
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Danh sách loại phòng',
            'data' => $data
        ]);
    }

    /**
     * Lấy thông tin chi tiết 1 loại phòng
     * GET /api/loai-phong/{id}
     */
    public function show($id)
    {
        $loaiPhong = LoaiPhong::find($id);

        if (!$loaiPhong) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy loại phòng'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $loaiPhong
        ]);
    }

    /**
     * Thêm loại phòng mới
     * POST /api/loai-phong
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'IDLoaiPhong' => 'required|string|max:10|unique:loaiphong,IDLoaiPhong',
            'TenLoaiPhong' => 'required|string|max:100',
            'MoTa' => 'nullable|string',
            'SoNguoiToiDa' => 'required|integer|min:1',
            'GiaCoBanMotDem' => 'required|numeric|min:0',
            'UrlAnhLoaiPhong' => 'nullable|string|max:255',
            'UuTienChinh' => 'boolean'
        ]);

        $loaiPhong = LoaiPhong::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thêm loại phòng thành công',
            'data' => $loaiPhong
        ], 201);
    }
}
