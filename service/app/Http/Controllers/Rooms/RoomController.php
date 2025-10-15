<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Rooms\RoomRepository;

class RoomController extends Controller
{
    /**
     * GET /api/rooms/available
     * Lấy tất cả phòng trống trong khoảng thời gian
     */
    private RoomRepository $roomRepository;
     public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }
    public function getAvailableRooms(Request $request)
    {
        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');

        // Validate ngày
        if (!$this->validateDates($checkIn, $checkOut)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng cung cấp ngày hợp lệ (check_in < check_out)',
            ], 400);
        }

        $rooms = $this->executeRoomQuery($checkIn, $checkOut);

        return response()->json([
            'status' => 'success',
            'data' => $rooms,
            'message' => empty($rooms) ? 'Không tìm thấy phòng trống nào.' : '',
        ]);
    }

    /**
     * GET /api/rooms/available/by_type
     * Lấy phòng trống theo loại phòng
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
            'message' => empty($rooms)
                ? 'Không tìm thấy phòng trống thuộc loại này.'
                : '',
        ]);
    }

    /**
     * Hàm dùng chung để truy vấn phòng trống
     */
    private function executeRoomQuery(string $checkIn, string $checkOut, ?string $roomTypeId = null)
    {
        $query = DB::table('Phong as P')
            ->join('LoaiPhong as LP', 'P.IDLoaiPhong', '=', 'LP.IDLoaiPhong')
            ->leftJoin('DatPhong as DP', function ($join) use ($checkIn, $checkOut) {
                $join->on('P.IDPhong', '=', 'DP.IDPhong')
                    ->whereIn('DP.TrangThai', [1, 2, 3]) // Đang đặt, đang ở, giữ chỗ
                    ->where(function ($q) use ($checkIn, $checkOut) {
                        $q->where('DP.NgayNhanPhong', '<', $checkOut)
                          ->where('DP.NgayTraPhong', '>', $checkIn);
                    });
            })
            ->whereNull('DP.IDDatPhong')
            ->where('P.TrangThai', 'Trống');

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
                // 'LP.GiaCoBanMotDem',
                'P.SoNguoiToiDa'
            )
            // ->orderBy('LP.GiaCoBanMotDem', 'ASC')
            ->get();
    }
    public function getAvailableRoomById()
{
    $checkIn  = $_GET['check_in'] ?? null;
    $checkOut = $_GET['check_out'] ?? null;
    $roomId   = $_GET['id'] ?? null;

    // Kiểm tra tham số
    if (empty($roomId)) {
        return response()->json(['error' => 'Vui lòng cung cấp ID phòng (id).'], 400);
    }

    if (!$this->validateDates($checkIn, $checkOut)) {
        return;
    }
    // Gọi hàm repository kiểm tra 1 phòng cụ thể
    $room = $this->roomRepository->findSingleAvailableRoom($checkIn, $checkOut, $roomId);

    if (!$room) {
        return response()->json(['error' => 'Phòng không trống hoặc bị trùng lịch đặt.'], 404);
    }

    return response()->json(['status' => 'success', 'data' => $room], 200);
}
    /**
     * Kiểm tra tính hợp lệ của ngày
     */
    private function validateDates(?string $checkIn, ?string $checkOut): bool
    {
        return !empty($checkIn)
            && !empty($checkOut)
            && strtotime($checkIn) < strtotime($checkOut);
    }
}
