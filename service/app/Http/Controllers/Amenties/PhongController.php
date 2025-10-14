<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use App\Models\Amenties\Phong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function optional;
use function response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PhongController extends Controller
{
    // GET /api/phong
    public function index(Request $request)
    {
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
                    'IDPhong'      => $p->IDPhong,
                    'SoPhong'      => $p->SoPhong,
                    'IDLoaiPhong'  => $p->IDLoaiPhong,
                    'TenLoaiPhong' => optional($p->loaiPhong)->TenLoaiPhong,
                    'XepHangSao'   => $p->XepHangSao,
                    'TrangThai'    => $p->TrangThai,
                    'MoTa'         => $p->MoTa,
                    'tien_nghi'    => $p->tienNghis->map(fn ($tn) => [
                        'IDTienNghi'  => $tn->IDTienNghi,
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

        $data = $query->get(['Phong.IDPhong', 'Phong.SoPhong', 'lp.TenLoaiPhong']);
        return response()->json(['success' => true, 'data' => $data]);
    }

    // GET /api/phongs
    public function index1()
    {
        return response()->json(Phong::all());
    }

    // GET /api/phongs/{id}
    public function show($id)
    {
        $phong = Phong::with('tienNghis')->find($id);
        if (!$phong) return response()->json(null, 404);
        return response()->json($phong);
    }

    // GET /api/phongs/loai/{maLoai}
    public function searchByLoai($maLoai)
    {
        $phongs = Phong::with('tienNghis')
            ->where('IDLoaiPhong', $maLoai)
            ->where(function ($q) {
                $q->whereNull('TrangThai')
                  ->orWhere('TrangThai', '<>', 'Phòng hư');
            })
            ->get();
        return response()->json($phongs);
    }

    // POST /api/phong
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IDLoaiPhong' => ['required', 'string', 'exists:LoaiPhong,IDLoaiPhong'],
            'SoPhong'     => ['required', 'string', 'max:20', 'unique:Phong,SoPhong'],
            'MoTa'        => ['nullable', 'string'],
            'XepHangSao'  => ['nullable', 'integer', 'between:1,5'],
            'TrangThai'   => ['nullable', 'string', Rule::in(['Trống', 'Đang sử dụng', 'Bảo trì'])],
            'UrlAnhPhong' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        //  Tự động sinh ID kiểu P001, P002, ...
        $last = Phong::orderBy('IDPhong', 'desc')->first();
        $nextId = $last
            ? 'P' . str_pad((int) substr($last->IDPhong, 1) + 1, 3, '0', STR_PAD_LEFT)
            : 'P001';

        $phong = Phong::create(array_merge(
            ['IDPhong' => $nextId],
            $validator->validated()
        ));

        return response()->json(['success' => true, 'data' => $phong], 201);
    }

    // PUT /api/phong/{phong}
    public function update(Request $request, Phong $phong)
    {
        $validator = Validator::make($request->all(), [
            'IDLoaiPhong' => ['sometimes', 'required', 'string', 'exists:LoaiPhong,IDLoaiPhong'],
            'SoPhong'     => ['sometimes', 'required', 'string', 'max:20', Rule::unique('Phong', 'SoPhong')->ignore($phong->IDPhong, 'IDPhong')],
            'MoTa'        => ['nullable', 'string'],
            'XepHangSao'  => ['nullable', 'integer', 'between:1,5'],
            'TrangThai'   => ['nullable', 'string', Rule::in(['Trống', 'Đang sử dụng', 'Bảo trì'])],
            'UrlAnhPhong' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $phong->update($validator->validated());
        return response()->json(['success' => true, 'data' => $phong]);
    }

    // DELETE /api/phong/{phong}
    public function destroy(Phong $phong)
    {
        $phong->tienNghis()->detach();
        $phong->delete();
        return response()->json(['success' => true]);
    }

    // GET /api/phong/{phong}/tien-nghi
    public function tienNghiIds(Phong $phong)
    {
        $ids = $phong->tienNghis()
            ->pluck('TienNghi.IDTienNghi')
            ->values();

        return response()->json(['success' => true, 'data' => $ids]);
    }

    // PUT /api/phong/{phong}/tien-nghi
    public function syncTienNghi(Request $request, Phong $phong)
    {
        $validator = Validator::make($request->all(), [
            'tien_nghi_ids'   => ['array'],
            'tien_nghi_ids.*' => ['string', 'exists:TienNghi,IDTienNghi'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
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
