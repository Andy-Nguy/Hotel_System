@extends('layouts.layout2')

{{-- Đặt tiêu đề cho trang --}}
@section('title', 'Khách hàng')

{{-- (MỚI) Thêm CSS để đồng bộ UI --}}
@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        /* === Styles đồng bộ từ Checkout === */
        .filter-controls .form-label.styled {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #1e3a8a;
            font-weight: 600;
            letter-spacing: 0.3px;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .filter-controls .form-control.styled,
        .filter-controls .form-select.styled {
            border: 1px solid #d1e0ff;
            background: #ffffff;
            color: #1e3a8a;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 0.6rem;
            font-size: 0.95rem;
        }

        .filter-controls .form-control.styled:focus,
        .filter-controls .form-select.styled:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
            outline: none;
            background: #f9fbff;
        }

        .filter-controls .btn.styled {
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 0.6rem 1.2rem;
            font-size: 0.95rem;
        }

        .filter-controls .btn-primary.styled {
            background: linear-gradient(90deg, #60a5fa, #93c5fd);
            border: none;
            color: #ffffff;
        }
        .filter-controls .btn-primary.styled:hover {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .filter-controls .btn-success.styled {
            background: linear-gradient(90deg, #22c55e, #4ade80);
            border: none;
            color: #ffffff;
        }
        .filter-controls .btn-success.styled:hover {
            background: linear-gradient(90deg, #16a34a, #22c55e);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        .filter-controls .btn-outline-secondary.styled {
            border: 1px solid #d1e0ff;
            color: #1e3a8a;
        }
        .filter-controls .btn-outline-secondary.styled:hover {
            background: #e6f0ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .filter-controls .btn-info.styled { /* Nút Xuất Excel */
            border: 1px solid #a5f3fc;
            color: #0e7490;
            background: #ecfeff;
        }
         .filter-controls .btn-info.styled:hover {
            background: #cffafe;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Fix bo góc cho input group */
        .filter-controls .input-group .btn.styled {
            border-radius: 0 10px 10px 0;
        }
        .filter-controls .input-group .form-control.styled {
            border-radius: 10px 0 0 10px;
        }

        .table-styled {
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }
        .table-styled thead {
            background: linear-gradient(90deg, #60a5fa, #93c5fd);
            color: #ffffff;
        }
        .table-styled th {
            padding: 0.8rem;
            text-align: center;
        }
        .table-styled tbody td {
            text-align: center;
        }

        /* Style cho modal giống checkout */
        .modal-content.styled {
            border-radius: 16px;
            border: none;
            background: linear-gradient(180deg, #f9fbff, #e6f0ff);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
        .modal-header.styled {
            border-bottom: 1px solid #d1e0ff;
            position: relative;
            padding: 0.75rem 1.25rem;
        }
        .modal-header.styled .modal-title {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            color: #1e3a8a;
            font-size: 1.1rem;
        }
        .modal-header.styled .decorator-line {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #60a5fa, #a78bfa);
        }
        .modal-footer.styled {
            border-top: 1px solid #d1e0ff;
            padding: 0.75rem 1.25rem;
        }
        .modal-body.styled .form-label {
            font-family: 'Inter', sans-serif;
            color: #1e3a8a;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .modal-body.styled .form-control,
        .modal-body.styled .form-select {
            border: 1px solid #d1e0ff;
            background: #ffffff;
            color: #1e3a8a;
            border-radius: 10px;
            padding: 0.6rem;
        }
        .modal-body.styled .form-control:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
            background: #f9fbff;
        }
         .modal-body.styled .btn-outline-primary { /* Nút Gửi OTP */
            border: 1px solid #d1e0ff;
            color: #1e3a8a;
            font-weight: 500;
            border-radius: 0 10px 10px 0;
            padding: 0.6rem;
         }
         .modal-body.styled .input-group .form-control {
            border-radius: 10px 0 0 10px;
         }
    </style>
@endpush

@section('content')
    {{-- Thêm padding p-3 (vì layout2 không có) --}}
    <div class="p-3">
        {{-- (MỚI) Card cho Bộ lọc --}}
        <div class="card border-0 shadow-lg mb-4"
            style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
            <div class="card-body py-4 px-4" style="position: relative;">
                {{-- Viền trang trí --}}
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>

                {{-- (ĐÃ SỬA) Bố cục filter controls --}}
                <div class="row g-3 align-items-center filter-controls">
                    <div class="col-lg-5">
                        <label class="form-label styled">Tìm kiếm</label>
                        <div class="input-group">
                            <input id="kh-search" type="text" class="form-control styled shadow-sm" placeholder="Tìm theo tên, email hoặc số điện thoại" style="border-radius: 10px 0 0 10px;" />
                            <button id="kh-search-btn" class="btn btn-primary styled shadow-sm" style="border-radius: 0 10px 10px 0;">Tìm</button>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <label class="form-label styled">Hiển thị</label>
                        <select id="kh-perpage" class="form-select styled shadow-sm">
                            <option value="10" selected>10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="col-lg-5 col-md-9 d-flex align-items-end justify-content-end gap-2 flex-wrap">
                        <button id="kh-add-btn" class="btn btn-success styled shadow-sm">Thêm khách hàng</button>
                        <button id="kh-print-btn" class="btn btn-outline-secondary styled shadow-sm">In</button>
                        <button id="kh-export-btn" class="btn btn-info styled shadow-sm">Xuất Excel</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- (ĐÃ SỬA) Card cho Bảng --}}
        <div class="card border-0 shadow-lg mb-4"
            style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
            <div class="card-body py-4 px-4" style="position: relative;">
                {{-- Viền trang trí --}}
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>

                <div class="table-responsive mt-2">
                    {{-- (ĐÃ SỬA) Thêm .table-styled, bỏ .table-bordered --}}
                    <table class="table table-hover table-styled" id="kh-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Ngày sinh</th>
                                <th>Ngày đăng ký</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Đang tải...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <nav class="mt-3">
                    <ul class="pagination justify-content-center" id="kh-pagination"></ul>
                </nav>
            </div>
        </div>


        {{-- (ĐÃ SỬA) Modal Thêm Khách Hàng (Chuyển sang Bootstrap 5) --}}
        <div id="kh-add-modal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content styled">
                    <div class="modal-header styled">
                        <h5 class="modal-title">Thêm khách hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        <div class="decorator-line"></div>
                    </div>
                    <div class="modal-body styled">
                        <div id="kh-add-errors" class="alert alert-danger" style="display:none"></div>

                        <div class="mb-3">
                            <label class="form-label">Chọn lựa chọn *</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input kh-choice" type="radio" name="kh_choice"
                                        id="kh_choice_account" value="account" checked />
                                    <label class="form-check-label" for="kh_choice_account">
                                        Tạo tài khoản (có xác nhận OTP)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input kh-choice" type="radio" name="kh_choice"
                                        id="kh_choice_guest" value="guest" />
                                    <label class="form-check-label" for="kh_choice_guest">
                                        Không tạo tài khoản (chỉ lưu khách hàng)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr style="border-color: #d1e0ff;" />

                        <form id="kh-add-form" onsubmit="return false;">
                            <div class="mb-2">
                                <label class="form-label">Họ tên *</label>
                                <input name="HoTen" class="form-control" required />
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Email *</label>
                                <div id="kh-email-group" class="input-group">
                                    <input name="Email" id="kh-email" class="form-control" required />
                                    <button type="button" class="btn btn-outline-primary"
                                        id="kh-send-otp-btn">Gửi OTP</button>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Số điện thoại</label>
                                <input name="SoDienThoai" class="form-control" />
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Ngày sinh</label>
                                <input name="NgaySinh" type="date" class="form-control" />
                            </div>

                            <div id="kh-otp-group" class="mb-2" style="display:none;">
                                <label class="form-label">Mã OTP *</label>
                                <input name="Otp" type="text" class="form-control"
                                    placeholder="Nhập mã OTP 6 số" maxlength="6" />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer styled">
                        <button class="btn btn-success styled" id="kh-add-submit">Lưu</button>
                        <button class="btn btn-outline-secondary styled" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- (ĐÃ SỬA) Modal Sửa Khách Hàng (Chuyển sang Bootstrap 5) --}}
        <div id="kh-edit-modal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content styled">
                    <div class="modal-header styled">
                        <h5 class="modal-title">Sửa thông tin khách hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        <div class="decorator-line"></div>
                    </div>
                    <div class="modal-body styled">
                        <div id="kh-edit-errors" class="alert alert-danger" style="display:none"></div>

                        <form id="kh-edit-form" onsubmit="return false;">
                            <input type="hidden" name="id" id="kh-edit-id" />
                            <div class="mb-2">
                                <label class="form-label">Họ tên *</label>
                                <input name="HoTen" class="form-control" required />
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Số điện thoại</label>
                                <input name="SoDienThoai" class="form-control" />
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Ngày sinh</label>
                                <input name="NgaySinh" type="date" class="form-control" />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer styled">
                        <button class="btn btn-success styled" id="kh-edit-submit">Lưu</button>
                        <button class="btn btn-outline-secondary styled" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- Các script dành riêng cho trang này --}}
@section('scripts')
    <script>
        (function() {
            const tableBody = document.querySelector('#kh-table tbody');
            const paginationEl = document.getElementById('kh-pagination');
            const searchInput = document.getElementById('kh-search');
            const perPageSelect = document.getElementById('kh-perpage');
            const searchBtn = document.getElementById('kh-search-btn');

            let currentPage = 1;

            // (MỚI) Khai báo biến modal
            const addModalEl = document.getElementById('kh-add-modal');
            const editModalEl = document.getElementById('kh-edit-modal');
            let ADD_MODAL, EDIT_MODAL;

            // (MỚI) Khởi tạo modal instances khi DOM sẵn sàng
            document.addEventListener('DOMContentLoaded', function() {
                if (addModalEl) ADD_MODAL = new bootstrap.Modal(addModalEl);
                if (editModalEl) EDIT_MODAL = new bootstrap.Modal(editModalEl);
            });


            function fmtDate(d) {
                if (!d) return '';
                try {
                    return new Date(d).toLocaleDateString('vi-VN');
                } catch (e) {
                    return d;
                }
            }

            function load(page) {
                const q = encodeURIComponent(searchInput.value || '');
                const per = encodeURIComponent(perPageSelect.value || '20');
                const url = '/api/khachhang?q=' + q + '&per_page=' + per + '&page=' + page;
                tableBody.innerHTML =
                    '<tr><td colspan="7" class="text-center text-muted">Đang tải...</td></tr>';
                fetch(url, {
                        credentials: 'same-origin'
                    })
                    .then(r => r.json())
                    .then(function(json) {
                        const items = json.data || [];
                        if (!items.length) {
                            tableBody.innerHTML =
                                '<tr><td colspan="7" class="text-center">Không có khách hàng.</td></tr>';
                            paginationEl.innerHTML = '';
                            return;
                        }
                        tableBody.innerHTML = items.map(function(k) {
                            // (ĐÃ SỬA) Đảm bảo data-customer được bao trong dấu nháy đơn
                            const khData = JSON.stringify(k).replace(/'/g, "&apos;");
                            return `<tr>
                            <td>${k.IDKhachHang || ''}</td>
                            <td>${k.HoTen || ''}</td>
                            <td>${k.Email || ''}</td>
                            <td>${k.SoDienThoai || ''}</td>
                            <td>${fmtDate(k.NgaySinh)}</td>
                            <td>${fmtDate(k.NgayDangKy)}</td>
                            <td><button class="btn btn-sm btn-warning kh-edit-btn" data-customer='${khData}'>Sửa</button></td>
                        </tr>`;
                        }).join('');

                        // render pagination
                        const meta = json.meta || null;
                        if (meta) {
                            const total = meta.total || 0;
                            const perPage = meta.per_page || 10;
                            const current = meta.current_page || 1;
                            const last = meta.last_page || 1;
                            currentPage = current;
                            let html = '';

                            function pageBtn(p, label, cls) {
                                return `<li class="page-item ${cls || ''}"><a class="page-link" href="#" data-page="${p}">${label}</a></li>`;
                            }
                            // Prev
                            if (current > 1) html += pageBtn(current - 1, '‹');

                            if (last <= 7) {
                                for (let i = 1; i <= last; i++) {
                                    const cls = (i === current) ? 'active' : '';
                                    html += pageBtn(i, i, cls);
                                }
                            } else {
                                // show first
                                if (current <= 4) {
                                    for (let i = 1; i <= 5; i++) {
                                        const cls = (i === current) ? 'active' : '';
                                        html += pageBtn(i, i, cls);
                                    }
                                    html +=
                                        `<li class="page-item disabled"><span class="page-link">…</span></li>`;
                                    html += pageBtn(last, last);
                                } else if (current > last - 4) {
                                    html += pageBtn(1, 1);
                                    html +=
                                        `<li class="page-item disabled"><span class="page-link">…</span></li>`;
                                    for (let i = last - 4; i <= last; i++) {
                                        const cls = (i === current) ? 'active' : '';
                                        html += pageBtn(i, i, cls);
                                    }
                                } else {
                                    html += pageBtn(1, 1);
                                    html +=
                                        `<li class="page-item disabled"><span class="page-link">…</span></li>`;
                                    for (let i = current - 2; i <= current + 2; i++) {
                                        const cls = (i === current) ? 'active' : '';
                                        html += pageBtn(i, i, cls);
                                    }
                                    html +=
                                        `<li class="page-item disabled"><span class="page-link">…</span></li>`;
                                    html += pageBtn(last, last);
                                }
                            }

                            // Next
                            if (current < last) html += pageBtn(current + 1, '›');
                            paginationEl.innerHTML = html;
                        } else {
                            paginationEl.innerHTML = '';
                        }
                    })
                    .catch(function(err) {
                        tableBody.innerHTML =
                            '<tr><td colspan="7" class="text-center text-danger">Lỗi tải dữ liệu.</td></tr>';
                        paginationEl.innerHTML = '';
                    });
            }

            // click pagination
            document.addEventListener('click', function(e) {
                const a = e.target.closest && e.target.closest('#kh-pagination a');
                if (!a) return;
                e.preventDefault();
                const p = parseInt(a.getAttribute('data-page') || '1');
                if (p && p !== currentPage) load(p);
            });

            searchBtn.addEventListener('click', function() {
                load(1);
            });
            perPageSelect.addEventListener('change', function() {
                load(1);
            });
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    load(1);
                }
            });

            // initial load
            load(1);

            // Add customer modal behaviour with 2 choices
            const addBtn = document.getElementById('kh-add-btn');
            const printBtn = document.getElementById('kh-print-btn');
            // (ĐÃ SỬA) Không cần các nút close/cancel vì data-bs-dismiss đã xử lý
            const addSubmit = document.getElementById('kh-add-submit');
            const addForm = document.getElementById('kh-add-form');
            const addErrors = document.getElementById('kh-add-errors');
            const choiceRadios = document.querySelectorAll('.kh-choice');
            const emailInput = document.getElementById('kh-email');
            const emailGroup = document.getElementById('kh-email-group');
            const sendOtpBtn = document.getElementById('kh-send-otp-btn');
            const otpGroup = document.getElementById('kh-otp-group');
            const otpInput = document.querySelector('input[name="Otp"]');

            // (ĐÃ XÓA) function showModal(modal)
            // (ĐÃ XÓA) function closeModal(modal)

            // Toggle OTP field and button based on choice
            function updateOtpVisibility() {
                const choice = document.querySelector('input[name="kh_choice"]:checked').value;
                if (choice === 'account') {
                    // Show OTP button and group
                    emailGroup.classList.add('input-group');
                    sendOtpBtn.style.display = 'block';
                    otpInput.required = true;
                } else {
                    // Hide OTP button and group for guest
                    emailGroup.classList.remove('input-group');
                    sendOtpBtn.style.display = 'none';
                    otpGroup.style.display = 'none';
                    otpInput.required = false;
                    otpInput.value = '';
                }
            }

            choiceRadios.forEach(function(radio) {
                radio.addEventListener('change', updateOtpVisibility);
            });

            // Print current visible customers
            if (printBtn) {
                printBtn.addEventListener('click', function() {
                    // collect visible rows from the table
                    const rows = Array.from(document.querySelectorAll('#kh-table tbody tr'));
                    if (!rows.length) {
                        alert('Không có dữ liệu để in');
                        return;
                    }

                    // Build printable HTML
                    let html =
                        '<!doctype html><html><head><meta charset="utf-8"><title>Danh sách khách hàng</title>' +
                        '<style>body{font-family:Arial,Helvetica,sans-serif;padding:20px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ccc;padding:8px;text-align:left}th{background:#f5f5f5}</style>' +
                        '</head><body>' +
                        '<h3>Danh sách khách hàng</h3>' +
                        '<table><thead><tr><th>ID</th><th>Họ tên</th><th>Email</th><th>Số điện thoại</th><th>Ngày sinh</th><th>Ngày đăng ký</th></tr></thead><tbody>';

                    // (ĐÃ SỬA) Giữ nguyên thứ tự, không reverse
                    rows.forEach(function(r) {
                        const cols = r.querySelectorAll('td');
                        if (!cols || cols.length < 6) return;
                        const id = cols[0].textContent.trim();
                        const name = cols[1].textContent.trim();
                        const email = cols[2].textContent.trim();
                        const phone = cols[3].textContent.trim();
                        const dob = cols[4].textContent.trim();
                        const reg = cols[5].textContent.trim();
                        html += '<tr>' +
                            '<td>' + id + '</td>' +
                            '<td>' + name + '</td>' +
                            '<td>' + email + '</td>' +
                            '<td>' + phone + '</td>' +
                            '<td>' + dob + '</td>' +
                            '<td>' + reg + '</td>' +
                            '</tr>';
                    });

                    html += '</tbody></table>';

                    // add print date/time and signature block
                    const now = new Date();

                    function pad(n) {
                        return n < 10 ? '0' + n : n;
                    }
                    const printedAt = pad(now.getDate()) + '/' + pad(now.getMonth() + 1) + '/' + now
                        .getFullYear() + ' ' + pad(now.getHours()) + ':' + pad(now.getMinutes());
                    html += '<div style="margin-top:30px;font-size:14px;">';
                    html += '<div>Ngày in: <strong>' + printedAt + '</strong></div>';
                    html += '<div style="margin-top:40px;">Người in (ký, ghi rõ họ tên):</div>';
                    html += '<div style="margin-top:60px;">__________________________</div>';
                    html += '</div>';
                    html += '</body></html>';

                    const w = window.open('', '_blank');
                    if (!w) {
                        alert('Trình duyệt chặn cửa sổ bật lên. Vui lòng cho phép popups để in.');
                        return;
                    }
                    w.document.open();
                    w.document.write(html);
                    w.document.close();
                    // small delay to ensure rendering
                    setTimeout(function() {
                        w.print();
                    }, 300);
                });
            }

            // Send OTP when email is filled
            sendOtpBtn && sendOtpBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const email = emailInput.value.trim();
                if (!email) {
                    alert('Vui lòng nhập email trước');
                    return;
                }
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert('Email không hợp lệ');
                    return;
                }

                // Check if email already exists
                fetch('/api/khachhang?email=' + encodeURIComponent(email), {
                        credentials: 'same-origin'
                    })
                    .then(r => r.json())
                    .then(function(json) {
                        const items = json.data || [];
                        if (items.length > 0) {
                            alert('Email này đã tồn tại');
                            return;
                        }

                        // Send OTP via API
                        sendOtpBtn.disabled = true;
                        fetch('/api/register-with-account', {
                                method: 'POST',
                                credentials: 'same-origin',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    HoTen: document.querySelector(
                                        '#kh-add-form input[name="HoTen"]').value || 'Khách hàng', // (SỬA) Thêm #kh-add-form
                                    Email: email,
                                    MatKhau: '123456',
                                    SoDienThoai: document.querySelector(
                                            '#kh-add-form input[name="SoDienThoai"]').value || // (SỬA) Thêm #kh-add-form
                                        '',
                                    NgaySinh: document.querySelector(
                                            '#kh-add-form input[name="NgaySinh"]').value || // (SỬA) Thêm #kh-add-form
                                        ''
                                })
                            })
                            .then(r => r.json().then(b => {
                                if (!r.ok) throw {
                                    status: r.status,
                                    body: b
                                };
                                return b;
                            }))
                            .then(function(json) {
                                otpGroup.style.display = 'block';
                                alert('Đã gửi OTP tới email ' + email +
                                    '. Vui lòng kiểm tra email và nhập OTP.');
                                sendOtpBtn.disabled = false;
                            })
                            .catch(function(err) {
                                sendOtpBtn.disabled = false;
                                alert('Lỗi gửi OTP: ' + (err.body && err.body.message ? err.body
                                    .message : 'Vui lòng thử lại'));
                            });
                    })
                    .catch(function(err) {
                        alert('Lỗi kiểm tra email');
                    });
            });

            addBtn && addBtn.addEventListener('click', function() {
                if (addErrors) {
                    addErrors.style.display = 'none';
                    addErrors.innerHTML = '';
                }
                if (addForm) addForm.reset();
                // Reset to account choice by default
                document.getElementById('kh_choice_account').checked = true;
                updateOtpVisibility();
                otpGroup.style.display = 'none';
                // (ĐÃ SỬA)
                if (ADD_MODAL) ADD_MODAL.show();
            });

            // (ĐÃ XÓA) addClose, addCancel listeners

            addSubmit && addSubmit.addEventListener('click', function(e) {
                e.preventDefault();
                if (!addForm) return;

                const choice = document.querySelector('#kh-add-form input[name="kh_choice"]:checked').value;
                const hoTen = document.querySelector('#kh-add-form input[name="HoTen"]').value;
                const email = document.querySelector('#kh-add-form input[name="Email"]').value;
                const soDienThoai = document.querySelector('#kh-add-form input[name="SoDienThoai"]').value;
                const ngaySinh = document.querySelector('#kh-add-form input[name="NgaySinh"]').value;
                const otp = document.querySelector('#kh-add-form input[name="Otp"]').value;

                // Validate
                if (!hoTen || !email) {
                    addErrors.style.display = 'block';
                    addErrors.innerHTML = '<div>Vui lòng nhập Họ tên và Email</div>';
                    return;
                }

                // If account choice, OTP is required
                if (choice === 'account' && !otp) {
                    addErrors.style.display = 'block';
                    addErrors.innerHTML = '<div>Vui lòng nhập OTP hoặc gửi OTP trước</div>';
                    return;
                }

                addSubmit.disabled = true;

                let payload = {
                    HoTen: hoTen,
                    Email: email,
                    SoDienThoai: soDienThoai,
                    NgaySinh: ngaySinh
                };

                // Determine which API to use
                let apiUrl = '/api/register-guest'; // default: guest
                if (choice === 'account') {
                    // Verify OTP first
                    apiUrl = '/api/verify-otp-account';
                    payload = {
                        Email: email,
                        Otp: otp
                    };
                }

                fetch(apiUrl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(function(res) {
                        return res.json().then(function(body) {
                            if (!res.ok) throw {
                                status: res.status,
                                body: body
                            };
                            return body;
                        });
                    })
                    .then(function(json) {
                        // (ĐÃ SỬA)
                        if (ADD_MODAL) ADD_MODAL.hide();
                        addSubmit.disabled = false; // (SỬA) Bật lại nút
                        try {
                            load(1);
                        } catch (e) {}
                        alert('Thêm khách hàng thành công!');
                    })
                    .catch(function(err) {
                        addSubmit.disabled = false;
                        if (err && err.status === 422 && err.body && err.body.messages) {
                            const msgs = err.body.messages;
                            let html = '<ul class="mb-0">';
                            Object.keys(msgs).forEach(function(k) {
                                msgs[k].forEach(function(m) {
                                    html += '<li>' + m + '</li>';
                                });
                            });
                            html += '</ul>';
                            addErrors.style.display = 'block';
                            addErrors.innerHTML = html;
                        } else if (err && err.status === 409) {
                            addErrors.style.display = 'block';
                            addErrors.innerHTML = '<div>' + (err.body && err.body.message ? err.body
                                .message : 'Conflict') + '</div>';
                        } else {
                            addErrors.style.display = 'block';
                            addErrors.innerHTML = '<div>Lỗi: ' + (err.body && err.body.message ? err
                                .body.message : 'Vui lòng thử lại') + '</div>';
                        }
                    });
            });

            // Edit customer
            // (ĐÃ SỬA) Không cần các nút close/cancel
            const editSubmit = document.getElementById('kh-edit-submit');
            const editForm = document.getElementById('kh-edit-form');
            const editErrors = document.getElementById('kh-edit-errors');
            const editIdInput = document.getElementById('kh-edit-id');

            // Handle edit button click in table
            document.addEventListener('click', function(e) {
                const editBtn = e.target.closest && e.target.closest('.kh-edit-btn');
                if (!editBtn) return;

                try {
                    const khData = editBtn.getAttribute('data-customer');
                    if (!khData) {
                        alert('Lỗi: Không tìm thấy dữ liệu khách hàng');
                        return;
                    }
                    const kh = JSON.parse(khData);

                    // Populate form with customer data
                    editIdInput.value = kh.IDKhachHang;
                    document.querySelector('#kh-edit-form input[name="HoTen"]').value = kh.HoTen || '';
                    document.querySelector('#kh-edit-form input[name="SoDienThoai"]').value = kh
                        .SoDienThoai || '';
                    document.querySelector('#kh-edit-form input[name="NgaySinh"]').value = kh.NgaySinh || '';
                    editErrors.style.display = 'none';
                    editErrors.innerHTML = '';
                    // (ĐÃ SỬA)
                    if (EDIT_MODAL) EDIT_MODAL.show();
                } catch (err) {
                    alert('Lỗi: ' + err.message);
                }
            });

            // (ĐÃ XÓA) editClose, editCancel listeners

            editSubmit && editSubmit.addEventListener('click', function(e) {
                e.preventDefault();
                if (!editForm) return;

                const id = editIdInput.value;
                const hoTen = document.querySelector('#kh-edit-form input[name="HoTen"]').value;
                const soDienThoai = document.querySelector('#kh-edit-form input[name="SoDienThoai"]')
                    .value;
                const ngaySinh = document.querySelector('#kh-edit-form input[name="NgaySinh"]').value;

                // Validate
                if (!hoTen) {
                    editErrors.style.display = 'block';
                    editErrors.innerHTML = '<div>Vui lòng nhập Họ tên</div>';
                    return;
                }

                editSubmit.disabled = true;

                const payload = {
                    HoTen: hoTen,
                    SoDienThoai: soDienThoai || undefined,
                    NgaySinh: ngaySinh || undefined
                };

                fetch('/api/khachhang/' + id, {
                        method: 'PUT',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(function(res) {
                        return res.json().then(function(body) {
                            if (!res.ok) throw {
                                status: res.status,
                                body: body
                            };
                            return body;
                        });
                    })
                    .then(function(json) {
                        editSubmit.disabled = false;
                        // (ĐÃ SỬA)
                        if (EDIT_MODAL) EDIT_MODAL.hide();
                        load(currentPage);
                        alert('Cập nhật khách hàng thành công!');
                    })
                    .catch(function(err) {
                        editSubmit.disabled = false;
                        if (err && err.status === 422 && err.body && err.body.messages) {
                            const msgs = err.body.messages;
                            let html = '<ul class="mb-0">';
                            Object.keys(msgs).forEach(function(k) {
                                msgs[k].forEach(function(m) {
                                    html += '<li>' + m + '</li>';
                                });
                            });
                            html += '</ul>';
                            editErrors.style.display = 'block';
                            editErrors.innerHTML = html;
                        } else if (err && err.status === 409) {
                            editErrors.style.display = 'block';
                            editErrors.innerHTML = '<div>' + (err.body && err.body.message ? err.body
                                .message : 'Conflict') + '</div>';
                        } else if (err && err.status === 404) {
                            editErrors.style.display = 'block';
                            editErrors.innerHTML = '<div>Khách hàng không tồn tại</div>';
                        } else {
                            editErrors.style.display = 'block';
                            editErrors.innerHTML = '<div>Lỗi: ' + (err.body && err.body.message ? err
                                .body.message : 'Vui lòng thử lại') + '</div>';
                        }
                    });
            });

            // Export to Excel (CSV)
            const exportBtn = document.getElementById('kh-export-btn');

            if (exportBtn) {
                exportBtn.addEventListener('click', function() {
                    const rows = Array.from(document.querySelectorAll('#kh-table tbody tr'));
                    if (!rows.length) {
                        alert('Không có dữ liệu để xuất');
                        return;
                    }

                    const data = [
                        ['ID', 'Họ tên', 'Email', 'Số điện thoại', 'Ngày sinh', 'Ngày đăng ký']
                    ];

                    rows.forEach(function(r) {
                        const cols = r.querySelectorAll('td');
                        if (!cols || cols.length < 6) return;
                        const id = cols[0].textContent.trim();
                        const name = cols[1].textContent.trim();
                        const email = cols[2].textContent.trim();
                        const phone = cols[3].textContent.trim();
                        const dob = cols[4].textContent.trim();
                        const reg = cols[5].textContent.trim();
                        data.push([id, name, email, phone, dob, reg]);
                    });

                    const csvContent = data.map(e => e.map(function(cell) {
                        if (cell === null || cell === undefined) return '';
                        var s = cell.toString();
                        if (s.indexOf(',') >= 0 || s.indexOf('"') >= 0 || s
                            .indexOf('\n') >= 0) {
                            s = '"' + s.replace(/"/g, '""') + '"';
                        }
                        return s;
                    }).join(',')).join('\n');
                    // prepend UTF-8 BOM so Excel (Windows) recognizes UTF-8 and displays Vietnamese correctly
                    const blob = new Blob(["\uFEFF" + csvContent], {
                        type: 'text/csv;charset=utf-8;'
                    });
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'Danh_sach_khach_hang.csv';
                    link.style.display = 'none';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                });
            }
        })();
    </script>
@endsection
