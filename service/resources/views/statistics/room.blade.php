@extends('layouts.layout2')

@section('title', 'Phòng')

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

        .form-control.styled:focus,
        .form-select.styled:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
            outline: none;
            background: #f9fbff;
        }

        /* Style cho textarea */
        textarea.form-control.styled.autosize {
            overflow: hidden;
            resize: vertical;
            min-height: calc(1.5em + 1.2rem + 2px); /* Match input height */
        }

        .input-group-text.styled {
            background: #ffffff;
            border: 1px solid #d1e0ff;
            color: #60a5fa;
            transition: all 0.3s ease;
            border-radius: 10px 0 0 10px;
            padding: 0.6rem;
        }
        .form-control.styled.in-group {
            border-radius: 0 10px 10px 0;
            border-left: 0;
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
         .btn-sm.styled { /* Adjust padding for small buttons */
             padding: 0.35rem 0.8rem;
             font-size: 0.85rem;
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

        .btn-warning.styled { /* Nút Update */
            background: linear-gradient(90deg, #f97316, #fb923c);
            border: none;
            color: #ffffff;
        }
        .btn-warning.styled:hover {
            background: linear-gradient(90deg, #ea580c, #f97316);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }
        .btn-warning.styled:disabled {
             background: linear-gradient(90deg, #fdba74, #fed7aa);
             opacity: 0.7;
        }

        .btn-outline-secondary.styled {
            border: 1px solid #d1e0ff;
            color: #1e3a8a;
            background-color: #fff; /* Ensure bg for shadow */
        }
        .btn-outline-secondary.styled:hover {
            background: #e6f0ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
         /* Style nút Sửa trong bảng */
        .btn-outline-primary.styled {
            border: 1px solid #60a5fa;
            color: #3b82f6;
            background-color: #eff6ff;
        }
         .btn-outline-primary.styled:hover {
            background: #dbeafe;
             border-color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
         }


        .table-styled {
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border-collapse: separate; /* Needed for border-radius */
            border-spacing: 0;
            /* table-layout: fixed; /* Bỏ fixed để cột tự điều chỉnh */
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
        /* Căn chỉnh cụ thể cho các cột */
        .table-styled td.text-wrap, .table-styled th.text-wrap { white-space: normal !important; }
        .table-styled td.break-anywhere, .table-styled th.break-anywhere { overflow-wrap: anywhere; word-break: break-word; }
        .table-styled td.description-cell {
            white-space: normal !important;
            max-width: 320px; /* Giới hạn chiều rộng mô tả */
            text-align: left !important; /* Căn trái mô tả */
        }
         .table-styled th.description-header { text-align: left !important; } /* Căn trái header Mô tả */
         .table-styled td.text-end, .table-styled th.text-end { text-align: right !important; }
         .table-styled td.text-start, .table-styled th.text-start { text-align: left !important; }

        /* Style cho nút dropdown trạng thái */
        .status-dropdown .dropdown-toggle {
            min-width: 120px; /* Đảm bảo nút đủ rộng */
             border-radius: 10px !important; /* Ghi đè bo tròn bootstrap */
             padding: 0.35rem 0.8rem !important; /* Giống btn-sm.styled */
             font-size: 0.85rem !important;
             color: white !important; /* Luôn chữ trắng */
             box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        /* Màu nền dựa trên class gốc */
        .status-dropdown .btn-success { background: linear-gradient(90deg, #22c55e, #4ade80); border:none; }
        .status-dropdown .btn-success:hover { background: linear-gradient(90deg, #16a34a, #22c55e); }
        .status-dropdown .btn-danger { background: linear-gradient(90deg, #ef4444, #f87171); border:none; }
        .status-dropdown .btn-danger:hover { background: linear-gradient(90deg, #dc2626, #ef4444); }
        .status-dropdown .btn-secondary { background: linear-gradient(90deg, #6b7280, #9ca3af); border:none; }
        .status-dropdown .btn-secondary:hover { background: linear-gradient(90deg, #4b5563, #6b7280); }
        .status-dropdown .dropdown-menu { border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,0.1); }


        /* === End Styles đồng bộ === */

        /* Styles cũ giữ lại */
        .img-preview { width: 100%; max-height: 160px; object-fit: cover; border-radius: 0.5rem; }
    </style>
@endpush

@section('content')
    <div class="p-3"> {{-- Giữ padding wrapper --}}

        {{-- Form Cập nhật trong Card --}}
        <div id="roomFormWrap" class="collapse">
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
                <div class="card-body py-4 px-4" style="position: relative;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="form-label styled m-0" style="font-size: 1.1rem;"><i class="bi bi-pencil-square me-2" style="color: #60a5fa;"></i>CẬP NHẬT PHÒNG</h6>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary styled shadow-sm" id="btnCloseForm">
                                <i class="bi bi-x-lg me-1"></i>Đóng
                            </button>
                        </div>
                    </div>
                    <form id="roomForm" class="row g-3" autocomplete="off">
                        <div class="col-md-3">
                            <label class="form-label styled">Mã phòng</label>
                            <input type="text" name="IDPhong" class="form-control styled" readonly style="background-color: #e9ecef;"/>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label styled">Số phòng</label>
                            <input type="text" name="SoPhong" class="form-control styled" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label styled">Loại Phòng</label>
                            <select name="IDLoaiPhong" class="form-control styled">
                                <option value="">-- Chọn loại phòng --</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label styled">Tên phòng</label>
                            <textarea name="TenPhong" class="form-control styled autosize" rows="1"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label styled">Mô tả</label>
                            <textarea name="MoTa" class="form-control styled autosize" rows="3"></textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label styled">Giá phòng (VND)</label>
                            <input type="number" name="GiaCoBanMotDem" class="form-control styled" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label styled">Số người tối đa</label>
                            <input type="number" name="SoNguoiToiDa" class="form-control styled" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label styled">Ảnh hiện tại</label>
                            <div class="border rounded p-2 text-center" style="background: #fff; border-color: #d1e0ff !important;">
                                <img id="roomImagePreview" class="img-preview" src="https://placehold.co/300x200/e0f2fe/3b82f6?text=Room+Image"
                                    alt="Ảnh phòng" onerror="this.src='https://placehold.co/300x200/e0f2fe/3b82f6?text=Image+Error'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label styled">Chọn ảnh mới</label>
                            <input type="file" id="roomImageFile" class="form-control styled" accept="image/*" />
                            <!-- <div class="d-flex gap-2 mt-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary styled" id="btnUseOriginalImage">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i>Dùng lại ảnh cũ
                                </button>
                            </div> -->
                        </div>
                        <div class="col-12 d-flex gap-2 mt-3">
                            <button type="button" class="btn btn-warning styled shadow-sm" id="btnUpdateRoom" disabled>
                                <i class="bi bi-save me-1"></i>Cập nhật phòng
                            </button>
                            <button type="reset" class="btn btn-outline-secondary styled shadow-sm" id="btnResetForm">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                            </button>
                        </div>
                        <input type="hidden" id="roomOriginalKey" />
                        <input type="hidden" id="roomOriginalIDPhong" />
                        <input type="hidden" id="roomOriginalSoPhong" />
                        <input type="hidden" id="roomOriginalTenLoaiPhong" />
                        <input type="hidden" id="roomOriginalUrlAnhPhong" name="UrlAnhPhong" />
                    </form>
                </div>
            </div>
        </div>

        {{-- Bộ lọc trong Card --}}
        <div class="card border-0 shadow-lg mb-4" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
            <div class="card-body py-4 px-4" style="position: relative;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-6 col-lg-5">
                        <label class="form-label styled">Tìm kiếm</label>
                        <div class="input-group">
                            <span class="input-group-text styled"><i class="bi bi-search"></i></span>
                            <input id="roomSearchInput" type="text" class="form-control styled in-group shadow-sm"
                                placeholder="Tìm tên phòng, mã phòng, loại phòng, mô tả..." />
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                         <label class="form-label styled">Trạng thái</label>
                        <select id="roomStatusFilter" class="form-select styled shadow-sm">
                            <option value="">Tất cả trạng thái</option>
                            <option value="Phòng trống">Phòng trống</option>
                            <option value="Phòng hư">Phòng hư</option>
                            <option value="Đang sử dụng">Đang sử dụng</option>
                            <option value="Đã đặt">Đã đặt</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                         <label class="form-label styled">Xếp hạng</label>
                        <select id="roomStarFilter" class="form-select styled shadow-sm">
                            <option value="">Tất cả xếp hạng</option>
                            <option value="1">1 sao</option>
                            <option value="2">2 sao</option>
                            <option value="3">3 sao</option>
                            <option value="4">4 sao</option>
                            <option value="5">5 sao</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3 d-flex">
                        <button id="roomFilterClear" class="btn btn-outline-secondary styled shadow-sm w-100">
                            <i class="bi bi-x-circle me-1"></i>Xóa lọc
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bảng trong Card --}}
         <div class="card border-0 shadow-lg mb-4" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
            <div class="card-body py-4 px-4" style="position: relative;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>
                <div class="table-responsive mt-2">
                    <table class="table table-striped table-hover table-styled" id="roomTable">
                        <thead>
                            <tr>
                                <th style="width:4%;">STT</th>
                                <th style="width:10%;">Loại Phòng</th>
                                <th style="width:6%;">Mã phòng</th>
                                <th style="width:6%;">Số phòng</th>
                                <th style="width:15%;">Tên phòng</th>
                                <th class="description-header" style="width:25%;">Mô tả</th>
                                <th class="text-end" style="width:8%;">Giá</th>
                                <th style="width:6%;">Số người</th>
                                <th style="width:8%;">Hạng</th>
                                <th style="width:6%;">Ảnh</th>
                                <th style="width:10%;">Trạng thái</th>
                                <th style="width:6%;">Sửa</th>
                            </tr>
                        </thead>
                        <tbody id="roomTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        const KEY_FIELD = 'IDPhong';
    let ROOMS = [];
    // Bản đồ cache-bust cho ảnh theo tên file: { filename: timestamp }
    let IMG_BUST = {};
        let LOAI_PHONGS = []; // Danh sách loại phòng
        const FILTER = {
            q: '',
            status: '',
            star: ''
        };
    const CLOSE_FORM_AFTER_UPDATE = true;
        const UPLOAD_ENDPOINT = '/api/upload';
        const MAX_IMAGE_SIZE_MB = 8;

        let previewObjectURL = null;

        // Chuẩn hoá + trim để so sánh không lệ thuộc hoa/thường, dấu, khoảng trắng
        function normalize(s) {
            return (s || '')
                .toString()
                .toLowerCase()
                .normalize('NFD')
                .replace(/\p{Diacritic}/gu, '')
                .trim();
        }

        function applyFilter() {
            let arr = ROOMS.slice();
            const q = normalize(FILTER.q);

            if (q) {
                arr = arr.filter(r => {
                    const fields = [
                        r.SoPhong, r.TenPhong, r.IDPhong, r.TenLoaiPhong, r.MoTa,
                        (r.status || r.TrangThai)
                    ].map(normalize);
                    return fields.some(v => v.includes(q));
                });
            }

            if (FILTER.status) {
                const want = normalize(FILTER.status);
                arr = arr.filter(r => normalize(r.status || r.TrangThai) === want);
            }

            if (FILTER.star) {
                arr = arr.filter(r => Number(r.XepHangSao) === Number(FILTER.star));
            }

            renderRooms(arr);
        }

        function getKey(room) {
            return room?.[KEY_FIELD] || room?.IDPhong || room?.SoPhong || '';
        }

        function imgSrc(url) {
            if (!url) return 'https://placehold.co/300x200/e0f2fe/3b82f6?text=No+Image';
            const s = String(url);
            if (/^https?:\/\//i.test(s)) return s;
            if (s.startsWith('/')) return s;
            if (s.startsWith('uploads/')) return '/' + s;
            // Ảnh được lưu trong public/HomePage/img/slider/
            const base = '/HomePage/img/slider/' + s;
            const bust = IMG_BUST[s];
            return bust ? (base + '?v=' + bust) : base;
        }

        function markImageUpdated(filename) {
            if (!filename) return;
            IMG_BUST[String(filename)] = Date.now();
        }

        function cleanPayload(o) {
            const r = {};
            Object.entries(o).forEach(([k, v]) => {
                if (v !== null && v !== '' && v !== undefined) r[k] = v
            });
            return r;
        }

        // Hiển thị toast thông báo ngắn gọn, tự ẩn
        function showToast(message, type = 'success', duration = 1800) {
            let cont = document.getElementById('toastContainer');
            if (!cont) {
                cont = document.createElement('div');
                cont.id = 'toastContainer';
                cont.style.position = 'fixed';
                cont.style.top = '12px';
                cont.style.right = '12px';
                cont.style.zIndex = '1060';
                cont.style.display = 'flex';
                cont.style.flexDirection = 'column';
                cont.style.gap = '8px';
                document.body.appendChild(cont);
            }
            const el = document.createElement('div');
            el.style.padding = '10px 14px';
            el.style.borderRadius = '10px';
            el.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            el.style.color = '#fff';
            el.style.fontFamily = 'Inter, system-ui, sans-serif';
            el.style.fontSize = '0.9rem';
            el.style.display = 'flex';
            el.style.alignItems = 'center';
            el.style.gap = '8px';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-6px)';
            el.style.transition = 'opacity .2s ease, transform .2s ease';
            const bg = type === 'success' ? '#22c55e' : (type === 'error' ? '#ef4444' : '#3b82f6');
            el.style.background = `linear-gradient(90deg, ${bg}, ${bg}CC)`;
            el.innerHTML = `<i class="bi ${type==='success'?'bi-check-circle':'bi-info-circle'}"></i><span>${message}</span>`;
            cont.appendChild(el);
            requestAnimationFrame(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            });
            setTimeout(() => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(-6px)';
                setTimeout(() => el.remove(), 220);
            }, duration);
        }

        async function loadRooms() {
            try {
                // Use the API that includes TenLoaiPhong via the relation
                const res = await axios.get('/api/phongs', {
                    params: {
                        _t: Date.now()
                    }
                });
                ROOMS = Array.isArray(res.data) ? res.data : (res.data.data || []);
                applyFilter();
            } catch (err) {
                console.error('Lỗi API:', err);
                document.getElementById('roomTableBody').innerHTML =
                    '<tr><td colspan="12" class="text-center py-3">Không thể tải danh sách phòng.</td></tr>';
            }
        }

        async function loadLoaiPhongs() {
            try {
                const res = await axios.get('/api/loaiphongs');
                LOAI_PHONGS = Array.isArray(res.data) ? res.data : (res.data.data || []);
                populateLoaiPhongDropdown();
            } catch (err) {
                console.error('Lỗi tải loại phòng:', err);
            }
        }

        function populateLoaiPhongDropdown() {
            const select = document.querySelector('select[name="IDLoaiPhong"]');
            if (!select) return;

            // Xóa các option cũ (trừ option đầu tiên)
            while (select.options.length > 1) {
                select.remove(1);
            }

            // Thêm các option từ danh sách loại phòng
            LOAI_PHONGS.forEach(loai => {
                const option = document.createElement('option');
                option.value = loai.IDLoaiPhong;
                option.textContent = loai.TenLoaiPhong;
                select.appendChild(option);
            });
        }

        function renderRooms(rooms) {
            const body = document.getElementById('roomTableBody');
            body.innerHTML = '';
            if (!rooms.length) {
                body.innerHTML = '<tr><td colspan="12" class="text-center py-3">Không có phòng nào.</td></tr>';
                return;
            }
            const frag = document.createDocumentFragment();

            rooms.forEach((room, i) => {
                let stars = '';
                if (room.XepHangSao)
                    for (let k = 0; k < room.XepHangSao; k++) stars +=
                        '<i class="bi bi-star-fill text-warning"></i>';
                else stars = '<span class="text-muted">N/A</span>';

                const currentStatus = (room.status && room.status.trim() !== '') ? room.status : (room
                    .TrangThai || 'Phòng trống');
                const availableStatuses = ['Phòng trống', 'Phòng hư'];
            const statusItems = availableStatuses.map(s => `
        <li><a class="dropdown-item ${currentStatus === s ? 'active' : ''}" href="javascript:void(0)"
             onclick="return changeStatus(this,'${s}','${room.SoPhong}')">${s}</a></li>`).join('');
                const btnClass = currentStatus === 'Phòng trống' ? 'btn-success' :
                    currentStatus === 'Phòng hư' ? 'btn-danger' :
                    'btn-secondary';
                                const statusContent = `
                    <div class="dropdown status-dropdown">
                        <button class="btn btn-sm ${btnClass} dropdown-toggle status-btn" type="button" data-bs-toggle="dropdown">
              ${currentStatus}
            </button>
            <ul class="dropdown-menu">${statusItems}</ul>
          </div>`;

                const tr = document.createElement('tr');
                tr.innerHTML = `
          <td class="text-center">${i + 1}</td>
          <td class="text-wrap break-anywhere">${room.TenLoaiPhong || 'N/A'}</td>
          <td class="text-center">${room.IDPhong || 'N/A'}</td>
          <td class="text-center">${room.SoPhong || 'N/A'}</td>
          <td class="text-wrap break-anywhere">${room.TenPhong || 'N/A'}</td>
          <td class="description-cell break-anywhere">${room.MoTa || 'N/A'}</td>
          <td class="text-end">${room.GiaCoBanMotDem ?? 'N/A'}</td>
          <td class="text-center">${room.SoNguoiToiDa ?? 'N/A'}</td>
          <td class="text-center">${stars}</td>
          <td class="text-center"><img src="${imgSrc(room.UrlAnhPhong)}" width="60" height="60" class="rounded"
                   onerror="this.src='https://placehold.co/60x60/e0f2fe/3b82f6?text=No+Img';"></td>
          <td class="text-center">${statusContent}</td>
          <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary styled btn-edit-room"
                    data-index="${ROOMS.indexOf(room)}">Edit</button>
          </td>`;
                frag.appendChild(tr);
            });
            body.appendChild(frag);
        }

        function snapshotFormDefaults() {
            const f = document.getElementById('roomForm');
            if (!f) return;
            Array.from(f.elements).forEach(el => {
                if (!el.name) return;
                if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                    if (el.type !== 'file') el.defaultValue = el.value;
                } else if (el.tagName === 'SELECT') {
                    Array.from(el.options).forEach(opt => {
                        opt.defaultSelected = (opt.value === el.value);
                    });
                }
            });
        }

        function setPreviewFromUrl(url) {
            const img = document.getElementById('roomImagePreview');
            if (!img) {
                console.warn('Không tìm thấy #roomImagePreview');
                return;
            }
            img.src = imgSrc(url);
        }

        function setPreviewFromFile(file) {
            const img = document.getElementById('roomImagePreview');
            if (!img) {
                console.warn('Không tìm thấy #roomImagePreview');
                return;
            }
            if (previewObjectURL) {
                URL.revokeObjectURL(previewObjectURL);
                previewObjectURL = null;
            }
            previewObjectURL = URL.createObjectURL(file);
            img.src = previewObjectURL;
        }

        function clearFileSelection() {
            const fileInput = document.getElementById('roomImageFile');
            if (fileInput) fileInput.value = '';
            if (previewObjectURL) {
                URL.revokeObjectURL(previewObjectURL);
                previewObjectURL = null;
            }
        }

        function useOriginalImage() {
            try {
                clearFileSelection();
                const hidden = document.getElementById('roomOriginalUrlAnhPhong');
                if (!hidden) {
                    console.error('Thiếu #roomOriginalUrlAnhPhong');
                    return;
                }
                const originalUrl = hidden.value;
                setPreviewFromUrl(originalUrl || '');
            } catch (err) {
                console.error('useOriginalImage error:', err);
            }
        }

        function initAutosize(scope = document) {
            const areas = scope.querySelectorAll('textarea.autosize');
            areas.forEach(t => {
                const resize = () => {
                    t.style.height = 'auto';
                    t.style.height = t.scrollHeight + 'px';
                };
                setTimeout(resize, 0);
                t.removeEventListener('input', t._autoResizeHandler || (() => {}));
                t._autoResizeHandler = resize;
                t.addEventListener('input', resize);
            });
        }

        function fillForm(room) {
            const f = document.getElementById('roomForm');
            const set = (n, v) => {
                if (f.elements[n]) f.elements[n].value = v ?? '';
            }
            set('IDPhong', room.IDPhong);
            set('SoPhong', room.SoPhong);

            // Set loại phòng dropdown dựa trên ID; nếu thiếu, map từ tên
            let idLoaiPhong = room.IDLoaiPhong ||
                (room.loaiPhong && room.loaiPhong.IDLoaiPhong) ||
                (room.LoaiPhong && room.LoaiPhong.IDLoaiPhong) || '';
            if (!idLoaiPhong) {
                const ten = (room.TenLoaiPhong || (room.LoaiPhong && room.LoaiPhong.TenLoaiPhong) || '').toString();
                if (ten && LOAI_PHONGS && LOAI_PHONGS.length) {
                    const norm = s => (s||'').toString().toLowerCase().normalize('NFD').replace(/\p{Diacritic}/gu,'').trim();
                    const found = LOAI_PHONGS.find(lp => norm(lp.TenLoaiPhong) === norm(ten));
                    if (found) idLoaiPhong = found.IDLoaiPhong;
                }
            }
            set('IDLoaiPhong', idLoaiPhong);

            set('TenPhong', room.TenPhong);
            set('MoTa', room.MoTa);
            set('GiaCoBanMotDem', room.GiaCoBanMotDem);
            set('SoNguoiToiDa', room.SoNguoiToiDa);
            set('XepHangSao', room.XepHangSao);

            document.getElementById('roomOriginalUrlAnhPhong').value = room.UrlAnhPhong || '';
            setPreviewFromUrl(room.UrlAnhPhong || '');
            clearFileSelection();

            document.getElementById('roomOriginalKey').value = getKey(room);
            document.getElementById('roomOriginalIDPhong').value = room.IDPhong || '';
            document.getElementById('roomOriginalSoPhong').value = room.SoPhong || '';
            document.getElementById('btnUpdateRoom').disabled = false;

            initAutosize(f);
            snapshotFormDefaults();
        }

        function setBtnLoading(isLoading) {
            const btn = document.getElementById('btnUpdateRoom');
            if (!btn) return;
            if (isLoading) {
                btn.disabled = true;
                btn.dataset._html = btn.innerHTML;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Đang lưu...';
            } else {
                btn.disabled = false;
                if (btn.dataset._html) btn.innerHTML = btn.dataset._html;
            }
        }

        function getUploadedUrlFromResponse(res) {
            const d = res?.data || {};
            // Backend giờ chỉ trả về tên file (vd: room_abc123_1234567890.jpg)
            // Không cần parse URL phức tạp nữa
            let filename = d.url || d.path || '';
            if (!filename) return '';
            // Trả về chỉ tên file để lưu vào DB
            return String(filename).trim();
        }

        async function uploadImage(file, overwriteFilename = null) {
            const fd = new FormData();
            fd.append('file', file);
            if (overwriteFilename) {
                fd.append('keepName', 'true');
                // Backend có thể nhận chỉ tên file để ghi đè trong slider
                fd.append('originalUrl', overwriteFilename);
            }
            const res = await axios.post('/api/upload', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json'
                }
            });
            const filename = getUploadedUrlFromResponse(res);
            if (!filename) throw new Error('Upload ảnh không trả về tên file hợp lệ');
            return filename;
        }

        // Xóa ảnh cũ từ server
        async function deleteOldImage(filename) {
            if (!filename || filename.startsWith('http')) return; // Không xóa URL external hoặc rỗng
            try {
                await axios.delete('/api/upload', {
                    data: { filename: filename }
                });
            } catch (err) {
                console.warn('Không thể xóa ảnh cũ:', filename, err);
                // Không throw error, chỉ warning
            }
        }

        // CẬP NHẬT PHÒNG: ưu tiên SoPhong làm param URL để khớp backend
        async function updateRoom() {
            const key = document.getElementById('roomOriginalKey').value;
            if (!key) {
                alert('Chọn 1 phòng để cập nhật');
                return;
            }

            const f = document.getElementById('roomForm');
            const v = n => f.elements[n] ? f.elements[n].value : '';
            const file = document.getElementById('roomImageFile').files[0];
            let newImageUrl = document.getElementById('roomOriginalUrlAnhPhong').value || '';
            const oldImageUrl = newImageUrl; // Lưu lại ảnh cũ để xóa sau

            try {
                if (file) {
                    if (!file.type.startsWith('image/')) {
                        alert('Vui lòng chọn đúng định dạng ảnh.');
                        return;
                    }
                    const sizeMB = file.size / (1024 * 1024);
                    if (sizeMB > MAX_IMAGE_SIZE_MB) {
                        alert(`Ảnh quá lớn (${sizeMB.toFixed(1)} MB). Tối đa ${MAX_IMAGE_SIZE_MB} MB.`);
                        return;
                    }
                    setBtnLoading(true);

                    // Nếu có ảnh cũ -> ghi đè cùng tên để không cần xoá riêng
                    if (oldImageUrl) {
                        newImageUrl = await uploadImage(file, oldImageUrl);
                    } else {
                        // Không có ảnh cũ -> upload tên mới
                        newImageUrl = await uploadImage(file);
                    }
                    // Đánh dấu cache-bust cho ảnh mới để trình duyệt không dùng cache cũ
                    markImageUpdated(newImageUrl);
                    // Cập nhật preview theo URL (dùng cache-bust)
                    setPreviewFromUrl(newImageUrl);
                } else {
                    setBtnLoading(true);
                }

                // Ưu tiên SoPhong -> IDPhong -> key
                const routeParam =
                    (document.getElementById('roomOriginalSoPhong').value || '').trim() ||
                    (document.getElementById('roomOriginalIDPhong').value || '').trim() ||
                    key;

                const payload = cleanPayload({
                    SoPhong: v('SoPhong').trim(),
                    IDLoaiPhong: v('IDLoaiPhong') && v('IDLoaiPhong') !== '' ? String(v('IDLoaiPhong')) : undefined, // Gửi dạng string (vd: LP01)
                    TenPhong: v('TenPhong').trim(),
                    MoTa: v('MoTa').trim(),
                    GiaCoBanMotDem: v('GiaCoBanMotDem') ? Number(v('GiaCoBanMotDem')) : null,
                    SoNguoiToiDa: v('SoNguoiToiDa') ? Number(v('SoNguoiToiDa')) : null,
                    UrlAnhPhong: newImageUrl
                });

                await axios.put(`/api/phongs/${encodeURIComponent(routeParam)}`, payload);

                showToast('Cập nhật phòng thành công!', 'success');
                await loadRooms();

                const updated = ROOMS.find(r =>
                    String(r.SoPhong) === String(routeParam) || String(r.IDPhong) === String(routeParam)
                );
                if (updated) fillForm(updated);

                if (CLOSE_FORM_AFTER_UPDATE) hideForm();
            } catch (e) {
                console.error(e);
                alert('Lỗi: ' + (e.response?.data?.message || e.response?.data || e.message));
            } finally {
                setBtnLoading(false);
            }
        }

        function showFormAndScroll() {
            const wrap = document.getElementById('roomFormWrap');
            const collapse = bootstrap.Collapse.getOrCreateInstance(wrap, {
                toggle: false
            });
            const doScroll = () => {
                const headerH = document.querySelector('.app-header')?.offsetHeight || 0;
                const top = wrap.getBoundingClientRect().top + window.scrollY - (headerH + 12);
                window.scrollTo({
                    top,
                    behavior: 'smooth'
                });
                const first = document.querySelector('#roomForm [name="SoPhong"]') || document.querySelector(
                    '#roomForm input, #roomForm textarea');
                if (first) first.focus();
            };
            if (wrap.classList.contains('show')) doScroll();
            else {
                wrap.addEventListener('shown.bs.collapse', doScroll, {
                    once: true
                });
                collapse.show();
            }
        }

        function hideForm() {
            const wrap = document.getElementById('roomFormWrap');
            bootstrap.Collapse.getOrCreateInstance(wrap, {
                toggle: false
            }).hide();
        }

        function bindEvents() {
            // Tìm kiếm + lọc
            const qInput = document.getElementById('roomSearchInput');
            const stSel = document.getElementById('roomStatusFilter');
            const starSel = document.getElementById('roomStarFilter');
            const clearBtn = document.getElementById('roomFilterClear');

            const debounce = (fn, t = 250) => {
                let id;
                return (...a) => {
                    clearTimeout(id);
                    id = setTimeout(() => fn.apply(this, a), t);
                };
            };
            if (qInput) qInput.addEventListener('input', debounce(() => {
                FILTER.q = qInput.value || '';
                applyFilter();
            }, 250));
            if (stSel) stSel.addEventListener('change', () => {
                FILTER.status = stSel.value || '';
                applyFilter();
            });
            if (starSel) starSel.addEventListener('change', () => {
                FILTER.star = starSel.value || '';
                applyFilter();
            });
            if (clearBtn) clearBtn.addEventListener('click', e => {
                e.preventDefault();
                FILTER.q = '';
                FILTER.status = '';
                FILTER.star = '';
                if (qInput) qInput.value = '';
                if (stSel) stSel.value = '';
                if (starSel) starSel.value = '';
                applyFilter();
            });

            // Edit -> fill + mở + cuộn
            document.getElementById('roomTableBody').addEventListener('click', e => {
                const btn = e.target.closest('.btn-edit-room');
                if (!btn) return;
                const idx = Number(btn.dataset.index);
                const room = ROOMS[idx];
                if (room) {
                    fillForm(room);
                    showFormAndScroll();
                }
            });

            // Chọn ảnh: preview ngay; nếu Cancel/không hợp lệ -> quay về ảnh cũ
            const fileInput = document.getElementById('roomImageFile');
            if (fileInput) fileInput.addEventListener('change', () => {
                const file = fileInput.files[0];
                if (!file) {
                    useOriginalImage();
                    return;
                }
                if (!file.type.startsWith('image/')) {
                    alert('Vui lòng chọn đúng định dạng ảnh.');
                    useOriginalImage();
                    return;
                }
                const sizeMB = file.size / (1024 * 1024);
                if (sizeMB > MAX_IMAGE_SIZE_MB) {
                    alert(`Ảnh quá lớn (${sizeMB.toFixed(1)} MB). Tối đa ${MAX_IMAGE_SIZE_MB} MB.`);
                    useOriginalImage();
                    return;
                }
                setPreviewFromFile(file);
            });

            // // Nút "Dùng lại ảnh cũ"
            // const btnUseOriginal = document.getElementById('btnUseOriginalImage');
            // if (btnUseOriginal) btnUseOriginal.addEventListener('click', e => {
            //     e.preventDefault();
            //     useOriginalImage();
            // });

            // Cập nhật
            document.getElementById('btnUpdateRoom').onclick = updateRoom;

            // Reset
            document.getElementById('roomForm').addEventListener('reset', () => {
                setTimeout(() => {
                    useOriginalImage();
                    initAutosize(document.getElementById('roomForm'));
                    const first = document.querySelector('#roomForm [name="SoPhong"]') || document
                        .querySelector('#roomForm input, #roomForm textarea');
                    if (first) first.focus();
                }, 0);
            });

            // Đóng form
            const btnClose = document.getElementById('btnCloseForm');
            if (btnClose) btnClose.addEventListener('click', e => {
                e.preventDefault();
                hideForm();
            });

            // ESC đóng form
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape' && document.getElementById('roomFormWrap').classList.contains('show'))
                    hideForm();
            });

            // Khi form đóng: reset + disable update + clear key + preview mặc định
            const wrap = document.getElementById('roomFormWrap');
            wrap.addEventListener('hidden.bs.collapse', () => {
                const f = document.getElementById('roomForm');
                f.reset();
                document.getElementById('btnUpdateRoom').disabled = true;
                document.getElementById('roomOriginalKey').value = '';
                document.getElementById('roomOriginalUrlAnhPhong').value = '';
                clearFileSelection();
                setPreviewFromUrl('');
            });

            // Kích hoạt autosize ngay lần đầu
            initAutosize(document);
        }

        async function changeStatus(el, status, roomNumber) {
            if (!confirm(`Chuyển trạng thái phòng ${roomNumber} thành "${status}"?`)) return false;
            try {
                await axios.put(`/api/phongs/${encodeURIComponent(roomNumber)}`, {
                    status
                }, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const td = el.closest('td');
                const btn = td.querySelector('.status-btn');
                if (btn) {
                    btn.innerHTML = status;
                    // Cập nhật class màu ngay để không cần reload
                    btn.classList.remove('btn-success','btn-danger','btn-secondary');
                    const cls = (status === 'Phòng trống') ? 'btn-success'
                              : (status === 'Phòng hư') ? 'btn-danger'
                              : 'btn-secondary';
                    btn.classList.add(cls);
                }
                td.querySelectorAll('.dropdown-item').forEach(a => a.classList.remove('active'));
                el.classList.add('active');
                const item = ROOMS.find(r => String(r.SoPhong) === String(roomNumber));
                if (item) {
                    item.status = status;
                    item.TrangThai = status;
                }
                showToast('Cập nhật trạng thái thành công!', 'success');
            } catch (err) {
                console.error(err);
                alert('Không thể cập nhật trạng thái.');
            }
            return false;
        }

        document.addEventListener('DOMContentLoaded', async () => {
            await Promise.all([
                loadRooms(),
                loadLoaiPhongs()
            ]);
            bindEvents();
        });
    </script>
@endsection

