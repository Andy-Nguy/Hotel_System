<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
</head>
<body>
    <h2>Xin chào <?php echo e($customerData['HoTen'] ?? 'Khách hàng'); ?>,</h2>

    <p>Cảm ơn bạn đã đặt phòng tại The Cappa Luxury Hotel. Dưới đây là tóm tắt đặt phòng của bạn:</p>

    <ul>
        <li><strong>Mã đặt phòng:</strong> <?php echo e($bookingData['IDDatPhong'] ?? ''); ?></li>
        <li><strong>Phòng:</strong> <?php echo e($bookingData['IDPhong'] ?? ''); ?></li>
        <li><strong>Ngày nhận phòng:</strong> <?php echo e($bookingData['NgayNhanPhong'] ?? ''); ?></li>
        <li><strong>Ngày trả phòng:</strong> <?php echo e($bookingData['NgayTraPhong'] ?? ''); ?></li>
        <li><strong>Số đêm:</strong> <?php echo e($bookingData['SoDem'] ?? ''); ?></li>
        <li><strong>Giá mỗi đêm:</strong> <?php echo e(number_format($bookingData['GiaPhong'] ?? 0, 0, ',', '.')); ?> VND</li>
        <li><strong>Tổng tiền:</strong> <?php echo e(number_format($bookingData['TongTien'] ?? 0, 0, ',', '.')); ?> VND</li>
    </ul>

    <p>Nếu bạn cần hỗ trợ thêm, vui lòng trả lời email này hoặc gọi số 855 100 4444.</p>

    <p>Trân trọng,<br>The Cappa Luxury Hotel Team</p>
</body>
</html><?php /**PATH I:\Ky_06_2025_2026\php\New folder\Hotel_System\service\resources\views/emails/booking_confirmation.blade.php ENDPATH**/ ?>