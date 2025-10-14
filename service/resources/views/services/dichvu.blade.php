@extends('layouts.layout2')

@section('title', 'Quản lý Dịch vụ')

@section('content')
<div class="container-fluid py-3">
    {{-- Alert area --}}
    <div id="alertArea"></div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-concierge-bell me-2"></i>Danh sách dịch vụ
                            <span class="badge bg-secondary ms-2" id="dichvuCount">0</span>
                        </h5>
                        <button id="btnOpenCreateDichVu" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-1"></i> Thêm dịch vụ
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchDichVu" class="form-control" placeholder="Tìm dịch vụ theo tên...">
                        <button class="btn btn-outline-secondary" id="clearSearchDichVu" title="Xóa tìm kiếm">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <!-- NEW: Sort controls -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted small mb-0" for="sortOption">Sắp xếp:</label>
                            <select id="sortOption" class="form-select form-select-sm" style="max-width: 280px;">
                                <option value="updated_desc">Ngày cập nhật - Mới nhất</option>
                                <option value="updated_asc">Ngày cập nhật - Cũ nhất</option>
                                <option value="id_asc">ID tăng dần</option>
                                <option value="id_desc">ID giảm dần</option>
                                <option value="name_asc">Tên A → Z</option>
                                <option value="name_desc">Tên Z → A</option>
                            </select>
                        </div>
                        <!-- Active sorting indicator -->
                        <span id="sortActivePill" class="badge bg-light text-secondary border d-flex align-items-center gap-1 px-2 py-1">
                            <i class="bi bi-sort-down"></i>
                            <span>Ngày cập nhật - Mới nhất</span>
                        </span>
                    </div>
                    <!-- END Sort controls -->

                    <div class="position-relative" id="dichvuTableWrap">
                        <table class="table table-hover align-middle m-0" id="tableDichVu">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Dịch Vụ</th>
                                    <th>Giá (VND)</th>
                                    <th class="text-end">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- JS will render rows here --}}
                            </tbody>
                        </table>
                        <div class="table-overlay d-none" id="dichvuOverlay">
                            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card" id="chitietPanel">
                <div class="card-header">
                     <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" id="chitietPanelTitle">Chi tiết dịch vụ</h5>
                        <button id="btnOpenCreateChiTiet" class="btn btn-success btn-sm d-none">
                            <i class="bi bi-plus-lg me-1"></i> Thêm chi tiết
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chitietPlaceholder" class="text-center text-muted py-5">
                        <i class="bi bi-card-list fs-2"></i>
                        <p class="mt-2">Chọn một dịch vụ từ danh sách bên trái để quản lý chi tiết.</p>
                    </div>
                    <div id="chitietContent" class="d-none">
                        <div class="position-relative" id="chitietTableWrap">
                            <table class="table table-striped table-hover align-middle m-0" id="tableChiTiet">
                                <thead class="table-light">
                                    <tr>
                                        <th>Thông tin chi tiết</th>
                                        <th class="text-end">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- JS will render rows here --}}
                                </tbody>
                            </table>
                             <div class="table-overlay d-none" id="chitietOverlay">
                                <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                            </div>
                        </div>

                        <div id="dichvuImageContainer" class="mt-4 d-none">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                 <h6 class="mb-0">Hình ảnh đại diện</h6>
                                 <button id="btnEditImage" class="btn btn-outline-secondary btn-sm d-none"><i class="bi bi-pencil me-1"></i>Thay đổi</button>
                            </div>
                            <div class="text-center">
                                <img src="" id="dichvuImagePreview" class="img-fluid rounded border p-1 d-none" alt="Hình ảnh dịch vụ">
                                <div id="dichvuImagePlaceholder" class="text-muted fst-italic mt-2 py-3 d-none">
                                    <i class="bi bi-image fs-3"></i>
                                    <p class="mb-2">Dịch vụ này chưa có hình ảnh.</p>
                                    <button id="btnAddImage" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Thêm hình ảnh</button>
                                </div>

                                <!-- Inline avatar edit form: URL or upload only (no name/price) -->
                                <div id="imageEditForm" class="mt-3 d-none text-start">
                                    <div class="mb-2">
                                        <label for="imageUrlInput" class="form-label mb-1">URL hình ảnh</label>
                                        <input type="text" id="imageUrlInput" class="form-control" placeholder="Dán URL hình ảnh vào đây">
                                    </div>
                                    <div class="mb-2">
                                        <label for="imageFileInput" class="form-label mb-1">Hoặc tải tệp từ thiết bị</label>
                                        <input type="file" id="imageFileInput" class="form-control" accept="image/*" />
                                    </div>
                                    <div class="text-end mt-3">
                                        <button type="button" id="btnCancelImageEdit" class="btn btn-outline-secondary btn-sm me-2">Hủy</button>
                                        <button type="button" id="btnSaveNewImage" class="btn btn-primary btn-sm">Lưu hình ảnh mới</button>
                                    </div>
                                </div>
                                <!-- End inline avatar edit form -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDichVu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formDichVu" onsubmit="return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDichVuTitle">Thêm Dịch Vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="dvId" />
                    <div class="mb-3">
                        <label for="TenDichVu" class="form-label">Tên Dịch Vụ</label>
                        <input type="text" id="TenDichVu" class="form-control" placeholder="VD: Giặt ủi, Spa, Thuê xe..." required />
                    </div>
                    <div class="mb-3">
                        <label for="TienDichVu" class="form-label">Tiền Dịch Vụ (VND)</label>
                        <input type="number" id="TienDichVu" class="form-control" placeholder="VD: 50000" min="0" required />
                    </div>
                     <div class="mb-3">
                        <label for="HinhDichVu" class="form-label">Hình ảnh (URL)</label>
                        <input type="text" id="HinhDichVu" class="form-control" placeholder="Để trống hoặc dán URL vào đây" />
                        <div class="form-text">Hoặc tải file hình ảnh bên dưới</div>
                        <input type="file" id="HinhDichVuFile" class="form-control mt-2" accept="image/*" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="btnSubmitDichVu">Lưu</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalDeleteDichVu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xóa Dịch Vụ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn chắc chắn muốn xóa dịch vụ: <strong id="deleteDichVuName"></strong>?</p>
                <input type="hidden" id="deleteDichVuId" />
                <div class="small text-danger">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    Lưu ý: Mọi thông tin chi tiết liên quan đến dịch vụ này cũng sẽ bị xóa.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDeleteDichVu">Xóa</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalChiTiet" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formChiTiet" onsubmit="return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalChiTietTitle">Thêm Chi Tiết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ctId" />
                    <!-- NEW: show which service you are adding/editing detail for -->
                    <div class="small text-muted mb-2" id="ctForServiceInfo"></div>
                    <div class="mb-3">
                        <label for="ThongTinDV" class="form-label">Thông tin chi tiết</label>
                        <textarea id="ThongTinDV" class="form-control" rows="3" placeholder="VD: Gói giặt ủi bao gồm 5kg quần áo..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="btnSubmitChiTiet">Lưu</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalDeleteChiTiet" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xóa Chi Tiết Dịch Vụ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn chắc chắn muốn xóa chi tiết này?</p>
                <blockquote class="blockquote-footer" id="deleteChiTietName"></blockquote>
                <input type="hidden" id="deleteChiTietId" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDeleteChiTiet">Xóa</button>
            </div>
        </div>
    </div>
