

-- =========================================
-- 1. Khách Hàng (online)
-- =========================================
CREATE TABLE IF NOT EXISTS `KhachHang` (
      IDKhachHang INT AUTO_INCREMENT PRIMARY KEY,
    `HoTen` VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL,
    `NgaySinh` DATE NULL,
    `SoDienThoai` VARCHAR(20) CHARACTER SET utf8mb4 NULL,
    `Email` VARCHAR(100) CHARACTER SET utf8mb4 UNIQUE NULL,
    `NgayDangKy` DATE DEFAULT (CURRENT_DATE),
    `TichDiem` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tài khoản người dùng (login)
CREATE TABLE IF NOT EXISTS `TaiKhoanNguoiDung` (
   IDNguoiDung INT AUTO_INCREMENT PRIMARY KEY,
    IDKhachHang INT NOT NULL,
    `MatKhau` VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL,
    `VaiTro` TINYINT(1) NOT NULL COMMENT '0: Khách hàng, 1: Nhân viên', -- MySQL uses TINYINT instead of BIT
    FOREIGN KEY (`IDKhachHang`) REFERENCES `KhachHang`(`IDKhachHang`) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pending_users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    hoten VARCHAR(100),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    sodienthoai VARCHAR(15) NULL,
    ngaysinh DATE NULL,
    otp CHAR(6),
    otp_expired_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `password_resets` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX (`email`),
    INDEX (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


SELECT * FROM TaiKhoanNguoiDung
INSERT INTO KhachHang (IDKhachHang, HoTen, NgaySinh, SoDienThoai, Email, NgayDangKy, TichDiem)
VALUES ('', 'Nguyễn Văn An', '1990-05-15', '0905123456', 'an.nv@hotel.com', CURRENT_DATE, 0);

-- Thêm tài khoản nhân viên vào bảng TaiKhoanNguoiDung
INSERT INTO TaiKhoanNguoiDung (IDNguoiDung, IDKhachHang, MatKhau, VaiTro)

-- =========================================
-- 2. Khách Sạn, Loại Phòng, Phòng, Ảnh
-- =========================================
CREATE TABLE IF NOT EXISTS `LoaiPhong` (
    `IDLoaiPhong` CHAR(50) PRIMARY KEY,
    `TenLoaiPhong` VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL,
    `MoTa` TEXT CHARACTER SET utf8mb4 NULL,
    `UrlAnhLoaiPhong` VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `LoaiPhong` (`IDLoaiPhong`, `TenLoaiPhong`, `MoTa`, `UrlAnhLoaiPhong`) VALUES
('LP001', 'Phòng Standard', 'Phòng tiêu chuẩn cho 2 người', '1.jpg'),
('LP002', 'Phòng Deluxe', 'Phòng cao cấp với view đẹp', '2.jpg'),
('LP003', 'Phòng Family', 'Phòng gia đình', '3.jpg'),
('LP004', 'Phòng Suite', 'Phòng hạng sang, có phòng khách riêng', '4.jpg'),
('LP005', 'Phòng VIP', 'Phòng VIP với dịch vụ cao cấp nhất', '5.jpg');

CREATE TABLE IF NOT EXISTS `Phong` (
    `IDPhong` CHAR(50) PRIMARY KEY,
    `IDLoaiPhong` CHAR(50) NULL,
    `TenPhong` VARCHAR(20) CHARACTER SET utf8mb4 NULL, -- Thêm cột (không bắt buộc)
    `SoPhong` VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL,
    `MoTa` TEXT CHARACTER SET utf8mb4 NULL,
    `SoNguoiToiDa` INT NULL,
    `GiaCoBanMotDem` DECIMAL(18,2) NULL,
    `XepHangSao` INT NULL,
    `TrangThai` VARCHAR(50) CHARACTER SET utf8mb4 NULL COMMENT 'Trống, Đã đặt, Đang sử dụng, Phòng hư',
    `UrlAnhPhong` VARCHAR(255) NULL,
    FOREIGN KEY (`IDLoaiPhong`) REFERENCES `LoaiPhong`(`IDLoaiPhong`) 
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SELECT * FROM KhachHang

INSERT IGNORE INTO `Phong` (`IDPhong`, `IDLoaiPhong`, `TenPhong`, `SoPhong`, `MoTa`, `SoNguoiToiDa`, `GiaCoBanMotDem`, `XepHangSao`, `TrangThai`, `UrlAnhPhong`) VALUES
('P001', 'LP001', 'ST101', 'ST101', 'Phòng Standard tầng 1', 2, 500000.00, 3, 'Trống', '1.jpg'),
('P002', 'LP001', 'ST102', 'ST102', 'Phòng Standard tầng 1', 3, 800000.00, 3, 'Đã đặt', '2.jpg'),
('P003', 'LP002', 'DL201', 'DL201', 'Phòng Deluxe view biển', 8, 1000000.00, 4, 'Trống', '3.jpg'),
('P004', 'LP004', 'SU301', 'SU301', 'Suite có phòng khách riêng', 4, 1500000.00, 5, 'Trống', '4.jpg'),
('P005', 'LP005', 'VIP401', 'VIP401', 'Phòng VIP tầng cao nhất', 5, 2500000.00, 5, 'Trống', '5.jpg');

-- (Bỏ bảng AnhLoaiPhong vì đã comment và không cần thiết nếu chỉ lưu 1 ảnh)

-- =========================================
-- 3. Tiện Nghi
-- =========================================
CREATE TABLE IF NOT EXISTS `TienNghi` (
    `IDTienNghi` CHAR(50) PRIMARY KEY,
    `TenTienNghi` VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `TienNghi` (`IDTienNghi`, `TenTienNghi`) VALUES
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
    `IDPhong` CHAR(50) NOT NULL,
    `IDTienNghi` CHAR(50) NOT NULL,
    FOREIGN KEY (`IDPhong`) REFERENCES `Phong`(`IDPhong`) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`IDTienNghi`) REFERENCES `TienNghi`(`IDTienNghi`) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `TienNghiPhong` (`IDTienNghiPhong`, `IDPhong`, `IDTienNghi`) VALUES
('TNP001', 'P001', 'TN001'),
('TNP002', 'P001', 'TN002'),
('TNP003', 'P001', 'TN003'),
('TNP004', 'P002', 'TN001'),
('TNP005', 'P002', 'TN002'),
('TNP006', 'P002', 'TN003'),
('TNP007', 'P002', 'TN004'),
('TNP008', 'P003', 'TN001'),
('TNP009', 'P003', 'TN002'),
('TNP010', 'P003', 'TN003'),
('TNP011', 'P003', 'TN004'),
('TNP012', 'P003', 'TN006'),
('TNP013', 'P004', 'TN001'),
('TNP014', 'P004', 'TN002'),
('TNP015', 'P004', 'TN003'),
('TNP016', 'P004', 'TN004'),
('TNP017', 'P004', 'TN005'),
('TNP018', 'P004', 'TN006'),
('TNP019', 'P004', 'TN007'),
('TNP020', 'P005', 'TN001'),
('TNP021', 'P005', 'TN002'),
('TNP022', 'P005', 'TN003'),
('TNP023', 'P005', 'TN004'),
('TNP024', 'P005', 'TN005'),
('TNP025', 'P005', 'TN006'),
('TNP026', 'P005', 'TN007'),
('TNP027', 'P005', 'TN008');

-- =========================================
-- 4. Đặt Phòng
-- =========================================
CREATE TABLE IF NOT EXISTS `DatPhong` (
    `IDDatPhong` CHAR(50) PRIMARY KEY,
      IDKhachHang INT NULL,
    `IDPhong` CHAR(50) NOT NULL,
    `NgayDatPhong` DATE DEFAULT (CURRENT_DATE),
    `NgayNhanPhong` DATE NOT NULL,
    `NgayTraPhong` DATE NOT NULL,
    `SoDem` INT NULL,
    `TongTien` DECIMAL(18,2) NOT NULL,
    `TienCoc` DECIMAL(18,2) DEFAULT 0,
    `TrangThai` INT NOT NULL COMMENT '1:Chờ Xác Nhận, 2:Đã Xác Nhận, 0:Đã Hủy, 3:Đang sử dụng, 4:Hoàn thành',
    `TrangThaiThanhToan` INT NOT NULL COMMENT '1:Chưa TT, 2:Đã TT, 0:Đã cọc, -1:Chưa cọc',
    FOREIGN KEY (`IDKhachHang`) REFERENCES `KhachHang`(`IDKhachHang`) 
        ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (`IDPhong`) REFERENCES `Phong`(`IDPhong`) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 5. Hóa Đơn
-- =========================================
CREATE TABLE IF NOT EXISTS `HoaDon` (
    `IDHoaDon` CHAR(50) PRIMARY KEY,
    `IDDatPhong` CHAR(50) NOT NULL,
    `NgayLap` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `TienPhong` INT NULL,
    `SLNgay` INT NULL,
    `TongTien` DECIMAL(18,2) NOT NULL,
    `TienCoc` DECIMAL(18,2) DEFAULT 0,
    `TienThanhToan` DECIMAL(18,2) NULL,
    `TrangThaiThanhToan` INT NULL,
    `GhiChu` TEXT CHARACTER SET utf8mb4 NULL,
    FOREIGN KEY (`IDDatPhong`) REFERENCES `DatPhong`(`IDDatPhong`) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- Dịch Vụ & Chi tiết
-- =========================================
CREATE TABLE IF NOT EXISTS `DichVu` (
    `IDDichVu` CHAR(50) PRIMARY KEY,
    `TenDichVu` VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL, -- Sửa lỗi kiểu DECIMAL
    `TienDichVu` DECIMAL(18,2) DEFAULT 0,
    `HinhDichVu` VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `TTDichVu` (
    `IDTTDichVu` CHAR(50) PRIMARY KEY,
    `IDDichVu` CHAR(50) NOT NULL,
    `ThongTinDV` VARCHAR(255) CHARACTER SET utf8mb4 NULL,
    FOREIGN KEY (`IDDichVu`) REFERENCES `DichVu`(`IDDichVu`) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `CTHDDV` (
    `IDCTHDDV` INT AUTO_INCREMENT PRIMARY KEY, -- MySQL dùng AUTO_INCREMENT thay IDENTITY
    `IDHoaDon` CHAR(50) NOT NULL,
    `IDDichVu` CHAR(50) NOT NULL,
    `Tiendichvu` DECIMAL(18,2) DEFAULT 0,
    `ThoiGianThucHien` DATETIME NULL, -- Thay DATE bằng DATETIME để lưu giờ
    FOREIGN KEY (`IDHoaDon`) REFERENCES `HoaDon`(`IDHoaDon`) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`IDDichVu`) REFERENCES `DichVu`(`IDDichVu`) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================
-- 6. Lịch sử trạng thái tiền cọc / đặt phòng
-- =========================================
CREATE TABLE IF NOT EXISTS `LichSuDatPhong` (
    `IDLichSu` INT AUTO_INCREMENT PRIMARY KEY, -- MySQL AUTO_INCREMENT thay IDENTITY
    `IDDatPhong` CHAR(50) NOT NULL, -- Sửa kiểu dữ liệu cho khớp với DatPhong
    `TrangThaiCu` VARCHAR(50) CHARACTER SET utf8mb4 NULL,
    `TrangThaiMoi` VARCHAR(50) CHARACTER SET utf8mb4 NULL,
    `NgayCapNhat` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `GhiChu` TEXT CHARACTER SET utf8mb4 NULL,
    FOREIGN KEY (`IDDatPhong`) REFERENCES `DatPhong`(`IDDatPhong`) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;