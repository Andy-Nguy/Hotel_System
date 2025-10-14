-- =========================================
-- RESET DATABASE VÀ TẠO MỚI
-- =========================================
DROP DATABASE IF EXISTS khachsan;

CREATE DATABASE IF NOT EXISTS khachsan
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE khachsan;

-- =========================================
-- 1. Bảng Loại Phòng
-- =========================================
CREATE TABLE LoaiPhong (
    IDLoaiPhong CHAR(10) PRIMARY KEY,
    TenLoaiPhong VARCHAR(100) NOT NULL,
    MoTa TEXT,
    SoNguoiToiDa INT,
    GiaCoBanMotDem DECIMAL(18,2),
    UrlAnhLoaiPhong VARCHAR(255),
    UuTienChinh BOOLEAN DEFAULT 0
);

-- Trigger tự động tạo IDLoaiPhong (LPxxx)
DELIMITER $$
CREATE TRIGGER trg_LoaiPhong_BeforeInsert
BEFORE INSERT ON LoaiPhong
FOR EACH ROW
BEGIN
    DECLARE new_id INT;
    DECLARE prefix VARCHAR(3) DEFAULT 'LP';
    SELECT IFNULL(MAX(CAST(SUBSTRING(IDLoaiPhong, 3) AS UNSIGNED)), 0) + 1
    INTO new_id
    FROM LoaiPhong;
    SET NEW.IDLoaiPhong = CONCAT(prefix, LPAD(new_id, 3, '0'));
END$$
DELIMITER ;


-- =========================================
-- 2. Bảng Phòng
-- =========================================
CREATE TABLE Phong (
    IDPhong CHAR(10) PRIMARY KEY,
    IDLoaiPhong CHAR(10) NOT NULL,
    SoPhong VARCHAR(20) NOT NULL,
    TenPhong VARCHAR(100) NOT NULL,
    MoTa TEXT,
    UuTienChinh BOOLEAN DEFAULT 0,
    XepHangSao INT,
    TrangThai VARCHAR(50),
    UrlAnhPhong VARCHAR(255),
    FOREIGN KEY (IDLoaiPhong) REFERENCES LoaiPhong(IDLoaiPhong)
);

-- Trigger tự động tạo IDPhong (Pxxx)
DELIMITER $$
CREATE TRIGGER trg_Phong_BeforeInsert
BEFORE INSERT ON Phong
FOR EACH ROW
BEGIN
    DECLARE new_id INT;
    DECLARE prefix VARCHAR(2) DEFAULT 'P';
    SELECT IFNULL(MAX(CAST(SUBSTRING(IDPhong, 2) AS UNSIGNED)), 0) + 1 INTO new_id FROM Phong;
    SET NEW.IDPhong = CONCAT(prefix, LPAD(new_id, 3, '0'));
END$$
DELIMITER ;

-- =========================================
-- 3. Bảng Tiện Nghi
-- =========================================
CREATE TABLE TienNghi (
    IDTienNghi CHAR(10) PRIMARY KEY,
    TenTienNghi VARCHAR(100) NOT NULL
);

-- Trigger tự động tạo IDTienNghi (TNxxx)
DELIMITER $$
CREATE TRIGGER trg_TienNghi_BeforeInsert
BEFORE INSERT ON TienNghi
FOR EACH ROW
BEGIN
    DECLARE new_id INT;
    DECLARE prefix VARCHAR(2) DEFAULT 'TN';
    SELECT IFNULL(MAX(CAST(SUBSTRING(IDTienNghi, 3) AS UNSIGNED)), 0) + 1 INTO new_id FROM TienNghi;
    SET NEW.IDTienNghi = CONCAT(prefix, LPAD(new_id, 3, '0'));
END$$
DELIMITER ;

-- =========================================
-- 4. Bảng Tiện Nghi Phòng (Liên kết)
-- =========================================
CREATE TABLE TienNghiPhong (
    IDTienNghiPhong CHAR(10) PRIMARY KEY,
    IDPhong CHAR(10) NOT NULL,
    IDTienNghi CHAR(10) NOT NULL,
    FOREIGN KEY (IDPhong) REFERENCES Phong(IDPhong),
    FOREIGN KEY (IDTienNghi) REFERENCES TienNghi(IDTienNghi)
);

