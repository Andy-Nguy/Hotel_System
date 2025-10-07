<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use App\Models\Amenties\Phong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PhongController extends Controller
{
    // GET /api/phong
    // - Mặc định trả ít trường (dùng cho dropdown)
    // - Nếu ?with=tiennghi => trả kèm danh sách tiện nghi để render bảng
    public function index(Request $request)
    {
        $with = $request->query('with', '');
        $idLoai = $request->query('IDLoaiPhong'); // nhận filter

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
                    'IDPhong'       => (int) $p->IDPhong,
                    'SoPhong'       => $p->SoPhong,
                    'IDLoaiPhong'   => (int) $p->IDLoaiPhong,
                    'TenLoaiPhong'  => optional($p->loaiPhong)->TenLoaiPhong,
                    'XepHangSao'    => $p->XepHangSao,
                    'TrangThai'     => $p->TrangThai,
                    'MoTa'          => $p->MoTa,
                    'tien_nghi'     => $p->tienNghis->map(fn ($tn) => [
                        'IDTienNghi'   => (int) $tn->IDTienNghi,
                        'TenTienNghi'  => $tn->TenTienNghi,
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

        $data = $query->get(['Phong.IDPhong', 'Phong.SoPhong', 'lp.TenLoaiPhong']);
        return response()->json(['success' => true, 'data' => $data]);
    }

    // POST /api/phong
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IDLoaiPhong'  => ['required', 'integer', 'exists:LoaiPhong,IDLoaiPhong'],
            'SoPhong'      => ['required', 'string', 'max:20', 'unique:Phong,SoPhong'],
            'MoTa'         => ['nullable', 'string'],
            'UuTienChinh'  => ['nullable', 'boolean'],
            'XepHangSao'   => ['nullable', 'integer', 'between:1,5'],
            'TrangThai'    => ['nullable', 'string', Rule::in(['Trống', 'Đang sử dụng', 'Bảo trì'])],
            'UrlAnhPhong'  => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false, 'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $phong = Phong::create($validator->validated());
        return response()->json(['success' => true, 'data' => $phong], 201);
    }

    // PUT /api/phong/{phong}
    public function update(Request $request, Phong $phong)
    {
        $validator = Validator::make($request->all(), [
            'IDLoaiPhong'  => ['sometimes', 'required', 'integer', 'exists:LoaiPhong,IDLoaiPhong'],
            'SoPhong'      => ['sometimes', 'required', 'string', 'max:20', Rule::unique('Phong', 'SoPhong')->ignore($phong->IDPhong, 'IDPhong')],
            'MoTa'         => ['nullable', 'string'],
            'UuTienChinh'  => ['nullable', 'boolean'],
            'XepHangSao'   => ['nullable', 'integer', 'between:1,5'],
            'TrangThai'    => ['nullable', 'string', Rule::in(['Trống', 'Đang sử dụng', 'Bảo trì'])],
            'UrlAnhPhong'  => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false, 'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $phong->update($validator->validated());
        return response()->json(['success' => true, 'data' => $phong]);
    }

    // DELETE /api/phong/{phong}
    public function destroy(Phong $phong)
    {
        $phong->tienNghis()->detach(); // gỡ pivot trước để an toàn
        $phong->delete();
        return response()->json(['success' => true]);
    }

    // GET /api/phong/{phong}/tien-nghi
    public function tienNghiIds(Phong $phong)
    {
        $ids = $phong->tienNghis()
            ->pluck('TienNghi.IDTienNghi')
            ->map(fn ($id) => (int) $id)
            ->values();

        return response()->json(['success' => true, 'data' => $ids]);
    }

    // PUT /api/phong/{phong}/tien-nghi
    public function syncTienNghi(Request $request, Phong $phong)
    {
        $validator = Validator::make($request->all(), [
            'tien_nghi_ids'   => ['array'],
            'tien_nghi_ids.*' => ['integer', 'exists:TienNghi,IDTienNghi'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false, 'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $ids = $validator->validated()['tien_nghi_ids'] ?? [];
        $phong->tienNghis()->sync($ids);

        $assigned = $phong->tienNghis()
            ->orderBy('TenTienNghi')
            ->get(['TienNghi.IDTienNghi', 'TienNghi.TenTienNghi']);

        return response()->json(['success' => true, 'data' => $assigned]);
    }
}
