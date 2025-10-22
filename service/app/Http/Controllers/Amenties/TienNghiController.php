<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use App\Models\Amenties\TienNghi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TienNghiController extends Controller
{
    // GET /api/tien-nghi
    public function index()
    {
        $data = TienNghi::orderBy('IDTienNghi')->get(['IDTienNghi', 'TenTienNghi']);
        return response()->json(['success' => true, 'data' => $data]);
    }

    // POST /api/tien-nghi
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TenTienNghi' => 'required|string|max:100|unique:TienNghi,TenTienNghi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $tienNghi = TienNghi::create($validator->validated());
        return response()->json(['success' => true, 'data' => $tienNghi]);
    }

    // PUT /api/tien-nghi/{id}
    public function update(Request $request, TienNghi $tienNghi)
    {
        $validator = Validator::make($request->all(), [
            'TenTienNghi' => [
                'required', 'string', 'max:100',
                Rule::unique('TienNghi', 'TenTienNghi')->ignore($tienNghi->IDTienNghi, 'IDTienNghi'),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check whether any room that has this amenity is currently not empty.
        $inUse = DB::table('TienNghiPhong as tnp')
            ->join('Phong as p', 'tnp.IDPhong', '=', 'p.IDPhong')
            ->where('tnp.IDTienNghi', $tienNghi->IDTienNghi)
            ->where(function ($q) {
                // consider room 'in use' when TrangThai is not 'Trống' (string)
                $q->whereNotNull('p.TrangThai')
                  ->where('p.TrangThai', '<>', 'Trống');
            })
            ->exists();

        if ($inUse) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể chỉnh sửa tiện nghi này vì đang có phòng sử dụng. Vui lòng gỡ tiện nghi khỏi các phòng (hoặc chờ phòng trống) trước khi chỉnh sửa.'
            ], 400);
        }

        $tienNghi->update($validator->validated());
        return response()->json(['success' => true, 'data' => $tienNghi]);
    }

    // DELETE /api/tien-nghi/{id}
    public function destroy(TienNghi $tienNghi)
    {
        // Prevent deletion if any assigned room is not empty
        $inUse = DB::table('TienNghiPhong as tnp')
            ->join('Phong as p', 'tnp.IDPhong', '=', 'p.IDPhong')
            ->where('tnp.IDTienNghi', $tienNghi->IDTienNghi)
            ->where(function ($q) {
                $q->whereNotNull('p.TrangThai')
                  ->where('p.TrangThai', '<>', 'Trống');
            })
            ->exists();

        if ($inUse) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa tiện nghi này vì đang có phòng sử dụng. Vui lòng gỡ tiện nghi khỏi các phòng (hoặc chờ phòng trống) trước khi xóa.'
            ], 400);
        }

        // Safe to detach and delete
        $tienNghi->phongs()->detach();
        $tienNghi->delete();

        return response()->json(['success' => true]);
    }
}
