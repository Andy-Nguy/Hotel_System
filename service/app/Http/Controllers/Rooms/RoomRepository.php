<?php

namespace App\Http\Controllers\Rooms;

use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;

class RoomRepository
{
    private PDO $db;

    public function __construct()
    {
        // Laravel style: use DB facade to get PDO connection
        $this->db = DB::connection()->getPdo();
    }

    /**
     * Lấy tất cả phòng trống trong khoảng ngày (mọi loại phòng)
     */
    public function findAvailableRooms(string $checkInDate, string $checkOutDate): array
    {
        return $this->executeRoomQuery($checkInDate, $checkOutDate, null);
    }

    /**
     * Lấy các phòng trống theo loại phòng
     */
    public function findAvailableRoomsByType(string $checkInDate, string $checkOutDate, string $roomTypeId): array
    {
        return $this->executeRoomQuery($checkInDate, $checkOutDate, $roomTypeId);
    }

    /**
     * Kiểm tra 1 phòng cụ thể có trống không
     */
    public function findSingleAvailableRoom(string $checkInDate, string $checkOutDate, string $roomId): ?array
    {
        $sql = "
            SELECT
                P.IDPhong, P.SoPhong, P.SoNguoiToiDa,
                LP.TenLoaiPhong,  P.MoTa, P.UrlAnhPhong
            FROM
                Phong P
            JOIN
                LoaiPhong LP ON P.IDLoaiPhong = LP.IDLoaiPhong
            LEFT JOIN
                DatPhong DP ON P.IDPhong = DP.IDPhong
                AND DP.TrangThai IN (1, 2, 3)
                AND DP.NgayNhanPhong < :checkOutDate
                AND DP.NgayTraPhong > :checkInDate
            WHERE
                DP.IDDatPhong IS NULL
                AND P.TrangThai = 'Phòng trống'
                AND P.IDPhong = :roomId
            LIMIT 1;
        ";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':checkInDate', $checkInDate);
            $stmt->bindParam(':checkOutDate', $checkOutDate);
            $stmt->bindParam(':roomId', $roomId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            logger()->error("RoomRepository::findSingleAvailableRoom error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Hàm nội bộ thực thi truy vấn kiểm tra phòng trống
     */
    private function executeRoomQuery(string $checkInDate, string $checkOutDate, ?string $roomTypeId): array
    {
        $sql = "
            SELECT
                P.IDPhong, P.SoPhong, P.SoNguoiToiDa,
                LP.TenLoaiPhong,  P.MoTa, P.UrlAnhPhong
            FROM
                Phong P
            JOIN
                LoaiPhong LP ON P.IDLoaiPhong = LP.IDLoaiPhong
            LEFT JOIN
                DatPhong DP ON P.IDPhong = DP.IDPhong
                AND DP.TrangThai IN (1, 2, 3)
                AND DP.NgayNhanPhong < :checkOutDate
                AND DP.NgayTraPhong > :checkInDate
            WHERE
                DP.IDDatPhong IS NULL
                AND P.TrangThai = 'Phòng trống'
                " . ($roomTypeId ? "AND P.IDLoaiPhong = :roomTypeId" : "") . "
            ORDER BY
                LP.GiaMotDem ASC;
        ";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':checkInDate', $checkInDate);
            $stmt->bindParam(':checkOutDate', $checkOutDate);
            if ($roomTypeId) {
                $stmt->bindParam(':roomTypeId', $roomTypeId);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            logger()->error("RoomRepository::executeRoomQuery error: " . $e->getMessage());
            return [];
        }
    }
}
