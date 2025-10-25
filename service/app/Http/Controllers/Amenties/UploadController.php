<?php

namespace App\Http\Controllers\Amenties;

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

            $baseDir = public_path('HomePage/img/slider');
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
                // Hỗ trợ cả URL tuyệt đối, đường dẫn tương đối và chỉ mỗi tên file
                $pathFromUrl = parse_url($originalUrl, PHP_URL_PATH) ?? '';
                $pathFromUrl = $pathFromUrl !== '' ? $pathFromUrl : (string) $originalUrl;
                $pathFromUrl = str_replace('\\', '/', $pathFromUrl);

                // Lấy basename an toàn
                $rawBasename = basename($pathFromUrl);
                // Chỉ cho phép ký tự chữ, số, gạch dưới, gạch ngang và dấu chấm trong tên file
                $safeBasename = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $rawBasename);

                $oldBase   = pathinfo($safeBasename, PATHINFO_FILENAME);
                $oldExtRaw = pathinfo($safeBasename, PATHINFO_EXTENSION);
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

                // Nếu thiếu tên base cũ -> tạo mới theo thời điểm để tránh tên rỗng
                $baseNameToUse = $oldBase !== '' ? $oldBase : ('room_' . Str::random(8) . '_' . time());
                $filename = $baseNameToUse . '.' . ($oldExt ?: $newExt ?: 'jpg');

                $targetDir = $baseDir; // Ghi đè trong thư mục slider mặc định
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

            // Chỉ trả về tên file để lưu vào database (không có đường dẫn đầy đủ)
            // Frontend sẽ tự ghép với /img/slider/ khi hiển thị
            return response()->json([
                'url'   => $filename,      // CHỈ TÊN FILE (vd: room_abc123_1234567890.jpg)
                'path'  => $filename,      // Giữ tương thích
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

    /**
     * DELETE /api/upload
     * Xóa file ảnh từ server
     */
    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'filename' => ['required', 'string', 'max:255'],
            ]);

            $filename = $request->input('filename');

            // Chỉ cho phép xóa file trong thư mục slider
            $baseDir = public_path('HomePage/img/slider');

            // Sanitize filename để tránh directory traversal
            $cleanFilename = basename($filename);
            $fullPath = $baseDir . DIRECTORY_SEPARATOR . $cleanFilename;

            // Kiểm tra file có tồn tại và nằm trong thư mục cho phép
            if (File::exists($fullPath) && strpos(realpath($fullPath), realpath($baseDir)) === 0) {
                File::delete($fullPath);
                return response()->json([
                    'message' => 'Xóa ảnh thành công.',
                    'filename' => $cleanFilename,
                ], 200);
            }

            return response()->json([
                'message' => 'File không tồn tại hoặc không hợp lệ.',
            ], 404);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Xóa ảnh thất bại.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
