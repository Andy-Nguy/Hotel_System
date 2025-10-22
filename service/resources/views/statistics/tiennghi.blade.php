@extends('layouts.layout2')

@section('title', 'Tiện nghi')

@section('content')
<div class="container-fluid py-3">
    {{-- khu vực hiển thị alert --}}
    <div id="alertArea"></div>

    <!-- Tabs điều hướng -->
    <ul class="nav nav-pills mb-3" id="amenitiesTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-manage-tab" data-bs-toggle="pill" data-bs-target="#tab-manage" type="button" role="tab">
                Quản lý & gán tiện nghi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-rooms-tab" data-bs-toggle="pill" data-bs-target="#tab-rooms" type="button" role="tab">
                Phòng & tiện nghi
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Tab 1: Quản lý & gán -->
        <div class="tab-pane fade show active" id="tab-manage" role="tabpanel" aria-labelledby="tab-manage-tab">
            <div class="row">
                <div class="col-md-6">
                    {{-- bảng tiện nghi --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    Danh sách tiện nghi
                                    <span class="badge bg-secondary ms-2" id="amenitiesCount">0</span>
                                </h5>
                                <button id="btnOpenCreate" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-lg me-1"></i> Thêm
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- input-group search + clear -->
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" id="searchTienNghi" class="form-control" placeholder="Tìm tiện nghi...">
                                <button class="btn btn-outline-secondary" id="clearSearchTienNghi" title="Xóa tìm kiếm">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>

                            <!-- Lọc nhanh + sắp xếp -->
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                <div class="btn-group btn-group-sm" role="group" aria-label="filters">
                                    <button class="btn btn-outline-secondary filter-tn active" data-filter="all">Tất cả</button>
                                    <button class="btn btn-outline-secondary filter-tn" data-filter="selected">Đã chọn</button>
                                    <button class="btn btn-outline-secondary filter-tn" data-filter="unselected">Chưa chọn</button>
                                </div>
                                <div class="ms-auto d-flex align-items-center gap-2">
                                    <span class="small text-muted">Sắp xếp:</span>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="sort">
                                        <button class="btn btn-outline-secondary sort-tn" data-key="IDTienNghi">ID</button>
                                        <button class="btn btn-outline-secondary sort-tn" data-key="TenTienNghi">Tên</button>
                                    </div>
                                </div>
                            </div>

                            <div class="position-relative" id="amenitiesTableWrap">
                                <table class="table table-striped table-hover align-middle m-0" id="tableTienNghi">
                                    <thead class="table-light">
                                        <tr>
                                            <th id="thTnId" class="sortable">ID</th>
                                            <th id="thTnName" class="sortable">Tên tiện nghi</th>
                                            <th class="text-end">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- JS render --}}
                                    </tbody>
                                </table>
                                <div class="table-overlay d-none" id="amenitiesOverlay">
                                    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Create/Edit Tiện nghi -->
                    <div class="modal fade" id="modalCreateEdit" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitle">Thêm tiện nghi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="tnId" />
                                    <div class="mb-3">
                                        <label class="form-label">Tên tiện nghi</label>
                                        <input type="text" id="TenTienNghi" class="form-control" placeholder="VD: Điều hòa, Ấm đun nước..." />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-primary" id="btnSubmitCreateEdit">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Confirm Delete Tiện nghi -->
                    <div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Xóa tiện nghi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Bạn chắc chắn muốn xóa tiện nghi: <strong id="deleteName"></strong>?</p>
                                    <input type="hidden" id="deleteId" />
                                    <div class="small text-muted">
                                        Lưu ý: Các gán tiện nghi của phòng sẽ được gỡ tự động.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-danger" id="btnConfirmDelete">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    {{-- phần gán tiện nghi --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Gán tiện nghi cho phòng</h5>
                        </div>
                        <div class="card-body position-relative">
                            {{-- Cải thiện UX/UI dropdown: thêm icon, viền nổi bật, hiệu ứng focus --}}
                            <div class="row g-2 align-items-end mb-2 assign-select-row">
                                <div class="col-md-6">
                                    <label class="form-label mb-1 text-primary">Loại phòng</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="bi bi-building"></i></span>
                                        <select id="selectLoaiPhongAssign" class="form-select form-select-lg shadow-sm"></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label mb-1 text-primary">Phòng</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="bi bi-door-closed"></i></span>
                                        <select id="selectPhong" class="form-select form-select-lg shadow-sm" disabled></select>
                                    </div>
                                </div>
                            </div>

                            <div id="assignSelectionInfo" class="small text-muted mb-2">
                                <i class="bi bi-info-circle me-1"></i> Chưa chọn loại phòng/phòng.
                            </div>

                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="applyAllInType" disabled>
                                <label class="form-check-label" for="applyAllInType" id="applyAllLabel">
                                    Áp dụng cho tất cả phòng thuộc loại đã chọn
                                </label>
                            </div>

                            <div class="mb-2">
                                <input type="text" id="filterCheckbox" class="form-control mb-2" placeholder="Tìm tiện nghi...">

                                <!-- sticky toolbar + selected count + unsaved badge -->
                                <div class="assign-toolbar d-flex justify-content-between align-items-center mb-2">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-outline-primary" id="btnSelectAll">
                                            <i class="bi bi-check2-square me-1"></i>Chọn tất cả
                                        </button>
                                        <button class="btn btn-outline-secondary" id="btnClearAll">
                                            <i class="bi bi-square me-1"></i>Bỏ chọn
                                        </button>
                                        <button class="btn btn-outline-dark" id="btnInvert">
                                            <i class="bi bi-shuffle me-1"></i>Đảo chọn
                                        </button>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="small text-muted">Đã chọn: <b id="selectedCount">0</b></span>
                                        <span id="unsavedBadge" class="badge bg-warning-subtle text-warning-emphasis d-none">Chưa lưu</span>
                                    </div>
                                </div>

                                <div id="checkboxTienNghiList" class="form-check-box-list"></div>
                            </div>

                            <div class="mb-2">
                                <strong>Tiện nghi hiện tại:</strong>
                                <div id="currentAssigned" class="mt-1"></div>
                            </div>
                            <button id="btnSaveAssign" class="btn btn-primary w-100" disabled>Lưu gán tiện nghi</button>

                            <!-- overlay loading riêng cho khu vực gán -->
                            <div id="assignOverlay" class="assign-overlay d-none">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Phòng & tiện nghi -->
        <div class="tab-pane fade" id="tab-rooms" role="tabpanel" aria-labelledby="tab-rooms-tab">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Bảng phòng</h5>
                        </div>
                        <div class="card-body">
                            <div id="roomFilterChips" class="mb-2"></div>
                            <!-- input-group search + clear -->
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" id="searchPhong" class="form-control" placeholder="Tìm phòng...">
                                <button class="btn btn-outline-secondary" id="clearSearchPhong" title="Xóa tìm kiếm">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                            <div class="position-relative" id="roomsTableWrap">
                                <table class="table table-striped table-hover align-middle m-0" id="tablePhong">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Số phòng</th>
                                            <th>Loại phòng</th>
                                            <th>Trạng thái</th>
                                            <th>Tiện nghi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- JS render --}}
                                    </tbody>
                                </table>
                                <div class="table-overlay d-none" id="roomsOverlay">
                                    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /tab-rooms -->
    </div><!-- /tab-content -->
