@extends('layouts.layout2')

@section('title', 'Phòng')

@section('content')
    {{-- Các CSS tùy chỉnh từ file index.blade.php cũ --}}
    <style>
        .table-scroll-y { max-height: 65vh; overflow-y: auto; }
        table th, table td { vertical-align: middle; }
        .img-preview { width: 100%; max-height: 160px; object-fit: cover; border-radius: 0.5rem; }

        .text-wrap { white-space: normal !important; }
        .break-anywhere { overflow-wrap: anywhere; word-break: break-word; }
        .description-cell { white-space: normal !important; max-width: 320px; }

        textarea.form-control.autosize { overflow: hidden; resize: vertical; min-height: 38px; }
    </style>

    {{-- Toàn bộ nội dung trong <div class="app-body"> của file index.blade.php cũ --}}
    <div id="roomFormWrap" class="collapse">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="m-0"><i class="bi bi-pencil-square me-2"></i>UPDATE PHÒNG</h6>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btnCloseForm">
                            <i class="bi bi-x-lg me-1"></i>Đóng
                        </button>
                    </div>
                </div>

                <form id="roomForm" class="row g-3" autocomplete="off">
                    <div class="col-md-3">
                        <label class="form-label">Mã phòng</label>
                        <input type="text" name="IDPhong" class="form-control" readonly />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Số phòng</label>
                        <input type="text" name="SoPhong" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tên Loại Phòng</label>
                        <textarea name="TenLoaiPhong" class="form-control autosize" rows="2"></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tên phòng</label>
                        <textarea name="TenPhong" class="form-control autosize" rows="2"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mô tả</label>
                        <textarea name="MoTa" class="form-control autosize" rows="4"></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Giá phòng</label>
                        <input type="number" name="GiaCoBanMotDem" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Số người tối đa</label>
                        <input type="number" name="SoNguoiToiDa" class="form-control" />
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Ảnh hiện tại</label>
                        <div class="border rounded p-2 text-center bg-light">
                            <img id="roomImagePreview" class="img-preview" src="https://picsum.photos/300/200"
                                alt="Ảnh phòng" onerror="this.src='https://picsum.photos/300/200'">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Chọn ảnh mới</label>
                        <input type="file" id="roomImageFile" class="form-control" accept="image/*" />
                        <div class="d-flex gap-2 mt-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="btnUseOriginalImage">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Dùng lại ảnh cũ
                            </button>
                        </div>
                    </div>

                    <div class="col-12 d-flex gap-2 mt-2">
                        <button type="button" class="btn btn-warning" id="btnUpdateRoom" disabled>
                            <i class="bi bi-save me-1"></i>Cập nhật phòng
                        </button>
                        <button type="reset" class="btn btn-outline-secondary" id="btnResetForm">
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

    <div class="card border-0 shadow-sm mb-2">
        <div class="card-body py-2">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input id="roomSearchInput" type="text" class="form-control"
                            placeholder="Tìm tên phòng, mã phòng, loại phòng, mô tả..." />
                    </div>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <select id="roomStatusFilter" class="form-select form-select-sm">
                        <option value="">Tất cả trạng thái</option>
                        <option value="Phòng trống">Phòng trống</option>
                        <option value="Phòng hư">Phòng hư</option>
                        <option value="Đang sử dụng">Đang sử dụng</option>
                        <option value="Đã đặt">Đã đặt</option>
                    </select>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <select id="roomStarFilter" class="form-select form-select-sm">
                        <option value="">Tất cả xếp hạng</option>
                        <option value="1">1 sao</option>
                        <option value="2">2 sao</option>
                        <option value="3">3 sao</option>
                        <option value="4">4 sao</option>
                        <option value="5">5 sao</option>
                    </select>
                </div>
                <div class="col-12 col-md-3 col-lg-2 d-flex gap-2">
                    <button id="roomFilterClear" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="bi bi-x-circle me-1"></i>Xóa lọc
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-3" style="padding-left: 0; padding-right: 0; margin-left: -15px; margin-right: -15px;">
        <div class="table-responsive mt-4" style="margin-left: -15px; margin-right: -15px;">
            <table class="table table-striped table-hover table-bordered"
                style="border-collapse: collapse; width: 100%; border-radius: 0.5rem; overflow: hidden; table-layout: fixed;">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width:4%;">STT</th>
                        <th class="text-center" style="width:10%;">Tên Loại Phòng</th>
                        <th class="text-center" style="width:6%;">Mã phòng</th>
                        <th class="text-center" style="width:6%;">Số phòng</th>
                        <th class="text-center" style="width:15%;">Tên phòng</th>
                        <th class="text-center" style="width:30%;">Mô tả</th>
                        <th class="text-center" style="width:10%;">Giá</th>
                        <th class="text-center" style="width:8%;">Số người tối đa</th>
                        <th class="text-center" style="width:10%;">Xếp hạng</th>
                        <th class="text-center" style="width:8%;">Ảnh</th>
                        <th class="text-center" style="width:14%;">Trạng thái</th>
                        <th class="text-center" style="width:6%;">Hành động</th>
                    </tr>
                </thead>
                <tbody id="roomTableBody"></tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Thêm Axios vì layout2 không có --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        const KEY_FIELD = 'IDPhong';
        let ROOMS = [];
        const FILTER = {
            q: '',
            status: '',
            star: ''
        };
        const CLOSE_FORM_AFTER_UPDATE = false;
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
            if (!url) return '/img/slider/default.jpg';
            const s = String(url);
            if (/^https?:\/\//i.test(s)) return s;
            if (s.startsWith('/')) return s;
            if (s.startsWith('uploads/')) return '/' + s;
            return '/img/slider/' + s;
        }

        function cleanPayload(o) {
            const r = {};
            Object.entries(o).forEach(([k, v]) => {
                if (v !== null && v !== '' && v !== undefined) r[k] = v
            });
            return r;
        }

        async function loadRooms() {
            try {
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
            async function loadRooms() {
                try {
                    // Use the API that includes TenLoaiPhong via the relation
                    const res = await axios.get('/api/phong?with=tiennghi');
                    ROOMS = Array.isArray(res.data.data) ? res.data.data : (Array.isArray(res.data) ? res.data : []);
                    applyFilter();
                } catch (err) {
                    console.error('Lỗi API:', err);
                    document.getElementById('roomTableBody').innerHTML =
                        '<tr><td colspan="12" class="text-center py-3">Không thể tải danh sách phòng.</td></tr>';
                }
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
          <li><a class="dropdown-item ${currentStatus === s ? 'active' : ''}" href="#"
                 onclick="return changeStatus(this,'${s}','${room.SoPhong}')">${s}</a></li>`).join('');
                const btnClass = currentStatus === 'Phòng trống' ? 'btn-success' :
                    currentStatus === 'Phòng hư' ? 'btn-danger' :
                    'btn-secondary';
                const statusContent = `
          <div class="dropdown">
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
                   onerror="this.src='https://picsum.photos/60/60';"></td>
          <td class="text-center">${statusContent}</td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-secondary btn-edit-room"
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
            set('TenLoaiPhong', room.TenLoaiPhong || room.tenLoaiPhong ||
                (room.LoaiPhong && (room.LoaiPhong.TenLoaiPhong || room.LoaiPhong.tenLoaiPhong)) || '');
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
            let url = d.url || d.Location || d.path || (d.data && d.data.url) || '';
            if (!url) return '';
            const s = String(url);
            if (/^https?:\/\//i.test(s)) return s;
            if (s.startsWith('/')) return location.origin + s;
            return location.origin + '/' + s.replace(/^\.?\//, '');
        }

        async function uploadImage(file) {
            const fd = new FormData();
            fd.append('file', file);
            const res = await axios.post('/api/upload', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json'
                }
            });
            const url = getUploadedUrlFromResponse(res);
            if (!url) throw new Error('Upload ảnh không trả về URL hợp lệ');
            return url;
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
                    newImageUrl = await uploadImage(file);
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
                    TenLoaiPhong: v('TenLoaiPhong').trim(), // nếu không muốn đổi loại hàng loạt, bạn có thể loại bỏ dòng này
                    TenPhong: v('TenPhong').trim(),
                    MoTa: v('MoTa').trim(),
                    GiaCoBanMotDem: v('GiaCoBanMotDem') ? Number(v('GiaCoBanMotDem')) : null,
                    SoNguoiToiDa: v('SoNguoiToiDa') ? Number(v('SoNguoiToiDa')) : null,
                    UrlAnhPhong: newImageUrl
                });

                await axios.put(`/api/phongs/${encodeURIComponent(routeParam)}`, payload);

                alert('Cập nhật thành công!');
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

            // Nút "Dùng lại ảnh cũ"
            const btnUseOriginal = document.getElementById('btnUseOriginalImage');
            if (btnUseOriginal) btnUseOriginal.addEventListener('click', e => {
                e.preventDefault();
                useOriginalImage();
            });

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
                if (btn) btn.innerHTML = status;
                td.querySelectorAll('.dropdown-item').forEach(a => a.classList.remove('active'));
                el.classList.add('active');
                const item = ROOMS.find(r => String(r.SoPhong) === String(roomNumber));
                if (item) {
                    item.status = status;
                    item.TrangThai = status;
                }
                alert('Cập nhật trạng thái thành công!');
            } catch (err) {
                console.error(err);
                alert('Không thể cập nhật trạng thái.');
            }
            return false;
        }

        document.addEventListener('DOMContentLoaded', async () => {
            await loadRooms();
            bindEvents();
        });
    </script>
@endsection
