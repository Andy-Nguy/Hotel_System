<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Throwable;

class UploadController extends Controller
{
    /**
     * POST /api/upload
     * - Nếu keepName=true và có originalUrl => ghi đè đúng tên file cũ (vd: /uploads/2.jpg).
     * - Ngược lại đặt tên ngẫu nhiên.
     * Trả về: { url: 'http://localhost:8000/uploads/..', path: '/uploads/..', ... }
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'file'        => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:8192'], // 8MB
                'keepName'    => ['nullable'],
                'originalUrl' => ['nullable', 'string'],
                'folder'      => ['nullable', 'string', 'max:50'], // nếu không keepName mà muốn subfolder (vd: rooms)
            ]);

            $f = $request->file('file');

            // Lấy metadata trước khi move (tránh lỗi trên file tạm)
            $originalName = $f->getClientOriginalName();
            $mime         = $f->getClientMimeType() ?: $f->getMimeType();
            $size         = $f->getSize(); // bytes

            $baseDir = public_path('uploads');
            File::ensureDirectoryExists($baseDir, 0755, true);

            $keepName    = filter_var($request->input('keepName'), FILTER_VALIDATE_BOOLEAN);
            $originalUrl = (string) $request->input('originalUrl', '');

            $targetDir = $baseDir;
            $filename  = null;

            // Chuẩn hoá ext để so
            $normalizeExt = function ($ext) {
                $ext = strtolower((string)$ext);
                return $ext === 'jpeg' ? 'jpg' : $ext;
            };

            if ($keepName && $originalUrl !== '') {
                // Lấy path từ URL (hỗ trợ absolute hoặc relative)
                $pathFromUrl = parse_url($originalUrl, PHP_URL_PATH) ?? '';
                $pathFromUrl = str_replace('\\', '/', $pathFromUrl);

                // Mặc định chỉ cho ghi đè trong /uploads
                $relativeAfterUploads = '';
                if (Str::startsWith($pathFromUrl, '/uploads/')) {
                    $relativeAfterUploads = substr($pathFromUrl, strlen('/uploads/')); // ví dụ: "rooms/2.jpg" hoặc "2.jpg"
                }

                // Lấy basename và dir (nếu không nằm trong /uploads thì vẫn dùng basename, lưu ở /uploads)
                $basename = pathinfo($pathFromUrl, PATHINFO_BASENAME);       // 2.jpg
                $dirPart  = $relativeAfterUploads !== '' ? pathinfo($relativeAfterUploads, PATHINFO_DIRNAME) : ''; // rooms hoặc .

                // Sanitizer dir: chỉ a-zA-Z0-9_- và dấu / giữa các segment
                $dirSanitized = '';
                if ($dirPart && $dirPart !== '.' && $dirPart !== DIRECTORY_SEPARATOR) {
                    $segments = array_filter(explode('/', trim($dirPart, '/.')));
                    $segments = array_map(function ($seg) {
                        return preg_replace('/[^a-zA-Z0-9_\-]/', '', $seg);
                    }, $segments);
                    $segments = array_filter($segments);
                    if (!empty($segments)) {
                        $dirSanitized = implode(DIRECTORY_SEPARATOR, $segments);
                    }
                }

                $oldBase   = pathinfo($basename, PATHINFO_FILENAME);       // 2
                $oldExtRaw = pathinfo($basename, PATHINFO_EXTENSION);      // jpg
                $oldExt    = $normalizeExt($oldExtRaw);

                // Ext của file đang upload
                $newExtRaw = $f->getClientOriginalExtension() ?: $f->extension() ?: '';
                $newExt    = $normalizeExt($newExtRaw);

                // Bắt người dùng giữ nguyên định dạng (để Content-Type đúng)
                if ($oldExt && $newExt && $oldExt !== $newExt) {
                    return response()->json([
                        'message' => 'Ảnh mới phải cùng định dạng .' . $oldExt . ' như ảnh cũ.',
                    ], 422);
                }

                $filename = $oldBase . '.' . ($oldExt ?: $newExt ?: 'jpg');

                $targetDir = $dirSanitized ? ($baseDir . DIRECTORY_SEPARATOR . $dirSanitized) : $baseDir;
                File::ensureDirectoryExists($targetDir, 0755, true);
            } else {
                // Đặt tên mới (random) + optional subfolder
                $subfolderRaw = (string) $request->input('folder', '');
                $subfolder    = trim(preg_replace('/[^a-zA-Z0-9_\-]/', '', $subfolderRaw));
                $targetDir    = $subfolder ? ($baseDir . DIRECTORY_SEPARATOR . $subfolder) : $baseDir;
                File::ensureDirectoryExists($targetDir, 0755, true);

                $ext = $normalizeExt($f->getClientOriginalExtension() ?: $f->extension() ?: 'jpg');
                $filename = 'room_' . Str::random(12) . '_' . time() . '.' . $ext;
            }

            $fullTarget = $targetDir . DIRECTORY_SEPARATOR . $filename;

            // Nếu tồn tại sẵn -> xoá để ghi đè
            if (File::exists($fullTarget)) {
                File::delete($fullTarget);
            }

            // Move file vào đích
            $f->move($targetDir, $filename);

            // Tạo relative path và absolute url trả về
            $relativeDir = trim(str_replace(public_path(), '', $targetDir), '\\/');
            if ($relativeDir === '') {
                // đề phòng trường hợp path khác biệt, gắn đúng 'uploads'
                $relativeDir = 'uploads';
            }

            $relativePath = '/' . trim($relativeDir, '/') . '/' . $filename; // /uploads[/...]/filename
            $absoluteUrl  = $request->getSchemeAndHttpHost() . $relativePath;

            return response()->json([
                'url'   => $absoluteUrl,   // FE sẽ dùng url này lưu DB
                'path'  => $relativePath,  // nếu FE parse path vẫn OK
                'name'  => $originalName,
                'mime'  => $mime,
                'size'  => $size,
            ], 201);

        } catch (Throwable $e) {
            // \Log::error($e);
            return response()->json([
                'message' => 'Upload thất bại.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
