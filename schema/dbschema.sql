
-- ⚙️ Cấu hình ban đầu
-- =========================================
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- =========================================
-- 1️⃣ Bảng KHÁCH HÀNG
-- =========================================
CREATE TABLE IF NOT EXISTS `KhachHang` (
    `IDKhachHang` INT AUTO_INCREMENT PRIMARY KEY,
    `HoTen` VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL,
    `NgaySinh` DATE NULL,
    `SoDienThoai` VARCHAR(20) CHARACTER SET utf8mb4 NULL,
    `Email` VARCHAR(100) CHARACTER SET utf8mb4 UNIQUE NULL,
    `NgayDangKy` DATE DEFAULT (CURRENT_DATE),
    `TichDiem` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 2️⃣ Bảng TÀI KHOẢN NGƯỜI DÙNG
-- =========================================
CREATE TABLE IF NOT EXISTS `TaiKhoanNguoiDung` (
    `IDNguoiDung` INT AUTO_INCREMENT PRIMARY KEY,
    `IDKhachHang` INT NOT NULL,
    `MatKhau` VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL,
    `VaiTro` TINYINT(1) NOT NULL COMMENT '0: Khách hàng, 1: Nhân viên',
    FOREIGN KEY (`IDKhachHang`) REFERENCES `KhachHang`(`IDKhachHang`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 3️⃣ Bảng PENDING USERS
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
-- 4️⃣ Bảng LOẠI PHÒNG
-- =========================================
CREATE TABLE IF NOT EXISTS `LoaiPhong` (
    `IDLoaiPhong` CHAR(50) PRIMARY KEY,
    `TenLoaiPhong` VARCHAR(100) NOT NULL,
    `MoTa` TEXT,
    `UrlAnhLoaiPhong` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `LoaiPhong` VALUES
('LP001', 'Phòng Standard', 'Phòng tiêu chuẩn cho 2 người', '1.jpg'),
('LP002', 'Phòng Deluxe', 'Phòng cao cấp với view đẹp', '2.jpg'),
('LP003', 'Phòng Family', 'Phòng gia đình', '3.jpg'),
('LP004', 'Phòng Suite', 'Phòng hạng sang, có phòng khách riêng', '4.jpg'),
('LP005', 'Phòng VIP', 'Phòng VIP với dịch vụ cao cấp nhất', '5.jpg');

-- =========================================
-- 5️⃣ Bảng PHÒNG
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Phong` VALUES
('P001', 'LP001', 'Phòng ST101', 'ST101', 'Phòng Standard tầng 1', 2, 500000, 3, 'Trống', '1.jpg'),
('P002', 'LP001', 'Phòng ST102', 'ST102', 'Phòng Standard tầng 1', 3, 800000, 3, 'Đã đặt', '2.jpg'),
('P003', 'LP002', 'Phòng DL201', 'DL201', 'Phòng Deluxe view biển', 8, 1000000, 4, 'Trống', '3.jpg'),
('P004', 'LP004', 'Phòng SU301', 'SU301', 'Suite có phòng khách riêng', 4, 1500000, 5, 'Trống', '4.jpg'),
('P005', 'LP005', 'Phòng VIP401', 'VIP401', 'Phòng VIP tầng cao nhất', 5, 2500000, 5, 'Trống', '5.jpg');

-- =========================================
-- 6️⃣ Tiện nghi & Tiện nghi phòng
-- =========================================
CREATE TABLE IF NOT EXISTS `TienNghi` (
    `IDTienNghi` CHAR(50) PRIMARY KEY,
    `TenTienNghi` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `TienNghi` VALUES
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
    FOREIGN KEY (`IDPhong`) REFERENCES `Phong`(`IDPhong`),
    FOREIGN KEY (`IDTienNghi`) REFERENCES `TienNghi`(`IDTienNghi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 7️⃣ Đặt phòng
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
    FOREIGN KEY (`IDKhachHang`) REFERENCES `KhachHang`(`IDKhachHang`),
    FOREIGN KEY (`IDPhong`) REFERENCES `Phong`(`IDPhong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 8️⃣ Hóa đơn
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 9️⃣ Dịch vụ & chi tiết dịch vụ
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `CTHDDV` (
    `IDCTHDDV` VARCHAR(50) PRIMARY KEY,
   `IDHoaDon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
    `IDDichVu` VARCHAR(50),
    `TienDichVu` DECIMAL(18,2) DEFAULT 0,
    `ThoiGianThucHien` DATETIME,
    FOREIGN KEY (`IDHoaDon`) REFERENCES `HoaDon`(`IDHoaDon`),
    FOREIGN KEY (`IDDichVu`) REFERENCES `DichVu`(`IDDichVu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =========================================
-- 🔟 Lịch sử đặt phòng
-- =========================================
CREATE TABLE IF NOT EXISTS `LichSuDatPhong` (
    `IDLichSu` INT AUTO_INCREMENT PRIMARY KEY,
    `IDDatPhong` VARCHAR(50) NOT NULL,
    `TrangThaiCu` VARCHAR(50),
    `TrangThaiMoi` VARCHAR(50),
    `NgayCapNhat` DATETIME DEFAULT (CURRENT_TIMESTAMP),
    `GhiChu` TEXT,
    FOREIGN KEY (`IDDatPhong`) REFERENCES `DatPhong`(`IDDatPhong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


SHOW CREATE TABLE HoaDon;

-- =========================================
-- ✅ Kích hoạt lại FK
-- =========================================
SET FOREIGN_KEY_CHECKS = 1;

SELECT * FROM datphong

SELECT  * FROM khachhang
SELECT * FROM taikhoannguoidung
SELECT * FROM phong
SELECT * FROM loaiphong

SELECT * FROM hoadon

SELECT * FROM dichvu

CREATE TABLE IF NOT EXISTS `password_resets` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX (`email`),
    INDEX (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `DichVu` (`IDDichVu`, `TenDichVu`, `TienDichVu`, `HinhDichVu`) VALUES
('DV001', 'Giặt ủi', 50000, 'giat_ui.jpg'),
('DV002', 'Ăn sáng buffet', 120000, 'an_sang_buffet.jpg'),
('DV003', 'Đưa đón sân bay', 300000, 'dua_don_san_bay.jpg'),
('DV004', 'Thuê xe máy', 150000, 'thue_xe_may.jpg'),
('DV005', 'Spa & Massage', 400000, 'spa_massage.jpg'),
('DV006', 'Phòng Gym', 80000, 'phong_gym.jpg'),
('DV007', 'Hồ bơi vô cực', 100000, 'ho_boi_vo_cuc.jpg'),
('DV008', 'Mini bar trong phòng', 200000, 'mini_bar.jpg'),
('DV009', 'Tour tham quan địa phương', 350000, 'tour_tham_quan.jpg'),
('DV010', 'Dịch vụ dọn phòng đặc biệt', 70000, 'don_phong_dac_biet.jpg');

SELECT * FROM HoaDon


