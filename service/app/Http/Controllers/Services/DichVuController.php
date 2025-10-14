<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Services\DichVu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class DichVuController extends Controller
{
    // Ensure a single place to define the public services directory
    private const IMAGE_DIR_REL = 'services';
    private function servicesDir(): string
    {
        return public_path(self::IMAGE_DIR_REL); // D:\Nam4\php\Hotel_System\service\public\services
    }

    /**
     * Display a listing of the resource. (READ ALL)
     */
    public function index(Request $request)
    {
        $dichvus = DichVu::with('chiTiet')->get();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $dichvus,
            ], 200);
        }

        return view('services.dichvu', [
            'dichvus' => $dichvus,
            'viewMode' => 'list',
            'dichvu' => null
        ]);
    }

    /**
     * Show the form for creating a new resource. (CREATE FORM)
     */
    public function create(Request $request)
    {
        // Web only (API does not use create form)
        return view('services.dichvu', [
            'dichvus' => DichVu::all(),
            'viewMode' => 'create',
            'dichvu' => new DichVu()
        ]);
    }

    /**
     * Store a newly created resource in storage. (CREATE LOGIC)
     */
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

    /**
     * Display the specified resource. (READ ONE)
     */
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

    /**
     * Show the form for editing the specified resource. (EDIT FORM)
     */
    public function edit(Request $request, $id)
    {
        $dichvu = DichVu::findOrFail($id);

        return view('services.dichvu', [
            'dichvus' => DichVu::all(),
            'viewMode' => 'edit',
            'dichvu' => $dichvu
        ]);
    }

    /**
     * Update the specified resource in storage. (UPDATE LOGIC)
     * Always save new image into public/services and safely delete old image.
     */
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
                if (!empty($dichvu->HinhDichVu) && file_exists(public_path($dichvu->HinhDichVu))) {
                    @unlink(public_path($dichvu->HinhDichVu));
                }
                $dichvu->HinhDichVu = null;
            } elseif ($newPath) {
                // Delete old image only if path differs from new path
                if (!empty($dichvu->HinhDichVu)) {
                    $oldAbs = realpath(public_path($dichvu->HinhDichVu)) ?: '';
                    $newAbs = realpath(public_path($newPath)) ?: '';
                    if ($oldAbs && $newAbs && $oldAbs !== $newAbs && file_exists($oldAbs)) {
                        @unlink($oldAbs);
                    }
                }
                $dichvu->HinhDichVu = $newPath; // stores 'services/filename.ext'
            } else {
                // Could not save new image (invalid URL or download failed)
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không thể lưu hình ảnh mới. Vui lòng thử lại với URL/tệp hợp lệ.'
                    ], 422);
                }
                return redirect()->back()->with('error', 'Không thể lưu hình ảnh mới. Vui lòng thử lại.');
            }

            // Persist to DB (cập nhật vào database khách sạn)
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
            // Cập nhật tên/giá (không dùng trong avatar flow)
            $request->validate([
                'TenDichVu'  => 'required|string|max:100',
                'TienDichVu' => 'required|numeric|min:0',
            ]);
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

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy(Request $request, $id)
    {
        $dichvu = DichVu::findOrFail($id);

        // Xóa file hình (nếu có)
        if (!empty($dichvu->HinhDichVu) && file_exists(public_path($dichvu->HinhDichVu))) {
            @unlink(public_path($dichvu->HinhDichVu));
        }

        // Xóa các chi tiết liên quan
        $dichvu->chiTiet()->delete();

        // Xóa dịch vụ
        $dichvu->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa dịch vụ thành công!'
            ], 200);
        }

        return redirect()->route('dichvu.index')->with('success', 'Xóa dịch vụ thành công!');
    }

    /**
     * Helper: Lưu file upload vào public/services (trả về 'services/filename.ext')
     * Đường dẫn thực: D:\Nam4\php\Hotel_System\service\public\services
     */
    private function saveImage(\Illuminate\Http\UploadedFile $file, string $tenDichVu): string
    {
        $dir = $this->servicesDir();
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0775, true, true);
        }
        $ext = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        // Unique filename to avoid collision with old image
        $filename = 'DV_' . Str::slug($tenDichVu, '_') . '_' . time() . '_' . Str::lower(Str::random(6)) . '.' . $ext;
        $file->move($dir, $filename);
        return self::IMAGE_DIR_REL . '/' . $filename; // relative path saved to DB
    }

    /**
     * Helper: Tải ảnh từ URL về public/services (trả về 'services/filename.ext' hoặc null)
     */
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
            // Unique filename to avoid collision with old image
            $filename = 'DV_' . Str::slug($tenDichVu, '_') . '_' . time() . '_' . Str::lower(Str::random(6)) . '.' . $ext;

            File::put($dir . DIRECTORY_SEPARATOR . $filename, $response->body());

            return self::IMAGE_DIR_REL . '/' . $filename; // relative path saved to DB
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

    public function getChiTiet(Request $request, string $IDDichVu)
    {
        $dichvu = DichVu::findOrFail($IDDichVu);
        $chitiet = $dichvu->chiTiet()->get();
        return response()->json(['success' => true, 'data' => $chitiet]);
    }

    // Generate next service ID in format DV001, DV002, ... (5 chars: 'DV' + 3 digits)
    private function generateNextServiceId(): string
    {
        $next = DichVu::count() + 1;
        $id = 'DV' . str_pad((string)$next, 3, '0', STR_PAD_LEFT);
        // ensure unique in case of concurrent inserts or deleted rows
        while (DichVu::where('IDDichVu', $id)->exists()) {
            $next++;
            $id = 'DV' . str_pad((string)$next, 3, '0', STR_PAD_LEFT);
        }
        return $id;
    }
}
