@extends('layouts.layout2')

@section('title', 'Xác nhận Đặt phòng')

@push('styles')
<style>
        /* small adjustments for the bookings table */
        #bookings-table th, #bookings-table td { vertical-align: middle; }
        .actions button { margin-right: 6px; }

        /* === Styles đồng bộ từ bookingtructiep === */
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
        .btn-success.styled {
            background: linear-gradient(90deg, #22c55e, #4ade80);
            border: none;
            color: #ffffff;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 0.6rem 1.2rem;
        }
        .btn-success.styled:hover {
            background: linear-gradient(90deg, #16a34a, #22c55e);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }
        .btn-danger.styled {
            background: linear-gradient(90deg, #ef4444, #f87171);
            border: none;
            color: #ffffff;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 0.6rem 1.2rem;
        }
        .btn-danger.styled:hover {
            background: linear-gradient(90deg, #dc2626, #ef4444);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        .btn-outline-secondary.styled {
            border: 1px solid #d1e0ff;
            color: #1e3a8a;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 0.6rem;
            font-size: 0.95rem;
        }
        .btn-outline-secondary.styled:hover {
            background: #e6f0ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .table-styled {
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border-collapse: separate;
            border-spacing: 0;
        }
        .table-styled thead {
            background: linear-gradient(90deg, #60a5fa, #93c5fd);
            color: #ffffff;
        }
        .table-styled th {
            padding: 0.8rem;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }
        .table-styled tbody td {
            text-align: center;
            vertical-align: middle;
            padding: 0.6rem;
        }
        .table-styled td.text-start { text-align: left !important; }
        .table-styled th.text-start { text-align: left !important; }
        .table-styled td.text-end { text-align: right !important; }
        .table-styled th.text-end { text-align: right !important; }

        /* Modal styling */
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
        .modal-body.styled .form-control {
            border: 1px solid #d1e0ff;
            background: #ffffff;
            color: #1e3a8a;
            border-radius: 10px;
            padding: 0.6rem;
        }
        /* === Kết thúc Styles đồng bộ === */
    </style>
@endpush

@section('content')
<div class="card mb-3">
    <div class="card-body">
                            <div class="d-flex mb-3 align-items-center">
                                <div class="me-2 d-flex align-items-center">
                                    <small class="me-2">Từ</small>
                                    <input type="date" id="filter-from" class="form-control form-control-sm styled shadow-sm" />
                                </div>

                                <div class="me-2 d-flex align-items-center">
                                    <small class="me-2">Đến</small>
                                    <input type="date" id="filter-to" class="form-control form-control-sm styled shadow-sm" />
                                </div>

                                <div class="me-2 d-flex align-items-center">
                                    <small class="me-2">Trạng thái</small>
                                    <select id="filter-status" class="form-select form-select-sm styled shadow-sm">
                                        <option value="-1">Tất cả</option>
                                        <option value="1">Chờ xác nhận</option>
                                        <option value="2">Đã xác nhận</option>
                                        <option value="0">Đã hủy</option>
                                    </select>
                                </div>

                                <div class="me-2 d-flex align-items-center" style="min-width:220px">
                                    <small class="me-2">Tìm</small>
                                    <input type="text" id="filter-q" class="form-control form-control-sm styled shadow-sm" placeholder="Mã đặt / Tên phòng" />
                                </div>

                                <div class="d-flex align-items-center">
                                    <button id="btn-filter" class="btn btn-primary btn-sm styled ms-2 shadow-sm">Lọc</button>
                                    <div id="list-loading" style="display:none; margin-left:8px;"><span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span></div>
                                    <div id="results-count" class="ms-3 text-muted small">&nbsp;</div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-styled" id="bookings-table">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Ngày đặt</th>
                                            <th>Phòng</th>
                                            <th>Từ</th>
                                            <th>Đến</th>
                                            <th>Khách hàng</th>
                                            <th>Email</th>
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
                            <nav>
                                <ul class="pagination" id="bookings-pager"></ul>
                            </nav>
        </div>
    </div>
</div>

    <!-- Invoice Modal (enhanced) -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content styled">
                <div class="modal-header styled">
                    <h5 class="modal-title">Tạo Hóa Đơn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    <div class="decorator-line"></div>
                </div>
                <div class="modal-body styled">
                    <div class="alert alert-danger d-none" id="invoice-error"></div>

                    <p><strong>Mã đặt phòng:</strong> <span id="inv-booking-id"></span></p>
                    <p><strong>Tổng tiền phòng:</strong> <span id="inv-room-total">...</span></p>

                    <hr>
                    <div id="inv-loading-services" class="text-center py-3">
                        <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                        <p class="text-muted mt-2">Đang tải danh sách dịch vụ...</p>
                    </div>

                    <div id="inv-services-area" class="d-none">
                        <h6>Chọn Dịch vụ</h6>
                        <div class="table-responsive" style="max-height:300px; overflow-y:auto">
                            <table class="table table-sm table-styled" id="inv-services-table">
                                <thead>
                                    <tr>
                                        <th>Tên dịch vụ</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <label for="inv-paid-now" class="col-sm-4 col-form-label">Tiền khách đưa:</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control styled" id="inv-paid-now" placeholder="0">
                            </div>
                        </div>

                        <p><strong>Tổng tiền dịch vụ:</strong> <span id="inv-services-total">0 VND</span></p>
                        <p><strong>Tổng hóa đơn:</strong> <span id="inv-invoice-total">0 VND</span></p>
                        <p><strong>Tiền cọc:</strong> <span id="inv-deposit">0 VND</span></p>
                        <p><strong>Tiền còn lại:</strong> <span id="inv-remaining">0 VND</span></p>
                    </div>
                </div>
                <div class="modal-footer styled">
                    <button type="button" class="btn btn-outline-secondary styled" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary styled" id="inv-save" disabled>Lưu hóa đơn</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success toast -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div id="inv-toast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">Hóa đơn đã được tạo thành công!</div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
    // Ensure a placeholder openInvoiceModal exists early so clicks will enqueue requests
    if (typeof window !== 'undefined') {
        if (!window._pendingInvoiceOpen) window._pendingInvoiceOpen = [];
        if (!window.openInvoiceModal) {
            window.openInvoiceModal = function(id){ window._pendingInvoiceOpen.push(id); };
        }
        // provide a global escapeHtml helper so other inline scripts can use it
        if (!window.escapeHtml) {
            window.escapeHtml = function(s){ if (s === null || s === undefined) return ''; return String(s).replace(/[&<>"]+/g, function(ch){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[ch]; }); };
        }
    }
    </script>

    <script>
    (function(){
        const $tbody = document.querySelector('#bookings-table tbody');
        const $pager = document.getElementById('bookings-pager');

        function fmtMoney(v){ return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', maximumFractionDigits: 0 }).format(Number(v)||0); }
        function fmtDate(d){ if (!d) return ''; try { return new Date(d).toLocaleDateString('vi-VN'); } catch(e) { return d; } }
        function statusLabel(s){ const map = {1:'Chờ xác nhận',2:'Đã xác nhận',0:'Đã hủy',3:'Đang sử dụng',4:'Hoàn thành'}; return map[s]||(''+s); }

        function showLoading(){ document.getElementById('list-loading').style.display='inline-block'; document.getElementById('btn-filter').disabled = true; }
        function hideLoading(){ document.getElementById('list-loading').style.display='none'; document.getElementById('btn-filter').disabled = false; }

        async function fetchList(page=1){
            showLoading();
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
            if (!resp.ok) { hideLoading(); alert('Không thể tải danh sách'); return; }
            const data = await resp.json();
            
            // Fetch invoice status for all bookings BEFORE rendering
            const rows = data.data || [];
            if (rows.length > 0) {
                await Promise.all(rows.map(async (r) => {
                    if (String(r.TrangThai) === '2') {
                        r._hasInvoice = await checkInvoiceExists(r.IDDatPhong);
                    }
                }));
            }
            
            renderTable(data);
            hideLoading();
        }

        function renderTable(data){
            $tbody.innerHTML = '';
            const rows = data.data || [];
            if (rows.length === 0){ $tbody.innerHTML = '<tr><td colspan="9" style="text-align:center">Không có đặt phòng</td></tr>'; $pager.innerHTML = ''; document.getElementById('results-count').textContent = 'Kết quả: 0'; return; }
            rows.forEach(r => {
                const tr = document.createElement('tr');
                tr.innerHTML = '<td>'+escapeHtml(r.IDDatPhong||'')+'</td>'+
                    '<td>'+escapeHtml(fmtDate(r.NgayDatPhong))+'</td>'+
                    '<td>'+escapeHtml(r.TenPhong||'')+'</td>'+
                    '<td>'+escapeHtml(fmtDate(r.NgayNhanPhong))+'</td>'+
                    '<td>'+escapeHtml(fmtDate(r.NgayTraPhong))+'</td>'+
                    '<td>'+escapeHtml(r.KhachHangHoTen || '')+'<br/><small class="text-muted">'+escapeHtml(r.KhachHangPhone || '')+'</small></td>'+
                    '<td><small class="text-muted">'+escapeHtml(r.KhachHangEmail || '')+'</small></td>'+
                    '<td style="text-align:right">'+fmtMoney(r.TongTien||0)+'</td>'+
                    '<td>'+escapeHtml(statusLabel(r.TrangThai))+'</td>'+
                    '<td class="actions">'+actionButtonsHtml(r)+'</td>';
                $tbody.appendChild(tr);
                bindRowButtons(tr, r);
            });
            renderPager(data);
            try { document.getElementById('results-count').textContent = 'Kết quả: ' + (data.total || (data.meta && data.meta.total) || (data.data && data.data.length) || 0); } catch(e){}
        }

        function actionButtonsHtml(r){
            let html = '';
            if (String(r.TrangThai) === '1') html += '<button class="btn btn-sm btn-success styled btn-confirm" data-id="'+escapeHtml(r.IDDatPhong)+'">Xác nhận</button>';
            if (String(r.TrangThai) !== '0' && String(r.TrangThai) !== '2') html += '<button class="btn btn-sm btn-danger styled btn-cancel" data-id="'+escapeHtml(r.IDDatPhong)+'">Hủy</button>';
            if (String(r.TrangThai) === '2') {
                if (r._hasInvoice) {
                    html += '<button class="btn btn-sm btn-secondary styled" disabled style="cursor:not-allowed">✓ Đã tạo hóa đơn</button>';
                } else {
                    html += '<button class="btn btn-sm btn-primary styled btn-invoice" data-id="'+escapeHtml(r.IDDatPhong)+'">Tạo hóa đơn</button>';
                }
            }
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

            tr.querySelectorAll('.btn-invoice').forEach(btn => btn.addEventListener('click', async function(){
                const id = this.dataset.id;
                // ensure an invoice does not already exist for this booking (cached)
                try {
                    const has = await checkInvoiceExists(id);
                    if (has) { alert('Đã có hóa đơn cho đặt phòng này'); return; }
                } catch(err){ console.error('invoice check failed', err); }
                if (window.openInvoiceClick) window.openInvoiceClick(id);
                else if (window.openInvoiceModal) window.openInvoiceModal(id);
                else alert('Chức năng tạo hóa đơn chưa sẵn sàng');
            }));
        }

        // cache of invoice existence per booking id
        const _invoiceExistsCache = new Map();
        async function checkInvoiceExists(id){
            if (!id) return false;
            if (_invoiceExistsCache.has(id)) return _invoiceExistsCache.get(id);
            try {
                const resp = await fetch('/api/hoadon?IDDatPhong=' + encodeURIComponent(id));
                if (!resp.ok) { _invoiceExistsCache.set(id, false); return false; }
                const data = await resp.json();
                // if any invoice exists in response.data or response array
                const list = data.data || data || [];
                const exists = Array.isArray(list) ? list.length > 0 : false;
                _invoiceExistsCache.set(id, exists);
                return exists;
            } catch(e){ _invoiceExistsCache.set(id, false); return false; }
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
        if (typeof window !== 'undefined') window.fetchList = fetchList;

        if (typeof window !== 'undefined' && !window.openInvoiceClick) {
            window.openInvoiceClick = function(id){
                if (window.openInvoiceModal) { try { window.openInvoiceModal(id); } catch(e){ console.error(e); alert('Không thể mở modal hóa đơn: '+e.message); } return; }
                const start = Date.now();
                const t = setInterval(function(){
                    if (window.openInvoiceModal) { clearInterval(t); try { window.openInvoiceModal(id); } catch(e){ console.error(e); alert('Không thể mở modal hóa đơn: '+e.message); } return; }
                    if (Date.now() - start > 2000) { clearInterval(t); alert('Chức năng tạo hóa đơn chưa sẵn sàng — thử tải lại trang hoặc kiểm tra console'); }
                }, 100);
            };
        }
    })();
    </script>

    <script>
    (function(){
        const invoiceModalEl = document.getElementById('invoiceModal');
        const invoiceModal = new bootstrap.Modal(invoiceModalEl);
    let currentBookingId = null;
    let services = []; // loaded from API
    let currentRoomTotal = 0;

    async function openInvoiceModal(bookingId, attempt = 0){
            // ensure modal DOM exists (some callers may trigger before DOM nodes are ready). Retry a few times.
            const maxAttempts = 20;
                const servicesAreaEl = document.getElementById('inv-services-area');
                const loadingEl = document.getElementById('inv-loading-services');
                const servicesTableBody = document.querySelector('#inv-services-table tbody');
            const bookingEl = document.getElementById('inv-booking-id');
            const roomTotalEl = document.getElementById('inv-room-total');
            const depositEl = document.getElementById('inv-deposit');
            const paidNowEl = document.getElementById('inv-paid-now');
            const remainingEl = document.getElementById('inv-remaining');
            const invoiceErrorEl = document.getElementById('invoice-error');
                if (!servicesAreaEl || !loadingEl || !servicesTableBody || !bookingEl || !roomTotalEl || !invoiceErrorEl) {
                if (attempt < maxAttempts) {
                    // retry shortly
                    setTimeout(() => openInvoiceModal(bookingId, attempt + 1), 100);
                    return;
                }
                alert('Không thể mở modal hóa đơn — phần tử giao diện chưa sẵn sàng');
                return;
            }

            currentBookingId = bookingId;
            bookingEl.textContent = bookingId;
            roomTotalEl.textContent = '...';
                // show loading area, hide services area
                if (loadingEl) loadingEl.style.display = '';
                if (servicesAreaEl) servicesAreaEl.style.display = 'none';
            invoiceErrorEl.style.display = 'none';
            // disable save until services loaded
            const saveBtnInit = document.getElementById('inv-save'); if (saveBtnInit) saveBtnInit.disabled = true;

            // fetch booking details to get room total
            try {
                const resp = await fetch('/api/datphong/' + encodeURIComponent(bookingId));
                if (!resp.ok) throw new Error('Không lấy được thông tin đặt phòng');
                const data = await resp.json();
                currentRoomTotal = Number(data.TongTienPhong || 0);
                const depositVal = Number(data.TienCoc || data.TienDatCoc || 0);
                document.getElementById('inv-room-total').textContent = new Intl.NumberFormat('vi-VN', { style:'currency', currency:'VND', maximumFractionDigits:0 }).format(currentRoomTotal);
                if (depositEl) depositEl.textContent = new Intl.NumberFormat('vi-VN', { style:'currency', currency:'VND', maximumFractionDigits:0 }).format(depositVal);
                if (paidNowEl) { paidNowEl.value = 0; paidNowEl.addEventListener('input', function(){ recalcTotals(); }); }
                document.getElementById('inv-services-total').textContent = new Intl.NumberFormat('vi-VN', { style:'currency', currency:'VND', maximumFractionDigits:0 }).format(0);
                document.getElementById('inv-invoice-total').textContent = new Intl.NumberFormat('vi-VN', { style:'currency', currency:'VND', maximumFractionDigits:0 }).format(currentRoomTotal);
                if (remainingEl) remainingEl.textContent = new Intl.NumberFormat('vi-VN', { style:'currency', currency:'VND', maximumFractionDigits:0 }).format(currentRoomTotal - depositVal);
            } catch (e) {
                document.getElementById('invoice-error').textContent = e.message; document.getElementById('invoice-error').style.display = 'block';
            }

            // fetch services (robust: read text then parse so we can report server response on parse errors)
            try {
                // Use the public services endpoint which returns a plain JSON array for customers
                // (calling /api/dichvu from an unauthenticated XHR may return the admin HTML page)
                const r2 = await fetch('/api/public-services');
                const txt = await r2.text();
                if (!r2.ok) throw new Error('Không tải được dịch vụ: ' + r2.status + ' ' + txt);
                let svs;
                try { svs = JSON.parse(txt); } catch(parseErr) { throw new Error('Lỗi phân tích JSON dịch vụ: ' + parseErr.message + ' — response: ' + txt); }
                // normalize common API shapes: array, {data: [...]}, {data:{data:[...]}}
                function normalizeServices(x){
                    if (!x) return [];
                    if (Array.isArray(x)) return x;
                    if (x.data && Array.isArray(x.data)) return x.data;
                    if (x.data && x.data.data && Array.isArray(x.data.data)) return x.data.data;
                    if (x.items && Array.isArray(x.items)) return x.items;
                    // fallback: try to find first array value
                    for (const k in x) if (Array.isArray(x[k])) return x[k];
                    return [];
                }
                    services = normalizeServices(svs || {});
                    console.debug('Loaded services from /api/dichvu:', svs, 'normalized->', services);
                    // render into the table tbody
                    renderServicesList();
                    // show services area and hide loading
                    if (loadingEl) loadingEl.style.display = 'none';
                    if (servicesAreaEl) servicesAreaEl.style.display = '';
                    // enable save now
                    const saveBtn = document.getElementById('inv-save'); if (saveBtn) saveBtn.disabled = false;
            } catch (e) {
                    if (invoiceErrorEl) { invoiceErrorEl.textContent = 'Lỗi khi tải dịch vụ: ' + e.message; invoiceErrorEl.style.display = 'block'; }
                console.error('Failed to load services', e);
            }

            invoiceModal.show();
        }

        function recalcTotals(){
            const servicesTotalEl = document.getElementById('inv-services-total');
            const invoiceTotalEl = document.getElementById('inv-invoice-total');
            let svTotal = 0;
            document.querySelectorAll('#inv-services-table .inv-sv-qty').forEach(inp => {
                const q = parseInt(inp.value) || 0;
                const price = Number(inp.dataset.price || 0);
                svTotal += q * price;
                // update per-row subtotal if present
                const tr = inp.closest('tr');
                if (tr) {
                    const subEl = tr.querySelector('.inv-sv-subtotal');
                    if (subEl) subEl.textContent = new Intl.NumberFormat('vi-VN', { style:'currency', currency:'VND', maximumFractionDigits:0 }).format(q * price);
                }
            });
            if (servicesTotalEl) servicesTotalEl.textContent = new Intl.NumberFormat('vi-VN', { style:'currency', currency:'VND', maximumFractionDigits:0 }).format(svTotal);
            const total = Number(currentRoomTotal || 0) + svTotal;
            if (invoiceTotalEl) invoiceTotalEl.textContent = new Intl.NumberFormat('vi-VN', { style:'currency', currency:'VND', maximumFractionDigits:0 }).format(total);
            // compute remaining after deposit and any immediate payment
            const depositVal = Number((document.getElementById('inv-deposit') && document.getElementById('inv-deposit').textContent) ? parseFloat(document.getElementById('inv-deposit').textContent.replace(/[^0-9\.-]+/g,"")) : 0) || 0;
            const paidNow = Number((document.getElementById('inv-paid-now') && document.getElementById('inv-paid-now').value) ? parseFloat(document.getElementById('inv-paid-now').value) : 0) || 0;
            const remaining = total - depositVal - paidNow;
            const remainingElLocal = document.getElementById('inv-remaining');
            if (remainingElLocal) remainingElLocal.textContent = new Intl.NumberFormat('vi-VN', { style:'currency', currency:'VND', maximumFractionDigits:0 }).format(remaining > 0 ? remaining : 0);
            return svTotal;
        }

        function renderServicesList(){
            const tableBody = document.querySelector('#inv-services-table tbody');
            if (!tableBody) return;
            if (!services.length) {
                tableBody.innerHTML = '<tr><td colspan="4" class="text-muted">Không có dịch vụ</td></tr>';
                recalcTotals();
                return;
            }
            const html = services.map(s => {
                const price = Number(s.TienDichVu || 0);
                return '<tr data-id="'+escapeHtml(s.IDDichVu)+'">'
                    + '<td>' + escapeHtml(s.TenDichVu || '') + '</td>'
                    + '<td>' + new Intl.NumberFormat('vi-VN', { style:'currency', currency:'VND', maximumFractionDigits:0 }).format(price) + '</td>'
                    + '<td><input type="number" min="0" value="0" class="form-control form-control-sm inv-sv-qty" data-id="'+escapeHtml(s.IDDichVu)+'" data-price="'+price+'" /></td>'
                    + '<td class="text-end inv-sv-subtotal">' + new Intl.NumberFormat('vi-VN', { style:'currency', currency:'VND', maximumFractionDigits:0 }).format(0) + '</td>'
                    + '</tr>';
            }).join('');
            tableBody.innerHTML = html;
            // attach listeners to inputs inside the table
            document.querySelectorAll('#inv-services-table .inv-sv-qty').forEach(inp => {
                inp.addEventListener('input', function(){ recalcTotals(); });
            });
            // initial totals
            recalcTotals();
        }

        // export function so other scripts / handlers can open the modal
        if (typeof window !== 'undefined') {
            window.openInvoiceModal = openInvoiceModal;
            // process any pending opens queued before script loaded
            if (Array.isArray(window._pendingInvoiceOpen) && window._pendingInvoiceOpen.length) {
                const queued = window._pendingInvoiceOpen.slice();
                window._pendingInvoiceOpen = [];
                queued.forEach(id => { try { openInvoiceModal(id); } catch(err) { console.error('Failed opening queued invoice', err); } });
            }
        }

        document.getElementById('inv-save').addEventListener('click', async function(){
            // collect selected services
            const selected = [];
            document.querySelectorAll('#inv-services-table .inv-sv-qty').forEach(inp => {
                const q = parseInt(inp.value) || 0;
                if (q > 0) selected.push({ IDDichVu: inp.dataset.id, quantity: q });
            });

            const paidNowVal = Number((document.getElementById('inv-paid-now') && document.getElementById('inv-paid-now').value) ? parseFloat(document.getElementById('inv-paid-now').value) : 0) || 0;
            const payload = { IDDatPhong: currentBookingId, DichVuIDs: selected, TrangThaiThanhToan: 3, TienDaThanhToan: paidNowVal };
            try {
                const $save = document.getElementById('inv-save');
                $save.disabled = true;
                const r = await fetch('/api/hoadon', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }, body: JSON.stringify(payload) });
                if (!r.ok) {
                    const err = await r.json().catch(()=>({}));
                    throw new Error(err.error || err.message || 'Lỗi khi lưu hóa đơn');
                }
                const res = await r.json();
                invoiceModal.hide();
                alert('Hóa đơn tạo thành công: ' + (res.IDHoaDon || ''));
                // refresh list
                if (window.fetchList) window.fetchList(1);
            } catch (e) {
                document.getElementById('invoice-error').textContent = e.message; document.getElementById('invoice-error').style.display = 'block';
            } finally {
                const $save = document.getElementById('inv-save'); if ($save) $save.disabled = false;
            }
        });
    })();
    </script>
@endsection
