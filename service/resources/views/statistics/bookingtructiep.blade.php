@extends('layouts.layout2')

{{-- Đặt tiêu đề trang --}}
@section('title', 'Đặt phòng trực tiếp')

{{-- (MỚI) Thêm một số style nhỏ cho label và input-group giống checkout --}}
@push('styles')
<style>
    /* ... (Toàn bộ style CSS của bạn được giữ nguyên) ... */
    .form-label.styled {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: #1e3a8a;
        font-weight: 600;
        letter-spacing: 0.3px;
        font-size: 0.9rem;
    }
    .form-control.styled, .form-select.styled {
        border: 1px solid #d1e0ff;
        background: #ffffff;
        color: #1e3a8a;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        border-radius: 10px;
        padding: 0.6rem;
        font-size: 0.95rem;
    }
    .form-control.styled:focus, .form-select.styled:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
        outline: none;
        background: #f9fbff;
    }
    .btn-primary.styled {
        background: linear-gradient(90deg, #60a5fa, #93c5fd);
        border: none;
        color: #ffffff;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        border-radius: 10px;
        padding: 0.6rem 1.2rem;
    }
    .btn-primary.styled:hover {
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    .btn-outline-secondary.styled {
        border: 1px solid #d1e0ff;
        color: #1e3a8a;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        border-radius: 0 10px 10px 0; /* Căn chỉnh cho input group */
        padding: 0.6rem;
        font-size: 0.95rem;
    }
    .form-control.styled.in-group {
        border-radius: 10px 0 0 10px;
    }
    .btn-outline-secondary.styled:hover {
        background: #e6f0ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    /* Table style parity with tiennghi */
    .table-styled,
    .table.styled { /* support old class until markup updated */
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border-collapse: separate; /* keep rounded corners */
        border-spacing: 0;
    }
    .table-styled thead,
    .table.styled thead {
        background: linear-gradient(90deg, #60a5fa, #93c5fd);
        color: #ffffff;
    }
    .table-styled th,
    .table.styled th {
        padding: 0.8rem;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }
    .table-styled tbody td,
    .table.styled tbody td {
        text-align: center;
        vertical-align: middle;
        padding: 0.6rem;
    }
    .table-styled td.text-start, .table-styled th.text-start,
    .table.styled td.text-start, .table.styled th.text-start { text-align: left !important; }
    .table-styled td.text-end,   .table-styled th.text-end,
    .table.styled td.text-end,   .table.styled th.text-end   { text-align: right !important; }

    /* (MỚI) Style cho nút loading */
    .btn-loading {
        position: relative;
        pointer-events: none;
        color: transparent !important;
    }
    .btn-loading::after {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -12px;
        margin-top: -12px;
        width: 24px;
        height: 24px;
        border: 2px solid #fff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: btn-spin 0.6s linear infinite;
    }
    @keyframes btn-spin {
        from { transform: rotate(0turn); }
        to { transform: rotate(1turn); }
    }
</style>
@endpush

{{-- Nội dung chính --}}
@section('content')
<div class="container-fluid py-3">
    {{-- Khu vực hiển thị thông báo lỗi/thành công (Giữ nguyên) --}}
    <div id="alertArea">
        {{-- ... (Giữ nguyên các thẻ alert session) ... --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Đã xảy ra lỗi:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    {{-- (ĐÃ THAY ĐỔI) Bỏ 'action' và 'method' - Sẽ xử lý bằng JS --}}
    <form id="formDatPhong">
        @csrf {{-- Vẫn giữ CSRF token --}}
        <div class="row">

            <div class="col-lg-8">
                {{-- (Giữ nguyên) Card chọn phòng --}}
                <div class="card border-0 shadow-lg mb-3" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
                    <div class="card-body py-4 px-4" style="position: relative;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>
                        <h5 class="form-label styled mb-3" style="font-size: 1.1rem;">
                            <i class="bi bi-door-open-fill me-2" style="color: #60a5fa;"></i>1. Chọn phòng trống
                        </h5>
                        <input type="text" id="searchPhong" class="form-control styled shadow-sm mb-3" placeholder="Tìm theo tên, loại phòng, giá...">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover align-middle m-0 table-styled" id="tablePhongTrong">
                                <thead>
                                    <tr>
                                        <th>Chọn</th>
                                        <th>Số phòng</th>
                                        <th>Loại phòng</th>
                                        <th>Giá / đêm</th>
                                        <th>Số người</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($danhSachPhongTrong as $phong)
                                        <tr class="phong-row" data-name="{{ $phong->TenPhong }}" data-price="{{ $phong->GiaCoBanMotDem }}">
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input radio-chon-phong" type="radio"
                                                           name="IDPhong"
                                                           id="phong_{{ $phong->IDPhong }}"
                                                           value="{{ $phong->IDPhong }}"
                                                           data-price="{{ $phong->GiaCoBanMotDem }}"
                                                           data-name="{{ $phong->SoPhong }}"
                                                           {{ old('IDPhong') == $phong->IDPhong ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            <td>{{ $phong->SoPhong }}</td>
                                            <td>{{ $phong->loaiPhong->TenLoaiPhong ?? 'N/A' }}</td>
                                            <td>{{ number_format($phong->GiaCoBanMotDem, 0, ',', '.') }} đ</td>
                                            <td>{{ $phong->SoNguoiToiDa }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Không có phòng trống nào.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- (Giữ nguyên) Card thông tin khách hàng --}}
                <div class="card border-0 shadow-lg mb-3" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
                    <div class="card-body py-4 px-4" style="position: relative;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>
                        <h5 class="form-label styled mb-3" style="font-size: 1.1rem;">
                            <i class="bi bi-person-lines-fill me-2" style="color: #60a5fa;"></i>2. Thông tin khách hàng
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="soDienThoai" class="form-label styled mb-1">Số điện thoại</label>
                                <div class="input-group">
                                    <input type="text" class="form-control styled shadow-sm in-group" id="soDienThoai" name="soDienThoai" value="{{ old('soDienThoai') }}" placeholder="Nhập SĐT để tìm...">
                                    <button class="btn btn-outline-secondary styled shadow-sm" type="button" id="btnTimSDT">
                                        <i class="bi bi-search"></i> Tìm
                                    </button>
                                </div>
                                <div id="soDienThoaiFeedback" class="form-text" style="min-height: 1.25rem;">
                                    Để trống nếu là khách lẻ 000
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="hoTen" class="form-label styled mb-1">Họ tên</label>
                                <input type="text" class="form-control styled shadow-sm" id="hoTen" name="hoTen" value="{{ old('hoTen') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label styled mb-1">Email</label>
                                <input type="email" class="form-control styled shadow-sm" id="email" name="email" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- (Giữ nguyên) Card Dịch vụ --}}
                <div class="card border-0 shadow-lg mb-3" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
                    <div class="card-body py-4 px-4" style="position: relative;">
                         <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>
                        <h5 class="form-label styled mb-3" style="font-size: 1.1rem;">
                            <i class="bi bi-bag-check-fill me-2" style="color: #60a5fa;"></i>3. Dịch vụ (Tùy chọn)
                        </h5>
                        <div class="row" style="max-height: 250px; overflow-y: auto;">
                            @forelse ($danhSachDichVu as $dv)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input chk-dichvu" type="checkbox"
                                               name="dich_vu[]"
                                               value="{{ $dv->IDDichVu }}"
                                               id="dv_{{ $dv->IDDichVu }}"
                                               data-price="{{ $dv->TienDichVu }}"
                                               {{ (is_array(old('dich_vu')) && in_array($dv->IDDichVu, old('dich_vu'))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="dv_{{ $dv->IDDichVu }}">
                                            {{ $dv->TenDichVu }} ({{ number_format($dv->TienDichVu, 0, ',', '.') }} đ)
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p>Không có dịch vụ nào.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                {{-- (Giữ nguyên) Card Tóm tắt --}}
                <div class="card border-0 shadow-lg" style="position: sticky; top: 1rem; border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
                    <div class="modal-header py-3" style="border-bottom: 1px solid #d1e0ff; position: relative;">
                        <h6 class="modal-title" style="font-family: 'Inter', sans-serif; font-weight: 600; color: #1e3a8a; font-size: 1.1rem;">
                            <i class="bi bi-receipt me-2" style="color: #60a5fa; padding-left: 15px;"></i>Tóm tắt & Thanh toán
                        </h6>
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>
                    </div>

                    <div class="card-body py-4 px-4">
                        {{-- ... (Giữ nguyên nội dung tóm tắt) ... --}}
                        <div class="mb-3">
                            <label class="form-label styled mb-1">Phòng đã chọn:</label>
                            <h4 id="phongChon" class="text-primary" style="font-weight: 600;">Chưa chọn</h4>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="ngayNhanPhong" class="form-label styled mb-1">Ngày nhận phòng</label>
                                <input type="date" class="form-control styled shadow-sm" id="ngayNhanPhong"
                                       value="{{ now()->format('Y-m-d') }}" readonly
                                       style="background-color: #e9ecef;">
                            </div>
                            <div class="col-md-12">
                                <label for="ngayTraPhong" class="form-label styled mb-1">Ngày trả phòng (*)</label>
                                <input type="date" class="form-control styled shadow-sm" id="ngayTraPhong" name="NgayTraPhong"
                                       value="{{ old('NgayTraPhong', now()->addDay()->format('Y-m-d')) }}"
                                       min="{{ now()->addDay()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <hr style="border-color: #d1e0ff;" />
                        <ul class="list-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                            <li class="list-group-item d-flex justify-content-between align-items-center" style="border: 1px solid #d1e0ff; background: #fff; padding: 0.8rem;">
                                Đơn giá phòng / đêm
                                <span><span id="donGia">0</span> đ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center" style="border: 1px solid #d1e0ff; background: #fff; padding: 0.8rem;">
                                Số đêm
                                <span>x <span id="soDem">1</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center" style="border: 1px solid #d1e0ff; background: #fff; padding: 0.8rem;">
                                Tiền dịch vụ
                                <span>+ <span id="tongTienDichVu">0</span> đ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-light fw-bold" style="border: 1px solid #d1e0ff; padding: 0.8rem;">
                                <strong class="text-primary">Tổng tiền (A)</strong>
                                <strong class="text-primary"><span id="tongCong">0</span> đ</strong>
                            </li>
                            <li class="list-group-item" style="border: 1px solid #d1e0ff; background: #fff; padding: 0.8rem;">
                                <label for="tienCoc" class="form-label styled mb-1">Tiền cọc (B) (*)</label>
                                <input type="number" class="form-control styled shadow-sm" id="tienCoc" name="TienCoc"
                                       value="{{ old('TienCoc', 0) }}" min="0">
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-info" style="border: 1px solid #d1e0ff; padding: 0.8rem;">
                                <strong class="fw-bold">Còn lại (A - B)</strong>
                                <strong class="text-danger fw-bold"><span id="conLai">0</span> đ</strong>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer py-3" style="border-top: 1px solid #d1e0ff;">
                        {{-- (ĐÃ THAY ĐỔI) Đổi type="submit" thành type="button" và thêm ID --}}
                        <button type="button" class="btn btn-primary styled w-100 btn-lg shadow-sm" style="font-size: 1.1rem;" id="btnXacNhanDatPhong">
                            <i class="bi bi-check-circle me-2"></i> Xác nhận đặt phòng
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

{{-- Scripts JS cho tính toán --}}
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const DOMElements = {
            // (MỚI) Thêm Form và Nút Submit
            formDatPhong: document.getElementById('formDatPhong'),
            btnXacNhan: document.getElementById('btnXacNhanDatPhong'),
            alertArea: document.getElementById('alertArea'),

            ngayNhan: document.getElementById('ngayNhanPhong'),
            ngayTra: document.getElementById('ngayTraPhong'),
            tienCoc: document.getElementById('tienCoc'),
            phongRadios: document.querySelectorAll('.radio-chon-phong'),
            dichVuCheckboxes: document.querySelectorAll('.chk-dichvu'),
            searchPhong: document.getElementById('searchPhong'),
            tablePhongTrong: document.getElementById('tablePhongTrong').querySelector('tbody'),
            phongChon: document.getElementById('phongChon'),
            donGia: document.getElementById('donGia'),
            soDem: document.getElementById('soDem'),
            tongTienDichVu: document.getElementById('tongTienDichVu'),
            tongCong: document.getElementById('tongCong'),
            conLai: document.getElementById('conLai'),
            btnTimSDT: document.getElementById('btnTimSDT'),
            soDienThoai: document.getElementById('soDienThoai'),
            soDienThoaiFeedback: document.getElementById('soDienThoaiFeedback'),
            hoTen: document.getElementById('hoTen'),
            email: document.getElementById('email'),
        };

        let state = {
            giaPhong: 0,
            tenPhong: 'Chưa chọn',
            soDem: 1,
            tienDichVu: 0,
            tienCoc: 0,
        };

        // --- HÀM TÍNH TOÁN (Giữ nguyên) ---
        function tinhSoDem() {
            try {
                const nhan = new Date(DOMElements.ngayNhan.value);
                const tra = new Date(DOMElements.ngayTra.value);
                const diffTime = tra - nhan;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                state.soDem = diffDays > 0 ? diffDays : 1;
            } catch (e) {
                state.soDem = 1;
            }
        }

        function tinhTienDichVu() {
            let total = 0;
            DOMElements.dichVuCheckboxes.forEach(chk => {
                if (chk.checked) {
                    total += parseFloat(chk.dataset.price || 0);
                }
            });
            state.tienDichVu = total;
        }

        function updateSummary() {
            tinhSoDem();
            tinhTienDichVu();
            state.tienCoc = parseFloat(DOMElements.tienCoc.value) || 0;
            const tongTienPhong = state.giaPhong * state.soDem;
            const tongCong = tongTienPhong + state.tienDichVu;
            const conLai = tongCong - state.tienCoc;
            DOMElements.phongChon.textContent = state.tenPhong;
            DOMElements.donGia.textContent = formatCurrency(state.giaPhong);
            DOMElements.soDem.textContent = state.soDem;
            DOMElements.tongTienDichVu.textContent = formatCurrency(state.tienDichVu);
            DOMElements.tongCong.textContent = formatCurrency(tongCong);
            DOMElements.conLai.textContent = formatCurrency(conLai);
        }

        function formatCurrency(number) {
            return new Intl.NumberFormat('vi-VN').format(number);
        }

        // --- HÀM TÌM KIẾM KHÁCH HÀNG (Giữ nguyên) ---
        async function checkKhachHang() {
            const sdt = DOMElements.soDienThoai.value.trim();
            const feedback = DOMElements.soDienThoaiFeedback;
            DOMElements.hoTen.value = '';
            DOMElements.email.value = '';
            if (sdt === '') {
                feedback.textContent = 'Để trống nếu là khách lẻ 000';
                feedback.className = 'form-text text-muted';
                return;
            }
            feedback.textContent = 'Đang tìm...';
            feedback.className = 'form-text text-info';
            try {
                // (MỚI) Đảm bảo URL API là chính xác (kiểm tra api.php của bạn)
                const response = await fetch(`/api/khach-hang/search?sdt=${encodeURIComponent(sdt)}`);
                if (!response.ok) throw new Error('Lỗi máy chủ khi tìm kiếm.');
                const json = await response.json();
                if (json.success && json.data.length > 0) {
                    const khach = json.data[0];
                    feedback.textContent = `Tìm thấy khách hàng: ${khach.HoTen}`;
                    feedback.className = 'form-text text-success';
                    DOMElements.hoTen.value = khach.HoTen;
                    DOMElements.email.value = khach.Email || '';
                } else {
                    feedback.textContent = 'Khách hàng mới. Vui lòng nhập thông tin.';
                    feedback.className = 'form-text text-warning';
                }
            } catch (error) {
                console.error('Lỗi tìm khách hàng:', error);
                feedback.textContent = 'Lỗi khi tìm kiếm. Vui lòng thử lại.';
                feedback.className = 'form-text text-danger';
            }
        }

        // --- (MỚI) HÀM XỬ LÝ SUBMIT FORM BẰNG API (AJAX/FETCH) ---
        async function handleFormSubmit(event) {
            // 1. Ngăn chặn hành vi submit mặc định
            event.preventDefault();

            const btn = DOMElements.btnXacNhan;
            btn.classList.add('btn-loading'); // Thêm class loading
            btn.disabled = true;

            // 2. Thu thập dữ liệu form
            const formData = new FormData(DOMElements.formDatPhong);

            // 3. Lấy CSRF token (đã có @csrf trong form)
            const csrfToken = formData.get('_token');

            try {
                // 4. Gửi request đến API endpoint
                const response = await fetch("{{ route('api.datphong.truc_tiep.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json', // Yêu cầu server trả về JSON
                        // 'Content-Type': 'application/json' // Không cần khi dùng FormData
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Thành công: chỉ thông báo, KHÔNG chuyển hướng
                    showAlert('success', 'Đặt phòng thành công. Vui lòng hướng dẫn khách lên phòng.');
                    // Khóa nút để tránh đặt trùng; có thể bổ sung reset form nếu cần
                    btn.textContent = 'Đã đặt phòng';
                    btn.disabled = true;

                } else {
                    // Lỗi từ server (validation hoặc lỗi 500)
                    let errorMessage = result.message || 'Đã xảy ra lỗi không xác định.';
                    if (result.errors) {
                        errorMessage = '<ul>';
                        Object.values(result.errors).forEach(errs => {
                            errs.forEach(err => {
                                errorMessage += `<li>${err}</li>`;
                            });
                        });
                        errorMessage += '</ul>';
                    }
                    showAlert('danger', `<strong>Lỗi:</strong> ${errorMessage}`);
                }

            } catch (error) {
                // Lỗi mạng hoặc lỗi JavaScript
                console.error('Fetch error:', error);
                showAlert('danger', 'Lỗi kết nối. Không thể gửi yêu cầu đặt phòng.');
            } finally {
                // 5. Hoàn tất
                btn.classList.remove('btn-loading');
                btn.disabled = false;
            }
        }

        // (MỚI) Hàm hiển thị thông báo
        function showAlert(type, message) {
            // Xóa alert cũ
            const existingAlert = DOMElements.alertArea.querySelector('.alert');
            if (existingAlert) {
                existingAlert.remove();
            }

            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.role = 'alert';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            DOMElements.alertArea.prepend(alertDiv);
            window.scrollTo(0, 0); // Cuộn lên đầu trang
        }


        // --- SỰ KIỆN (ĐÃ CẬP NHẬT) ---

        // (MỚI) Gắn sự kiện submit form vào hàm mới
        DOMElements.formDatPhong.addEventListener('submit', handleFormSubmit);
        // (MỚI) Gắn sự kiện click nút vào hàm submit (vì nút là type="button")
        DOMElements.btnXacNhan.addEventListener('click', (e) => {
             // Kích hoạt sự kiện submit của form
            DOMElements.formDatPhong.requestSubmit();
        });


        // (Giữ nguyên các sự kiện còn lại)
        DOMElements.btnTimSDT.addEventListener('click', checkKhachHang);
        DOMElements.soDienThoai.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                checkKhachHang();
            }
        });
        DOMElements.ngayTra.addEventListener('change', updateSummary);
        DOMElements.tienCoc.addEventListener('input', updateSummary);
        DOMElements.phongRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    state.giaPhong = parseFloat(this.dataset.price || 0);
                    state.tenPhong = this.dataset.name || 'Lỗi';
                    updateSummary();
                }
            });
        });
        DOMElements.dichVuCheckboxes.forEach(chk => {
            chk.addEventListener('change', updateSummary);
        });
        DOMElements.searchPhong.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const rows = DOMElements.tablePhongTrong.querySelectorAll('tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // --- KHỞI CHẠY LẦN ĐẦU (Giữ nguyên) ---
        const checkedRadio = document.querySelector('.radio-chon-phong:checked');
        if (checkedRadio) {
            state.giaPhong = parseFloat(checkedRadio.dataset.price || 0);
            state.tenPhong = checkedRadio.dataset.name || 'Lỗi';
        }
        updateSummary();
    });
</script>
@endsection
