<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Quản lý Khách hàng - Adminlite</title>

    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.svg')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/bootstrap/bootstrap-icons.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/main.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css')); ?>" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        .cursor-pointer {
            cursor: pointer
        }

        .form-check-box-list {
            max-height: 360px;
            overflow: auto;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="main-container">

            <!-- Sidebar -->
            <nav id="sidebar" class="sidebar-wrapper">
                <div class="app-brand p-3 mb-3">
                    <a href="<?php echo e(route('khachhang.index')); ?>">
                        <img src="<?php echo e(asset('assets/images/logo.svg')); ?>" class="logo" alt="AdminLite" />
                    </a>
                </div>
                <div class="sidebarMenuScroll">
                    <ul class="sidebar-menu">
                        <li class="active current-page">
                            <a href="<?php echo e(route('khachhang.index')); ?>">
                                <i class="bi bi-box"></i>
                                <span class="menu-text">Khách hàng</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="sidebar-settings gap-1 d-lg-flex d-none">
                    <a href="#" class="settings-icon" data-bs-toggle="tooltip" title="Profile">
                        <i class="bi bi-person"></i>
                    </a>
                </div>
            </nav>
            <!-- Sidebar ends -->

            <!-- App container -->
            <div class="app-container">
                <!-- Header -->
                <div class="app-header d-flex align-items-center">
                    <div class="d-flex">
                        <button class="pin-sidebar">
                            <i class="bi bi-list lh-1"></i>
                        </button>
                    </div>
                    <div class="d-flex align-items-center ms-3">
                        <h5 class="m-0">Quản lý Khách hàng</h5>
                    </div>
                    <div class="app-brand-sm d-lg-none d-flex ms-auto">
                        <a href="<?php echo e(route('khachhang.index')); ?>">
                            <img src="<?php echo e(asset('assets/images/logo-sm.svg')); ?>" class="logo" alt="AdminLite" />
                        </a>
                    </div>
                    <div class="header-actions">
                        <div class="d-flex">
                            <button class="toggle-sidebar">
                                <i class="bi bi-list lh-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Header ends -->

                <!-- Body -->
                <div class="app-body p-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex mb-3 align-items-center">
                                <input id="kh-search" type="text" class="form-control me-2" placeholder="Tìm theo tên, email hoặc số điện thoại" style="max-width:800px;" />
                                <select id="kh-perpage" class="form-select w-auto me-2">
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                                <button id="kh-search-btn" class="btn btn-primary btn-sm me-2">Tìm</button>
                                <button id="kh-add-btn" class="btn btn-success btn-sm">Thêm khách hàng</button>
                                <button id="kh-print-btn" class="btn btn-secondary btn-sm ms-2">In</button>
                                <button id="kh-export-btn" class="btn btn-info btn-sm ms-2">Xuất Excel</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="kh-table">
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
                                        <tr><td colspan="6" class="text-center text-muted">Đang tải...</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            <nav>
                                <ul class="pagination" id="kh-pagination"></ul>
                            </nav>
                            
                            <!-- Add customer modal with 2 choices -->
                            <div id="kh-add-modal" class="modal" tabindex="-1" style="display:none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Thêm khách hàng</h5>
                                            <button type="button" class="btn-close" id="kh-add-close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="kh-add-errors" class="alert alert-danger" style="display:none"></div>
                                            
                                            <!-- Choice selection -->
                                            <div class="mb-3">
                                                <label class="form-label">Chọn lựa chọn *</label>
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input kh-choice" type="radio" name="kh_choice" id="kh_choice_account" value="account" checked />
                                                        <label class="form-check-label" for="kh_choice_account">
                                                            Tạo tài khoản (có xác nhận OTP)
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input kh-choice" type="radio" name="kh_choice" id="kh_choice_guest" value="guest" />
                                                        <label class="form-check-label" for="kh_choice_guest">
                                                            Không tạo tài khoản (chỉ lưu khách hàng)
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr />

                                            <form id="kh-add-form">
                                                <div class="mb-2">
                                                    <label class="form-label">Họ tên *</label>
                                                    <input name="HoTen" class="form-control" required />
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Email *</label>
                                                    <div id="kh-email-group" class="input-group">
                                                        <input name="Email" id="kh-email" class="form-control" required />
                                                        <button type="button" class="btn btn-outline-primary" id="kh-send-otp-btn">Gửi OTP</button>
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

                                                <!-- OTP field (only for account creation) -->
                                                <div id="kh-otp-group" class="mb-2" style="display:none;">
                                                    <label class="form-label">Mã OTP *</label>
                                                    <input name="Otp" type="text" class="form-control" placeholder="Nhập mã OTP 6 số" maxlength="6" />
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-success" id="kh-add-submit">Lưu</button>
                                            <button class="btn btn-secondary" id="kh-add-cancel">Hủy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit customer modal -->
                            <div id="kh-edit-modal" class="modal" tabindex="-1" style="display:none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Sửa thông tin khách hàng</h5>
                                            <button type="button" class="btn-close" id="kh-edit-close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="kh-edit-errors" class="alert alert-danger" style="display:none"></div>
                                            
                                            <form id="kh-edit-form">
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
                                        <div class="modal-footer">
                                            <button class="btn btn-success" id="kh-edit-submit">Lưu</button>
                                            <button class="btn btn-secondary" id="kh-edit-cancel">Hủy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Body ends -->

            </div>
            <!-- App container ends -->
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/overlay-scroll/custom-scrollbar.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/custom.js')); ?>"></script>
</script>
    <script>
    (function(){
        const tableBody = document.querySelector('#kh-table tbody');
        const paginationEl = document.getElementById('kh-pagination');
        const searchInput = document.getElementById('kh-search');
        const perPageSelect = document.getElementById('kh-perpage');
        const searchBtn = document.getElementById('kh-search-btn');

        let currentPage = 1;

        function fmtDate(d){ if(!d) return ''; try { return new Date(d).toLocaleDateString('vi-VN'); } catch(e){ return d; } }

        function load(page){
            const q = encodeURIComponent(searchInput.value || '');
            const per = encodeURIComponent(perPageSelect.value || '20');
            const url = '/api/khachhang?q=' + q + '&per_page=' + per + '&page=' + page;
            tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Đang tải...</td></tr>';
            fetch(url, { credentials: 'same-origin' })
                .then(r => r.json())
                .then(function(json){
                    const items = json.data || [];
                    if (!items.length) {
                        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Không có khách hàng.</td></tr>';
                        paginationEl.innerHTML = '';
                        return;
                    }
                    tableBody.innerHTML = items.map(function(k){
                        const khData = JSON.stringify(k);
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
                        function pageBtn(p, label, cls){ return `<li class="page-item ${cls || ''}"><a class="page-link" href="#" data-page="${p}">${label}</a></li>`; }
                        // Prev
                        if (current > 1) html += pageBtn(current-1, '‹');

                        if (last <= 7) {
                            for (let i = 1; i <= last; i++) {
                                const cls = (i===current) ? 'active' : '';
                                html += pageBtn(i, i, cls);
                            }
                        } else {
                            // show first
                            if (current <= 4) {
                                for (let i = 1; i <= 5; i++) {
                                    const cls = (i===current) ? 'active' : '';
                                    html += pageBtn(i, i, cls);
                                }
                                html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
                                html += pageBtn(last, last);
                            } else if (current > last - 4) {
                                html += pageBtn(1, 1);
                                html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
                                for (let i = last-4; i <= last; i++) {
                                    const cls = (i===current) ? 'active' : '';
                                    html += pageBtn(i, i, cls);
                                }
                            } else {
                                html += pageBtn(1, 1);
                                html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
                                for (let i = current-2; i <= current+2; i++) {
                                    const cls = (i===current) ? 'active' : '';
                                    html += pageBtn(i, i, cls);
                                }
                                html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
                                html += pageBtn(last, last);
                            }
                        }

                        // Next
                        if (current < last) html += pageBtn(current+1, '›');
                        paginationEl.innerHTML = html;
                    } else {
                        paginationEl.innerHTML = '';
                    }
                })
                .catch(function(err){
                    tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Lỗi tải dữ liệu.</td></tr>';
                    paginationEl.innerHTML = '';
                });
        }

        // click pagination
        document.addEventListener('click', function(e){
            const a = e.target.closest && e.target.closest('#kh-pagination a');
            if (!a) return;
            e.preventDefault();
            const p = parseInt(a.getAttribute('data-page') || '1');
            if (p && p !== currentPage) load(p);
        });

        searchBtn.addEventListener('click', function(){ load(1); });
        perPageSelect.addEventListener('change', function(){ load(1); });
        searchInput.addEventListener('keydown', function(e){ if (e.key === 'Enter') { e.preventDefault(); load(1); } });

        // initial load
        load(1);

        // Add customer modal behaviour with 2 choices
    const addBtn = document.getElementById('kh-add-btn');
    const printBtn = document.getElementById('kh-print-btn');
        const addModal = document.getElementById('kh-add-modal');
        const addClose = document.getElementById('kh-add-close');
        const addCancel = document.getElementById('kh-add-cancel');
        const addSubmit = document.getElementById('kh-add-submit');
        const addForm = document.getElementById('kh-add-form');
        const addErrors = document.getElementById('kh-add-errors');
        const choiceRadios = document.querySelectorAll('.kh-choice');
        const emailInput = document.getElementById('kh-email');
        const emailGroup = document.getElementById('kh-email-group');
        const sendOtpBtn = document.getElementById('kh-send-otp-btn');
        const otpGroup = document.getElementById('kh-otp-group');
        const otpInput = document.querySelector('input[name="Otp"]');

        function showModal(modal){ if(modal) modal.style.display='block'; }
        function closeModal(modal){ if(modal) modal.style.display='none'; }

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

        choiceRadios.forEach(function(radio){
            radio.addEventListener('change', updateOtpVisibility);
        });

        // Print current visible customers
        if (printBtn) {
            printBtn.addEventListener('click', function(){
                // collect visible rows from the table
                const rows = Array.from(document.querySelectorAll('#kh-table tbody tr'));
                if (!rows.length) {
                    alert('Không có dữ liệu để in');
                    return;
                }

                // Build printable HTML
                let html = '<!doctype html><html><head><meta charset="utf-8"><title>Danh sách khách hàng</title>' +
                           '<style>body{font-family:Arial,Helvetica,sans-serif;padding:20px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ccc;padding:8px;text-align:left}th{background:#f5f5f5}</style>' +
                           '</head><body>' +
                           '<h3>Danh sách khách hàng</h3>' +
                           '<table><thead><tr><th>ID</th><th>Họ tên</th><th>Email</th><th>Số điện thoại</th><th>Ngày sinh</th><th>Ngày đăng ký</th></tr></thead><tbody>';

                // reverse order: print bottom-to-top
                rows.reverse();
                rows.forEach(function(r){
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
                function pad(n){ return n<10 ? '0'+n : n; }
                const printedAt = pad(now.getDate()) + '/' + pad(now.getMonth()+1) + '/' + now.getFullYear() + ' ' + pad(now.getHours()) + ':' + pad(now.getMinutes());
                html += '<div style="margin-top:30px;font-size:14px;">';
                html += '<div>Ngày in: <strong>' + printedAt + '</strong></div>';
                html += '<div style="margin-top:40px;">Người in (ký, ghi rõ họ tên):</div>';
                html += '<div style="margin-top:60px;">__________________________</div>';
                html += '</div>';
                html += '</body></html>';

                const w = window.open('', '_blank');
                if (!w) { alert('Trình duyệt chặn cửa sổ bật lên. Vui lòng cho phép popups để in.'); return; }
                w.document.open();
                w.document.write(html);
                w.document.close();
                // small delay to ensure rendering
                setTimeout(function(){ w.print(); }, 300);
            });
        }

        // Send OTP when email is filled
        sendOtpBtn && sendOtpBtn.addEventListener('click', function(e){
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
            fetch('/api/khachhang?email=' + encodeURIComponent(email), { credentials: 'same-origin' })
                .then(r => r.json())
                .then(function(json){
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
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            HoTen: document.querySelector('input[name="HoTen"]').value || 'Khách hàng',
                            Email: email,
                            MatKhau: '123456',
                            SoDienThoai: document.querySelector('input[name="SoDienThoai"]').value || '',
                            NgaySinh: document.querySelector('input[name="NgaySinh"]').value || ''
                        })
                    })
                    .then(r => r.json().then(b => { if (!r.ok) throw {status: r.status, body: b}; return b; }))
                    .then(function(json){
                        otpGroup.style.display = 'block';
                        alert('Đã gửi OTP tới email ' + email + '. Vui lòng kiểm tra email và nhập OTP.');
                        sendOtpBtn.disabled = false;
                    })
                    .catch(function(err){
                        sendOtpBtn.disabled = false;
                        alert('Lỗi gửi OTP: ' + (err.body && err.body.message ? err.body.message : 'Vui lòng thử lại'));
                    });
                })
                .catch(function(err){
                    alert('Lỗi kiểm tra email');
                });
        });

        addBtn && addBtn.addEventListener('click', function(){
            if (addErrors) { addErrors.style.display='none'; addErrors.innerHTML=''; }
            if (addForm) addForm.reset();
            // Reset to account choice by default
            document.getElementById('kh_choice_account').checked = true;
            updateOtpVisibility();
            otpGroup.style.display = 'none';
            showModal(addModal);
        });

        addClose && addClose.addEventListener('click', function(){ closeModal(addModal); });
        addCancel && addCancel.addEventListener('click', function(){ closeModal(addModal); });

        addSubmit && addSubmit.addEventListener('click', function(e){
            e.preventDefault();
            if (!addForm) return;

            const choice = document.querySelector('input[name="kh_choice"]:checked').value;
            const hoTen = document.querySelector('input[name="HoTen"]').value;
            const email = emailInput.value;
            const soDienThoai = document.querySelector('input[name="SoDienThoai"]').value;
            const ngaySinh = document.querySelector('input[name="NgaySinh"]').value;
            const otp = otpInput.value;

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

            fetch(apiUrl, { method: 'POST', credentials: 'same-origin', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) })
                .then(function(res){ return res.json().then(function(body){ if (!res.ok) throw {status:res.status, body:body}; return body; }); })
                .then(function(json){
                    closeModal(addModal);
                    try { load(1); } catch(e){}
                    alert('Thêm khách hàng thành công!');
                })
                .catch(function(err){
                    addSubmit.disabled = false;
                    if (err && err.status === 422 && err.body && err.body.messages) {
                        const msgs = err.body.messages;
                        let html = '<ul class="mb-0">';
                        Object.keys(msgs).forEach(function(k){ msgs[k].forEach(function(m){ html += '<li>'+m+'</li>'; }); });
                        html += '</ul>';
                        addErrors.style.display = 'block';
                        addErrors.innerHTML = html;
                    } else if (err && err.status === 409) {
                        addErrors.style.display = 'block';
                        addErrors.innerHTML = '<div>'+ (err.body && err.body.message ? err.body.message : 'Conflict') +'</div>';
                    } else {
                        addErrors.style.display = 'block';
                        addErrors.innerHTML = '<div>Lỗi: '+ (err.body && err.body.message ? err.body.message : 'Vui lòng thử lại') +'</div>';
                    }
                });
        });

        // Edit customer
        const editModal = document.getElementById('kh-edit-modal');
        const editClose = document.getElementById('kh-edit-close');
        const editCancel = document.getElementById('kh-edit-cancel');
        const editSubmit = document.getElementById('kh-edit-submit');
        const editForm = document.getElementById('kh-edit-form');
        const editErrors = document.getElementById('kh-edit-errors');
        const editIdInput = document.getElementById('kh-edit-id');

        // Handle edit button click in table
        document.addEventListener('click', function(e){
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
                document.querySelector('#kh-edit-form input[name="SoDienThoai"]').value = kh.SoDienThoai || '';
                document.querySelector('#kh-edit-form input[name="NgaySinh"]').value = kh.NgaySinh || '';
                editErrors.style.display = 'none';
                editErrors.innerHTML = '';
                showModal(editModal);
            } catch(err){
                alert('Lỗi: ' + err.message);
            }
        });

        editClose && editClose.addEventListener('click', function(){ closeModal(editModal); });
        editCancel && editCancel.addEventListener('click', function(){ closeModal(editModal); });

        editSubmit && editSubmit.addEventListener('click', function(e){
            e.preventDefault();
            if (!editForm) return;

            const id = editIdInput.value;
            const hoTen = document.querySelector('#kh-edit-form input[name="HoTen"]').value;
            const soDienThoai = document.querySelector('#kh-edit-form input[name="SoDienThoai"]').value;
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

            fetch('/api/khachhang/' + id, { method: 'PUT', credentials: 'same-origin', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) })
                .then(function(res){ return res.json().then(function(body){ if (!res.ok) throw {status:res.status, body:body}; return body; }); })
                .then(function(json){
                    editSubmit.disabled = false;
                    closeModal(editModal);
                    load(currentPage);
                    alert('Cập nhật khách hàng thành công!');
                })
                .catch(function(err){
                    editSubmit.disabled = false;
                    if (err && err.status === 422 && err.body && err.body.messages) {
                        const msgs = err.body.messages;
                        let html = '<ul class="mb-0">';
                        Object.keys(msgs).forEach(function(k){ msgs[k].forEach(function(m){ html += '<li>'+m+'</li>'; }); });
                        html += '</ul>';
                        editErrors.style.display = 'block';
                        editErrors.innerHTML = html;
                    } else if (err && err.status === 409) {
                        editErrors.style.display = 'block';
                        editErrors.innerHTML = '<div>'+ (err.body && err.body.message ? err.body.message : 'Conflict') +'</div>';
                    } else if (err && err.status === 404) {
                        editErrors.style.display = 'block';
                        editErrors.innerHTML = '<div>Khách hàng không tồn tại</div>';
                    } else {
                        editErrors.style.display = 'block';
                        editErrors.innerHTML = '<div>Lỗi: '+ (err.body && err.body.message ? err.body.message : 'Vui lòng thử lại') +'</div>';
                    }
                });
        });

        // Export to Excel (CSV)
        const exportBtn = document.getElementById('kh-export-btn');

        if (exportBtn) {
            exportBtn.addEventListener('click', function(){
                const rows = Array.from(document.querySelectorAll('#kh-table tbody tr'));
                if (!rows.length) {
                    alert('Không có dữ liệu để xuất');
                    return;
                }

                const data = [['ID', 'Họ tên', 'Email', 'Số điện thoại', 'Ngày sinh', 'Ngày đăng ký']];

                rows.forEach(function(r){
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

                const csvContent = data.map(e => e.map(function(cell){
                    if (cell === null || cell === undefined) return '';
                    var s = cell.toString();
                    if (s.indexOf(',') >= 0 || s.indexOf('"') >= 0 || s.indexOf('\n') >= 0) {
                        s = '"' + s.replace(/"/g,'""') + '"';
                    }
                    return s;
                }).join(',')).join('\n');
                // prepend UTF-8 BOM so Excel (Windows) recognizes UTF-8 and displays Vietnamese correctly
                const blob = new Blob(["\uFEFF" + csvContent], { type: 'text/csv;charset=utf-8;' });
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
</body>
</html><?php /**PATH I:\Ky_06_2025_2026\php\New folder\Hotel_System\service\resources\views/amenties/khachhang.blade.php ENDPATH**/ ?>