</div>

<style>
    /* Hover effect for room table rows */
    #tablePhong tbody tr {
        transition: all 0.2s ease;
        position: relative;
    }

    #tablePhong tbody tr:hover {
        background-color: #eef2f7;
        border: 1px solid #d0d7de;
        transform: translateY(-1px);
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(31, 35, 40, 0.08);
    }

    /* Style for amenities in room table */
    #tablePhong .amenity-label {
        display: inline-block;
        background-color: #6b7280;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        margin: 2px;
        font-size: 0.8rem;
        cursor: pointer;
    }

    /* Sortable headers */
    th.sortable {
        cursor: pointer;
        user-select: none;
    }

    th.sortable::after {
        content: ' ⇅';
        font-weight: normal;
        color: #adb5bd;
        font-size: .8rem;
    }

    /* Checkbox list container */
    .form-check-box-list {
        max-height: 320px;
        overflow-y: auto;
        border: 1px solid #e9ecef;
        border-radius: .375rem;
        padding: .5rem .75rem;
        background: #fff;
    }

    /* Overlay loading for tables */
    .table-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, .6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        border-radius: .375rem;
    }

    /* Amenity label clickable filter in rooms table */
    #tablePhong .amenity-label {
        display: inline-block;
        background-color: #6b7280;
        color: #fff;
        padding: 2px 8px;
        border-radius: 12px;
        margin: 2px;
        font-size: .8rem;
        cursor: pointer;
    }

    /* Toolbar sticky trong khu vực gán */
    .assign-toolbar {
        position: sticky;
        top: 0;
        background: #fff;
        z-index: 1;
        padding: .25rem 0;
        border-bottom: 1px dashed #e9ecef;
    }

    /* Chip tiện nghi hiện tại với nút xóa nhỏ */
    #currentAssigned .amenity-chip {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        background-color: #0d6efd;
        color: #fff;
        border-radius: 16px;
        padding: 2px 8px;
        margin: 2px;
        font-size: .8rem;
    }

    #currentAssigned .amenity-chip .remove {
        cursor: pointer;
        opacity: .85;
    }

    #currentAssigned .amenity-chip .remove:hover {
        opacity: 1;
        text-decoration: underline;
    }

    /* Overlay cho khu vực gán */
    .assign-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, .6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 5;
        border-radius: .375rem;
    }

    /* Làm rõ vùng checkbox khi disabled theo logic (không chọn phòng) */
    .form-check-box-list.disabled {
        pointer-events: none;
        opacity: .6;
    }

    /* Tinh chỉnh cụm chọn loại/phòng */
    .assign-select-row .form-label {
        font-weight: 600;
    }

    .assign-select-row .input-group-text i {
        line-height: 1;
        font-size: 1rem;
    }

    /* Giữ viền rõ khi select bị disabled */
    .form-select:disabled {
        background-color: #f8f9fa;
        border: 1px solid var(--bs-border-color, #ced4da);
        opacity: 1;
    }
</style>
@endsection

@section('scripts')
<script>
    const API_BASE = '/api';
    let ALL_TIEN_NGHI = [];
    let SELECTED_TN_IDS = [];
    let PHONG_TABLE = [];
    let ALL_LOAI_PHONG = [];

    // Trạng thái UI
    let AMENITY_FILTER_MODE = 'all'; // all | selected | unselected
    let SORT_STATE = {
        tn: {
            key: 'TenTienNghi',
            dir: 'asc'
        }
    };
    let ROOM_FILTER_AMENITY = '';

    // Debounce helper
    function debounce(fn, wait = 250) {
        let t;
        return (...args) => {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    // Normalize Vietnamese text (case-insensitive, accent-insensitive)
    function vnNormalize(str = '') {
        return String(str).toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/đ/g, 'd').replace(/Đ/g, 'd');
    }

    // Toggle overlay
    function toggleOverlay(target, show) {
        const el = target === 'amenities' ? '#amenitiesOverlay' : '#roomsOverlay';
        $(el).toggleClass('d-none', !show);
    }

    // Hàm gọi API
    async function apiFetch(url, options = {}) {
        const opts = {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            ...options
        };
        if (options.body && typeof options.body === 'object') opts.body = JSON.stringify(options.body);
        const res = await fetch(url, opts);
        const text = await res.text();
        let data = null;
        try { data = text ? JSON.parse(text) : null; } catch (e) { data = text; }
        if (!res.ok) {
            const msg = (data && data.message) ? data.message : (data && typeof data === 'string' ? data : res.statusText || 'HTTP error');
            const err = new Error(msg);
            // attach parsed body for callers who want details
            err.body = data;
            throw err;
        }
        return data;
    }

    // Hiển thị alert
    function showAlert(type, message) {
        const alert = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
			${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
        $('#alertArea').html(alert);
        setTimeout(() => $('.alert').alert('close'), 3000);
    }

    // Nạp danh sách tiện nghi
    async function loadTienNghi() {
        toggleOverlay('amenities', true);
        const json = await apiFetch(`${API_BASE}/tien-nghi`);
        ALL_TIEN_NGHI = (json?.data || []).map(x => ({
            IDTienNghi: String(x.IDTienNghi),
            TenTienNghi: x.TenTienNghi
        }));
        renderTienNghiTable(ALL_TIEN_NGHI);
        renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
        toggleOverlay('amenities', false);
    }

    // Nạp danh sách loại phòng (dropdown)
    async function loadLoaiPhong() {
        const json = await apiFetch(`${API_BASE}/loai-phong`);
        ALL_LOAI_PHONG = json?.data || [];
        let html = '<option value="">-- Chọn loại phòng --</option>';
        ALL_LOAI_PHONG.forEach(x => {
            html += `<option value="${x.IDLoaiPhong}">${x.TenLoaiPhong}</option>`;
        });
        $('#selectLoaiPhongAssign').html(html);
    }

    // Nạp danh sách phòng
    async function loadPhongs() {
        const json = await apiFetch(`${API_BASE}/phong`);
        PHONG_TABLE = json?.data || [];
        await refreshAssignPhongDropdown();
    }

    // Nạp danh sách phòng cho bảng
    async function loadPhongTable() {
        toggleOverlay('rooms', true);
        const json = await apiFetch(`${API_BASE}/phong?with=tiennghi`);
        const raw = json?.data || [];
        PHONG_TABLE = raw.map(x => {
            const tnArr = Array.isArray(x.TienNghis) ?
                x.TienNghis :
                (Array.isArray(x.tien_nghis) ? x.tien_nghis : (Array.isArray(x.tien_nghi) ? x.tien_nghi : []));
            return {
                ...x,
                TienNghis: tnArr,
                TenPhong: x.TenPhong || x.SoPhong,
                TrangThai: x.TrangThai || 'Không xác định'
            };
        });
        renderPhongTable(PHONG_TABLE);
        toggleOverlay('rooms', false);
    }

    // Theo loại phòng -> dropdown phòng
    async function refreshAssignPhongDropdown() {
        const lid = $('#selectLoaiPhongAssign').val();
        $('#selectPhong').prop('disabled', !lid);
        $('#applyAllInType').prop('disabled', !lid).prop('checked', !!lid); // Enable và check công tắc khi có loại phòng
        $('#applyAllLabel').toggleClass('disabled', !lid); // Làm mờ label khi công tắc disable
        if (!lid) {
            $('#selectPhong').html('<option value="">-- Chọn phòng --</option>');
            SELECTED_TN_IDS = [];
            ASSIGNED_ORIG_IDS = [];
            renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
            renderCurrentAssigned([]);
            setDirty(false);
            return;
        }
        const phongs = PHONG_TABLE.filter(x => String(x.IDLoaiPhong) === String(lid));
        let html = '<option value="">-- Chọn phòng --</option>';
        phongs.forEach(x => {
            html += `<option value="${x.IDPhong}">${x.SoPhong}</option>`;
        });
        $('#selectPhong').html(html);
        SELECTED_TN_IDS = [];
        ASSIGNED_ORIG_IDS = [];
        renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
        renderCurrentAssigned([]);
        setDirty(false);
        updateAssignInfo();
        refreshSaveButtonState();
    }

    // Lấy danh sách ID tiện nghi của phòng
    async function fetchAssignedIds(phongId) {
        const json = await apiFetch(`${API_BASE}/phong/${phongId}/tien-nghi`);
        // map objects -> ID strings
        return (json?.data || []).map(item => String(item.IDTienNghi));
    }

    // Đồng bộ tiện nghi cho phòng
    async function syncPhongTienNghi(phongId, tienNghiIds) {
        return await apiFetch(`${API_BASE}/phong/${phongId}/tien-nghi`, {
            method: 'PUT',
            body: {
                tien_nghi_ids: tienNghiIds
            }
        });
    }

    // Render bảng tiện nghi (lọc + sắp xếp)
    function renderTienNghiTable(data) {
        const search = vnNormalize($('#searchTienNghi').val() || '');
        let filtered = data.filter(x => vnNormalize(x.TenTienNghi).includes(search));

        // Lọc nhanh theo trạng thái chọn
        if (AMENITY_FILTER_MODE === 'selected') {
            filtered = filtered.filter(x => SELECTED_TN_IDS.includes(String(x.IDTienNghi)));
        } else if (AMENITY_FILTER_MODE === 'unselected') {
            filtered = filtered.filter(x => !SELECTED_TN_IDS.includes(String(x.IDTienNghi)));
        }

        // Sắp xếp
        const {
            key,
            dir
        } = SORT_STATE.tn;
        filtered.sort((a, b) => {
            const va = key === 'IDTienNghi' ? Number(a[key]) : vnNormalize(a[key]);
            const vb = key === 'IDTienNghi' ? Number(b[key]) : vnNormalize(b[key]);
            if (va < vb) return dir === 'asc' ? -1 : 1;
            if (va > vb) return dir === 'asc' ? 1 : -1;
            return 0;
        });

        let html = '';
        if (filtered.length === 0) {
            html = `<tr><td colspan="3" class="empty-state py-4"><i class="bi bi-inbox me-1"></i> Không có dữ liệu phù hợp</td></tr>`;
        } else {
            filtered.forEach(x => {
                html += `<tr>
					<td>${x.IDTienNghi}</td>
					<td>${x.TenTienNghi}</td>
					<td class="text-end">
						<button class="btn btn-sm btn-outline-primary btn-edit me-1" data-id="${x.IDTienNghi}" data-name="${x.TenTienNghi}"><i class="bi bi-pencil"></i></button>
						<button class="btn btn-sm btn-outline-danger btn-delete" data-id="${x.IDTienNghi}"><i class="bi bi-trash"></i></button>
					</td>
				</tr>`;
            });
        }
        $('#tableTienNghi tbody').html(html);
        $('#amenitiesCount').text(filtered.length);

        // Bind actions
        $('.btn-edit').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#tnId').val(id);
            $('#TenTienNghi').val(name);
            $('#modalTitle').text('Sửa tiện nghi');
            new bootstrap.Modal(document.getElementById('modalCreateEdit')).show();
        });
        $('.btn-delete').on('click', function() {
            const id = String($(this).data('id'));
            $('#deleteId').val(id);
            const tn = ALL_TIEN_NGHI.find(t => String(t.IDTienNghi) === id);
            $('#deleteName').text(tn ? tn.TenTienNghi : '');
            new bootstrap.Modal(document.getElementById('modalDelete')).show();
        });
    }

    // Render danh sách checkbox tiện nghi (keep this one)
    function renderCheckboxList(data, selectedIds) {
        const search = vnNormalize($('#filterCheckbox').val() || '');
        const filtered = data.filter(x => vnNormalize(x.TenTienNghi).includes(search));
        let html = '';
        if (filtered.length === 0) {
            html = `<div class="empty-state py-2"><i class="bi bi-inbox me-1"></i> Không có tiện nghi</div>`;
        } else {
            filtered.forEach(x => {
                const isChecked = selectedIds.includes(String(x.IDTienNghi)) ? 'checked' : '';
                html += `<div class="form-check">
					<input class="form-check-input chk-tiennghi" type="checkbox" value="${x.IDTienNghi}" id="chk-${x.IDTienNghi}" ${isChecked}>
					<label class="form-check-label" for="chk-${x.IDTienNghi}">${x.TenTienNghi}</label>
				</div>`;
            });
        }
        $('#checkboxTienNghiList').html(html);
        $('#selectedCount').text(selectedIds.length);
    }

    // Render danh sách tiện nghi đang gán
    function renderCurrentAssigned(names) {
        const container = $('#currentAssigned');
        container.empty();
        if (!names || names.length === 0) return container.html('<i>Chưa có tiện nghi nào được gán</i>');
        names.forEach(name => container.append(`<span class="badge bg-primary me-1 mb-1">${name}</span>`));
    }

    // Room filter chips
    function renderRoomFilterChips() {
        if (!ROOM_FILTER_AMENITY) return $('#roomFilterChips').empty();
        $('#roomFilterChips').html(
            `<span class="badge bg-info text-white">
				Lọc theo tiện nghi: ${ROOM_FILTER_AMENITY}
				<a href="#" id="clearAmenityFilter" class="text-white ms-1 text-decoration-none">×</a>
			</span>`
        );
        $('#clearAmenityFilter').on('click', function(e) {
            e.preventDefault();
            ROOM_FILTER_AMENITY = '';
            renderRoomFilterChips();
            renderPhongTable(PHONG_TABLE);
        });
    }

    // Render bảng phòng (hỗ trợ lọc theo tiện nghi)
    function renderPhongTable(data) {
        const q = vnNormalize($('#searchPhong').val() || '');
        const filtered = data.filter(x => {
            const soPhong = vnNormalize(String(x.SoPhong ?? ''));
            const tenLoai = vnNormalize(String(x.TenLoaiPhong ?? ''));
            const trangThai = vnNormalize(String(x.TrangThai ?? ''));
            const tn = (Array.isArray(x.TienNghis) ? vnNormalize(x.TienNghis.map(t => t.TenTienNghi).join(',')) : '');
            let base = (soPhong.includes(q) || tenLoai.includes(q) || trangThai.includes(q) || tn.includes(q));
            if (ROOM_FILTER_AMENITY) {
                const hasAmenity = Array.isArray(x.TienNghis) && x.TienNghis.some(t => vnNormalize(t.TenTienNghi).includes(vnNormalize(ROOM_FILTER_AMENITY)));
                base = base && hasAmenity;
            }
            return base;
        });

        let html = '';
        if (filtered.length === 0) {
            html = `<tr><td colspan="5" class="empty-state py-4"><i class="bi bi-inbox me-1"></i> Không có dữ liệu phòng</td></tr>`;
        } else {
            filtered.forEach(x => {
                const amenities = Array.isArray(x.TienNghis) ? x.TienNghis : [];
                const amenitiesHtml = amenities.length > 0 ?
                    amenities.map(t => `<span class="amenity-label amenity-filter-chip" data-name="${t.TenTienNghi}">${t.TenTienNghi}</span>`).join('') :
                    '<i>Chưa có tiện nghi</i>';
                html += `<tr class="phong-row cursor-pointer" data-id="${x.IDPhong}">
					<td>${x.IDPhong}</td>
					<td>${x.SoPhong}</td>
					<td>${x.TenLoaiPhong || ''}</td>
					<td>${x.TrangThai || ''}</td>
					<td>${amenitiesHtml}</td>
				</tr>`;
            });
        }
        $('#tablePhong tbody').html(html);

        // Click badge tiện nghi để lọc nhanh
        $('.amenity-filter-chip').on('click', function(e) {
            e.stopPropagation();
            ROOM_FILTER_AMENITY = $(this).data('name');
            renderRoomFilterChips();
            renderPhongTable(PHONG_TABLE);
        });

        // Click dòng phòng -> đồng bộ chọn dropdown gán
        $('.phong-row').on('click', async function() {
            const pid = $(this).data('id');
            const phong = PHONG_TABLE.find(x => String(x.IDPhong) === String(pid));
            if (!phong) return showAlert('danger', 'Không tìm thấy phòng');
            // Chuyển sang tab quản lý để gán nhanh
            const tabTrigger = document.querySelector('#tab-manage-tab');
            tabTrigger && new bootstrap.Tab(tabTrigger).show();
            $('#selectLoaiPhongAssign').val(phong.IDLoaiPhong);
            await refreshAssignPhongDropdown();
            $('#selectPhong').val(phong.IDPhong).trigger('change');
        });
    }

    $(document).ready(async function() {
        await loadLoaiPhong();
        await loadPhongs();
        await loadTienNghi();
        await loadPhongTable();

        // Debounced searches
        $('#searchTienNghi').on('input', debounce(function() {
            renderTienNghiTable(ALL_TIEN_NGHI);
        }, 200));
        $('#searchPhong').on('input', debounce(function() {
            renderPhongTable(PHONG_TABLE);
        }, 200));
        $('#filterCheckbox').on('input', debounce(function() {
            renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
        }, 200));

        // Clear search buttons
        $('#clearSearchTienNghi').on('click', function() {
            $('#searchTienNghi').val('');
            renderTienNghiTable(ALL_TIEN_NGHI);
        });
        $('#clearSearchPhong').on('click', function() {
            $('#searchPhong').val('');
            renderPhongTable(PHONG_TABLE);
        });

        // Lọc nhanh tiện nghi
        $('.filter-tn').on('click', function() {
            $('.filter-tn').removeClass('active');
            $(this).addClass('active');
            AMENITY_FILTER_MODE = $(this).data('filter');
            renderTienNghiTable(ALL_TIEN_NGHI);
        });

        // Sắp xếp tiện nghi
        $('.sort-tn').on('click', function() {
            const key = $(this).data('key');
            SORT_STATE.tn.dir = (SORT_STATE.tn.key === key && SORT_STATE.tn.dir === 'asc') ? 'desc' : 'asc';
            SORT_STATE.tn.key = key;
            renderTienNghiTable(ALL_TIEN_NGHI);
        });

        // Checkbox changes
        $('#checkboxTienNghiList').on('change', '.chk-tiennghi', function() {
            const id = String($(this).val());
            if (this.checked) {
                if (!SELECTED_TN_IDS.includes(id)) SELECTED_TN_IDS.push(id);
            } else {
                SELECTED_TN_IDS = SELECTED_TN_IDS.filter(x => x !== id);
            }
            $('#selectedCount').text(SELECTED_TN_IDS.length);
        });

        // Bulk select/clear current filtered checkboxes
        $('#btnSelectAll').on('click', function() {
            const search = vnNormalize($('#filterCheckbox').val() || '');
            const filteredIds = ALL_TIEN_NGHI.filter(x => vnNormalize(x.TenTienNghi).includes(search)).map(x => String(x.IDTienNghi));
            filteredIds.forEach(id => {
                if (!SELECTED_TN_IDS.includes(id)) SELECTED_TN_IDS.push(id);
            });
            renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
        });
        $('#btnClearAll').on('click', function() {
            const search = vnNormalize($('#filterCheckbox').val() || '');
            const filteredIds = new Set(ALL_TIEN_NGHI.filter(x => vnNormalize(x.TenTienNghi).includes(search)).map(x => String(x.IDTienNghi)));
            SELECTED_TN_IDS = SELECTED_TN_IDS.filter(id => !filteredIds.has(id));
            renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
        });

        // Thay đổi loại phòng
        $('#selectLoaiPhongAssign').on('change', async function() {
            await refreshAssignPhongDropdown();
        });

        // Mở modal thêm tiện nghi
        $('#btnOpenCreate').off('click').on('click', function() {
            $('#tnId').val('');
            $('#TenTienNghi').val('');
            $('#modalTitle').text('Thêm tiện nghi');
            const modalEl = document.getElementById('modalCreateEdit');
            const instance = new bootstrap.Modal(modalEl);
            modalEl.addEventListener('shown.bs.modal', () => {
                $('#TenTienNghi').trigger('focus');
            }, {
                once: true
            });
            instance.show();
        });

        // Lưu tiện nghi
        $('#btnSubmitCreateEdit').off('click').on('click', async function() {
            const id = $('#tnId').val();
            const name = ($('#TenTienNghi').val() || '').trim();
            if (!name) return showAlert('warning', 'Vui lòng nhập Tên tiện nghi');

            let url = `${API_BASE}/tien-nghi`,
                method = 'POST';
            if (id) {
                url = `${API_BASE}/tien-nghi/${id}`;
                method = 'PUT';
            }

            try {
                const json = await apiFetch(url, {
                    method,
                    body: {
                        TenTienNghi: name
                    }
                });
                if (!json || json.success !== true) throw new Error(json?.message || 'API trả về không hợp lệ.');
                showAlert('success', id ? 'Đã cập nhật tiện nghi' : 'Đã tạo tiện nghi');
                await loadTienNghi();
                await loadPhongTable();
                const instance = bootstrap.Modal.getInstance(document.getElementById('modalCreateEdit'));
                if (instance) instance.hide();
            } catch (e) {
                showAlert('danger', e.message || 'Có lỗi xảy ra khi lưu tiện nghi.');
                console.error(e);
            }
        });

        // Xóa tiện nghi
        $('#btnConfirmDelete').off('click').on('click', async function() {
            const id = $('#deleteId').val();
            const modalEl = document.getElementById('modalDelete');
            try {
                const json = await apiFetch(`${API_BASE}/tien-nghi/${id}`, {
                    method: 'DELETE'
                });
                if (!json || json.success !== true) throw new Error(json?.message || 'Không thể xóa');
                showAlert('success', 'Đã xóa tiện nghi');
                await loadTienNghi();
                await loadPhongTable();
            } catch (e) {
                // If API returned an informative message (e.g., "Không thể gán tiện nghi..."), show it
                showAlert('danger', e.message || 'Không thể xóa');
                console.error(e);
            } finally {
                // Always hide the modal after the attempt (so user doesn't have to click Hủy)
                const instance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                try { instance.hide(); } catch (ignore) {}
            }
        });

        // Chọn phòng -> nạp tiện nghi đã gán
        $('#selectPhong').on('change', async function() {
            const pid = $(this).val();
            if (!pid) {
                SELECTED_TN_IDS = [];
                renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
                renderCurrentAssigned([]);
                return;
            }
            const ids = await fetchAssignedIds(pid);
            SELECTED_TN_IDS = ids;
            renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
            renderCurrentAssigned(
                ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(String(x.IDTienNghi))).map(x => x.TenTienNghi)
            );
        });

        $('#btnSaveAssign').off('click').on('click', async function() {
            const pid = $('#selectPhong').val();
            const lid = $('#selectLoaiPhongAssign').val();
            const applyAll = $('#applyAllInType').is(':checked');

            const $btn = $(this);
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Đang lưu...');
            toggleAssignOverlay(true);

            try {
                    if (applyAll) {
                    if (!lid) {
                        showAlert('warning', 'Hãy chọn loại phòng trước khi áp dụng cho tất cả phòng.');
                        return;
                    }
                    const rooms = PHONG_TABLE.filter(x => String(x.IDLoaiPhong) === String(lid)).map(r => String(r.IDPhong));
                    if (rooms.length === 0) {
                        showAlert('warning', 'Không có phòng nào trong loại đã chọn.');
                        return;
                    }
                    let ok = 0, fail = 0;
                    const errors = [];
                    for (const rid of rooms) {
                        const res = await syncPhongTienNghi(rid, SELECTED_TN_IDS);
                        if (res && res.success === true) {
                            ok++;
                        } else {
                            fail++;
                            const msg = (res && res.message) ? String(res.message) : `Lỗi khi áp dụng cho phòng ${rid}`;
                            errors.push({ room: rid, message: msg });
                        }
                    }
                    if (fail === 0) {
                        showAlert('success', `Đã áp dụng cho ${ok}/${rooms.length} phòng.`);
                    } else {
                        // show summary and up to first 3 error messages so user knows why some rooms failed
                        const sample = errors.slice(0, 3).map(e => `${e.room}: ${e.message}`).join('; ');
                        const more = errors.length > 3 ? ` và ${errors.length - 3} lỗi khác` : '';
                        showAlert('warning', `Đã áp dụng cho ${ok}/${rooms.length} phòng. ${fail} thất bại. Lỗi: ${sample}${more}`);
                        console.warn('Bulk assign errors', errors);
                    }
                } else {
                    if (!pid) {
                        showAlert('warning', 'Hãy chọn phòng trước khi lưu.');
                        return;
                    }
                    const json = await syncPhongTienNghi(pid, SELECTED_TN_IDS);
                    if (!json || json.success !== true) throw new Error(json?.message || 'Không thể lưu gán tiện nghi.');
                    showAlert('success', 'Đã lưu gán tiện nghi cho phòng.');
                    ASSIGNED_ORIG_IDS = [...SELECTED_TN_IDS];
                    setDirty(false);
                }
                await loadPhongTable();

                // Reset về trạng thái mặc định sau khi lưu thành công
                await resetAssignSection();
            } catch (e) {
                showAlert('danger', e.message || 'Không thể lưu gán tiện nghi.');
                console.error(e);
            } finally {
                toggleAssignOverlay(false);
                $btn.prop('disabled', false).text('Lưu gán tiện nghi');
                refreshSaveButtonState();
            }
        });

        // Khi vào tab rooms, cập nhật chips
        document.getElementById('tab-rooms-tab')?.addEventListener('shown.bs.tab', () => {
            renderRoomFilterChips();
        });

        // cập nhật info và trạng thái lưu khi đổi loại/phòng
        $('#selectLoaiPhongAssign').on('change', async function() {
            await refreshAssignPhongDropdown();
            updateAssignInfo();
            setDirty(false); // đổi loại phòng -> reset dirty
        });

        $('#selectPhong').on('change', async function() {
            const pid = $(this).val();
            updateAssignInfo();
            refreshSaveButtonState();
            if (!pid) {
                SELECTED_TN_IDS = [];
                renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
                renderCurrentAssigned([]);
                ASSIGNED_ORIG_IDS = [];
                setDirty(false);
                return;
            }
            try {
                toggleAssignOverlay(true);
                const ids = await fetchAssignedIds(pid);
                SELECTED_TN_IDS = ids;
                ASSIGNED_ORIG_IDS = [...ids];
                renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
                const items = ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(String(x.IDTienNghi)))
                    .map(x => ({
                        id: String(x.IDTienNghi),
                        name: x.TenTienNghi
                    }));
                renderCurrentAssigned(items);
                setDirty(false);
            } finally {
                toggleAssignOverlay(false);
            }
        });

        // đảo chọn theo danh sách đang lọc
        $('#btnInvert').on('click', function() {
            const search = vnNormalize($('#filterCheckbox').val() || '');
            const filteredIds = new Set(
                ALL_TIEN_NGHI.filter(x => vnNormalize(x.TenTienNghi).includes(search)).map(x => String(x.IDTienNghi))
            );
            const next = new Set(SELECTED_TN_IDS);
            [...filteredIds].forEach(id => {
                if (next.has(id)) next.delete(id);
                else next.add(id);
            });
            SELECTED_TN_IDS = [...next];
            renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
            const items = ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(String(x.IDTienNghi)))
                .map(x => ({
                    id: String(x.IDTienNghi),
                    name: x.TenTienNghi
                }));
            renderCurrentAssigned(items);
            setDirty(!areArraysEqual(SELECTED_TN_IDS, ASSIGNED_ORIG_IDS));
        });

        // Bật/tắt lưu khi đổi chế độ áp dụng
        $('#applyAllInType').on('change', function() {
            refreshSaveButtonState();
        });

        // checkbox thay đổi -> cập nhật chip + dirty + button state
        $('#checkboxTienNghiList').on('change', '.chk-tiennghi', function() {
            const id = String($(this).val());
            if (this.checked) {
                if (!SELECTED_TN_IDS.includes(id)) SELECTED_TN_IDS.push(id);
            } else {
                SELECTED_TN_IDS = SELECTED_TN_IDS.filter(x => x !== id);
            }
            $('#selectedCount').text(SELECTED_TN_IDS.length);
            const items = ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(String(x.IDTienNghi)))
                .map(x => ({
                    id: String(x.IDTienNghi),
                    name: x.TenTienNghi
                }));
            renderCurrentAssigned(items);
            setDirty(!areArraysEqual(SELECTED_TN_IDS, ASSIGNED_ORIG_IDS));
        });

        // bulk select/clear -> cập nhật chip + dirty
        $('#btnSelectAll').on('click', function() {
            const search = vnNormalize($('#filterCheckbox').val() || '');
            const filteredIds = ALL_TIEN_NGHI.filter(x => vnNormalize(x.TenTienNghi).includes(search)).map(x => String(x.IDTienNghi));
            filteredIds.forEach(id => {
                if (!SELECTED_TN_IDS.includes(id)) SELECTED_TN_IDS.push(id);
            });
            renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
            const items = ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(String(x.IDTienNghi)))
                .map(x => ({
                    id: String(x.IDTienNghi),
                    name: x.TenTienNghi
                }));
            renderCurrentAssigned(items);
            setDirty(!areArraysEqual(SELECTED_TN_IDS, ASSIGNED_ORIG_IDS));
        });
        $('#btnClearAll').on('click', function() {
            const search = vnNormalize($('#filterCheckbox').val() || '');
            const filteredIds = new Set(ALL_TIEN_NGHI.filter(x => vnNormalize(x.TenTienNghi).includes(search)).map(x => String(x.IDTienNghi)));
            SELECTED_TN_IDS = SELECTED_TN_IDS.filter(id => !filteredIds.has(id));
            renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
            const items = ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(String(x.IDTienNghi)))
                .map(x => ({
                    id: String(x.IDTienNghi),
                    name: x.TenTienNghi
                }));
            renderCurrentAssigned(items);
            setDirty(!areArraysEqual(SELECTED_TN_IDS, ASSIGNED_ORIG_IDS));
        });

        // bật/tắt lưu khi đổi chế độ áp dụng
        $('#applyAllInType').on('change', function() {
            refreshSaveButtonState();
        });

        // Lưu gán tiện nghi -> đồng bộ dirty, overlay
        $('#btnSaveAssign').off('click').on('click', async function() {
            const pid = $('#selectPhong').val();
            const lid = $('#selectLoaiPhongAssign').val();
            const applyAll = $('#applyAllInType').is(':checked');

            const $btn = $(this);
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Đang lưu...');
            toggleAssignOverlay(true);

            try {
                if (applyAll) {
                    if (!lid) {
                        showAlert('warning', 'Hãy chọn loại phòng trước khi áp dụng cho tất cả phòng.');
                        return;
                    }
                    const rooms = PHONG_TABLE.filter(x => String(x.IDLoaiPhong) === String(lid)).map(r => String(r.IDPhong));
                    if (rooms.length === 0) {
                        showAlert('warning', 'Không có phòng nào trong loại đã chọn.');
                        return;
                    }
                    let ok = 0,
                        fail = 0;
                    for (const rid of rooms) {
                        const res = await syncPhongTienNghi(rid, SELECTED_TN_IDS);
                        (res && res.success === true) ? ok++ : fail++;
                    }
                    showAlert(fail === 0 ? 'success' : 'warning', `Đã áp dụng cho ${ok}/${rooms.length} phòng.`);
                } else {
                    if (!pid) {
                        showAlert('warning', 'Hãy chọn phòng trước khi lưu.');
                        return;
                    }
                    const json = await syncPhongTienNghi(pid, SELECTED_TN_IDS);
                    if (!json || json.success !== true) throw new Error(json?.message || 'Không thể lưu gán tiện nghi.');
                    showAlert('success', 'Đã lưu gán tiện nghi cho phòng.');
                    ASSIGNED_ORIG_IDS = [...SELECTED_TN_IDS];
                    setDirty(false);
                }
                await loadPhongTable();

                // Reset UI về mặc định sau khi lưu thành công
                await resetAssignSection();
            } catch (e) {
                showAlert('danger', e.message || 'Không thể lưu gán tiện nghi.');
                console.error(e);
            } finally {
                toggleAssignOverlay(false);
                $btn.prop('disabled', false).text('Lưu gán tiện nghi');
                refreshSaveButtonState();
            }
        });
    });

    // State quản lý khu vực gán
    let ASSIGNED_ORIG_IDS = [];
    let ASSIGN_DIRTY = false;

    function areArraysEqual(a = [], b = []) {
        if (a.length !== b.length) return false;
        const sa = [...a].sort();
        const sb = [...b].sort();
        return sa.every((v, i) => v === sb[i]);
    }

    function toggleAssignOverlay(show) {
        $('#assignOverlay').toggleClass('d-none', !show);
    }

    function setDirty(flag) {
        ASSIGN_DIRTY = !!flag;
        $('#unsavedBadge').toggleClass('d-none', !ASSIGN_DIRTY);
        refreshSaveButtonState();
    }

    function updateAssignInfo() {
        const lid = $('#selectLoaiPhongAssign').val();
        const pid = $('#selectPhong').val();
        const tenLoai = lid ? (ALL_LOAI_PHONG.find(l => String(l.IDLoaiPhong) === String(lid))?.TenLoaiPhong || '') : '';
        const soPhong = pid ? (PHONG_TABLE.find(p => String(p.IDPhong) === String(pid))?.SoPhong || '') : '';
        if (!lid && !pid) {
            $('#assignSelectionInfo').html('<i class="bi bi-info-circle me-1"></i> Chưa chọn loại phòng/phòng.');
        } else if (lid && !pid) {
            $('#assignSelectionInfo').html(`<i class="bi bi-building me-1"></i> Loại phòng: <b>${tenLoai}</b>`);
        } else {
            $('#assignSelectionInfo').html(`<i class="bi bi-door-closed me-1"></i> Loại: <b>${tenLoai}</b> • Phòng: <b>${soPhong}</b>`);
        }
    }

    function refreshSaveButtonState() {
        const applyAll = $('#applyAllInType').is(':checked');
        const lid = $('#selectLoaiPhongAssign').val();
        const pid = $('#selectPhong').val();
        let can = false;
        if (applyAll) {
            can = !!lid; // cho phép lưu khi áp dụng toàn loại và đã chọn loại
        } else {
            can = !!pid && ASSIGN_DIRTY; // với phòng đơn, cần chọn phòng và có thay đổi
        }
        $('#btnSaveAssign').prop('disabled', !can);
        // cũng làm mờ danh sách khi không chọn phòng (chỉ khi không áp dụng toàn loại)
        const disableList = !applyAll && !pid;
        $('#checkboxTienNghiList').toggleClass('disabled', disableList);
    }

    // Reset khu vực gán về mặc định (không chọn gì)
    async function resetAssignSection() {
        $('#selectLoaiPhongAssign').val('');
        await refreshAssignPhongDropdown();
        $('#applyAllInType').prop('checked', false).prop('disabled', true);
        $('#filterCheckbox').val(''); // clear search trong danh sách checkbox
        SELECTED_TN_IDS = [];
        ASSIGNED_ORIG_IDS = [];
        renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
        renderCurrentAssigned([]);
        updateAssignInfo();
        setDirty(false);
        refreshSaveButtonState();
    }

    // Render danh sách tiện nghi đang gán (chip removable)
    function renderCurrentAssigned(items) {
        const container = $('#currentAssigned');
        container.empty();
        if (!items || items.length === 0) {
            container.html('<i>Chưa có tiện nghi nào được gán</i>');
            return;
        }
        items.forEach(it => {
            container.append(
                `<span class="amenity-chip" data-id="${it.id}">
					${it.name}
					<a class="remove text-white-50" data-id="${it.id}" title="Bỏ tiện nghi">×</a>
				</span>`
            );
        });

        // remove chip -> bỏ chọn tương ứng
        container.off('click', '.remove').on('click', '.remove', function(e) {
            e.preventDefault();
            const id = String($(this).data('id'));
            SELECTED_TN_IDS = SELECTED_TN_IDS.filter(x => x !== id);
            // bỏ tick checkbox nếu có
            $(`#chk-${id}`).prop('checked', false);
            $('#selectedCount').text(SELECTED_TN_IDS.length);
            // cập nhật chip
            const itemsNow = ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(String(x.IDTienNghi)))
                .map(x => ({
                    id: String(x.IDTienNghi),
                    name: x.TenTienNghi
                }));
            renderCurrentAssigned(itemsNow);
            setDirty(!areArraysEqual(SELECTED_TN_IDS, ASSIGNED_ORIG_IDS));
        });
    }
</script>
@endsection