-- Trigger tự động tạo IDTienNghiPhong (TNPxxx)
DELIMITER $$
CREATE TRIGGER trg_TienNghiPhong_BeforeInsert
BEFORE INSERT ON TienNghiPhong
FOR EACH ROW
BEGIN
    DECLARE new_id INT;
    DECLARE prefix VARCHAR(3) DEFAULT 'TNP';
    SELECT IFNULL(MAX(CAST(SUBSTRING(IDTienNghiPhong, 4) AS UNSIGNED)), 0) + 1 INTO new_id FROM TienNghiPhong;
    SET NEW.IDTienNghiPhong = CONCAT(prefix, LPAD(new_id, 3, '0'));
END$$
DELIMITER ;

-- =========================================
-- 5. Bảng Dịch Vụ
-- =========================================
CREATE TABLE DichVu (
    IDDichVu Char(50) PRIMARY KEY,
    -- SỬA ĐỔI: Chuyển TenDichVu từ DECIMAL sang VARCHAR
    TenDichVu VARCHAR(100) NOT NULL, 
    TienDichVu DECIMAL(18,2) DEFAULT 0,
    HinhDichVu char(255)
);

-- =========================================
-- 6. Bảng Thông Tin Chi Tiết Dịch Vụ
-- =========================================
CREATE TABLE TTDichVu (
    IDTTDichVu Char(50) PRIMARY KEY,
    IDDichVu Char(50) ,
    ThongTinDV char(255),
    FOREIGN KEY (IDDichVu) REFERENCES DichVu(IDDichVu)
);

-- =========================================
-- 7. Bảng Chi Tiết Hóa Đơn Dịch Vụ (Log)
-- =========================================
CREATE TABLE CTHDDV (
    IDCTHDDV INT PRIMARY KEY AUTO_INCREMENT,
    IDHoaDon Char(50) NULL, 
    IDDichVu Char(50) NOT NULL,
    Tiendichvu DECIMAL(18,2) DEFAULT 0,
    ThoiGianThucHien DATETIME, 
    FOREIGN KEY (IDDichVu) REFERENCES DichVu(IDDichVu)
    -- FOREIGN KEY IDHoaDon: Cần bổ sung khi tạo bảng HoaDon
);

-- =========================================
-- DỮ LIỆU MẪU (Bắt đầu từ đây)
-- =========================================

-- Insert data into LoaiPhong (không cần ID vì trigger tự tạo)
INSERT INTO LoaiPhong (TenLoaiPhong, MoTa, SoNguoiToiDa, GiaCoBanMotDem, UrlAnhLoaiPhong, UuTienChinh) VALUES
('Phòng Đơn', 'Phòng đơn tiêu chuẩn cho 1 người', 1, 450000, 'images/loai_phong_don.jpg', 1),
('Phòng Đôi', 'Phòng đôi cho 2 người, đầy đủ tiện nghi', 2, 750000, 'images/loai_phong_doi.jpg', 1),
('Phòng Gia Đình', 'Phòng rộng rãi cho 4 người', 4, 1200000, 'images/loai_phong_giadinh.jpg', 0),
('Phòng VIP', 'Phòng cao cấp với view thành phố', 2, 1800000, 'images/loai_phong_vip.jpg', 1),
('Phòng Suite', 'Phòng sang trọng nhất của khách sạn', 2, 2500000, 'images/loai_phong_suite.jpg', 0);

