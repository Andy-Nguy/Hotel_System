<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
</head>
<body>
    <h2>Xin chào {{ $customerData['HoTen'] ?? 'Khách hàng' }},</h2>

    <p>Cảm ơn bạn đã đặt phòng tại The Cappa Luxury Hotel. Dưới đây là tóm tắt đặt phòng của bạn:</p>

    <ul>
        <li><strong>Mã đặt phòng:</strong> {{ $bookingData['IDDatPhong'] ?? '' }}</li>
        <li><strong>Phòng:</strong> {{ $bookingData['IDPhong'] ?? '' }}</li>
        <li><strong>Ngày nhận phòng:</strong> {{ $bookingData['NgayNhanPhong'] ?? '' }}</li>
        <li><strong>Ngày trả phòng:</strong> {{ $bookingData['NgayTraPhong'] ?? '' }}</li>
        <li><strong>Số đêm:</strong> {{ $bookingData['SoDem'] ?? '' }}</li>
        <li><strong>Giá mỗi đêm:</strong> {{ number_format($bookingData['GiaPhong'] ?? 0, 0, ',', '.') }} VND</li>
        <li><strong>Tổng tiền:</strong> {{ number_format($bookingData['TongTien'] ?? 0, 0, ',', '.') }} VND</li>
    </ul>

    <p>Nếu bạn cần hỗ trợ thêm, vui lòng trả lời email này hoặc gọi số 855 100 4444.</p>

    <p>Trân trọng,<br>The Cappa Luxury Hotel Team</p>
</body>
</html>