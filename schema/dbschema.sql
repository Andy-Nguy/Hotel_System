-- =========================================
-- 1. Khách Hàng (online)
-- =========================================
CREATE TABLE KhachHang (
    IDKhachHang INT AUTO_INCREMENT PRIMARY KEY,
    HoTen VARCHAR(100) NOT NULL,
    NgaySinh DATE,
    SoDienThoai VARCHAR(20),
    Email VARCHAR(100) UNIQUE,
    NgayDangKy DATE DEFAULT (CURRENT_DATE)
);

-- =========================================
-- 2. Tài khoản người dùng (login)
-- =========================================
CREATE TABLE TaiKhoanNguoiDung (
    IDNguoiDung INT AUTO_INCREMENT PRIMARY KEY,
    IDKhachHang INT NOT NULL,
    MatKhau VARCHAR(255) NOT NULL,
    VaiTro TINYINT, -- 1: Khách hàng, 2: Nhân viên
    FOREIGN KEY (IDKhachHang) REFERENCES KhachHang(IDKhachHang)
);

-- =========================================
-- 3. Loại Phòng, Phòng
-- =========================================
CREATE TABLE LoaiPhong (
    IDLoaiPhong INT AUTO_INCREMENT PRIMARY KEY,
    TenLoaiPhong VARCHAR(100) NOT NULL,
    MoTa TEXT,
    SoNguoiToiDa INT,
    GiaCoBanMotDem DECIMAL(18,2),
    UrlAnhLoaiPhong VARCHAR(255),
    UuTienChinh BOOLEAN DEFAULT 0
);

CREATE TABLE Phong (
    IDPhong INT AUTO_INCREMENT PRIMARY KEY,
    IDLoaiPhong INT NOT NULL,
    SoPhong VARCHAR(20) NOT NULL,
    MoTa TEXT,
    UuTienChinh BOOLEAN DEFAULT 0,
    XepHangSao INT,
    TrangThai VARCHAR(50),
    UrlAnhPhong VARCHAR(255),
    FOREIGN KEY (IDLoaiPhong) REFERENCES LoaiPhong(IDLoaiPhong)
);

-- =========================================
-- 4. Tiện Nghi
-- =========================================
CREATE TABLE TienNghi (
    IDTienNghi INT AUTO_INCREMENT PRIMARY KEY,
    TenTienNghi VARCHAR(100) NOT NULL
);

CREATE TABLE TienNghiPhong (
    IDTienNghiPhong INT AUTO_INCREMENT PRIMARY KEY,
    IDPhong INT NOT NULL,
    IDTienNghi INT NOT NULL,
    FOREIGN KEY (IDPhong) REFERENCES Phong(IDPhong),
    FOREIGN KEY (IDTienNghi) REFERENCES TienNghi(IDTienNghi)
);

-- =========================================
-- 5. Đặt Phòng
-- =========================================
CREATE TABLE DatPhong (
    IDDatPhong INT AUTO_INCREMENT PRIMARY KEY,
    IDKhachHang INT NULL,
    IDPhong INT NOT NULL,
    NgayDatPhong DATE DEFAULT (CURRENT_DATE),
    NgayNhanPhong DATE NOT NULL,
    NgayTraPhong DATE NOT NULL,
    TongTien DECIMAL(18,2) NOT NULL,
    TienCoc DECIMAL(18,2) DEFAULT 0,
    TrangThai VARCHAR(50),
    TrangThaiThanhToan VARCHAR(50),
    FOREIGN KEY (IDKhachHang) REFERENCES KhachHang(IDKhachHang),
    FOREIGN KEY (IDPhong) REFERENCES Phong(IDPhong)
);

-- =========================================
-- 6. Hóa Đơn
-- =========================================
CREATE TABLE HoaDon (
    IDHoaDon INT AUTO_INCREMENT PRIMARY KEY,
    IDDatPhong INT NOT NULL,
    NgayLap DATETIME DEFAULT CURRENT_TIMESTAMP,
    TongTien DECIMAL(18,2) NOT NULL,
    TienCoc DECIMAL(18,2) DEFAULT 0,
    TienThanhToan DECIMAL(18,2),
    TrangThaiThanhToan VARCHAR(50),
    GhiChu TEXT,
    FOREIGN KEY (IDDatPhong) REFERENCES DatPhong(IDDatPhong)
);

