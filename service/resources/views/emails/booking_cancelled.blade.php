<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đặt phòng đã bị hủy</title>
</head>
<body>
    <h2>Xin chào {{ $customerData['HoTen'] ?? 'Khách hàng' }},</h2>

    <p>Chúng tôi thông báo rằng đặt phòng của bạn đã bị hủy. Dưới đây là thông tin chi tiết:</p>

    <ul>
        <li><strong>Mã đặt phòng:</strong> {{ $bookingData['IDDatPhong'] ?? '' }}</li>
        <li><strong>Phòng:</strong> {{ $bookingData['TenPhong'] ?? $bookingData['IDPhong'] ?? '' }}</li>
        <li><strong>Ngày nhận phòng:</strong> {{ isset($bookingData['NgayNhanPhong']) ? \Carbon\Carbon::parse($bookingData['NgayNhanPhong'])->format('d/m/Y') : '' }}</li>
        <li><strong>Ngày trả phòng:</strong> {{ isset($bookingData['NgayTraPhong']) ? \Carbon\Carbon::parse($bookingData['NgayTraPhong'])->format('d/m/Y') : '' }}</li>
        <li><strong>Số đêm:</strong> {{ $bookingData['SoDem'] ?? '' }}</li>
        <li><strong>Tổng tiền:</strong> {{ number_format($bookingData['TongTien'] ?? 0, 0, ',', '.') }} VND</li>
    </ul>

    <p>Nếu bạn tin rằng đây là nhầm lẫn, vui lòng liên hệ với bộ phận hỗ trợ.</p>

    <p>Trân trọng,<br>The Cappa Luxury Hotel Team</p>
</body>
</html>