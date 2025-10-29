<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Rooms\RoomRepository;

class RoomController extends Controller
{
    private RoomRepository $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    /**
     * ============================================
     * GET /api/rooms/available
     * Lấy tất cả phòng trống trong khoảng thời gian
     * ============================================
     */
    public function getAvailableRooms(Request $request)
    {
        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');

        if (!$this->validateDates($checkIn, $checkOut)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ngày nhận phòng phải trước ngày trả phòng hoặc không hợp lệ.',
            ], 400);
        }

        $checkIn = $this->normalizeDateFormat($checkIn);
        $checkOut = $this->normalizeDateFormat($checkOut);

        $rooms = $this->executeRoomQuery($checkIn, $checkOut);

        return response()->json([
            'status' => 'success',
            'data' => $rooms,
            'message' => $rooms->isEmpty()
                ? 'Không tìm thấy phòng trống nào trong khoảng thời gian này.'
                : '',
        ]);
    }

    /**
     * ===================================================
     * GET /api/rooms/available/by_type
     * Lấy danh sách phòng trống theo loại phòng
     * ===================================================
     */
    public function getAvailableRoomsByType(Request $request)
    {
        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');
        // accept alternative param names from various frontends
        $roomTypeId = $request->query('room_type_id') ?? $request->query('room_type') ?? $request->query('type_id');

        if (empty($roomTypeId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng cung cấp mã loại phòng (room_type_id).',
            ], 400);
        }

        if (!$this->validateDates($checkIn, $checkOut)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ngày nhận phòng phải trước ngày trả phòng hoặc không hợp lệ.',
            ], 400);
        }

        $checkIn = $this->normalizeDateFormat($checkIn);
        $checkOut = $this->normalizeDateFormat($checkOut);

    $rooms = $this->executeRoomQuery($checkIn, $checkOut, $this->coerceId($roomTypeId));

        return response()->json([
            'status' => 'success',
            'data' => $rooms,
            'message' => $rooms->isEmpty()
                ? 'Không tìm thấy phòng trống thuộc loại này trong thời gian đã chọn.'
                : '',
        ]);
    }

    /**
     * ============================================
     * GET /api/rooms/available/by_id
     * Kiểm tra 1 phòng cụ thể có trống hay không
     * ============================================
     */
    public function getAvailableRoomById(Request $request)
    {
        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');
        // frontends sometimes send 'room' instead of 'id'
        $roomId = $request->query('id') ?? $request->query('room');

        if (empty($roomId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng cung cấp ID phòng (id).',
            ], 400);
        }

        if (!$this->validateDates($checkIn, $checkOut)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ngày nhận phòng phải trước ngày trả phòng hoặc không hợp lệ.',
            ], 400);
        }

        $checkIn = $this->normalizeDateFormat($checkIn);
        $checkOut = $this->normalizeDateFormat($checkOut);

    $room = $this->roomRepository->findSingleAvailableRoom($checkIn, $checkOut, $this->coerceId($roomId));

        if (!$room) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phòng không trống hoặc đang được đặt trong thời gian này.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $room,
        ]);
    }

    /**
     * ============================================
     * Hàm truy vấn phòng trống (dùng chung)
     * ============================================
     */
   private function executeRoomQuery(string $checkIn, string $checkOut, ?string $roomTypeId = null)
{
    $checkIn = $this->normalizeDateFormat($checkIn);
    $checkOut = $this->normalizeDateFormat($checkOut);

    $query = DB::table('Phong as P')
        ->join('LoaiPhong as LP', 'P.IDLoaiPhong', '=', 'LP.IDLoaiPhong')
        ->where('P.TrangThai', 'Phòng trống')
        ->whereNotExists(function ($sub) use ($checkIn, $checkOut) {
            $sub->from('DatPhong as DP')
                ->whereColumn('DP.IDPhong', 'P.IDPhong')
                ->whereIn('DP.TrangThai', [1, 2, 3]) // Chờ, xác nhận, đang sử dụng
                ->where(function ($w) use ($checkIn, $checkOut) {
                    $w->whereRaw('DATE(DP.NgayNhanPhong) < DATE(?)', [$checkOut])
                      ->whereRaw('DATE(DP.NgayTraPhong) > DATE(?)', [$checkIn]);
                });
        });

    if ($roomTypeId) {
        // defensive: allow numeric IDs or string codes
        if (is_numeric($roomTypeId)) {
            $query->where('P.IDLoaiPhong', (int)$roomTypeId);
        } else {
            // if frontends pass a code (e.g. 'DELUXE'), try matching against LoaiPhong code or name
            $query->where(function($q) use ($roomTypeId) {
                $q->where('P.IDLoaiPhong', $roomTypeId)
                  ->orWhere('LP.TenLoaiPhong', 'like', '%' . $roomTypeId . '%');
            });
        }
    }

    return $query
        ->select(
            'P.IDPhong',
            'P.SoPhong',
            'P.MoTa',
            'P.GiaCoBanMotDem',
            'P.UrlAnhPhong',
            'LP.TenLoaiPhong',
            'P.SoNguoiToiDa'
        )
        ->orderBy('P.SoPhong')
        ->get();
}


    /**
     * ============================================
     * Kiểm tra hợp lệ ngày
     * ============================================
     */
    private function validateDates(?string $checkIn, ?string $checkOut): bool
    {
        if (empty($checkIn) || empty($checkOut)) {
            return false;
        }

        $normIn = $this->normalizeDateFormat($checkIn);
        $normOut = $this->normalizeDateFormat($checkOut);

        if (!$normIn || !$normOut) {
            return false;
        }

        $timeIn = strtotime($normIn);
        $timeOut = strtotime($normOut);

        return ($timeIn && $timeOut && $timeIn < $timeOut);
    }

    /**
     * ============================================
     * Chuẩn hóa định dạng ngày
     * ============================================
     * Hỗ trợ:
     *  - dd/mm/yyyy
     *  - mm/dd/yyyy
     *  - yyyy-mm-dd
     */
    private function normalizeDateFormat(string $date): string
{
    if (strpos($date, '/') !== false) {
        $parts = explode('/', $date);
        if (count($parts) === 3) {
            [$a, $b, $c] = $parts;

            // Nếu $a <= 12 và $b <= 31 → giả định định dạng Mỹ (MM/DD/YYYY)
            if ((int)$a <= 12 && (int)$b <= 31) {
                return sprintf('%04d-%02d-%02d', $c, $a, $b);
            }

            // Nếu $a > 12 → định dạng Việt (DD/MM/YYYY)
            if ((int)$a > 12 && (int)$b <= 12) {
                return sprintf('%04d-%02d-%02d', $c, $b, $a);
            }

            // Mặc định fallback: dd/mm/yyyy
            return sprintf('%04d-%02d-%02d', $c, $b, $a);
        }
    }

    // Giữ nguyên nếu đã đúng dạng yyyy-mm-dd
    return $date;
}

    /**
     * Try to coerce a provided id value to an integer if numeric
     */
    private function coerceId($val)
    {
        if (is_numeric($val)) return (int)$val;
        return $val;
    }
}