-- =========================================
-- 7. Lịch Sử Đặt Phòng
-- =========================================
CREATE TABLE LichSuDatPhong (
    IDLichSu INT AUTO_INCREMENT PRIMARY KEY,
    IDDatPhong INT NOT NULL,
    TrangThaiCu VARCHAR(50),
    TrangThaiMoi VARCHAR(50),
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP,
    GhiChu TEXT,
    FOREIGN KEY (IDDatPhong) REFERENCES DatPhong(IDDatPhong)
);


SHOW TABLES;

INSERT INTO KhachHang (HoTen, NgaySinh, SoDienThoai, Email)
VALUES
('Nguyen Van A', '1998-05-12', '0901234567', 'a@example.com'),
('Tran Thi B', '2000-09-23', '0902345678', 'b@example.com'),
('Le Van C', '1995-03-10', '0903456789', 'c@example.com');

SELECT * FROM khachhang;
SELECT * FROM TaiKhoanNguoiDung;

-- 1. Thêm khách hàng (dù là nhân viên, vẫn là bản ghi trong KhachHang)
INSERT INTO KhachHang (HoTen, NgaySinh, SoDienThoai, Email)
VALUES ('Nhan Vien', '1998-05-15', '0905123456', 'nhanvien@example.com');

-- 2. Lấy IDKhachHang vừa tạo
SELECT IDKhachHang FROM KhachHang WHERE Email = 'nhanvien@example.com';
-- Mật khẩu đã được mã hóa bằng bcrypt: "123456"
INSERT INTO TaiKhoanNguoiDung (IDKhachHang, MatKhau, VaiTro)
VALUES (4, '$2a$10$ZMRF/jCS/nk9kF/aYbgPEeNlAsRZ5GkqBvlua306IBoIRC6HSxKma', 2);

SELECT kh.Email, kh.HoTen, tk.MatKhau, tk.VaiTro
FROM KhachHang kh
JOIN TaiKhoanNguoiDung tk ON kh.IDKhachHang = tk.IDKhachHang;


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

SELECT * FROM taikhoannguoidung

SELECT * FROM Tiennghi


-- 1) Loại phòng mẫu
INSERT INTO LoaiPhong (TenLoaiPhong, MoTa, SoNguoiToiDa, GiaCoBanMotDem, UrlAnhLoaiPhong, UuTienChinh)
VALUES
('Phòng đơn', 'Phòng 1 giường, phù hợp 1 người', 1, 500000, 'phongdon.jpg', 0),
('Phòng đôi', 'Phòng 2 người hoặc 2 giường', 2, 800000, 'phongdoi.jpg', 0),
('Phòng VIP', 'Phòng cao cấp, đầy đủ tiện nghi', 3, 1500000, 'phongvip.jpg', 1);

-- 2) Phòng mẫu (gắn IDLoaiPhong tương ứng: 1,2,3)
INSERT INTO Phong (IDLoaiPhong, SoPhong, MoTa, UuTienChinh, XepHangSao, TrangThai, UrlAnhPhong)
VALUES
(1, '101', 'Phòng đơn tầng 1', 0, 3, 'Trống', 'phong101.jpg'),
(2, '102', 'Phòng đôi tầng 1', 0, 4, 'Trống', 'phong102.jpg'),
(3, '103', 'Phòng VIP tầng 1', 1, 5, 'Đang sử dụng', 'phong103.jpg'),
(1, '201', 'Phòng đơn tầng 2', 0, 3, 'Trống', 'phong201.jpg'),
(2, '202', 'Phòng đôi tầng 2', 0, 4, 'Bảo trì', 'phong202.jpg');

-- 3) Tiện nghi mẫu
INSERT INTO TienNghi (TenTienNghi) VALUES
('Wi-Fi miễn phí'),
('Máy lạnh'),
('Tivi Màn hình phẳng'),
('Bồn tắm'),
('Minibar'),
('Ban công'),
('Dịch vụ phòng 24/7');

-- 4) Liên kết tiện nghi - phòng (IDPhong căn cứ theo AUTO_INCREMENT thứ tự phía trên)
INSERT INTO TienNghiPhong (IDPhong, IDTienNghi) VALUES
(1,1),(1,2),(1,3),
(2,1),(2,2),(2,3),(2,5),
(3,1),(3,2),(3,3),(3,4),(3,5),
(4,1),(4,2),(4,3),
(5,1),(5,2);

