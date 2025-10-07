<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use App\Models\Amenties\Phong;
use Illuminate\Http\Request;

class PhongTienNghiController extends Controller
{
    // GET /api/phong/{id}/tien-nghi
    // Lấy danh sách ID tiện nghi của 1 phòng
    public function show($phongId)
    {
        $phong = Phong::findOrFail($phongId);

        $ids = $phong->tienNghis()
            ->pluck('TienNghi.IDTienNghi');

        return response()->json(['success' => true, 'data' => $ids]);
    }

    // PUT /api/phong/{id}/tien-nghi
    // Gán (đồng bộ) tiện nghi cho 1 phòng
    public function update(Request $request, $phongId)
    {
        $phong = Phong::findOrFail($phongId);

        $validated = $request->validate([
            'tien_nghi_ids' => 'array',
            'tien_nghi_ids.*' => 'string|exists:TienNghi,IDTienNghi',
        ]);

        $ids = $validated['tien_nghi_ids'] ?? [];

        // Gán danh sách tiện nghi mới
        $phong->tienNghis()->sync($ids);

        // Lấy lại danh sách sau khi sync
        $fresh = $phong->tienNghis()
            ->orderBy('TenTienNghi')
            ->get(['IDTienNghi', 'TenTienNghi']);

        return response()->json(['success' => true, 'data' => $fresh]);
    }
}
