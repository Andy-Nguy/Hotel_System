<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use App\Models\Amenties\Phong;
use App\Models\Amenties\LoaiPhong;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PhongController extends Controller
{
    // GET /api/phong?with=tiennghi&IDLoaiPhong=...
    public function index(Request $request)
    {
        $with = $request->query('with', '');
        $idLoai = $request->query('IDLoaiPhong');

        if (str_contains(strtolower($with), 'tiennghi')) {
            $roomQuery = Phong::query()
                ->leftJoin('LoaiPhong as lp', 'lp.IDLoaiPhong', '=', 'Phong.IDLoaiPhong')
                ->orderBy('Phong.SoPhong');

            if ($idLoai) {
                $roomQuery->where('Phong.IDLoaiPhong', $idLoai);
            }

            $rooms = $roomQuery->get([
                'Phong.IDPhong',
                'Phong.SoPhong',
                'Phong.IDLoaiPhong',
                'lp.TenLoaiPhong',
                'Phong.XepHangSao',
                'Phong.TrangThai',
                'Phong.MoTa',
            ]);

            $roomIds = $rooms->pluck('IDPhong')->all();

            $amenitiesByRoom = [];
            if (!empty($roomIds)) {
                $amenities = DB::table('TienNghiPhong as tnp')
                    ->join('TienNghi as tn', 'tnp.IDTienNghi', '=', 'tn.IDTienNghi')
                    ->whereIn('tnp.IDPhong', $roomIds)
                    ->orderBy('tn.TenTienNghi')
                    ->get(['tnp.IDPhong', 'tn.IDTienNghi', 'tn.TenTienNghi']);

                foreach ($amenities as $a) {
                    $amenitiesByRoom[$a->IDPhong][] = [
                        'IDTienNghi'  => $a->IDTienNghi,
                        'TenTienNghi' => $a->TenTienNghi,
                    ];
                }
            }

            $data = $rooms->map(function ($p) use ($amenitiesByRoom) {
                return [
                    'IDPhong'      => $p->IDPhong,
                    'SoPhong'      => $p->SoPhong,
                    'IDLoaiPhong'  => $p->IDLoaiPhong,
                    'TenLoaiPhong' => $p->TenLoaiPhong ?? null,
                    'XepHangSao'   => $p->XepHangSao,
                    'TrangThai'    => $p->TrangThai,
                    'MoTa'         => $p->MoTa,
                    'TienNghis'    => collect($amenitiesByRoom[$p->IDPhong] ?? [])->values(),
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

        $data = $query->get(['Phong.IDPhong', 'Phong.SoPhong', 'lp.TenLoaiPhong']);
        return response()->json(['success' => true, 'data' => $data]);
    }

    // GET /api/phongs (frontend đang dùng)
    public function index1()
    {
        return response()->json(Phong::all());
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

        // Rule validate (chỉ áp dụng khi field có gửi lên - 'sometimes')
        // LƯU Ý: tên bảng trong Rule::unique dùng đúng tên bảng thật (ví dụ 'Phong' nếu bạn dùng SQL Server/Oracle).
        $rules = [
            'IDPhong'       => ['sometimes','string','max:50', Rule::unique('Phong','IDPhong')->ignore($room->IDPhong, 'IDPhong')],
            'SoPhong'       => ['sometimes','string','max:50', Rule::unique('Phong','SoPhong')->ignore($room->SoPhong, 'SoPhong')],
            'IDLoaiPhong'   => ['sometimes','string','max:50'],
            'XepHangSao'    => ['sometimes','integer','between:1,5'],
            'TrangThai'     => ['sometimes','string','max:50'],
            'status'        => ['sometimes','string','max:50'], // hỗ trợ từ frontend
            'MoTa'          => ['sometimes','string','nullable'],
            'GiaPhong'      => ['sometimes','integer','min:0'],
            'SoNguoiToiDa'  => ['sometimes','integer','min:1'],
            'UrlAnhPhong'   => ['sometimes','string','max:255'],
        ];

        $validated = $request->validate($rules);

        // Map status (frontend) -> TrangThai (DB)
        if (isset($validated['status']) && !isset($validated['TrangThai'])) {
            $validated['TrangThai'] = $validated['status'];
        }

        // Chỉ nhận các field thật có trong bảng Phong
        $allowed = [
            'IDPhong','SoPhong','IDLoaiPhong',
            'XepHangSao','TrangThai','MoTa',
            'GiaPhong','SoNguoiToiDa','UrlAnhPhong'
        ];

        $data = array_intersect_key($validated, array_flip($allowed));
        // Loại null để không overwrite thành NULL
        $data = array_filter($data, fn($v) => !is_null($v));

        $room->fill($data);
        $room->save();

        return response()->json(['success' => true, 'data' => $room]);
    }
}