</div>

<style>
    #tableDichVu tbody tr {
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    #tableDichVu tbody tr.table-active,
    #tableDichVu tbody tr:hover {
        background-color: #e0e7ff;
    }
    .table-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, .7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        border-radius: .375rem;
    }
    .empty-state {
        text-align: center;
        color: #6c757d;
    }
    #dichvuImagePreview, #imagePreview {
        max-height: 250px;
        width: auto;
        object-fit: cover;
    }
    .table-img-thumb {
        width: 60px;
        height: 40px;
        object-fit: cover;
        border-radius: .25rem;
    }
    /* NEW: minor polish for sort controls */
    #sortOption:hover { box-shadow: 0 0 0 .05rem rgba(13,110,253,.25); }
    #sortActivePill { user-select: none; }
    #sortActivePill .bi { font-size: .95rem; }
</style>
@endsection

@section('scripts')
<script>
    const API_BASE = '/api/dichvu';
    let ALL_DICHVU = [];
    let CURRENT_CHITIET = [];
    let SELECTED_DICHVU_ID = null;
    let MODAL_DICHVU, MODAL_DELETE_DICHVU, MODAL_CHITIET, MODAL_DELETE_CHITIET;
    // NEW: current sort option + storage key
    let SORT_OPTION = 'updated_desc';
    const SORT_STORAGE_KEY = 'dv_sort_option';

    // --- UTILITY FUNCTIONS ---
    function debounce(fn, wait = 300) {
        let t;
        return (...args) => {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    function vnNormalize(str = '') {
        return String(str).toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function toggleOverlay(target, show) {
        $(`#${target}Overlay`).toggleClass('d-none', !show);
    }

    function formatCurrency(num) {
        return new Intl.NumberFormat('vi-VN').format(num || 0);
    }

    function showAlert(type, message, duration = 4000) {
        const alert = $(`<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`);
        $('#alertArea').empty().append(alert);
        setTimeout(() => alert.alert('close'), duration);
    }

    async function apiFetch(url, options = {}) {
        const defaultHeaders = {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        };
        const isFormData = (options.body instanceof FormData);
        const headers = isFormData ? defaultHeaders : { ...defaultHeaders, 'Content-Type': 'application/json' };

        const mergedOptions = { ...options, headers };
        if (options.body && !isFormData && typeof options.body !== 'string') {
            mergedOptions.body = JSON.stringify(options.body);
        }

        try {
            const response = await fetch(url, mergedOptions);
            if (response.status === 204) return { success: true, data: null };
            const json = await response.json();
            if (!response.ok) throw new Error(json.message || `Lỗi ${response.status}`);
            return json;
        } catch (error) {
            console.error('API Fetch Error:', error);
            showAlert('danger', error.message || 'Có lỗi xảy ra khi gọi API.');
            return { success: false, message: error.message };
        }
    }

    // Helpers for avatar edit form
    function toggleImageEdit(show) {
        $('#imageEditForm').toggleClass('d-none', !show);
    }
    function resetImageEditForm() {
        $('#imageUrlInput').val('');
        $('#imageFileInput').val(null);
    }

    function isExternalUrl(u) {
        return /^https?:\/\//i.test(u || '');
    }
    // NEW: safely append cache-busting param to any URL (handles existing query)
    function addCacheBuster(url) {
        if (!url) return '';
        const sep = url.includes('?') ? '&' : '?';
        return `${url}${sep}t=${Date.now()}`;
    }
    function buildImageSrc(path) {
        if (!path) return '';
        let base = isExternalUrl(path) ? String(path) : '/' + String(path).replace(/^\/+/, '');
        return addCacheBuster(base);
    }

    // NEW: helpers for sorting
    function getDvIdNumber(dv) {
        const m = String(dv?.IDDichVu || '').match(/\d+/);
        return m ? parseInt(m[0], 10) : 0;
    }
    function getUpdateDate(dv) {
        const d = dv?.updated_at || dv?.created_at || null;
        return d ? new Date(d).getTime() : 0;
    }
    function sortDichVu(list) {
        const arr = list.slice();
        switch (SORT_OPTION) {
            case 'id_asc':
                arr.sort((a,b) => getDvIdNumber(a) - getDvIdNumber(b)); break;
            case 'id_desc':
                arr.sort((a,b) => getDvIdNumber(b) - getDvIdNumber(a)); break;
            case 'name_asc':
                arr.sort((a,b) => vnNormalize(a.TenDichVu).localeCompare(vnNormalize(b.TenDichVu))); break;
            case 'name_desc':
                arr.sort((a,b) => vnNormalize(b.TenDichVu).localeCompare(vnNormalize(a.TenDichVu))); break;
            case 'updated_asc':
                arr.sort((a,b) => getUpdateDate(a) - getUpdateDate(b)); break;
            case 'updated_desc':
            default:
                arr.sort((a,b) => getUpdateDate(b) - getUpdateDate(a)); break;
        }
        return arr;
    }

    // NEW: map sort option to label + icon
    function sortLabelAndIcon(opt) {
        switch (opt) {
            case 'updated_desc': return { label: 'Ngày cập nhật - Mới nhất', icon: 'bi-clock-history' };
            case 'updated_asc':  return { label: 'Ngày cập nhật - Cũ nhất',  icon: 'bi-clock' };
            case 'id_asc':       return { label: 'ID tăng dần',               icon: 'bi-sort-numeric-down' };
            case 'id_desc':      return { label: 'ID giảm dần',               icon: 'bi-sort-numeric-up' };
            case 'name_asc':     return { label: 'Tên A → Z',                  icon: 'bi-sort-alpha-down' };
            case 'name_desc':    return { label: 'Tên Z → A',                  icon: 'bi-sort-alpha-up' };
            default:             return { label: 'Ngày cập nhật - Mới nhất', icon: 'bi-clock-history' };
        }
    }
    function updateSortIndicator() {
        const pill = document.getElementById('sortActivePill');
        if (!pill) return;
        const iconEl = pill.querySelector('i');
        const textEl = pill.querySelector('span:last-child');
        const { label, icon } = sortLabelAndIcon(SORT_OPTION);
        if (iconEl) {
            iconEl.className = `bi ${icon}`;
        }
        if (textEl) {
            textEl.textContent = label;
        }
    }

    // --- DICHVU (SERVICE) FUNCTIONS ---
    async function loadDichVu() {
        toggleOverlay('dichvu', true);
        const res = await apiFetch(API_BASE);
        if (res.success) {
            ALL_DICHVU = res.data || [];
            renderDichVuTable();
        }
        toggleOverlay('dichvu', false);
    }

    function renderDichVuTable() {
        const searchTerm = vnNormalize($('#searchDichVu').val());
        let filtered = ALL_DICHVU.filter(dv => vnNormalize(dv.TenDichVu).includes(searchTerm));
        filtered = sortDichVu(filtered); // apply sorting

        const tbody = $('#tableDichVu tbody');
        tbody.empty();
        $('#dichvuCount').text(filtered.length);

        if (filtered.length === 0) {
            tbody.html(`<tr><td colspan="4" class="empty-state py-4"><i class="bi bi-inbox me-1"></i> Không có dịch vụ nào</td></tr>`);
            return;
        }

        filtered.forEach(dv => {
            const tr = $(`
                <tr class="dichvu-row" data-id="${dv.IDDichVu}">
                    <td>${dv.IDDichVu}</td>
                    <td>${dv.TenDichVu}</td>
                    <td>${formatCurrency(dv.TienDichVu)}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary btn-edit-dv me-1" title="Sửa"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger btn-delete-dv" title="Xóa"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `).data('dichvu', dv);
            tbody.append(tr);
        });

        if (SELECTED_DICHVU_ID) {
            $(`.dichvu-row[data-id="${SELECTED_DICHVU_ID}"]`).addClass('table-active');
        }
    }

    function handleOpenDichVuModal(dichvu = null) {
        $('#formDichVu').trigger('reset');
        if (dichvu) {
            $('#modalDichVuTitle').text('Sửa Dịch Vụ');
            $('#dvId').val(dichvu.IDDichVu);
            $('#TenDichVu').val(dichvu.TenDichVu);
            $('#TienDichVu').val(dichvu.TienDichVu);
            $('#HinhDichVu').val(dichvu.HinhDichVu);

            // Track original values for change detection
            $('#formDichVu').data('original', {
                TenDichVu: dichvu.TenDichVu || '',
                TienDichVu: String(dichvu.TienDichVu ?? ''),
                HinhDichVu: dichvu.HinhDichVu || ''
            });
        } else {
            $('#modalDichVuTitle').text('Thêm Dịch Vụ');
            $('#dvId').val('');
            $('#formDichVu').data('original', null);
        }
        $('#HinhDichVuFile').val(null);
        MODAL_DICHVU.show();
    }

    async function handleSaveDichVu() {
        const form = document.getElementById('formDichVu');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const id = $('#dvId').val();
        const newTen = ($('#TenDichVu').val() || '').trim();
        const newTien = String($('#TienDichVu').val() || '');
        const file = $('#HinhDichVuFile')[0]?.files?.[0] || null;
        const urlVal = ($('#HinhDichVu').val() || '').trim();

        // Change detection only for edit mode
        const original = $('#formDichVu').data('original') || null;
        if (id && original) {
            const changedTen = newTen !== (original.TenDichVu || '');
            const changedTien = newTien !== String(original.TienDichVu || '');
            const changedHinh = !!file || (urlVal !== (original.HinhDichVu || ''));
            if (!changedTen && !changedTien && !changedHinh) {
                showAlert('info', 'No changes detected. Please modify at least one field and try again.');
                return;
            }
        }

        // Build FormData to support file upload
        const fd = new FormData();
        fd.append('TenDichVu', newTen);
        fd.append('TienDichVu', newTien);
        if (id && original) {
            const changedHinh = !!file || (urlVal !== (original.HinhDichVu || ''));
            if (changedHinh) fd.append('HinhDichVu', file ? file : urlVal);
        } else {
            if (file) fd.append('HinhDichVu', file);
            else if (urlVal) fd.append('HinhDichVu', urlVal);
        }

        const reqUrl = id ? `${API_BASE}/${id}` : API_BASE;
        if (id) fd.append('_method', 'PUT');

        const res = await apiFetch(reqUrl, { method: 'POST', body: fd });

        if (res.success) {
            MODAL_DICHVU.hide();

            if (!id) {
                // NEW: No reload — insert new service, select it, open Add Detail
                const newDv = res.data;
                if (newDv && newDv.IDDichVu) {
                    // Update local cache and table
                    const idx = ALL_DICHVU.findIndex(d => d.IDDichVu === newDv.IDDichVu);
                    if (idx >= 0) ALL_DICHVU[idx] = newDv; else ALL_DICHVU.unshift(newDv);
                    renderDichVuTable();

                    // Show details panel for the new service
                    await showChiTietPanel(newDv);

                    // Scroll to the details panel
                    document.getElementById('chitietPanel')?.scrollIntoView({ behavior: 'smooth', block: 'start' });

                    // Open the Add Detail modal and prefill info
                    handleOpenChiTietModal();
                    return; // stop further processing
                }
            }

            // Edit flow (or fallback)
            showAlert('success', res.message || (id ? 'Cập nhật thành công!' : 'Thêm mới thành công!'));
            await loadDichVu();
            if (id && id === SELECTED_DICHVU_ID) {
                const updated = res.data || ALL_DICHVU.find(dv => dv.IDDichVu === id);
                if (updated) await showChiTietPanel(updated);
            }
        }
    }

    function handleOpenDeleteDichVuModal(dichvu) {
        $('#deleteDichVuName').text(dichvu.TenDichVu);
        $('#deleteDichVuId').val(dichvu.IDDichVu);
        MODAL_DELETE_DICHVU.show();
    }

    async function handleConfirmDeleteDichVu() {
        const id = $('#deleteDichVuId').val();
        const res = await apiFetch(`${API_BASE}/${id}`, { method: 'DELETE' });

        if (res.success) {
            showAlert('success', 'Xóa dịch vụ thành công!');
            MODAL_DELETE_DICHVU.hide();
            if (SELECTED_DICHVU_ID === id) {
                resetChiTietPanel();
            }
            await loadDichVu();
        }
    }

    // --- CHITIET (SERVICE DETAIL) FUNCTIONS ---
    function resetChiTietPanel() {
        SELECTED_DICHVU_ID = null;
        CURRENT_CHITIET = [];
        $('#chitietPanelTitle').text('Chi tiết dịch vụ');
        $('#btnOpenCreateChiTiet').addClass('d-none');
        $('#chitietPlaceholder').removeClass('d-none');
        $('#chitietContent').addClass('d-none');
        $('#dichvuImageContainer').addClass('d-none');
        toggleImageEdit(false);
        resetImageEditForm();
        $('.dichvu-row').removeClass('table-active');
    }

    async function showChiTietPanel(dichvu) {
        // NEW: Rehydrate the latest service from cache to avoid stale HinhDichVu
        const _incoming = dichvu;
        if (_incoming && _incoming.IDDichVu) {
            const fresh = ALL_DICHVU.find(d => d.IDDichVu === _incoming.IDDichVu);
            if (fresh) dichvu = fresh;
        }

        SELECTED_DICHVU_ID = dichvu.IDDichVu;
        $('.dichvu-row').removeClass('table-active');
        $(`.dichvu-row[data-id="${SELECTED_DICHVU_ID}"]`).addClass('table-active');

        $('#chitietPanelTitle').html(`Chi tiết cho: <span class="text-primary">${dichvu.TenDichVu}</span>`);
        $('#btnOpenCreateChiTiet').removeClass('d-none');
        $('#chitietPlaceholder').addClass('d-none');
        $('#chitietContent').removeClass('d-none');
        $('#dichvuImageContainer').removeClass('d-none');

        // UPDATED: use helper for right panel preview
        const imgPreview = $('#dichvuImagePreview');
        const imgPlaceholder = $('#dichvuImagePlaceholder');
        const btnEditImage = $('#btnEditImage');

        const hasImg = !!dichvu.HinhDichVu;
        if (hasImg) {
            // always cache-bust on switch
            imgPreview.attr('src', buildImageSrc(dichvu.HinhDichVu)).removeClass('d-none');
            imgPlaceholder.addClass('d-none');
            btnEditImage.removeClass('d-none');
        } else {
            imgPreview.addClass('d-none').attr('src', '');
            imgPlaceholder.removeClass('d-none');
            btnEditImage.addClass('d-none');
        }

        // Ensure the inline editor is hidden/reset when switching services
        toggleImageEdit(false);
        resetImageEditForm();

        toggleOverlay('chitiet', true);
        const res = await apiFetch(`${API_BASE}/${SELECTED_DICHVU_ID}/chitiet`);
        if (res.success) {
            CURRENT_CHITIET = res.data || [];
            renderChiTietTable();
        }
        toggleOverlay('chitiet', false);
    }

    function renderChiTietTable() {
        const tbody = $('#tableChiTiet tbody');
        tbody.empty();

        if (CURRENT_CHITIET.length === 0) {
            tbody.html(`<tr><td colspan="2" class="empty-state py-4"><i class="bi bi-inbox me-1"></i> Chưa có thông tin chi tiết</td></tr>`);
            return;
        }

        CURRENT_CHITIET.forEach(ct => {
            const tr = $(`
                <tr>
                    <td>${ct.ThongTinDV}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary btn-edit-ct me-1" title="Sửa"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger btn-delete-ct" title="Xóa"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `).data('chitiet', ct);
            tbody.append(tr);
        });
    }

    function handleOpenChiTietModal(chitiet = null) {
        $('#formChiTiet').trigger('reset');
        // NEW: Show which service we are working on
        const sel = ALL_DICHVU.find(d => d.IDDichVu === SELECTED_DICHVU_ID);
        const info = sel
            ? `Đang ${chitiet ? 'chỉnh sửa' : 'thêm'} chi tiết cho dịch vụ: ${sel.IDDichVu} - ${sel.TenDichVu}`
            : (SELECTED_DICHVU_ID ? `Đang ${chitiet ? 'chỉnh sửa' : 'thêm'} chi tiết cho dịch vụ: ${SELECTED_DICHVU_ID}` : '');
        $('#ctForServiceInfo').text(info);

        if (chitiet) {
            $('#modalChiTietTitle').text('Sửa Chi Tiết');
            $('#ctId').val(chitiet.IDTTDichVu);
            $('#ThongTinDV').val(chitiet.ThongTinDV);
        } else {
            $('#modalChiTietTitle').text('Thêm Chi Tiết');
            $('#ctId').val('');
        }
        MODAL_CHITIET.show();
    }

    async function handleSaveChiTiet() {
        const form = document.getElementById('formChiTiet');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const id = $('#ctId').val();
        const data = { ThongTinDV: $('#ThongTinDV').val().trim() };

        const url = id
            ? `${API_BASE}/${SELECTED_DICHVU_ID}/chitiet/${id}`
            : `${API_BASE}/${SELECTED_DICHVU_ID}/chitiet`;
        const method = id ? 'PUT' : 'POST';

        const res = await apiFetch(url, { method, body: data });

        if (res.success) {
            showAlert('success', res.message || (id ? 'Cập nhật thành công!' : 'Thêm mới thành công!'));
            MODAL_CHITIET.hide();
            const selectedDichVu = ALL_DICHVU.find(dv => dv.IDDichVu === SELECTED_DICHVU_ID);
            if(selectedDichVu) await showChiTietPanel(selectedDichVu);
        }
    }

    function handleOpenDeleteChiTietModal(chitiet) {
        $('#deleteChiTietName').text(chitiet.ThongTinDV);
        $('#deleteChiTietId').val(chitiet.IDTTDichVu);
        MODAL_DELETE_CHITIET.show();
    }

    async function handleConfirmDeleteChiTiet() {
        const id = $('#deleteChiTietId').val();
        const url = `${API_BASE}/${SELECTED_DICHVU_ID}/chitiet/${id}`;
        const res = await apiFetch(url, { method: 'DELETE' });

        if (res.success) {
            showAlert('success', 'Xóa chi tiết thành công!');
            MODAL_DELETE_CHITIET.hide();
            const selectedDichVu = ALL_DICHVU.find(dv => dv.IDDichVu === SELECTED_DICHVU_ID);
            if(selectedDichVu) await showChiTietPanel(selectedDichVu);
        }
    }

    // Handle "Save New Image" with confirmation; only send URL or file (no name/price)
    async function handleSaveNewImage() {
        if (!SELECTED_DICHVU_ID) return;

        const file = $('#imageFileInput')[0]?.files?.[0] || null;
        const urlVal = ($('#imageUrlInput').val() || '').trim();

        if (!file && !urlVal) {
            showAlert('warning', 'Vui lòng chọn file hoặc nhập URL hình ảnh.');
            return;
        }

        const ok = window.confirm('The old image will be deleted. Are you sure you want to save the new one?');
        if (!ok) return;

        const fd = new FormData();
        if (file) {
            fd.append('HinhDichVu', file);
        } else {
            fd.append('HinhDichVu', urlVal);
        }
        fd.append('_method', 'PUT');

        toggleOverlay('chitiet', true);
        const res = await apiFetch(`${API_BASE}/${SELECTED_DICHVU_ID}`, { method: 'POST', body: fd });
        toggleOverlay('chitiet', false);

        if (res.success) {
            showAlert('success', 'Cập nhật hình ảnh thành công!');
            toggleImageEdit(false);
            resetImageEditForm();

            const updated = res.data;
            if (updated) {
                // Update cache
                const idx = ALL_DICHVU.findIndex(d => d.IDDichVu === SELECTED_DICHVU_ID);
                if (idx >= 0) ALL_DICHVU[idx] = updated;

                // Right preview (cache-bust)
                const newSrc = buildImageSrc(updated.HinhDichVu);
                $('#dichvuImagePreview').attr('src', newSrc).removeClass('d-none');
                $('#dichvuImagePlaceholder').addClass('d-none');
                $('#btnEditImage').removeClass('d-none');

                // NEW: Update the selected table row's data to the latest service
                const $row = $(`.dichvu-row[data-id="${SELECTED_DICHVU_ID}"]`);
                if ($row.length) $row.data('dichvu', updated);
            }
        }
    }

    // --- DOCUMENT READY - EVENT BINDING ---
    $(document).ready(function() {
        MODAL_DICHVU = new bootstrap.Modal(document.getElementById('modalDichVu'));
        MODAL_DELETE_DICHVU = new bootstrap.Modal(document.getElementById('modalDeleteDichVu'));
        MODAL_CHITIET = new bootstrap.Modal(document.getElementById('modalChiTiet'));
        MODAL_DELETE_CHITIET = new bootstrap.Modal(document.getElementById('modalDeleteChiTiet'));

        // NEW: restore sort from localStorage
        const savedSort = localStorage.getItem(SORT_STORAGE_KEY);
        if (savedSort) {
            SORT_OPTION = savedSort;
            $('#sortOption').val(savedSort);
        }
        updateSortIndicator();

        loadDichVu();

        $('#searchDichVu').on('input', debounce(renderDichVuTable, 300));
        $('#clearSearchDichVu').on('click', () => {
            $('#searchDichVu').val('').trigger('input');
        });

        $('#btnOpenCreateDichVu').on('click', () => handleOpenDichVuModal());
        $('#btnSubmitDichVu').on('click', handleSaveDichVu);
        $('#btnConfirmDeleteDichVu').on('click', handleConfirmDeleteDichVu);

        $('#tableDichVu').on('click', '.btn-edit-dv', function(e) {
            e.stopPropagation();
            const dichvu = $(this).closest('tr').data('dichvu');
            handleOpenDichVuModal(dichvu);
        });
        $('#tableDichVu').on('click', '.btn-delete-dv', function(e) {
            e.stopPropagation();
            const dichvu = $(this).closest('tr').data('dichvu');
            handleOpenDeleteDichVuModal(dichvu);
        });
        $('#tableDichVu').on('click', '.dichvu-row', function() {
            const dichvu = $(this).data('dichvu');
            if (SELECTED_DICHVU_ID !== dichvu.IDDichVu) {
                showChiTietPanel(dichvu);
            }
        });

        $('#btnOpenCreateChiTiet').on('click', () => handleOpenChiTietModal());
        $('#btnSubmitChiTiet').on('click', handleSaveChiTiet);
        $('#btnConfirmDeleteChiTiet').on('click', handleConfirmDeleteChiTiet);

        $('#tableChiTiet').on('click', '.btn-edit-ct', function(e) {
            e.stopPropagation();
            const chitiet = $(this).closest('tr').data('chitiet');
            handleOpenChiTietModal(chitiet);
        });
        $('#tableChiTiet').on('click', '.btn-delete-ct', function(e) {
            e.stopPropagation();
            const chitiet = $(this).closest('tr').data('chitiet');
            handleOpenDeleteChiTietModal(chitiet);
        });

        // Open inline avatar editor instead of the full service modal
        $('#btnAddImage, #btnEditImage').on('click', function() {
            if (!SELECTED_DICHVU_ID) return;
            resetImageEditForm();
            toggleImageEdit(true);
        });
        $('#btnCancelImageEdit').on('click', function() {
            resetImageEditForm();
            toggleImageEdit(false);
        });
        $('#btnSaveNewImage').on('click', handleSaveNewImage);

        // UPDATED: bind sort option + persist + update pill
        $('#sortOption').on('change', function() {
            SORT_OPTION = $(this).val() || 'updated_desc';
            localStorage.setItem(SORT_STORAGE_KEY, SORT_OPTION);
            updateSortIndicator();
            renderDichVuTable();
        });
    });
</script>
@endsection