-- Insert data into Phong (không cần IDPhong)
INSERT INTO Phong (IDLoaiPhong, SoPhong, TenPhong, MoTa, UuTienChinh, XepHangSao, TrangThai, UrlAnhPhong) VALUES
('LP001', '101', 'Phòng Đơn 101', 'Phòng đơn có cửa sổ hướng vườn', 1, 3, 'Trống', 'images/phong101.jpg'),
('LP001', '102', 'Phòng Đơn 102', 'Phòng đơn nhỏ gọn, yên tĩnh', 0, 3, 'Đang dọn', 'images/phong102.jpg'),
('LP002', '201', 'Phòng Đôi 201', 'Phòng đôi view hồ bơi', 1, 4, 'Trống', 'images/phong201.jpg'),
('LP002', '202', 'Phòng Đôi 202', 'Phòng đôi tiêu chuẩn', 0, 4, 'Đang thuê', 'images/phong202.jpg'),
('LP003', '301', 'Phòng Gia Đình 301', 'Phòng gia đình 2 giường lớn', 1, 4, 'Trống', 'images/phong301.jpg'),
('LP003', '302', 'Phòng Gia Đình 302', 'Phòng gia đình view thành phố', 0, 4, 'Trống', 'images/phong302.jpg'),
('LP004', '401', 'Phòng VIP 401', 'Phòng VIP ban công lớn', 1, 5, 'Đang thuê', 'images/phong401.jpg'),
('LP004', '402', 'Phòng VIP 402', 'Phòng VIP view biển', 0, 5, 'Trống', 'images/phong402.jpg'),
('LP005', '501', 'Phòng Suite 501', 'Phòng Suite sang trọng', 1, 5, 'Trống', 'images/phong501.jpg'),
('LP005', '502', 'Phòng Suite 502', 'Phòng Suite tầng cao nhất', 0, 5, 'Đang bảo trì', 'images/phong502.jpg');

-- Insert data into TienNghi (không cần ID)
INSERT INTO TienNghi (TenTienNghi) VALUES
('Wi-Fi miễn phí'),
('Máy lạnh'),
('Tivi màn hình phẳng'),
('Bồn tắm'),
('Minibar');

-- Insert data into TienNghiPhong
INSERT INTO TienNghiPhong (IDPhong, IDTienNghi) VALUES
('P001', 'TN001'),
('P001', 'TN002'),
('P002', 'TN001'),
('P003', 'TN001'),
('P003', 'TN003'),
('P005', 'TN004'),
('P005', 'TN002'),
('P007', 'TN005'),
('P009', 'TN001'),
('P009', 'TN003');

-- =========================================
-- DỮ LIỆU MẪU CHO DỊCH VỤ
-- =========================================
dichvudichvudichvu
-- SỬA ĐỔI: Cập nhật dữ liệu mẫu cho TenDichVu
INSERT INTO DichVu (IDDichVu, TenDichVu, TienDichVu, HinhDichVu) VALUES
('DV001', 'Ăn sáng tại phòng', 60000.00, 'images/dv_breakfast.jpg'),
('DV002', 'Giặt là', 20000.00, 'images/dv_laundry.jpg'),
('DV003', 'Massage thư giãn', 350000.00, 'images/dv_massage.jpg'),
('DV004', 'Sử dụng minibar', 120000.00, 'images/dv_minibar.jpg'),
('DV005', 'Trả phòng muộn', 0.00, 'images/dv_latecheckout.jpg');

-- Insert data into TTDichVu (Phải tự cung cấp IDTTDichVu)
INSERT INTO TTDichVu (IDTTDichVu, IDDichVu, ThongTinDV) VALUES
('TTDV01', 'DV001', 'Phục vụ từ 6:30 đến 9:30 sáng.'),
('TTDV02', 'DV001', 'Áp dụng phí 10% VAT.'),
('TTDV03', 'DV002', 'Giảm 20% cho khách hàng thân thiết.'),
('TTDV04', 'DV003', 'Có thể đặt trước 1 giờ.'),
('TTDV05', 'DV005', 'Miễn phí trả phòng muộn đến 14:00.');

-- Insert data into CTHDDV (Log sử dụng dịch vụ)
-- Dữ liệu này mô phỏng dịch vụ đã được sử dụng nhưng chưa thanh toán (IDHoaDon IS NULL)
INSERT INTO CTHDDV (IDHoaDon, IDDichVu, Tiendichvu, ThoiGianThucHien) VALUES
(NULL, 'DV001', 60000.00, NOW() - INTERVAL 2 DAY), -- Ăn sáng ngày -2
(NULL, 'DV001', 60000.00, NOW() - INTERVAL 1 DAY), -- Ăn sáng ngày -1
(NULL, 'DV002', 20000.00, NOW() - INTERVAL 1 DAY), -- Giặt là ngày -1
('HD9999', 'DV003', 350000.00, NOW() - INTERVAL 3 DAY); -- Massage đã được thanh toán (link tới hóa đơn HD9999)