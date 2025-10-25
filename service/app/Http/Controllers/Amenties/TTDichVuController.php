<?php
namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenties\DichVu;
use App\Models\Amenties\TTDichVu;
use Illuminate\Support\Str;

class TTDichVuController extends Controller
{
    /**
     * Display a listing of the resource. (READ ALL)
     * Hiển thị danh sách chi tiết của một dịch vụ.
     * Đây là màn hình chính để quản lý chi tiết TTDichVu.
     *
     * @param string $IDDichVu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, string $IDDichVu)
    {
        // 1. Lấy dịch vụ chính
        $dichvu = DichVu::findOrFail($IDDichVu);

        // 2. Lấy danh sách chi tiết liên quan
        $chitiet = $dichvu->chiTiet()->get();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $chitiet,
                'parent' => $dichvu,
            ], 200);
        }

        // Use the shared view with TTDV list mode
        return view('services.dichvu', [
            'dichvu'   => $dichvu,
            'chitiets' => $chitiet,
            'chitiet'  => null,
            'viewMode' => 'ttdv-list',
        ]);
    }

    /**
     * Show the form for creating a new resource. (CREATE FORM)
     * Hiển thị form tạo chi tiết mới.
     *
     * @param string $IDDichVu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request, string $IDDichVu)
    {
        $dichvu = DichVu::findOrFail($IDDichVu);

        return view('services.dichvu', [
            'dichvu'   => $dichvu,
            'chitiets' => $dichvu->chiTiet()->get(),
            'chitiet'  => null,
            'viewMode' => 'ttdv-create', // Chuyển sang chế độ form Thêm mới
        ]);
    }

    /**
     * Store a newly created resource in storage. (CREATE LOGIC)
     * Lưu chi tiết mới vào DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $IDDichVu
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request, string $IDDichVu)
    {
        $dichvu = DichVu::findOrFail($IDDichVu);

        $request->validate([
            'ThongTinDV' => 'required|string|max:255',
        ], [
            'ThongTinDV.required' => 'Thông tin chi tiết không được để trống.',
            'ThongTinDV.max' => 'Thông tin chi tiết không được vượt quá 255 ký tự.',
        ]);

        // Tạo IDTTDichVu thủ công (ví dụ: TTDV_ + UUID ngắn)
        $idTTDichVu = 'TTDV_' . Str::upper(Str::random(10));

        $ct = TTDichVu::create([
            'IDTTDichVu' => $idTTDichVu,
            'IDDichVu' => $dichvu->IDDichVu,
            'ThongTinDV' => $request->input('ThongTinDV'),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thêm thông tin chi tiết dịch vụ thành công!',
                'data' => $ct,
            ], 201);
        }

        // Chuyển hướng về danh sách chi tiết và flash thông báo
        return redirect()->route('chitiet.index', $IDDichVu)
                         ->with('success', 'Thêm thông tin chi tiết dịch vụ thành công!');
    }

    /**
     * Display the specified resource. (READ ONE)
     * Phương thức này thường không dùng trong Admin CRUD mà được tích hợp vào index.
     *
     * @param string $IDDichVu
     * @param string $IDTTDichVu
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $IDDichVu, string $IDTTDichVu)
    {
        if ($request->wantsJson()) {
            $ct = TTDichVu::where('IDDichVu', $IDDichVu)
                          ->where('IDTTDichVu', $IDTTDichVu)
                          ->first();

            if (!$ct) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy chi tiết dịch vụ.'], 404);
            }

            return response()->json(['success' => true, 'data' => $ct], 200);
        }

        // Redirect về trang index
        return redirect()->route('chitiet.index', $IDDichVu);
    }

    /**
     * Show the form for editing the specified resource. (UPDATE FORM)
     * Hiển thị form chỉnh sửa chi tiết.
     *
     * @param string $IDDichVu
     * @param  string  $IDTTDichVu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request, string $IDDichVu, string $IDTTDichVu)
    {
        $dichvu = DichVu::findOrFail($IDDichVu);
        $chitiet = TTDichVu::where('IDDichVu', $IDDichVu)
                            ->where('IDTTDichVu', $IDTTDichVu)
                            ->firstOrFail();

        return view('services.dichvu', [
            'dichvu'   => $dichvu,
            'chitiets' => $dichvu->chiTiet()->get(),
            'chitiet'  => $chitiet, // Đối tượng cần chỉnh sửa
            'viewMode' => 'ttdv-edit', // Chuyển sang chế độ form Chỉnh sửa
        ]);
    }

    /**
     * Update the specified resource in storage. (UPDATE LOGIC)
     * Cập nhật chi tiết vào DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $IDDichVu
     * @param  string  $IDTTDichVu
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $IDDichVu, string $IDTTDichVu)
    {
        $chitiet = TTDichVu::where('IDDichVu', $IDDichVu)
                            ->where('IDTTDichVu', $IDTTDichVu)
                            ->firstOrFail();

        $request->validate([
            'ThongTinDV' => 'required|string|max:255',
        ], [
            'ThongTinDV.required' => 'Thông tin chi tiết không được để trống.',
            'ThongTinDV.max' => 'Thông tin chi tiết không được vượt quá 255 ký tự.',
        ]);

        $chitiet->update([
            'ThongTinDV' => $request->input('ThongTinDV'),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thông tin chi tiết dịch vụ thành công!',
                'data' => $chitiet,
            ], 200);
        }

        // Chuyển hướng về danh sách chi tiết
        return redirect()->route('chitiet.index', $IDDichVu)
                         ->with('success', 'Cập nhật thông tin chi tiết dịch vụ thành công!');
    }

    /**
     * Remove the specified resource from storage. (DELETE LOGIC)
     * Xóa chi tiết khỏi DB.
     *
     * @param string $IDDichVu
     * @param  string  $IDTTDichVu
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request, string $IDDichVu, string $IDTTDichVu)
    {
        $chitiet = TTDichVu::where('IDDichVu', $IDDichVu)
                            ->where('IDTTDichVu', $IDTTDichVu)
                            ->firstOrFail();

        $chitiet->delete();

        if ($request->wantsJson()) {
            return response()->noContent(); // 204
        }

        // Chuyển hướng về danh sách chi tiết
        return redirect()->route('chitiet.index', $IDDichVu)
                         ->with('success', 'Xóa thông tin chi tiết dịch vụ thành công!');
    }
}
