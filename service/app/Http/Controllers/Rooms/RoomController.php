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
                'message' => 'Ngày nhận phòng phải trước ngày trả phòng.',
            ], 400);
        }

        $rooms = $this->executeRoomQuery($checkIn, $checkOut);

        return response()->json([
            'status' => 'success',
            'data' => $rooms,
            'message' => $rooms->isEmpty()
                ? 'Không tìm thấy phòng trống nào.'
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
        $roomTypeId = $request->query('room_type_id');

        if (!$this->validateDates($checkIn, $checkOut)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ngày nhận phòng phải trước ngày trả phòng.',
            ], 400);
        }

        if (empty($roomTypeId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng cung cấp mã loại phòng (room_type_id).',
            ], 400);
        }

        $rooms = $this->executeRoomQuery($checkIn, $checkOut, $roomTypeId);

        return response()->json([
            'status' => 'success',
            'data' => $rooms,
            'message' => $rooms->isEmpty()
                ? 'Không tìm thấy phòng trống thuộc loại này.'
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
        $roomId = $request->query('id');

        if (empty($roomId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng cung cấp ID phòng (id).',
            ], 400);
        }

        if (!$this->validateDates($checkIn, $checkOut)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ngày nhận phòng phải trước ngày trả phòng.',
            ], 400);
        }

        $room = $this->roomRepository->findSingleAvailableRoom($checkIn, $checkOut, $roomId);

        if (!$room) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phòng không trống hoặc đang được đặt.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $room,
        ]);
    }

    /**
     * ============================================
     * Hàm chung truy vấn phòng trống
     * ============================================
     */
    private function executeRoomQuery(string $checkIn, string $checkOut, ?string $roomTypeId = null)
    {
        $query = DB::table('Phong as P')
            ->join('LoaiPhong as LP', 'P.IDLoaiPhong', '=', 'LP.IDLoaiPhong')
            ->where('P.TrangThai', 'Trống')
            // ->where('P.IsActive', true) // nếu có cột này
            ->whereNotExists(function ($sub) {
                $sub->from('DatPhong as DP')
                    ->whereColumn('DP.IDPhong', 'P.IDPhong')
                    ->whereIn('DP.TrangThai', [1, 2, 3]); // Chờ xác nhận, Đã xác nhận, Đang sử dụng
            });

        if ($roomTypeId) {
            $query->where('P.IDLoaiPhong', $roomTypeId);
        }

        return $query
            ->select(
                'P.IDPhong',
                'P.SoPhong',
                'P.MoTa',
                'P.UrlAnhPhong',
                'LP.TenLoaiPhong',
                'P.SoNguoiToiDa'
            )
            ->orderBy('P.SoPhong')
            ->get();
    }

    /**
     * ============================================
     * Hàm kiểm tra tính hợp lệ của ngày
     * ============================================
     */
    private function validateDates(?string $checkIn, ?string $checkOut): bool
    {
        return !empty($checkIn)
            && !empty($checkOut)
            && strtotime($checkIn) < strtotime($checkOut);
    }
}
