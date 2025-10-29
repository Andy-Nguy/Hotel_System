-- =========================================
-- 0️⃣ Cấu hình ban đầu
-- =========================================
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- =========================================
-- 1️⃣ Tạo database
-- =========================================
CREATE DATABASE IF NOT EXISTS `khachsan` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `khachsan`;

-- =========================================
-- 2️⃣ Bảng KHÁCH HÀNG
-- =========================================
CREATE TABLE IF NOT EXISTS `KhachHang` (
    `IDKhachHang` INT AUTO_INCREMENT PRIMARY KEY,
    `HoTen` VARCHAR(100) NOT NULL,
    `NgaySinh` DATE NULL,
    `SoDienThoai` VARCHAR(20) NULL,
    `Email` VARCHAR(100) UNIQUE NULL,
    `NgayDangKy` DATE DEFAULT (CURRENT_DATE),
    `TichDiem` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 3️⃣ Bảng TÀI KHOẢN NGƯỜI DÙNG
-- =========================================
CREATE TABLE IF NOT EXISTS `TaiKhoanNguoiDung` (
    `IDNguoiDung` INT AUTO_INCREMENT PRIMARY KEY,
    `IDKhachHang` INT NOT NULL,
    `MatKhau` VARCHAR(255) NOT NULL,
    `VaiTro` TINYINT(1) NOT NULL COMMENT '0: Khách hàng, 1: Nhân viên',
    FOREIGN KEY (`IDKhachHang`) REFERENCES `KhachHang`(`IDKhachHang`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 4️⃣ Bảng pending_users
-- =========================================
CREATE TABLE IF NOT EXISTS `pending_users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `hoten` VARCHAR(100),
    `email` VARCHAR(255) UNIQUE,
    `password` VARCHAR(255),
    `sodienthoai` VARCHAR(15) NULL,
    `ngaysinh` DATE NULL,
    `otp` CHAR(6),
    `otp_expired_at` DATETIME,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 5️⃣ Bảng LOẠI PHÒNG
-- =========================================
CREATE TABLE IF NOT EXISTS `LoaiPhong` (
    `IDLoaiPhong` CHAR(50) PRIMARY KEY,
    `TenLoaiPhong` VARCHAR(100) NOT NULL,
    `MoTa` TEXT,
    `UrlAnhLoaiPhong` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Xóa dữ liệu cũ nếu có
DELETE FROM `LoaiPhong`;

INSERT INTO `LoaiPhong` (`IDLoaiPhong`, `TenLoaiPhong`, `MoTa`, `UrlAnhLoaiPhong`) VALUES
('LP001', 'Phòng Standard', 'Phòng tiêu chuẩn cho 2 người', '1.jpg'),
('LP002', 'Phòng Deluxe', 'Phòng cao cấp với view đẹp', '2.jpg'),
('LP003', 'Phòng Family', 'Phòng gia đình', '3.jpg'),
('LP004', 'Phòng Suite', 'Phòng hạng sang, có phòng khách riêng', '4.jpg'),
('LP005', 'Phòng VIP', 'Phòng VIP với dịch vụ cao cấp nhất', '5.jpg');

-- =========================================
-- 6️⃣ Bảng PHÒNG
-- =========================================
CREATE TABLE IF NOT EXISTS `Phong` (
    `IDPhong` CHAR(50) PRIMARY KEY,
    `IDLoaiPhong` CHAR(50),
    `TenPhong` VARCHAR(50),
    `SoPhong` VARCHAR(20) NOT NULL,
    `MoTa` TEXT,
    `SoNguoiToiDa` INT,
    `GiaCoBanMotDem` DECIMAL(18,2),
    `XepHangSao` INT,
    `TrangThai` VARCHAR(50),
    `UrlAnhPhong` VARCHAR(255),
    FOREIGN KEY (`IDLoaiPhong`) REFERENCES `LoaiPhong`(`IDLoaiPhong`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DELETE FROM `Phong`;

INSERT INTO `Phong` (`IDPhong`, `IDLoaiPhong`, `TenPhong`, `SoPhong`, `MoTa`, `SoNguoiToiDa`, `GiaCoBanMotDem`, `XepHangSao`, `TrangThai`, `UrlAnhPhong`) VALUES
('P001', 'LP001', 'Phòng ST101', 'ST101', 'Phòng Standard tầng 1', 2, 500000, 3, 'Phòng trống', '1.jpg'),
('P002', 'LP001', 'Phòng ST102', 'ST102', 'Phòng Standard tầng 1', 3, 800000, 3, 'Đã đặt', '2.jpg'),
('P003', 'LP002', 'Phòng DL201', 'DL201', 'Phòng Deluxe view biển', 8, 1000000, 4, 'Phòng trống', '3.jpg'),
('P004', 'LP004', 'Phòng SU301', 'SU301', 'Suite có phòng khách riêng', 4, 1500000, 5, 'Phòng trống', '4.jpg'),
('P005', 'LP005', 'Phòng VIP401', 'VIP401', 'Phòng VIP tầng cao nhất', 5, 2500000, 5, 'Phòng trống', '5.jpg');

-- =========================================
-- 7️⃣ Bảng TIỆN NGHI & TIỆN NGHI PHÒNG
-- =========================================
CREATE TABLE IF NOT EXISTS `TienNghi` (
    `IDTienNghi` CHAR(50) PRIMARY KEY,
    `TenTienNghi` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DELETE FROM `TienNghi`;

INSERT INTO `TienNghi` (`IDTienNghi`, `TenTienNghi`) VALUES
('TN001', 'Wi-Fi miễn phí'),
('TN002', 'Tivi màn hình phẳng'),
('TN003', 'Máy lạnh'),
('TN004', 'Tủ lạnh mini'),
('TN005', 'Bồn tắm'),
('TN006', 'Ban công'),
('TN007', 'Két sắt'),
('TN008', 'Bữa sáng miễn phí');

CREATE TABLE IF NOT EXISTS `TienNghiPhong` (
    `IDTienNghiPhong` CHAR(50) PRIMARY KEY,
    `IDPhong` CHAR(50),
    `IDTienNghi` CHAR(50),
    FOREIGN KEY (`IDPhong`) REFERENCES `Phong`(`IDPhong`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`IDTienNghi`) REFERENCES `TienNghi`(`IDTienNghi`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 8️⃣ Bảng Đặt Phòng
-- =========================================
CREATE TABLE IF NOT EXISTS `DatPhong` (
    `IDDatPhong` VARCHAR(50) PRIMARY KEY,
    `IDKhachHang` INT NOT NULL,
    `IDPhong` CHAR(50) NOT NULL,
    `NgayDatPhong` DATE,
    `NgayNhanPhong` DATE NOT NULL,
    `NgayTraPhong` DATE NOT NULL,
    `SoDem` INT,
    `GiaPhong` DECIMAL(18,2) NOT NULL,
    `TongTien` DECIMAL(18,2) NOT NULL,
    `TienCoc` DECIMAL(18,2) DEFAULT 0,
    `TienConLai` DECIMAL(18,2),
    `TrangThai` INT,
    `TrangThaiThanhToan` INT,
    FOREIGN KEY (`IDKhachHang`) REFERENCES `KhachHang`(`IDKhachHang`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`IDPhong`) REFERENCES `Phong`(`IDPhong`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 9️⃣ Bảng HÓA ĐƠN
-- =========================================
CREATE TABLE IF NOT EXISTS `HoaDon` (
    `IDHoaDon` VARCHAR(50) PRIMARY KEY,
    `IDDatPhong` VARCHAR(50),
    `NgayLap` DATETIME,
    `TongTien` DECIMAL(18,2) NOT NULL,
    `TienCoc` DECIMAL(18,2) DEFAULT 0,
    `TienThanhToan` DECIMAL(18,2),
    `TrangThaiThanhToan` INT,
    `GhiChu` TEXT,
    FOREIGN KEY (`IDDatPhong`) REFERENCES `DatPhong`(`IDDatPhong`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 🔟 Bảng DỊCH VỤ & CHI TIẾT DỊCH VỤ
-- =========================================
CREATE TABLE IF NOT EXISTS `DichVu` (
    `IDDichVu` VARCHAR(50) PRIMARY KEY,
    `TenDichVu` VARCHAR(255),
    `TienDichVu` DECIMAL(18,2) DEFAULT 0,
    `HinhDichVu` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `TTDichVu` (
    `IDTTDichVu` VARCHAR(50) PRIMARY KEY,
    `IDDichVu` VARCHAR(50),
    `ThongTinDV` VARCHAR(255),
    FOREIGN KEY (`IDDichVu`) REFERENCES `DichVu`(`IDDichVu`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `CTHDDV` (
    `IDCTHDDV` VARCHAR(50) PRIMARY KEY,
    `IDHoaDon` VARCHAR(50) NOT NULL,
    `IDDichVu` VARCHAR(50),
    `TienDichVu` DECIMAL(18,2) DEFAULT 0,
    `ThoiGianThucHien` DATETIME,
    FOREIGN KEY (`IDHoaDon`) REFERENCES `HoaDon`(`IDHoaDon`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`IDDichVu`) REFERENCES `DichVu`(`IDDichVu`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DELETE FROM `DichVu`;

INSERT INTO `DichVu` (`IDDichVu`, `TenDichVu`, `TienDichVu`, `HinhDichVu`) VALUES
('DV001', 'Giặt ủi', 50000, 'DV_giat_ui_1761723207_p33g1c.jpg'),
('DV002', 'Ăn sáng buffet', 120000, 'DV_an_sang_buffet_1761723255_nhebyt.jpg'),
('DV003', 'Đưa đón sân bay', 300000, 'DV_dua_don_san_bay_1761723499_wmcpcu.jpg'),
('DV004', 'Thuê xe máy', 150000, 'DV_thue_xe_may_1761723507_2datgb.jpg'),
('DV005', 'Spa & Massage', 400000, 'DV_spa_massage_1761723536_nzzjps.jpg'),
('DV006', 'Phòng Gym', 80000, 'DV_phong_gym_1761723547_fsribe.jpg'),
('DV007', 'Hồ bơi vô cực', 100000, 'DV_ho_boi_vo_cuc_1761723560_ol0xsb.jpg'),
('DV008', 'Mini bar trong phòng', 200000, 'DV_mini_bar_trong_phong_1761723568_4p8ie1.jpg'),
('DV009', 'Tour tham quan địa phương', 350000, 'DV_tour_tham_quan_dia_phuong_1761723579_qv8cbq.jpg'),
('DV010', 'Dịch vụ dọn phòng đặc biệt', 70000, 'DV_dich_vu_don_phong_dac_biet_1761723588_ea58jy.jpg');

INSERT INTO `TTDichVu` (`IDTTDichVu`, `IDDichVu`, `ThongTinDV`) VALUES
('TT001', 'DV001', 'Dịch vụ giặt ủi quần áo, áp dụng cho khách lưu trú từ 2 đêm trở lên. Thời gian xử lý: 24h.'),
('TT002', 'DV002', 'Buffet sáng tự chọn tại nhà hàng chính, phục vụ từ 6:30 - 10:00 hàng ngày. Bao gồm đồ Âu và Á.'),
('TT003', 'DV003', 'Dịch vụ đưa đón sân bay bằng xe 7 chỗ riêng, đặt trước 12h. Miễn phí cho đặt phòng từ 3 đêm.'),
('TT004', 'DV004', 'Thuê xe máy 125cc, bao gồm mũ bảo hiểm và xăng cơ bản. Yêu cầu đặt cọc CMND hoặc 2 triệu VNĐ.'),
('TT005', 'DV005', 'Gói spa & massage thư giãn 60 phút, sử dụng tinh dầu thiên nhiên. Đặt lịch trước 1 ngày.'),
('TT006', 'DV006', 'Phòng gym hiện đại mở cửa 6:00 - 22:00, miễn phí cho khách nội trú. Có huấn luyện viên hỗ trợ.'),
('TT007', 'DV007', 'Hồ bơi vô cực tầng thượng, mở cửa 7:00 - 19:00. Miễn phí khăn và nước uống.'),
('TT008', 'DV008', 'Mini bar trong phòng được bổ sung hàng ngày: 2 chai nước, 1 lon bia, snack đóng gói.'),
('TT009', 'DV009', 'Tour tham quan địa phương 4 tiếng, bao gồm xe, hướng dẫn viên và nước uống. Khởi hành 8:00 sáng.'),
('TT010', 'DV010', 'Dịch vụ dọn phòng đặc biệt: thay ga trải giường cao cấp, bổ sung hoa tươi và khăn thơm.');

-- =========================================
-- 1️⃣1️⃣ Lịch sử đặt phòng
-- =========================================
CREATE TABLE IF NOT EXISTS `LichSuDatPhong` (
    `IDLichSu` INT AUTO_INCREMENT PRIMARY KEY,
    `IDDatPhong` VARCHAR(50) NOT NULL,
    `TrangThaiCu` VARCHAR(50),
    `TrangThaiMoi` VARCHAR(50),
    `NgayCapNhat` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `GhiChu` TEXT,
    FOREIGN KEY (`IDDatPhong`) REFERENCES `DatPhong`(`IDDatPhong`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 1️⃣2️⃣ Password resets
-- =========================================
CREATE TABLE IF NOT EXISTS `password_resets` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX (`email`),
    INDEX (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- ✅ Kích hoạt lại FK
-- =========================================
SET FOREIGN_KEY_CHECKS = 1;

-- =========================================
-- 1️⃣3️⃣ Kiểm tra dữ liệu mẫu
-- =========================================
SELECT * FROM KhachHang;
SELECT * FROM TaiKhoanNguoiDung;
SELECT * FROM LoaiPhong;
SELECT * FROM Phong;
SELECT * FROM DichVu;
SELECT * FROM HoaDon;
