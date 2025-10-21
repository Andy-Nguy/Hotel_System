<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\Amenties\Phong;
use App\Models\Amenties\LoaiPhong;
use App\Models\Amenties\TienNghi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Phong2Controller extends Controller
{
    /**
     * THÊM HÀM MỚI: Trả về file view Blade cho trang quản lý phòng.
     * Route trong web.php (tên 'room.index') sẽ gọi hàm này.
     */
    public function showRoomManagementPage()
    {
        // Giả sử file của bạn là 'resources/views/room.blade.php'
        // Đổi 'room' nếu tên file của bạn khác (ví dụ: 'index')
        return view('room.room');
    }


    // GET /api/phong?with=tiennghi&IDLoaiPhong=...
    public function index(Request $request)
    {
        // ... (code của bạn giữ nguyên, không đổi)
        $with = $request->query('with', '');
        $idLoai = $request->query('IDLoaiPhong');

        if (str_contains($with, 'tiennghi')) {
            $query = Phong::query()
                ->with([
                    'loaiPhong:IDLoaiPhong,TenLoaiPhong',
                    'tienNghis:IDTienNghi,TenTienNghi'
                ])
                ->orderBy('SoPhong');

            if ($idLoai) {
                $query->where('IDLoaiPhong', $idLoai);
            }

            $data = $query->get()->map(function ($p) {
                return [
                    'IDPhong' => $p->IDPhong,
                    'SoPhong' => $p->SoPhong,
                    'IDLoaiPhong' => $p->IDLoaiPhong,
                    'TenLoaiPhong' => optional($p->loaiPhong)->TenLoaiPhong,
                    'TenPhong' => $p->TenPhong,
                    'GiaCoBanMotDem' => $p->GiaCoBanMotDem,
                    'SoNguoiToiDa' => $p->SoNguoiToiDa,
                    'XepHangSao' => $p->XepHangSao,
                    'TrangThai' => $p->TrangThai,
                    'MoTa' => $p->MoTa,
                    'tien_nghi' => $p->tienNghis->map(fn($tn) => [
                        'IDTienNghi' => $tn->IDTienNghi,
                        'TenTienNghi' => $tn->TenTienNghi,
                    ])->values(),
                ];
            })->values();

            return response()->json(['success' => true, 'data' => $data]);
        }

        $query = Phong::query()
            ->leftJoin('LoaiPhong as lp', 'lp.IDLoaiPhong', '=', 'Phong.IDLoaiPhong')
            ->orderBy('Phong.SoPhong');

        if ($idLoai) {
            $query->where('Phong.IDLoaiPhong', $idLoai);
        }

        $data = $query->get(['Phong.IDPhong', 'Phong.SoPhong', 'lp.TenPhong']);
        return response()->json(['success' => true, 'data' => $data]);
    }

    // GET /api/phongs (frontend đang dùng)
    public function index1()
    {
        $phongs = Phong::with('loaiPhong')
            ->orderBy('SoPhong')
            ->get();

        return response()->json($phongs);
    }

    // PUT/PATCH /api/phongs/{key}
    public function update(Request $request, $key)
    {
        // Tìm phòng theo IDPhong hoặc SoPhong
        $room = Phong::where('IDPhong', $key)
            ->orWhere('SoPhong', $key)
            ->first();

        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        // ...
        if ($request->filled('TenLoaiPhong')) {
            LoaiPhong::where('IDLoaiPhong', $room->IDLoaiPhong)
                ->update(['TenLoaiPhong' => $request->input('TenLoaiPhong')]);
        }
        if ($request->has('IDPhong') && $request->input('IDPhong') !== $room->IDPhong) {
            return response()->json(['message' => 'Không được phép cập nhật IDPhong'], 422);
        }
        if ($request->has('IDLoaiPhong') && $request->input('IDLoaiPhong') !== $room->IDLoaiPhong) {
            return response()->json(['message' => 'Không được phép cập nhật IDLoaiPhong'], 422);
        }

        $rules = [
            'SoPhong' => ['sometimes', 'string', 'max:50', Rule::unique('Phong', 'SoPhong')->ignore($room->SoPhong, 'SoPhong')],
            'TenPhong' => ['sometimes', 'string', 'max:255'],
            'TenLoaiPhong' => ['sometimes', 'string', 'max:255'],
            'XepHangSao' => ['sometimes', 'integer', 'between:1,5'],
            'TrangThai' => ['sometimes', 'string', 'max:50'],
            'status' => ['sometimes', 'string', 'max:50'],
            'MoTa' => ['sometimes', 'string', 'nullable'],
            'GiaCoBanMotDem' => ['sometimes', 'integer', 'min:0'],
            'SoNguoiToiDa' => ['sometimes', 'integer', 'min:1'],
            'UrlAnhPhong' => ['sometimes', 'string', 'max:255'],
        ];

        $validated = $request->validate($rules);

        if (isset($validated['status']) && !isset($validated['TrangThai'])) {
            $validated['TrangThai'] = $validated['status'];
        }

        // Chỉ nhận các field thật có trong bảng Phong
        $allowed = [
            // SỬA LỖI: Xóa khoảng trắng thừa ở cuối 'TenLoaiPhong '
            'TenLoaiPhong',
            'SoPhong',
            'TenPhong',
            'XepHangSao',
            'TrangThai',
            'MoTa',
            'GiaCoBanMotDem',
            'SoNguoiToiDa',
            'UrlAnhPhong'
        ];

        $data = array_intersect_key($validated, array_flip($allowed));
        $data = array_filter($data, fn($v) => !is_null($v));

        $room->fill($data);
        $room->save();

        return response()->json(['success' => true, 'data' => $room]);
    }
}
