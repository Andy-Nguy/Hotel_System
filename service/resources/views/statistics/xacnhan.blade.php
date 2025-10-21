<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Quản lý Đặt phòng - Admin</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* small adjustments for the bookings table */
        #bookings-table th, #bookings-table td { vertical-align: middle; }
        .actions button { margin-right: 6px; }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="main-container">

            <!-- Sidebar -->
            <nav id="sidebar" class="sidebar-wrapper">
                <div class="app-brand p-3 mb-3">
                    <a href="{{ route('datphong.index') }}">
                        <img src="{{ asset('assets/images/logo.svg') }}" class="logo" alt="Admin" />
                    </a>
                </div>
                <div class="sidebarMenuScroll">
                    <ul class="sidebar-menu">
                        <li class="active current-page">
                            <a href="{{ url('/xacnhan') }}">
                                <i class="bi bi-calendar-check"></i>
                                <span class="menu-text">Xác nhận Đặt phòng</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('khachhang.index') }}">
                                <i class="bi bi-people"></i>
                                <span class="menu-text">Khách hàng</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('datphong.index') }}">
                                <i class="bi bi-list"></i>
                                <span class="menu-text">Danh sách đặt phòng</span>
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
                        <h5 class="m-0">Xác nhận / Quản lý Đặt phòng</h5>
                    </div>
                    <div class="app-brand-sm d-lg-none d-flex ms-auto">
                        <a href="{{ url('/xacnhan') }}">
                            <img src="{{ asset('assets/images/logo-sm.svg') }}" class="logo" alt="Admin" />
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
                                <label class="me-2">Từ: <input type="date" id="filter-from" class="form-control form-control-sm"/></label>
                                <label class="me-2">Đến: <input type="date" id="filter-to" class="form-control form-control-sm"/></label>
                                <label class="me-2">Trạng thái: 
                                    <select id="filter-status" class="form-select form-select-sm">
                                        <option value="-1">Tất cả</option>
                                        <option value="1">Chờ xác nhận</option>
                                        <option value="2">Đã xác nhận</option>
                                        <option value="0">Đã hủy</option>
                                    </select>
                                </label>
                                <label class="me-2">Tìm: <input type="text" id="filter-q" class="form-control form-control-sm" placeholder="Mã đặt / Tên phòng"/></label>
                                <button id="btn-filter" class="btn btn-primary btn-sm ms-2">Lọc</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="bookings-table">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Ngày đặt</th>
                                            <th>Phòng</th>
                                            <th>Từ</th>
                                            <th>Đến</th>
                                            <th>Khách hàng</th>
                                            <th style="text-align:right">Tổng tiền (VND)</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td colspan="9" class="text-center text-muted">Đang tải...</td></tr>
                                    </tbody>
                                </table>
                            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/overlay-scroll/custom-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
    (function(){
        const $tbody = document.querySelector('#bookings-table tbody');
        const $pager = document.getElementById('bookings-pager');

    function fmtMoney(v){ return (Number(v)||0).toLocaleString('vi-VN', {maximumFractionDigits:0}); }
    function fmtDate(d){ if (!d) return ''; try { return new Date(d).toLocaleDateString('vi-VN'); } catch(e) { return d; } }
        function statusLabel(s){ const map = {1:'Chờ xác nhận',2:'Đã xác nhận',0:'Đã hủy',3:'Đang sử dụng',4:'Hoàn thành'}; return map[s]||(''+s); }

        async function fetchList(page=1){
            const from = document.getElementById('filter-from').value;
            const to = document.getElementById('filter-to').value;
            const status = document.getElementById('filter-status').value;
            const q = document.getElementById('filter-q').value;
            const per_page = 15;
            const params = new URLSearchParams({page, per_page});
            if (from) params.set('from', from);
            if (to) params.set('to', to);
            if (status !== '') params.set('status', status);
            if (q) params.set('q', q);
            const resp = await fetch('/api/datphong/list?' + params.toString());
            if (!resp.ok) { alert('Không thể tải danh sách'); return; }
            const data = await resp.json();
            renderTable(data);
        }

        function renderTable(data){
            $tbody.innerHTML = '';
            const rows = data.data || [];
            if (rows.length === 0){ $tbody.innerHTML = '<tr><td colspan="8" style="text-align:center">Không có đặt phòng</td></tr>'; $pager.innerHTML = ''; return; }
            rows.forEach(r => {
                const tr = document.createElement('tr');
                tr.innerHTML = '<td>'+escapeHtml(r.IDDatPhong||'')+'</td>'+
                    '<td>'+escapeHtml(fmtDate(r.NgayDatPhong))+'</td>'+
                    '<td>'+escapeHtml(r.TenPhong||'')+'</td>'+
                    '<td>'+escapeHtml(fmtDate(r.NgayNhanPhong))+'</td>'+
                    '<td>'+escapeHtml(fmtDate(r.NgayTraPhong))+'</td>'+
                    '<td>'+escapeHtml(r.KhachHangHoTen || '')+'<br/><small class="text-muted">'+escapeHtml(r.KhachHangPhone || r.KhachHangEmail || '')+'</small></td>'+
                    '<td style="text-align:right">'+fmtMoney(r.TongTien||0)+'</td>'+
                    '<td>'+escapeHtml(statusLabel(r.TrangThai))+'</td>'+
                    '<td class="actions">'+actionButtonsHtml(r)+'</td>';
                $tbody.appendChild(tr);
                bindRowButtons(tr, r);
            });
            renderPager(data);
        }

        function actionButtonsHtml(r){
            let html = '';
            if (String(r.TrangThai) === '1') html += '<button class="btn btn-sm btn-success btn-confirm" data-id="'+escapeHtml(r.IDDatPhong)+'">Xác nhận</button>';
            if (String(r.TrangThai) !== '0') html += '<button class="btn btn-sm btn-danger btn-cancel" data-id="'+escapeHtml(r.IDDatPhong)+'">Hủy</button>';
            return html;
        }

        function bindRowButtons(tr, r){
            tr.querySelectorAll('.btn-confirm').forEach(btn => btn.addEventListener('click', async function(){
                const id = this.dataset.id;
                if (!confirm('Xác nhận đặt phòng ' + id + '?')) return;
                const resp = await fetch('/api/datphong/' + encodeURIComponent(id) + '/confirm', {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}});
                if (resp.ok) { alert('Đã xác nhận'); fetchList(); } else { alert('Lỗi khi xác nhận'); }
            }));

            tr.querySelectorAll('.btn-cancel').forEach(btn => btn.addEventListener('click', async function(){
                const id = this.dataset.id;
                if (!confirm('Hủy đặt phòng ' + id + '?')) return;
                const resp = await fetch('/api/datphong/' + encodeURIComponent(id) + '/cancel', {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}});
                if (resp.ok) { alert('Đã hủy'); fetchList(); } else { alert('Lỗi khi hủy'); }
            }));
        }

        function renderPager(data){
            const current = data.current_page || 1; const last = data.last_page || 1;
            if (last <= 1) { $pager.innerHTML = ''; return; }
            let html = '';
            function pageBtn(p,label,disabled){ return '<li class="page-item'+(disabled? ' disabled':'')+'"><a class="page-link" href="#" data-page="'+p+'">'+label+'</a></li>'; }
            if (current > 1) html += pageBtn(current-1, '‹', false);
            const start = Math.max(1, current-2); const end = Math.min(last, current+2);
            if (start > 1) html += pageBtn(1,1,false) + '<li class="page-item disabled"><span class="page-link">…</span></li>';
            for (let p = start; p <= end; p++) html += pageBtn(p,p,p===current);
            if (end < last) html += '<li class="page-item disabled"><span class="page-link">…</span></li>' + pageBtn(last,last,false);
            if (current < last) html += pageBtn(current+1, '›', false);
            $pager.innerHTML = html;
            $pager.querySelectorAll('a[data-page]').forEach(a => a.addEventListener('click', function(e){ e.preventDefault(); fetchList(parseInt(this.dataset.page)); }));
        }

        function escapeHtml(s){ if (s === null || s === undefined) return ''; return String(s).replace(/[&<>"]+/g, function(ch){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[ch]; }); }

        document.getElementById('btn-filter').addEventListener('click', function(){ fetchList(1); });

        // initial load
        fetchList(1);
    })();
    </script>
</body>
</html>
