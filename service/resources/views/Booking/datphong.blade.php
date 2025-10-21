@extends('layouts.layout2')

{{-- Đặt tiêu đề trang --}}
@section('title', 'Chi tiết Đặt phòng')

{{-- Nội dung chính --}}
@section('content')
<div class="container-fluid py-3">

    {{-- Khu vực hiển thị thông báo thành công (từ redirect) --}}
    <div id="alertArea">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">1. Thông tin Khách hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Mã Đặt phòng:</strong>
                            <p class="fs-5">{{ $datPhong->IDDatPhong }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Trạng thái:</strong>
                            <p class="fs-5">
                                @if($datPhong->TrangThai == 1)
                                    <span class="badge bg-success">Phòng đang sử dụng</span>
                                @else
                                    <span class="badge bg-secondary">Chưa xác định</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong>Họ tên:</strong>
                            <p>{{ $datPhong->khachHang->HoTen ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Số điện thoại:</strong>
                            <p>{{ $datPhong->khachHang->SoDienThoai ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-12">
                            <strong>Email:</strong>
                            <p>{{ $datPhong->khachHang->Email ?? 'Không có' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">2. Chi tiết Phòng & Dịch vụ</h5>
                </div>
                <div class="card-body">
                    <h6><i class="bi bi-door-closed me-2"></i>Thông tin phòng</h6>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Số phòng</th>
                            <td>{{ $datPhong->phong->SoPhong ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Loại phòng</th>
                            <td>{{ $datPhong->phong->loaiPhong->TenLoaiPhong ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Ngày nhận</th>
                            <td>{{ \Carbon\Carbon::parse($datPhong->NgayNhanPhong)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Ngày trả</th>
                            <td>{{ \Carbon\Carbon::parse($datPhong->NgayTraPhong)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Số đêm</th>
                            <td>{{ $datPhong->SoDem }}</td>
                        </tr>
                    </table>

                    <h6 class="mt-4"><i class="bi bi-box me-2"></i>Dịch vụ đã sử dụng</h6>
                    @if($datPhong->hoaDon && $datPhong->hoaDon->chiTietDichVu->count() > 0)
                        <table class="table table-sm table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Tên dịch vụ</th>
                                    <th>Thời gian</th>
                                    <th class="text-end">Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datPhong->hoaDon->chiTietDichVu as $ctdv)
                                <tr>
                                    <td>{{ $ctdv->dichVu->TenDichVu ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ctdv->ThoiGianThucHien)->format('d/m/Y H:i') }}</td>
                                    <td class="text-end">{{ number_format($ctdv->TienDichVu, 0, ',', '.') }} đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p><em>Không sử dụng dịch vụ.</em></p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card" style="position: sticky; top: 1rem;">
                <div class="card-header">
                    <h5 class="mb-0">Hóa đơn ({{ $datPhong->hoaDon->IDHoaDon ?? 'N/A' }})</h5>
                </div>
                @if($datPhong->hoaDon)
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tiền phòng
                                <span>{{ number_format($datPhong->TongTien, 0, ',', '.') }} đ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tiền dịch vụ
                                <span>+ {{ number_format($datPhong->hoaDon->TongTien - $datPhong->TongTien, 0, ',', '.') }} đ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                <strong class="text-primary">Tổng cộng (A)</strong>
                                <strong class="text-primary">{{ number_format($datPhong->hoaDon->TongTien, 0, ',', '.') }} đ</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Đã cọc (B)
                                <span>- {{ number_format($datPhong->hoaDon->TienCoc, 0, ',', '.') }} đ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Còn lại (A - B)</strong>
                                <strong>{{ number_format($datPhong->hoaDon->TienThanhToan, 0, ',', '.') }} đ</strong>
                            </li>
                            <li class="list-group-item text-center">
                                @if($datPhong->hoaDon->TrangThaiThanhToan == 1)
                                    <span class="badge bg-success fs-6"><i class="bi bi-check-circle me-1"></i> ĐÃ THANH TOÁN</span>
                                @else
                                    <span class="badge bg-warning fs-6"><i class="bi bi-hourglass-split me-1"></i> CHƯA THANH TOÁN</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer d-grid gap-2">
                        <button class="btn btn-primary"><i class="bi bi-printer me-2"></i> In hóa đơn</button>
                        <button class="btn btn-success"><i class="bi bi-cash-coin me-2"></i> Thanh toán</button>
                    </div>
                @else
                    <div class="card-body">
                        <p class="text-danger">Chưa có hóa đơn cho lượt đặt phòng này.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- (Bạn có thể thêm JS cho nút in hoặc thanh toán ở đây) --}}
@endsection
