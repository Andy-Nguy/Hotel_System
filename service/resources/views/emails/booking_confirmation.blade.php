<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>
        @if($statusType === 'cancelled')
            Thông báo hủy đặt phòng
        @elseif($statusType === 'pending')
            Đặt phòng đang chờ xác nhận
        @else
            Xác nhận đặt phòng
        @endif
    </title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: 
                @if($statusType === 'cancelled')
                    linear-gradient(135deg, #ef4444, #dc2626)
                @elseif($statusType === 'pending')
                    linear-gradient(135deg, #f59e0b, #d97706)
                @else
                    linear-gradient(135deg, #3b82f6, #2563eb)
                @endif;
            color: white;
            padding: 30px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .status-badge {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
            font-size: 16px;
        }
        .status-confirmed {
            background: #22c55e;
            color: white;
        }
        .status-cancelled {
            background: #ef4444;
            color: white;
        }
        .info-box {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #6b7280;
            font-weight: 500;
        }
        .info-value {
            color: #111827;
            font-weight: 600;
        }
        .alert-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            background: #f3f4f6;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            border-radius: 0 0 10px 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏨 The Cappa Luxury Hotel</h1>
    </div>

    <div class="content">
        <h2>Xin chào {{ $customerData['HoTen'] ?? 'Khách hàng' }},</h2>

        @if($statusType === 'cancelled')
            <div class="status-badge status-cancelled">
                ❌ ĐẶT PHÒNG ĐÃ BỊ HỦY
            </div>
            <p><strong>Chúng tôi xin thông báo đặt phòng của quý khách đã bị hủy.</strong></p>
            
            <div class="alert-box">
                <strong>⚠️ Lưu ý quan trọng:</strong><br>
                Nếu quý khách không yêu cầu hủy đặt phòng này, vui lòng liên hệ với chúng tôi ngay lập tức qua số hotline: <strong>855 100 4444</strong>
            </div>
        @elseif($statusType === 'pending')
            <div class="status-badge" style="background: #f59e0b; color: white;">
                ⏳ ĐANG CHỜ XÁC NHẬN
            </div>
            <p><strong>Cảm ơn bạn đã đặt phòng tại The Cappa Luxury Hotel. Chúng tôi đã nhận được yêu cầu đặt phòng của bạn.</strong></p>
            
            <div class="alert-box">
                <strong>📋 Trạng thái:</strong> Đặt phòng đang chờ xác nhận từ bộ phận lễ tân.<br>
                <strong>⏰ Thời gian xử lý:</strong> Chúng tôi sẽ xác nhận trong vòng 2-4 giờ làm việc.<br>
                <strong>📞 Liên hệ:</strong> Nếu cần hỗ trợ gấp, vui lòng gọi <strong>855 100 4444</strong>
            </div>
        @else
            <div class="status-badge status-confirmed">
                ✅ XÁC NHẬN ĐẶT PHÒNG
            </div>
            <p><strong>Cảm ơn bạn đã đặt phòng tại The Cappa Luxury Hotel. Đặt phòng của bạn đã được xác nhận thành công!</strong></p>
        @endif

        <div class="info-box">
            <h3 style="margin-top: 0; color: #111827;">📋 Thông tin đặt phòng:</h3>
            
            <div class="info-row">
                <span class="info-label">Mã đặt phòng:</span>
                <span class="info-value">{{ $bookingData['IDDatPhong'] ?? '' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Phòng:</span>
                <span class="info-value">{{ $bookingData['SoPhong'] ?? $bookingData['IDPhong'] ?? '' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Ngày nhận phòng:</span>
                <span class="info-value">{{ $bookingData['NgayNhanPhong'] ?? '' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Ngày trả phòng:</span>
                <span class="info-value">{{ $bookingData['NgayTraPhong'] ?? '' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Số đêm:</span>
                <span class="info-value">{{ $bookingData['SoDem'] ?? '' }} đêm</span>
            </div>
            <div class="info-row">
                <span class="info-label">Giá mỗi đêm:</span>
                <span class="info-value">{{ number_format($bookingData['GiaPhong'] ?? 0, 0, ',', '.') }} VND</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tổng tiền:</span>
                <span class="info-value" style="color: #ef4444; font-size: 18px;">{{ number_format($bookingData['TongTien'] ?? 0, 0, ',', '.') }} VND</span>
            </div>
        </div>

        @if($statusType === 'cancelled')
            <p>Nếu quý khách muốn đặt phòng lại, vui lòng truy cập website của chúng tôi hoặc liên hệ trực tiếp.</p>
            <p><strong>Chúng tôi rất mong được phục vụ quý khách trong tương lai!</strong></p>
        @elseif($statusType === 'pending')
            <p><strong>📝 Các bước tiếp theo:</strong></p>
            <ul>
                <li>Chúng tôi sẽ kiểm tra tình trạng phòng và xác nhận trong thời gian sớm nhất</li>
                <li>Bạn sẽ nhận được email xác nhận cuối cùng khi đặt phòng được duyệt</li>
                <li>Nếu có vấn đề gì, chúng tôi sẽ liên hệ qua số điện thoại hoặc email của bạn</li>
            </ul>
            <p><strong>Xin cảm ơn sự kiên nhẫn của quý khách!</strong></p>
        @else
            <p><strong>🎉 Chúng tôi rất mong được đón tiếp quý khách!</strong></p>
            <p>Vui lòng đến khách sạn đúng giờ để làm thủ tục nhận phòng. Nếu có bất kỳ thắc mắc nào, đừng ngần ngại liên hệ với chúng tôi.</p>
        @endif

        <p style="margin-top: 30px;">
            <strong>Trân trọng,</strong><br>
            The Cappa Luxury Hotel Team<br>
            📞 Hotline: 855 100 4444
        </p>
    </div>

    <div class="footer">
        <p>Email này được gửi tự động từ hệ thống đặt phòng.</p>
        <p>© {{ date('Y') }} The Cappa Luxury Hotel. All rights reserved.</p>
    </div>
</body>
</html>