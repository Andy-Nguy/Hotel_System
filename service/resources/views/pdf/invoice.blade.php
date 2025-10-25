<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hóa đơn {{ $invoice->IDHoaDon }}</title>
    <style>
        body{ font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        .row{ display:flex; justify-content:space-between; }
        table{ width:100%; border-collapse: collapse; margin-top: 10px;}
        th,td{ border:1px solid #ccc; padding:6px 8px; text-align:left;}
        h2,h3{ margin:4px 0; }
    </style>
</head>
<body>
    <h2>{{ $hotel['name'] }}</h2>
    <div>{{ $hotel['address'] }} | {{ $hotel['phone'] }}</div>
    <hr>
    <h3>HÓA ĐƠN: {{ $invoice->IDHoaDon }}</h3>
    <div class="row">
        <div>
            <strong>Khách hàng:</strong> {{ optional($booking->khachHang)->HoTen }}<br>
            <strong>SĐT:</strong> {{ optional($booking->khachHang)->SoDienThoai }}<br>
            <strong>Email:</strong> {{ optional($booking->khachHang)->Email }}
        </div>
        <div>
            <strong>Phòng:</strong> {{ optional($booking->phong)->SoPhong }} - {{ optional($booking->phong)->Tenphong }}<br>
            <strong>Loại:</strong> {{ optional($booking->phong)->TenLoaiPhong }}<br>
            <strong>Ở:</strong> {{ $booking->NgayNhanPhong }} → {{ $booking->NgayTraPhong }} ({{ $booking->SoDem }} đêm)
        </div>
    </div>

    <table>
        <thead>
            <tr><th>Hạng mục</th><th>Số tiền</th></tr>
        </thead>
        <tbody>
            <tr><td>Tiền phòng</td><td>{{ number_format($totals['room_total'],0) }}</td></tr>
            <tr><td>Tiền dịch vụ</td><td>{{ number_format($totals['services_total'],0) }}</td></tr>
            <tr><td>Đã cọc</td><td>-{{ number_format($totals['deposit'],0) }}</td></tr>
            <tr><td><strong>Phải thanh toán</strong></td><td><strong>{{ number_format($totals['payable'],0) }}</strong></td></tr>
            <tr><td>Đã thanh toán</td><td>{{ number_format($totals['paid'],0) }}</td></tr>
            <tr><td><strong>Còn lại</strong></td><td><strong>{{ number_format($totals['remain'],0) }}</strong></td></tr>
        </tbody>
    </table>

    @if($invoice->chiTietDichVus->count())
    <h3>Chi tiết dịch vụ</h3>
    <table>
        <thead><tr><th>Dịch vụ</th><th>Thời gian</th><th>Tiền</th></tr></thead>
        <tbody>
            @foreach($invoice->chiTietDichVus as $ct)
            <tr>
                <td>{{ optional($ct->dichVu)->TenDichVu }}</td>
                <td>{{ $ct->ThoiGianThucHien }}</td>
                <td>{{ number_format($ct->TienDichVu,0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($invoice->GhiChu)
        <p><em>Ghi chú: {{ $invoice->GhiChu }}</em></p>
    @endif
</body>
</html>