@extends('layouts.layout2')

{{-- Đặt tiêu đề cho trang --}}
@section('title', 'Xác nhận Đặt phòng')

{{-- Nội dung chính của trang --}}
@section('content')
    {{-- (MỚI) Thêm CSS để đồng bộ UI --}}
    @push('styles')
    <style>
        /* === Styles đồng bộ từ Checkout === */
        .form-label.styled {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #1e3a8a;
            font-weight: 600;
            letter-spacing: 0.3px;
            font-size: 0.9rem;
            margin-bottom: 4px; /* Consistent spacing */
        }

        .form-control.styled,
        .form-select.styled {
            border: 1px solid #d1e0ff;
            background: #ffffff;
            color: #1e3a8a;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 0.6rem;
            font-size: 0.95rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05); /* Subtle shadow */
        }
        /* Giảm kích thước cho filter control */
        .filter-controls .form-control.styled,
        .filter-controls .form-select.styled {
             padding: 0.45rem 0.8rem;
             font-size: 0.9rem;
        }


        .form-control.styled:focus,
        .form-select.styled:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
            outline: none;
            background: #f9fbff;
        }

        .btn.styled {
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 0.6rem 1.2rem;
            font-size: 0.95rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); /* Subtle shadow */
        }
         /* Style riêng cho nút Lọc */
         .filter-controls .btn-primary.styled {
             padding: 0.45rem 1rem; /* Giảm padding */
             font-size: 0.9rem;
         }
          /* Style riêng cho nút trong bảng (Xác nhận, Hủy) */
         .table-styled .btn-sm.styled {
             padding: 0.3rem 0.7rem;
             font-size: 0.8rem;
         }


        .btn-primary.styled {
            background: linear-gradient(90deg, #60a5fa, #93c5fd);
            border: none;
            color: #ffffff;
        }
        .btn-primary.styled:hover {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-success.styled { /* Nút Xác nhận */
            background: linear-gradient(90deg, #22c55e, #4ade80);
            border: none;
            color: #ffffff;
        }
        .btn-success.styled:hover {
            background: linear-gradient(90deg, #16a34a, #22c55e);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        .btn-danger.styled { /* Nút Hủy */
             background: linear-gradient(90deg, #ef4444, #f87171);
             border:none; color: white;
         }
          .btn-danger.styled:hover {
            background: linear-gradient(90deg, #dc2626, #ef4444);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
          }

        .table-styled {
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border-collapse: separate; /* Needed for border-radius */
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
            white-space: nowrap; /* Ngăn header xuống dòng */
        }
        .table-styled tbody td {
            text-align: center;
            vertical-align: middle;
            padding: 0.6rem; /* Giảm padding body */
        }
         .table-styled td.text-start { text-align: left !important; }
         .table-styled th.text-start { text-align: left !important; }
         .table-styled td.text-end { text-align: right !important; }
         .table-styled th.text-end { text-align: right !important; }
         /* Style cho cột Khách hàng */
         .customer-cell small { color: #6b7280; font-size: 0.8em; }

        /* === End Styles đồng bộ === */

    </style>
    @endpush

    {{-- Thêm padding p-3 --}}
    <div class="p-3">
        {{-- (ĐÃ SỬA) Card bộ lọc --}}
        <div class="card border-0 shadow-lg mb-4" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
            <div class="card-body py-4 px-4 filter-controls" style="position: relative;">
                 <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>

                {{-- (ĐÃ SỬA) Dùng row/col và class styled --}}
                <div class="row g-3 align-items-center">
                    <div class="col-md-auto col-6">
                        <label for="filter-from" class="form-label styled mb-1">Từ ngày</label>
                        <input type="date" id="filter-from" class="form-control styled shadow-sm" />
                    </div>
                    <div class="col-md-auto col-6">
                        <label for="filter-to" class="form-label styled mb-1">Đến ngày</label>
                        <input type="date" id="filter-to" class="form-control styled shadow-sm" />
                    </div>
                    <div class="col-md-auto col-6">
                        <label for="filter-status" class="form-label styled mb-1">Trạng thái</label>
                        <select id="filter-status" class="form-select styled shadow-sm">
                            <option value="-1">Tất cả</option>
                            <option value="1">Chờ xác nhận</option>
                            <option value="2">Đã xác nhận</option>
                            <option value="0">Đã hủy</option>
                        </select>
                    </div>
                    <div class="col-md col-6"> {{-- col-md để chiếm phần còn lại --}}
                        <label for="filter-q" class="form-label styled mb-1">Tìm kiếm</label>
                        <input type="text" id="filter-q" class="form-control styled shadow-sm" placeholder="Mã đặt / Tên phòng" />
                    </div>
                    <div class="col-md-auto col-12 d-flex align-items-end"> {{-- Nút Lọc căn cuối cùng --}}
                        <button id="btn-filter" class="btn btn-primary styled shadow-sm w-100">
                             <i class="bi bi-funnel me-1"></i> Lọc
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- (ĐÃ SỬA) Card bảng dữ liệu --}}
        <div class="card border-0 shadow-lg mb-4" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
             <div class="card-body py-4 px-4" style="position: relative;">
                 <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>

                <div class="table-responsive mt-2">
                    {{-- (ĐÃ SỬA) Thêm class table-styled --}}
                    <table class="table table-hover table-styled" id="bookings-table">
                        <thead>
                            <tr>
                                <th style="width: 8%;">Mã</th>
                                <th style="width: 10%;">Ngày đặt</th>
                                <th class="text-start" style="width: 12%;">Phòng</th> {{-- Căn trái --}}
                                <th style="width: 8%;">Từ</th>
                                <th style="width: 8%;">Đến</th>
                                <th class="text-start" style="width: 18%;">Khách hàng</th> {{-- Căn trái --}}
                                <th class="text-end" style="width: 12%;">Tổng tiền (VND)</th> {{-- Căn phải --}}
                                <th style="width: 12%;">Trạng thái</th>
                                <th style="width: 12%;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-2"></span>Đang tải...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Phân trang --}}
                <nav aria-label="Page navigation" id="bookings-pager" style="display:none; margin-top: 1rem;">
                    {{-- JS sẽ render pagination ul ở đây --}}
                </nav>
            </div>
        </div>
    </div>
@endsection

{{-- Các script dành riêng cho trang này --}}
@section('scripts')
    {{-- (SCRIPT JS ĐÃ SỬA) --}}
    <script>
        (function() {
            const $tbody = document.querySelector('#bookings-table tbody');
            const $pagerContainer = document.getElementById('bookings-pager'); // Container cho pagination ul

            function fmtMoney(v) { return (Number(v) || 0).toLocaleString('vi-VN', { maximumFractionDigits: 0 }); }
            function fmtDate(d) { if (!d) return ''; try { return new Date(d).toLocaleDateString('vi-VN'); } catch (e) { return d; } }
            function statusLabel(s) { const map = { 1: 'Chờ xác nhận', 2: 'Đã xác nhận', 0: 'Đã hủy', 3: 'Đang sử dụng', 4: 'Hoàn thành' }; return map[s] || String(s); }
            function escapeHtml(s) { if (s === null || s === undefined) return ''; return String(s).replace(/[&<>"]+/g, ch => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[ch])); }

            async function fetchList(page = 1) {
                const from = document.getElementById('filter-from').value; const to = document.getElementById('filter-to').value;
                const status = document.getElementById('filter-status').value; const q = document.getElementById('filter-q').value;
                const per_page = 10; // Giảm số lượng để dễ test phân trang
                const params = new URLSearchParams({ page, per_page });
                if (from) params.set('from', from); if (to) params.set('to', to);
                 // (SỬA) Chỉ gửi status nếu khác -1 (Tất cả)
                if (status !== '-1') params.set('status', status);
                if (q) params.set('q', q);

                // Hiển thị loading
                 $tbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-2"></span>Đang tải...</td></tr>';
                 $pagerContainer.style.display = 'none'; // Ẩn pager khi loading

                try {
                    const resp = await fetch('/api/datphong/list?' + params.toString());
                    if (!resp.ok) throw new Error('Không thể tải danh sách');
                    const data = await resp.json();
                    renderTable(data);
                } catch (error) {
                    console.error("Fetch error:", error);
                    $tbody.innerHTML = '<tr><td colspan="9" class="text-center text-danger py-4"><i class="bi bi-exclamation-triangle me-2"></i>Lỗi khi tải dữ liệu. Vui lòng thử lại.</td></tr>'; // Thông báo lỗi rõ hơn
                     $pagerContainer.style.display = 'none'; // Ẩn pager khi lỗi
                }
            }

            function renderTable(data) {
                $tbody.innerHTML = '';
                const rows = data.data || [];
                if (rows.length === 0) {
                    $tbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted py-4"><i class="bi bi-inbox fs-4 d-block mb-2"></i>Không có đặt phòng nào phù hợp.</td></tr>'; // Thông báo rõ hơn
                     $pagerContainer.style.display = 'none'; // Ẩn pager nếu không có data
                    return;
                }
                rows.forEach(r => {
                    const tr = document.createElement('tr');
                    // (SỬA) Căn chỉnh cột và hiển thị '-' nếu thiếu
                    tr.innerHTML = `
                        <td>${escapeHtml(r.IDDatPhong || '-')}</td>
                        <td>${escapeHtml(fmtDate(r.NgayDatPhong))}</td>
                        <td class="text-start">${escapeHtml(r.TenPhong || r.SoPhong || '-')}</td>
                        <td>${escapeHtml(fmtDate(r.NgayNhanPhong))}</td>
                        <td>${escapeHtml(fmtDate(r.NgayTraPhong))}</td>
                        <td class="text-start customer-cell">
                            ${escapeHtml(r.KhachHangHoTen || '-')}
                            <br/><small>${escapeHtml(r.KhachHangPhone || r.KhachHangEmail || '')}</small>
                        </td>
                        <td class="text-end">${fmtMoney(r.TongTien || 0)}</td>
                        <td>${escapeHtml(statusLabel(r.TrangThai))}</td>
                        <td class="actions">${actionButtonsHtml(r)}</td>`;
                    $tbody.appendChild(tr);
                    bindRowButtons(tr, r);
                });
                renderPager(data); // Render pager sau khi có data
            }

            function actionButtonsHtml(r) {
                let html = '';
                 // (ĐÃ SỬA) Thêm class styled và btn-sm
                if (String(r.TrangThai) === '1') { // Chờ xác nhận
                    html += `<button class="btn btn-sm btn-success styled btn-confirm" data-id="${escapeHtml(r.IDDatPhong)}">Xác nhận</button>`;
                }
                if (String(r.TrangThai) !== '0') { // Không phải Đã hủy
                    html += `<button class="btn btn-sm btn-danger styled btn-cancel ms-1" data-id="${escapeHtml(r.IDDatPhong)}">Hủy</button>`; // Thêm ms-1
                }
                return html || '<span class="text-muted small">-</span>'; // Hiển thị '-' nếu không có action
            }

            function bindRowButtons(tr, r) {
                tr.querySelectorAll('.btn-confirm').forEach(btn => btn.addEventListener('click', async function() {
                    const id = this.dataset.id;
                    if (!confirm(`Xác nhận đặt phòng ${id}?`)) return;
                    this.disabled = true; // Disable nút khi đang xử lý
                    try {
                        const resp = await fetch(`/api/datphong/${encodeURIComponent(id)}/confirm`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } });
                        if (!resp.ok) throw new Error(await resp.text() || 'Lỗi API');
                        showAlert('success','Đã xác nhận đặt phòng ' + id); // (SỬA) Dùng showAlert
                        fetchList(data.current_page || 1); // Tải lại trang hiện tại
                    } catch (error) {
                         showAlert('danger', 'Lỗi khi xác nhận: ' + error.message);
                         this.disabled = false; // Bật lại nút nếu lỗi
                    }
                }));

                tr.querySelectorAll('.btn-cancel').forEach(btn => btn.addEventListener('click', async function() {
                    const id = this.dataset.id;
                    if (!confirm(`Hủy đặt phòng ${id}?`)) return;
                     this.disabled = true; // Disable nút
                     try {
                        const resp = await fetch(`/api/datphong/${encodeURIComponent(id)}/cancel`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } });
                        if (!resp.ok) throw new Error(await resp.text() || 'Lỗi API');
                         showAlert('success','Đã hủy đặt phòng ' + id); // (SỬA) Dùng showAlert
                        fetchList(data.current_page || 1); // Tải lại trang hiện tại
                     } catch (error) {
                         showAlert('danger','Lỗi khi hủy: ' + error.message);
                         this.disabled = false; // Bật lại nút nếu lỗi
                     }
                }));
            }

            function renderPager(data) {
                const current = data.current_page || 1;
                const last = data.last_page || 1;

                if (last <= 1) {
                    $pagerContainer.innerHTML = '';
                    $pagerContainer.style.display = 'none'; // Ẩn container nếu chỉ có 1 trang
                    return;
                }

                $pagerContainer.style.display = 'block'; // Hiển thị container
                let html = '<ul class="pagination justify-content-center">'; // Bắt đầu ul
                const windowSize = 5; // Số trang hiển thị quanh trang hiện tại

                function pageBtn(p, label, disabled, active) {
                    return `<li class="page-item${disabled ? ' disabled' : ''}${active ? ' active' : ''}"><a class="page-link" href="#" data-page="${p}">${label}</a></li>`;
                }

                // Nút Trang đầu & Trước
                html += pageBtn(1, '«', current === 1, false);
                html += pageBtn(current - 1, '‹', current === 1, false);

                // Tính toán trang bắt đầu và kết thúc để hiển thị
                let start = Math.max(1, current - Math.floor(windowSize / 2));
                let end = Math.min(last, start + windowSize - 1);
                 // Điều chỉnh nếu end bị giới hạn bởi last_page
                if (end === last) {
                    start = Math.max(1, last - windowSize + 1);
                }

                // Dấu '...' ở đầu
                if (start > 1) {
                    html += pageBtn(1, 1, false, false);
                    if (start > 2) {
                        html += '<li class="page-item disabled"><span class="page-link">…</span></li>';
                    }
                }

                // Các trang ở giữa
                for (let p = start; p <= end; p++) {
                    html += pageBtn(p, p, false, p === current);
                }

                // Dấu '...' ở cuối
                if (end < last) {
                    if (end < last - 1) {
                        html += '<li class="page-item disabled"><span class="page-link">…</span></li>';
                    }
                    html += pageBtn(last, last, false, false);
                }

                // Nút Sau & Trang cuối
                html += pageBtn(current + 1, '›', current === last, false);
                html += pageBtn(last, '»', current === last, false);

                html += '</ul>'; // Kết thúc ul
                $pagerContainer.innerHTML = html; // Gán HTML vào container

                // Gắn lại event listener cho các nút page mới được render
                $pagerContainer.querySelectorAll('a[data-page]').forEach(a => {
                    if (!a.closest('.disabled') && !a.closest('.active')) { // Chỉ gắn cho nút không bị disable/active
                         a.addEventListener('click', function(e) {
                            e.preventDefault();
                            const pageNum = parseInt(this.dataset.page);
                            if (!isNaN(pageNum)) {
                                fetchList(pageNum);
                            }
                        });
                    }
                });
            }


            // Gắn sự kiện filter
            document.getElementById('btn-filter').addEventListener('click', () => fetchList(1));
             // Tự động filter khi nhấn Enter trong ô tìm kiếm
             document.getElementById('filter-q').addEventListener('keydown', (e) => {
                 if (e.key === 'Enter') {
                     e.preventDefault();
                     fetchList(1);
                 }
             });
             // Tự động filter khi thay đổi select
             document.getElementById('filter-status').addEventListener('change', () => fetchList(1));
             document.getElementById('filter-from').addEventListener('change', () => fetchList(1));
             document.getElementById('filter-to').addEventListener('change', () => fetchList(1));


            // initial load
            fetchList(1);
        })();
    </script>
@endsection
