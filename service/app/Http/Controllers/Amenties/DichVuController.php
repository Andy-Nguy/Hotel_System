<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenties\DichVu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class DichVuController extends Controller
{
    // Directory under public/ where service images are stored
    private const IMAGE_DIR_REL = 'HomePage/img/pricing';

    private function servicesDir(): string
    {
        return public_path(self::IMAGE_DIR_REL);
    }

    /**
     * GET /api/dichvu or web listing
     */
    // public function index(Request $request)
    // {
    //     $services = DichVu::with('thongTin')->get();

    //     $result = $services->map(function ($s) {
    //         return [
    //             'IDDichVu' => $s->IDDichVu,
    //             'TenDichVu' => $s->TenDichVu,
    //             'TienDichVu' => $s->TienDichVu,
    //             'HinhDichVu' => $s->HinhDichVu,
    //             'ThongTin' => $s->thongTin->map(function ($t) {
    //                 return [
    //                     'IDTTDichVu' => $t->IDTTDichVu,
    //                     'ThongTinDV' => $t->ThongTinDV,
    //                 ];
    //             })->values()->all(),
    //         ];
    //     });

    //     // return raw array of services (no wrapper)
    //     return response()->json($result->values()->all());
    // }

    public function index(Request $request)
    {
        // Logic 2: Dùng 'chiTiet'
        $dichvus = DichVu::with('chiTiet')->get();

        if ($request->wantsJson()) {
            // Trả về JSON cho trang quản lý
            return response()->json([
                'success' => true,
                'data' => $dichvus,
            ], 200);
        }

        // Trả về View cho trang quản lý
        return view('statistics.dichvu', [ // Hoặc 'statistics.dichvu'
            'dichvus' => $dichvus,
            'viewMode' => 'list',
            'dichvu' => null
        ]);
    }

    public function getPublicServices(Request $request)
    {
        // Logic 1: Dùng 'thongTin'
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

        // Trả về JSON mảng [...] cho khách hàng
        return response()->json($result->values()->all());
    }

    public function create(Request $request)
    {
        return view('statistics.dichvu', [
            'dichvus' => DichVu::all(),
            'viewMode' => 'create',
            'dichvu' => new DichVu(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'TenDichVu'  => 'required|string|max:100',
            'TienDichVu' => 'required|numeric|min:0',
            'HinhDichVu' => 'nullable',
        ]);

        $idDichVu = $this->generateNextServiceId();

        $hinhPath = null;
        if ($request->hasFile('HinhDichVu')) {
            $hinhPath = $this->saveImage($request->file('HinhDichVu'), $request->input('TenDichVu'));
        } else {
            $url = trim((string) $request->input('HinhDichVu'));
            if ($url !== '' && filter_var($url, FILTER_VALIDATE_URL)) {
                $hinhPath = $this->downloadImage($url, $request->input('TenDichVu'));
            }
        }

        $dv = DichVu::create([
            'IDDichVu'   => $idDichVu,
            'TenDichVu'  => $request->input('TenDichVu'),
            'TienDichVu' => $request->input('TienDichVu'),
            'HinhDichVu' => $hinhPath,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thêm dịch vụ mới thành công!',
                'data'    => $dv,
            ], 201);
        }

        return redirect()->route('dichvu.index')->with('success', 'Thêm dịch vụ mới thành công!');
    }

    public function show(Request $request, $id)
    {
        $dichvu = DichVu::with('chiTiet')->find($id);

        if ($request->wantsJson()) {
            if (!$dichvu) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy dịch vụ.'], 404);
            }
            return response()->json(['success' => true, 'data' => $dichvu], 200);
        }

        return redirect()->route('dichvu.index');
    }

    public function edit(Request $request, $id)
    {
        $dichvu = DichVu::findOrFail($id);

        return view('statistics.dichvu', [
            'dichvus' => DichVu::all(),
            'viewMode' => 'edit',
            'dichvu' => $dichvu,
        ]);
    }

    public function update(Request $request, $id)
    {
        $dichvu = DichVu::findOrFail($id);

        if ($request->hasFile('HinhDichVu') || $request->has('HinhDichVu')) {
            $removeImage = false;
            $newPath = null;

            if ($request->hasFile('HinhDichVu')) {
                $newPath = $this->saveImage($request->file('HinhDichVu'), $dichvu->TenDichVu);
            } else {
                $url = trim((string) $request->input('HinhDichVu'));
                if ($url === '') {
                    $removeImage = true;
                } elseif (filter_var($url, FILTER_VALIDATE_URL)) {
                    $newPath = $this->downloadImage($url, $dichvu->TenDichVu);
                }
            }

            if ($removeImage) {
                $oldPath = $this->imageAbsPath($dichvu->HinhDichVu);
                if ($oldPath && file_exists($oldPath)) {
                    @unlink($oldPath);
                }
                $dichvu->HinhDichVu = null;
            } elseif ($newPath) {
                if (!empty($dichvu->HinhDichVu)) {
                    $oldAbs = $this->imageAbsPath($dichvu->HinhDichVu) ?: '';
                    $newAbs = $this->imageAbsPath($newPath) ?: '';
                    if ($oldAbs && $newAbs && $oldAbs !== $newAbs && file_exists($oldAbs)) {
                        @unlink($oldAbs);
                    }
                }
                $dichvu->HinhDichVu = $newPath;
            } else {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không thể lưu hình ảnh mới. Vui lòng thử lại với URL/tệp hợp lệ.'
                    ], 422);
                }
                return redirect()->back()->with('error', 'Không thể lưu hình ảnh mới. Vui lòng thử lại.');
            }

            // Before saving image-based changes, ensure service is not used in booked/in-use rooms
            $inUse = DB::table('CTHDDV as c')
                ->join('DatPhong as dp', 'c.IDHoaDon', '=', 'dp.IDDatPhong')
                ->join('DatPhong as dps', 'dp.IDDatPhong', '=', 'dp.IDDatPhong')
                ->where('c.IDDichVu', $dichvu->IDDichVu)
                ->where(function ($q) {
                    // consider booking statuses that are active/confirmed (2: confirmed, 3: in-use)
                    $q->where('dp.TrangThai', 2)->orWhere('dp.TrangThai', 3);
                })
                ->exists();

            if ($inUse) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể chỉnh sửa hình ảnh/dịch vụ vì dịch vụ đang được sử dụng trong các đặt phòng đang hoạt động.'
                ], 400);
            }

            $dichvu->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật dịch vụ thành công!',
                    'data'    => $dichvu->fresh('chiTiet'),
                ], 200);
            }

            return redirect()->route('dichvu.index')->with('success', 'Cập nhật dịch vụ thành công!');
        } else {
            $request->validate([
                'TenDichVu'  => 'required|string|max:100',
                'TienDichVu' => 'required|numeric|min:0',
            ]);
            // Prevent updating basic info if service is used by active bookings
            $inUse = DB::table('CTHDDV as c')
                ->join('HoaDon as h', 'c.IDHoaDon', '=', 'h.IDHoaDon')
                ->join('DatPhong as dp', 'h.IDDatPhong', '=', 'dp.IDDatPhong')
                ->where('c.IDDichVu', $dichvu->IDDichVu)
                ->where(function ($q) {
                    $q->where('dp.TrangThai', 2)->orWhere('dp.TrangThai', 3);
                })
                ->exists();

            if ($inUse) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể chỉnh sửa dịch vụ này vì đang được sử dụng trong các đặt phòng đang hoạt động.'
                ], 400);
            }

            $dichvu->TenDichVu  = $request->input('TenDichVu');
            $dichvu->TienDichVu = $request->input('TienDichVu');
            $dichvu->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật dịch vụ thành công!',
                    'data'    => $dichvu->fresh('chiTiet'),
                ], 200);
            }

            return redirect()->route('dichvu.index')->with('success', 'Cập nhật dịch vụ thành công!');
        }
    }

    public function destroy(Request $request, $id)
    {
        $dichvu = DichVu::findOrFail($id);

        $old = $this->imageAbsPath($dichvu->HinhDichVu);
        if ($old && file_exists($old)) {
            @unlink($old);
        }

        // Prevent deletion if the service is currently used in active bookings or associated with occupied rooms
        $inUseBookings = DB::table('CTHDDV as c')
            ->join('HoaDon as h', 'c.IDHoaDon', '=', 'h.IDHoaDon')
            ->join('DatPhong as dp', 'h.IDDatPhong', '=', 'dp.IDDatPhong')
            ->where('c.IDDichVu', $dichvu->IDDichVu)
            ->where(function ($q) {
                $q->where('dp.TrangThai', 2)->orWhere('dp.TrangThai', 3);
            })
            ->exists();

        $inUseRooms = DB::table('CTHDDV as c')
            ->join('HoaDon as h', 'c.IDHoaDon', '=', 'h.IDHoaDon')
            ->join('DatPhong as dp', 'h.IDDatPhong', '=', 'dp.IDDatPhong')
            ->join('Phong as p', 'dp.IDPhong', '=', 'p.IDPhong')
            ->where('c.IDDichVu', $dichvu->IDDichVu)
            ->where(function ($q) {
                $q->whereNotNull('p.TrangThai')->where('p.TrangThai', '<>', 'Trống');
            })
            ->exists();

        if ($inUseBookings || $inUseRooms) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa dịch vụ này vì đang được sử dụng bởi các đặt phòng hoặc phòng đang có trạng thái không trống.'
            ], 400);
        }

        $dichvu->chiTiet()->delete();
        $dichvu->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa dịch vụ thành công!'
            ], 200);
        }

        return redirect()->route('dichvu.index')->with('success', 'Xóa dịch vụ thành công!');
    }

    private function saveImage(\Illuminate\Http\UploadedFile $file, string $tenDichVu): string
    {
        $dir = $this->servicesDir();
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0775, true, true);
        }
        $ext = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $filename = 'DV_' . Str::slug($tenDichVu, '_') . '_' . time() . '_' . Str::lower(Str::random(6)) . '.' . $ext;
        $file->move($dir, $filename);
        return $filename;
    }

    private function downloadImage(string $url, string $tenDichVu): ?string
    {
        try {
            $response = Http::timeout(10)->get($url);
            if (!$response->successful()) return null;

            $dir = $this->servicesDir();
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0775, true, true);
            }

            $mime = (string) ($response->header('Content-Type') ?? '');
            $ext  = $this->mimeToExtension($mime);
            $filename = 'DV_' . Str::slug($tenDichVu, '_') . '_' . time() . '_' . Str::lower(Str::random(6)) . '.' . $ext;

            File::put($dir . DIRECTORY_SEPARATOR . $filename, $response->body());

            return $filename;
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function mimeToExtension(string $mime): string
    {
        $mime_map = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
        ];
        return $mime_map[$mime] ?? 'jpg';
    }

    /**
     * Given a stored HinhDichVu value (filename, relative path or full relative path),
     * return the absolute filesystem path to the image under public/ if it exists.
     * Returns null for external URLs or if file doesn't exist.
     */
    private function imageAbsPath(?string $stored): ?string
    {
        if (empty($stored)) return null;
        $s = trim((string) $stored);
        // External URLs are not deletable locally
        if (preg_match('#^https?://#i', $s)) return null;

        // Normalize: remove leading slashes
        $s = preg_replace('#^[\\/]+#', '', $s);

        // If it's a bare filename (no directory), assume services dir
        if (strpos($s, '/') === false) {
            $rel = self::IMAGE_DIR_REL . DIRECTORY_SEPARATOR . $s;
        } else {
            // otherwise treat it as a path relative to public/
            $rel = $s;
        }

        $abs = public_path($rel);
        return file_exists($abs) ? $abs : null;
    }

    public function getChiTiet(Request $request, string $IDDichVu)
    {
        $dichvu = DichVu::findOrFail($IDDichVu);
        $chitiet = $dichvu->chiTiet()->get();
        return response()->json(['success' => true, 'data' => $chitiet]);
    }

    /**
     * Return services added after a given service ID (e.g. after=DV005)
     * GET /api/dichvu/updates?after=DV005
     */
    public function updates(Request $request)
    {
        $after = $request->query('after');
        // convert ID like 'DV005' -> numeric 5
        $afterNum = 0;
        if ($after && preg_match('/(\d+)/', $after, $m)) {
            $afterNum = intval($m[1]);
        }

        $all = DichVu::all();
        $news = $all->filter(function($dv) use ($afterNum) {
            if (preg_match('/(\d+)/', $dv->IDDichVu, $m)) {
                return intval($m[1]) > $afterNum;
            }
            return false;
        })->values();

        return response()->json(['success' => true, 'data' => $news], 200);
    }

    private function generateNextServiceId(): string
    {
        $next = DichVu::count() + 1;
        $id = 'DV' . str_pad((string)$next, 3, '0', STR_PAD_LEFT);
        while (DichVu::where('IDDichVu', $id)->exists()) {
            $next++;
            $id = 'DV' . str_pad((string)$next, 3, '0', STR_PAD_LEFT);
        }
        return $id;
    }

    public function topUsed(Request $request)
    {
        $limit = intval($request->query('limit', 5));
        // join CTHDDV -> DichVu and count occurrences
        $rows = DB::table('CTHDDV as c')
            ->join('DichVu as d', 'c.IDDichVu', '=', 'd.IDDichVu')
            ->selectRaw('d.TenDichVu as label, COUNT(*) as cnt')
            ->groupBy('d.TenDichVu')
            ->orderByDesc('cnt')
            ->get();

        $total = $rows->sum('cnt');
        $top = $rows->take($limit)->map(function($r){ return ['label' => $r->label, 'value' => (int)$r->cnt]; })->values();
        $others = max(0, $total - $top->sum('value'));
        $data = $top->toArray();
        if ($others > 0) $data[] = ['label' => 'Khác', 'value' => (int)$others];

        return response()->json(['data' => $data, 'total' => (int)$total]);
    }
}
