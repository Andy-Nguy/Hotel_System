@extends('layouts.layout2')

{{-- Đặt tiêu đề trang --}}
@section('title', 'Đặt phòng trực tiếp')

{{-- Nội dung chính --}}
@section('content')
<div class="container-fluid py-3">
    {{-- Khu vực hiển thị thông báo lỗi/thành công (Giữ nguyên) --}}
    <div id="alertArea">
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

    {{-- Bắt đầu form, trỏ đến route 'store' --}}
    <form action="{{ route('datphong.truc_tiep.store') }}" method="POST" id="formDatPhong">
        @csrf
        <div class="row">

            <div class="col-lg-8">

                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">1. Chọn phòng trống</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" id="searchPhong" class="form-control mb-3" placeholder="Tìm theo tên, loại phòng, giá...">

                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover align-middle m-0" id="tablePhongTrong">
                                <thead class="table-light">
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

                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">2. Thông tin khách hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="soDienThoai" class="form-label">Số điện thoại</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="soDienThoai" name="soDienThoai" value="{{ old('soDienThoai') }}" placeholder="Nhập SĐT để tìm...">
                                    <button class="btn btn-outline-secondary" type="button" id="btnTimSDT">
                                        <i class="bi bi-search"></i> Tìm
                                    </button>
                                </div>
                                <div id="soDienThoaiFeedback" class="form-text" style="min-height: 1.25rem;">
                                    Để trống nếu là khách lẻ 000
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="hoTen" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="hoTen" name="hoTen" value="{{ old('hoTen') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">3. Dịch vụ (Tùy chọn)</h5>
                    </div>
                    <div class="card-body">
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
                <div class="card" style="position: sticky; top: 1rem;">
                    <div class="card-header">
                        <h5 class="mb-0">Tóm tắt & Thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class"form-label">Phòng đã chọn:</label>
                            <h4 id="phongChon" class="text-primary">Chưa chọn</h4>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="ngayNhanPhong" class="form-label">Ngày nhận phòng</label>
                                <input type="date" class="form-control" id="ngayNhanPhong"
                                       value="{{ now()->format('Y-m-d') }}" readonly
                                       style="background-color: #e9ecef;">
                            </div>
                            <div class="col-md-12">
                                <label for="ngayTraPhong" class="form-label">Ngày trả phòng (*)</label>
                                <input type="date" class="form-control" id="ngayTraPhong" name="NgayTraPhong"
                                       value="{{ old('NgayTraPhong', now()->addDay()->format('Y-m-d')) }}"
                                       min="{{ now()->addDay()->format('Y-m-d') }}">
                            </div>
                        </div>

                        <hr>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Đơn giá phòng / đêm
                                <span><span id="donGia">0</span> đ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Số đêm
                                <span>x <span id="soDem">1</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tiền dịch vụ
                                <span>+ <span id="tongTienDichVu">0</span> đ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                <strong class="text-primary">Tổng tiền (A)</strong>
                                <strong class="text-primary"><span id="tongCong">0</span> đ</strong>
                            </li>
                            <li class="list-group-item">
                                <label for="tienCoc" class="form-label">Tiền cọc (B) (*)</label>
                                <input type="number" class="form-control" id="tienCoc" name="TienCoc"
                                       value="{{ old('TienCoc', 0) }}" min="0">
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Còn lại (A - B)</strong>
                                <strong><span id="conLai">0</span> đ</strong>
                            </li>
                        </ul>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary w-100 btn-lg">
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
            ngayNhan: document.getElementById('ngayNhanPhong'),
            ngayTra: document.getElementById('ngayTraPhong'),
            tienCoc: document.getElementById('tienCoc'),
            phongRadios: document.querySelectorAll('.radio-chon-phong'),
            dichVuCheckboxes: document.querySelectorAll('.chk-dichvu'),
            searchPhong: document.getElementById('searchPhong'),
            tablePhongTrong: document.getElementById('tablePhongTrong').querySelector('tbody'),

            // Hiển thị tóm tắt
            phongChon: document.getElementById('phongChon'),
            donGia: document.getElementById('donGia'),
            soDem: document.getElementById('soDem'),
            tongTienDichVu: document.getElementById('tongTienDichVu'),
            tongCong: document.getElementById('tongCong'),
            conLai: document.getElementById('conLai'),

            // === (MỚI) Thêm các element cho việc tìm SĐT ===
            btnTimSDT: document.getElementById('btnTimSDT'),
            soDienThoai: document.getElementById('soDienThoai'),
            soDienThoaiFeedback: document.getElementById('soDienThoaiFeedback'),
            hoTen: document.getElementById('hoTen'),
            email: document.getElementById('email'),
            // ============================================
        };

        let state = {
            giaPhong: 0,
            tenPhong: 'Chưa chọn',
            soDem: 1,
            tienDichVu: 0,
            tienCoc: 0,
        };

        // --- HÀM TÍNH TOÁN ---

        // (Các hàm tinhSoDem, tinhTienDichVu, updateSummary, formatCurrency giữ nguyên)
        // Tính số đêm
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

        // Tính tiền dịch vụ
        function tinhTienDichVu() {
            let total = 0;
            DOMElements.dichVuCheckboxes.forEach(chk => {
                if (chk.checked) {
                    total += parseFloat(chk.dataset.price || 0);
                }
            });
            state.tienDichVu = total;
        }

        // Cập nhật toàn bộ UI
        function updateSummary() {
            // 1. Tính toán
            tinhSoDem();
            tinhTienDichVu();
            state.tienCoc = parseFloat(DOMElements.tienCoc.value) || 0;

            const tongTienPhong = state.giaPhong * state.soDem;
            const tongCong = tongTienPhong + state.tienDichVu;
            const conLai = tongCong - state.tienCoc;

            // 2. Cập nhật DOM
            DOMElements.phongChon.textContent = state.tenPhong;
            DOMElements.donGia.textContent = formatCurrency(state.giaPhong);
            DOMElements.soDem.textContent = state.soDem;
            DOMElements.tongTienDichVu.textContent = formatCurrency(state.tienDichVu);
            DOMElements.tongCong.textContent = formatCurrency(tongCong);
            DOMElements.conLai.textContent = formatCurrency(conLai);
        }

        // Helper format tiền
        function formatCurrency(number) {
            return new Intl.NumberFormat('vi-VN').format(number);
        }

        // === (MỚI) HÀM TÌM KIẾM KHÁCH HÀNG ===
        async function checkKhachHang() {
            const sdt = DOMElements.soDienThoai.value.trim();
            const feedback = DOMElements.soDienThoaiFeedback;

            // Reset form
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
                // Gọi API search từ KhachHangController
                const response = await fetch(`/api/khach-hang/search?sdt=${encodeURIComponent(sdt)}`);
                if (!response.ok) throw new Error('Lỗi máy chủ khi tìm kiếm.');

                const json = await response.json();

                if (json.success && json.data.length > 0) {
                    // Tìm thấy
                    const khach = json.data[0];
                    feedback.textContent = `Tìm thấy khách hàng: ${khach.HoTen}`;
                    feedback.className = 'form-text text-success';
                    DOMElements.hoTen.value = khach.HoTen;
                    DOMElements.email.value = khach.Email || ''; // Email có thể null
                } else {
                    // Không tìm thấy
                    feedback.textContent = 'Khách hàng mới. Vui lòng nhập thông tin.';
                    feedback.className = 'form-text text-warning';
                }
            } catch (error) {
                console.error('Lỗi tìm khách hàng:', error);
                feedback.textContent = 'Lỗi khi tìm kiếm. Vui lòng thử lại.';
                feedback.className = 'form-text text-danger';
            }
        }
        // ======================================


        // --- SỰ KIỆN ---

        // (MỚI) Thêm sự kiện cho nút tìm SĐT
        DOMElements.btnTimSDT.addEventListener('click', checkKhachHang);

        // (MỚI) Thêm sự kiện khi nhấn Enter trong ô SĐT
        DOMElements.soDienThoai.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Ngăn form submit
                checkKhachHang();
            }
        });

        // Thay đổi ngày trả phòng
        DOMElements.ngayTra.addEventListener('change', updateSummary);

        // Nhập tiền cọc
        DOMElements.tienCoc.addEventListener('input', updateSummary);

        // Chọn phòng (radio)
        DOMElements.phongRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    state.giaPhong = parseFloat(this.dataset.price || 0);
                    state.tenPhong = this.dataset.name || 'Lỗi';
                    updateSummary();
                }
            });
        });

        // Chọn dịch vụ (checkbox)
        DOMElements.dichVuCheckboxes.forEach(chk => {
            chk.addEventListener('change', updateSummary);
        });

        // Lọc/Search phòng
        DOMElements.searchPhong.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const rows = DOMElements.tablePhongTrong.querySelectorAll('tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // --- KHỞI CHẠY LẦN ĐẦU ---

        // Kích hoạt radio đã check (nếu có)
        const checkedRadio = document.querySelector('.radio-chon-phong:checked');
        if (checkedRadio) {
            state.giaPhong = parseFloat(checkedRadio.dataset.price || 0);
            state.tenPhong = checkedRadio.dataset.name || 'Lỗi';
        }

        // Chạy tính toán lần đầu
        updateSummary();
    });
</script>
@endsection
