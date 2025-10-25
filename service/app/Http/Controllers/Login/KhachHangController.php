<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Login\KhachHang;

class KhachHangController extends Controller
{
    /**
     * Return a list of customers (paginated).
     * Query params:
     *  - q: full-text like search against HoTen, Email, SoDienThoai
     *  - email: exact email filter
     *  - phone: exact phone filter
     *  - per_page: integer or 'all'
     *  - page: page number
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $email = $request->query('email');
        $phone = $request->query('phone');
        $perPage = $request->query('per_page', 20);

        $query = KhachHang::query();

        if ($q) {
            $query->where(function ($qr) use ($q) {
                $qr->where('HoTen', 'like', "%{$q}%")
                    ->orWhere('Email', 'like', "%{$q}%")
                    ->orWhere('SoDienThoai', 'like', "%{$q}%");
            });
        }
        if ($email) {
            $query->where('Email', $email);
        }
        if ($phone) {
            $query->where('SoDienThoai', $phone);
        }

        $query->orderBy('IDKhachHang', 'desc');

        // return all
        if (is_string($perPage) && strtolower($perPage) === 'all') {
            $items = $query->get();
            return response()->json(['data' => $items]);
        }

        $perPage = intval($perPage) > 0 ? intval($perPage) : 20;
        $p = $query->paginate($perPage);

        return response()->json([
            'data' => $p->items(),
            'meta' => [
                'total' => $p->total(),
                'per_page' => $p->perPage(),
                'current_page' => $p->currentPage(),
                'last_page' => $p->lastPage(),
            ],
        ]);
    }

    /**
     * Store a new customer.
     */
    public function store(Request $request)
    {
        $data = $request->only(['HoTen', 'NgaySinh', 'SoDienThoai', 'Email', 'NgayDangKy', 'TichDiem']);

        $rules = [
            'HoTen' => 'required|string|max:255',
            'Email' => 'nullable|email|max:255',
            'SoDienThoai' => 'nullable|string|max:50',
            'NgaySinh' => 'nullable|date',
            'NgayDangKy' => 'nullable|date',
            'TichDiem' => 'nullable|integer|min:0',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => 'validation', 'messages' => $validator->errors()], 422);
        }

        // optional: prevent duplicate email
        if (!empty($data['Email'])) {
            $exists = KhachHang::where('Email', $data['Email'])->exists();
            if ($exists) {
                return response()->json(['error' => 'conflict', 'message' => 'Email đã tồn tại'], 409);
            }
        }

        // set registration date if not provided
        if (empty($data['NgayDangKy'])) {
            $data['NgayDangKy'] = now()->toDateString();
        }

        $kh = KhachHang::create($data);

        return response()->json(['data' => $kh], 201);
    }

    /**
     * Update an existing customer
     * PUT /api/khachhang/{id}
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['HoTen', 'NgaySinh', 'SoDienThoai', 'Email', 'TichDiem']);

        $rules = [
            'HoTen' => 'required|string|max:255',
            'SoDienThoai' => 'nullable|string|max:50',
            'NgaySinh' => 'nullable|date',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => 'validation', 'messages' => $validator->errors()], 422);
        }

        $kh = KhachHang::find($id);
        if (!$kh) {
            return response()->json(['error' => 'not_found', 'message' => 'Khách hàng không tồn tại'], 404);
        }

        // check email uniqueness (exclude current)
        if (!empty($data['Email'])) {
            $exists = KhachHang::where('Email', $data['Email'])->where('IDKhachHang', '!=', $id)->exists();
            if ($exists) {
                return response()->json(['error' => 'conflict', 'message' => 'Email đã tồn tại'], 409);
            }
        }

        $kh->fill($data);
        $kh->save();

        return response()->json(['data' => $kh], 200);
    }



    // Tìm kiếm khách hàng (cho form đặt phòng trực tiếp)
    public function search(Request $request)
    {
        $sdt = $request->query('sdt');
        if (!$sdt) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Vui lòng cung cấp SĐT.'], 400);
        }

        try {
            // Tìm kiếm chính xác SĐT
            $khachHang = KhachHang::where('SoDienThoai', $sdt)->get();

            if ($khachHang->isEmpty()) {
                // Vẫn trả về success:true và data rỗng, đúng như JS mong đợi
                return response()->json(['success' => true, 'data' => []]);
            }

            // Trả về theo định dạng JS mong đợi
            return response()->json(['success' => true, 'data' => $khachHang]);
        } catch (\Exception $e) {
            // Ghi log lỗi để bạn có thể kiểm tra (storage/logs/laravel.log)
            logger()->error('Lỗi API KhachHang@search: ' . $e->getMessage());

            // Trả về 500 với thông báo lỗi
            return response()->json([
                'success' => false,
                'message' => 'Lỗi máy chủ nội bộ khi tìm kiếm.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
