<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Quản lý Tiện nghi - Adminlite</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <a href="{{ route('tiennghi.index') }}">
                        <img src="{{ asset('assets/images/logo.svg') }}" class="logo" alt="AdminLite" />
                    </a>
                </div>
                <div class="sidebarMenuScroll">
                    <ul class="sidebar-menu">
                        <li class="active current-page">
                            <a href="{{ route('tiennghi.index') }}">
                                <i class="bi bi-box"></i>
                                <span class="menu-text">Tiện nghi</span>
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
                        <h5 class="m-0">Quản lý Tiện nghi</h5>
                    </div>
                    <div class="app-brand-sm d-lg-none d-flex ms-auto">
                        <a href="{{ route('tiennghi.index') }}">
                            <img src="{{ asset('assets/images/logo-sm.svg') }}" class="logo" alt="AdminLite" />
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
                <div class="app-body">
                    <div class="container-fluid">
                        <!-- Alerts -->
                        <div id="alertArea"></div>

                        <div class="row g-4">
                            <!-- CRUD Tiện nghi -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="m-0">Danh sách Tiện nghi</h6>
                                        <button class="btn btn-primary btn-sm" id="btnOpenCreate">
                                            <i class="bi bi-plus-lg me-1"></i> Thêm tiện nghi
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" id="searchTienNghi" class="form-control" placeholder="Tìm theo tên...">
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle" id="tableTienNghi">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 80px;">ID</th>
                                                        <th>Tên tiện nghi</th>
                                                        <th style="width: 140px;" class="text-end">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gán tiện nghi cho Phòng -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="m-0">Gán tiện nghi cho Phòng</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3 align-items-end mb-3">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Chọn loại phòng</label>
                                                <select id="selectLoaiPhongAssign" class="form-select">
                                                    <option value="">-- Chọn loại phòng --</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Chọn phòng</label>
                                                <select id="selectPhong" class="form-select" disabled>
                                                    <option value="">-- Chọn phòng --</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Lọc tiện nghi</label>
                                                <input type="text" id="filterCheckbox" class="form-control" placeholder="Nhập để lọc...">
                                            </div>
                                        </div>
                                        <div class="form-check-box-list border rounded p-3" id="checkboxTienNghiList"></div>

                                        <div class="text-end mt-3">
                                            <button class="btn btn-success" id="btnSaveAssign">
                                                <i class="bi bi-save me-1"></i> Lưu gán tiện nghi
                                            </button>
                                        </div>

                                        <hr>
                                        <div>
                                            <h6 class="mb-2">Tiện nghi đang gán:</h6>
                                            <div id="currentAssigned" class="small text-muted"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Danh sách Phòng (kèm tiện nghi) -->
                        <div class="row g-4 mt-1">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="m-0">Danh sách Phòng</h6>
                                        <!-- <button class="btn btn-primary btn-sm" id="btnOpenCreatePhong">
                        <i class="bi bi-plus-lg me-1"></i> Thêm phòng
                      </button> -->
                                    </div>
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" id="searchPhong" class="form-control" placeholder="Tìm phòng theo số, loại, trạng thái...">
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle" id="tablePhong">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 80px;">ID</th>
                                                        <th>Số phòng</th>
                                                        <th>Loại phòng</th>
                                                        <th>Hạng sao</th>
                                                        <th>Trạng thái</th>
                                                        <th>Tiện nghi</th>
                                                        <th style="width: 160px;" class="text-end">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Create/Edit Tiện nghi -->
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
                                        <div class="small text-muted">Lưu ý: Các gán tiện nghi của phòng sẽ được gỡ tự động.</div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="button" class="btn btn-danger" id="btnConfirmDelete">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Create/Edit Phòng (chỉ giữ 1 bản duy nhất có phần tiện nghi bên trong) -->
                        <div class="modal fade" id="modalCreateEditPhong" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTitlePhong">Thêm phòng</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formCreateEditPhong">
                                            <input type="hidden" id="pId" />
                                            <div class="mb-3">
                                                <label class="form-label">Số phòng</label>
                                                <input type="text" id="pSoPhong" class="form-control" placeholder="Ví dụ: 101" maxlength="20" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Loại phòng</label>
                                                <select id="pIDLoaiPhong" class="form-select" required></select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Hạng sao (1-5)</label>
                                                <input type="number" id="pXepHangSao" class="form-control" min="1" max="5" placeholder="VD: 4">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Trạng thái</label>
                                                <select id="pTrangThai" class="form-select">
                                                    <option value="Trống">Trống</option>
                                                    <option value="Đang sử dụng">Đang sử dụng</option>
                                                    <option value="Bảo trì">Bảo trì</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Mô tả</label>
                                                <textarea id="pMoTa" class="form-control" rows="3" placeholder="Mô tả phòng..."></textarea>
                                            </div>

                                            <!-- Tiện nghi trong modal phòng -->
                                            <div class="mb-3">
                                                <label class="form-label">Tiện nghi</label>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                                    <input type="text" id="pFilterTienNghi" class="form-control" placeholder="Lọc tiện nghi...">
                                                </div>
                                                <div id="pTienNghiList" class="border rounded p-2" style="max-height: 260px; overflow:auto;">
                                                    <!-- checkboxes render bằng JS -->
                                                </div>
                                            </div>
                                            <!-- End Tiện nghi -->
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn btn-primary" id="btnSubmitCreateEditPhong">Lưu</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Confirm Delete Phòng -->
                        <div class="modal fade" id="modalDeletePhong" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Xóa phòng</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Bạn chắc chắn muốn xóa phòng: <strong id="deletePhongName"></strong>?</p>
                                        <input type="hidden" id="deletePhongId" />
                                        <div class="small text-muted">Các gán tiện nghi sẽ được gỡ tự động.</div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="button" class="btn btn-danger" id="btnConfirmDeletePhong">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modals -->
                        <!-- End Modals -->

                    </div>
                </div>
                <!-- Body ends -->

            </div>
            <!-- App container ends -->
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
        // API_BASE ổn định theo domain hiện tại (tránh sai port/host)
        const API_BASE = `${window.location.origin}/api`;
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        // Helper gọi API
        async function apiFetch(url, options = {}) {
            const headers = Object.assign({
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                options.headers || {}
            );

            const opts = Object.assign({
                    credentials: 'same-origin'
                },
                options, {
                    headers
                }
            );

            if (opts.body && typeof opts.body === 'object' && !(opts.body instanceof FormData)) {
                opts.headers['Content-Type'] = opts.headers['Content-Type'] || 'application/json; charset=utf-8';
                opts.body = JSON.stringify(opts.body);
            }

            let res;
            try {
                res = await fetch(url, opts);
            } catch (e) {
                throw new Error('Không thể kết nối máy chủ API.');
            }

            let data = null;
            try {
                data = await res.json();
            } catch (e) {}

            if (!res.ok) {
                const msg = (data && (data.message || data.error)) || `HTTP ${res.status} - ${res.statusText}`;
                throw new Error(msg);
            }

            return data;
        }

        // Helpers UI
        function showAlert(type, message) {
            const html = `
      <div class="alert alert-${type} alert-dismissible fade show" role="alert">
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>`;
            $('#alertArea').html(html);
            setTimeout(() => {
                $('.alert').alert('close');
            }, 5000);
        }

        function renderTienNghiTable(items) {
            const tbody = $('#tableTienNghi tbody');
            const keyword = ($('#searchTienNghi').val() || '').toLowerCase();
            tbody.empty();

            items
                .filter(x => (x.TenTienNghi || '').toLowerCase().includes(keyword))
                .forEach(item => {
                    const tr = $(`
          <tr>
            <td>${item.IDTienNghi}</td>
            <td>${item.TenTienNghi}</td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-primary me-2 btn-edit" data-id="${item.IDTienNghi}" data-name="${item.TenTienNghi}">
                <i class="bi bi-pencil-square"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${item.IDTienNghi}" data-name="${item.TenTienNghi}">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
        `);
                    tbody.append(tr);
                });

            // Bind actions
            $('.btn-edit').off('click').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                $('#tnId').val(id);
                $('#TenTienNghi').val(name);
                $('#modalTitle').text('Sửa tiện nghi');
                new bootstrap.Modal(document.getElementById('modalCreateEdit')).show();
            });

            $('.btn-delete').off('click').on('click', function() {
                $('#deleteId').val($(this).data('id'));
                $('#deleteName').text($(this).data('name'));
                new bootstrap.Modal(document.getElementById('modalDelete')).show();
            });
        }

        function renderCheckboxList(allTienNghi, checkedIds) {
            const cont = $('#checkboxTienNghiList');
            const filter = ($('#filterCheckbox').val() || '').toLowerCase();
            cont.empty();
            allTienNghi
                .filter(x => (x.TenTienNghi || '').toLowerCase().includes(filter))
                .forEach(item => {
                    const id = Number(item.IDTienNghi);
                    const checked = checkedIds.includes(id) ? 'checked' : '';
                    cont.append(`
          <div class="form-check">
            <input class="form-check-input chk-tiennghi" type="checkbox" value="${id}" id="chk_${id}" ${checked}>
            <label class="form-check-label" for="chk_${id}">${item.TenTienNghi}</label>
          </div>
        `);
                });
        }

        function renderCurrentAssigned(labels) {
            const cont = $('#currentAssigned');
            if (!labels.length) {
                cont.html('<em>Chưa gán tiện nghi nào.</em>');
                return;
            }
            cont.html(labels.map(x => `<span class="badge bg-secondary me-1 mb-1">${x}</span>`).join(' '));
        }

        // RENDER Tiện nghi trong Modal Phòng
        function renderPTienNghiList(allTienNghi, selectedIds) {
            const cont = $('#pTienNghiList');
            const filter = ($('#pFilterTienNghi').val() || '').toLowerCase();
            cont.empty();
            allTienNghi
                .filter(x => (x.TenTienNghi || '').toLowerCase().includes(filter))
                .forEach(item => {
                    const id = Number(item.IDTienNghi);
                    const checked = selectedIds.includes(id) ? 'checked' : '';
                    cont.append(`
          <div class="form-check">
            <input class="form-check-input p-chk-tiennghi" type="checkbox" value="${id}" id="p_chk_${id}" ${checked}>
            <label class="form-check-label" for="p_chk_${id}">${item.TenTienNghi}</label>
          </div>
        `);
                });
        }

        // RENDER Phòng (bảng)
        function renderPhongTable(items) {
            const tbody = $('#tablePhong tbody');
            const keyword = ($('#searchPhong').val() || '').toLowerCase();
            tbody.empty();

            items
                .filter(p => {
                    const joined = [
                        p.SoPhong || '',
                        p.TenLoaiPhong || '',
                        (p.TrangThai || ''),
                        (p.XepHangSao || '')
                    ].join(' ').toLowerCase();
                    return joined.includes(keyword);
                })
                .forEach(p => {
                    const badges = (p.tien_nghi || [])
                        .map(tn => `<span class="badge bg-secondary me-1 mb-1">${tn.TenTienNghi}</span>`)
                        .join(' ');
                    const tr = $(`
          <tr>
            <td>${p.IDPhong}</td>
            <td>${p.SoPhong}</td>
            <td>${p.TenLoaiPhong || ''}</td>
            <td>${p.XepHangSao ?? ''}</td>
            <td>${p.TrangThai || ''}</td>
            <td>${badges || '<em class="text-muted">Chưa có</em>'}</td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-primary me-2 btn-edit-phong"
                data-id="${p.IDPhong}"
                data-sophong="${p.SoPhong}"
                data-idloaiphong="${p.IDLoaiPhong}"
                data-xephangsao="${p.XepHangSao ?? ''}"
                data-trangthai="${p.TrangThai || 'Trống'}"
                data-mota="${(p.MoTa || '').replace(/"/g,'&quot;')}">
                <i class="bi bi-pencil-square"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger btn-delete-phong"
                data-id="${p.IDPhong}" data-name="${p.SoPhong}">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
        `);
                    tbody.append(tr);
                });

            // Bind actions edit/delete phòng
            $('.btn-edit-phong').off('click').on('click', async function() {
                const id = Number($(this).data('id'));
                $('#pId').val(id);
                $('#pSoPhong').val($(this).data('sophong'));
                $('#pIDLoaiPhong').val(String($(this).data('idloaiphong')));
                $('#pXepHangSao').val($(this).data('xephangsao') || '');
                $('#pTrangThai').val($(this).data('trangthai') || 'Trống');
                $('#pMoTa').val($(this).data('mota') || '');

                // Lấy tiện nghi hiện có của phòng để tick sẵn
                const room = PHONG_TABLE.find(r => Number(r.IDPhong) === id);
                if (room && Array.isArray(room.tien_nghi)) {
                    P_SELECTED_TN_IDS = room.tien_nghi.map(t => Number(t.IDTienNghi));
                } else {
                    P_SELECTED_TN_IDS = await fetchAssignedIds(id);
                }
                renderPTienNghiList(ALL_TIEN_NGHI, P_SELECTED_TN_IDS);

                $('#modalTitlePhong').text('Sửa phòng');
                new bootstrap.Modal(document.getElementById('modalCreateEditPhong')).show();
            });

            $('.btn-delete-phong').off('click').on('click', function() {
                $('#deletePhongId').val($(this).data('id'));
                $('#deletePhongName').text($(this).data('name'));
                new bootstrap.Modal(document.getElementById('modalDeletePhong')).show();
            });
        }

        // State
        let ALL_TIEN_NGHI = [];
        let ALL_PHONG = []; // cho dropdown gán tiện nghi
        let PHONG_TABLE = []; // cho bảng danh sách phòng (kèm tiện nghi)
        let SELECTED_TN_IDS = []; // tiện nghi tick cho panel gán
        let P_SELECTED_TN_IDS = []; // tiện nghi tick trong modal phòng

        // Loaders
        async function loadTienNghi() {
            try {
                const json = await apiFetch(`${API_BASE}/tien-nghi`);
                ALL_TIEN_NGHI = (json && json.success) ? (json.data || []) : (json?.data || []);
                renderTienNghiTable(ALL_TIEN_NGHI);

                const pid = $('#selectPhong').val();
                if (pid) {
                    const assignedIds = await fetchAssignedIds(pid);
                    SELECTED_TN_IDS = assignedIds;
                    renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
                    renderCurrentAssigned(
                        ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(Number(x.IDTienNghi))).map(x => x.TenTienNghi)
                    );
                } else {
                    SELECTED_TN_IDS = [];
                    renderCheckboxList(ALL_TIEN_NGHI, []);
                    renderCurrentAssigned([]);
                }
            } catch (e) {
                showAlert('danger', `Không tải được danh sách tiện nghi. ${e.message || ''}`);
                console.error(e);
            }
        }

        async function loadPhongs() {
            try {
                const json = await apiFetch(`${API_BASE}/phong`);
                ALL_PHONG = (json && json.success) ? (json.data || []) : (json?.data || []);
                const sel = $('#selectPhong');
                sel.empty().append(`<option value="">-- Chọn phòng --</option>`);
                ALL_PHONG.forEach(p => {
                    sel.append(`<option value="${p.IDPhong}">${p.SoPhong} - ${p.TenLoaiPhong || ''}</option>`);
                });
            } catch (e) {
                showAlert('danger', `Không tải được danh sách phòng (dropdown). ${e.message || ''}`);
                console.error(e);
            }
        }

        async function loadPhongTable() {
            try {
                const json = await apiFetch(`${API_BASE}/phong?with=tiennghi`);
                PHONG_TABLE = (json && json.success) ? (json.data || []) : (json?.data || []);
                renderPhongTable(PHONG_TABLE);
            } catch (e) {
                showAlert('danger', `Không tải được danh sách phòng. ${e.message || ''}`);
                console.error(e);
            }
        }

        async function loadLoaiPhongForModal() {
            try {
                const json = await apiFetch(`${API_BASE}/loai-phong`);
                const data = (json && json.success) ? (json.data || []) : (json?.data || []);
                const sel = $('#pIDLoaiPhong');
                sel.empty();
                data.forEach(lp => sel.append(`<option value="${lp.IDLoaiPhong}">${lp.TenLoaiPhong}</option>`));
            } catch (e) {
                showAlert('danger', `Không tải được loại phòng. ${e.message || ''}`);
                console.error(e);
            }
        }

        // Load loại phòng cho dropdown gán tiện nghi
        async function loadLoaiPhongAssign() {
            try {
                const json = await apiFetch(`${API_BASE}/loai-phong`);
                const data = (json && json.success) ? (json.data || []) : (json?.data || []);
                const sel = $('#selectLoaiPhongAssign');
                sel.empty().append(`<option value="">-- Chọn loại phòng --</option>`);
                data.forEach(lp => sel.append(`<option value="${lp.IDLoaiPhong}">${lp.TenLoaiPhong}</option>`));

                // Mới mở trang: disable dropdown phòng cho tới khi chọn loại
                $('#selectPhong').prop('disabled', true).empty().append(`<option value="">-- Chọn phòng --</option>`);
                // Reset panel gán
                SELECTED_TN_IDS = [];
                renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
                renderCurrentAssigned([]);
            } catch (e) {
                showAlert('danger', `Không tải được loại phòng. ${e.message || ''}`);
                console.error(e);
            }
        }

        // Load phòng theo loại (cho dropdown bên assign)
        async function loadPhongsByLoai(loaiId) {
            if (!loaiId) {
                $('#selectPhong').prop('disabled', true).empty().append(`<option value="">-- Chọn phòng --</option>`);
                return;
            }
            try {
                const json = await apiFetch(`${API_BASE}/phong?IDLoaiPhong=${encodeURIComponent(loaiId)}`);
                const items = (json && json.success) ? (json.data || []) : (json?.data || []);
                const sel = $('#selectPhong');
                sel.prop('disabled', false);
                sel.empty().append(`<option value="">-- Chọn phòng --</option>`);
                items.forEach(p => {
                    sel.append(`<option value="${p.IDPhong}">${p.SoPhong} - ${p.TenLoaiPhong || ''}</option>`);
                });
            } catch (e) {
                showAlert('danger', `Không tải được phòng theo loại. ${e.message || ''}`);
                console.error(e);
            }
        }

        // Reset panel gán (checkbox + badge)
        function resetAssignPanel() {
            SELECTED_TN_IDS = [];
            renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
            renderCurrentAssigned([]);
        }

        // Dựa trên loại hiện được chọn để refresh dropdown phòng
        async function refreshAssignPhongDropdown() {
            const loaiId = $('#selectLoaiPhongAssign').val();
            await loadPhongsByLoai(loaiId);
            // Sau khi đổi loại phòng, reset panel gán cho tới khi chọn phòng
            resetAssignPanel();
        }

        async function fetchAssignedIds(phongId) {
            try {
                const json = await apiFetch(`${API_BASE}/phong/${phongId}/tien-nghi`);
                if (json && json.success) {
                    return (json.data || []).map(x => Number(x));
                }
                return (json?.data || []).map(x => Number(x));
            } catch (e) {
                showAlert('danger', `Không lấy được tiện nghi của phòng #${phongId}. ${e.message || ''}`);
                console.error(e);
                return [];
            }
        }

        async function syncPhongTienNghi(phongId, ids) {
            return await apiFetch(`${API_BASE}/phong/${phongId}/tien-nghi`, {
                method: 'PUT',
                body: {
                    tien_nghi_ids: ids
                }
            });
        }

        // Events
        $(document).ready(async function() {
            await loadLoaiPhongAssign(); // MỚI: load danh sách loại phòng cho dropdown assign
            await loadTienNghi(); // bảng tiện nghi + checkbox
            await loadPhongTable(); // bảng phòng kèm tiện nghi
            await loadLoaiPhongForModal(); // dropdown loại phòng trong modal phòng

            // Khi đổi loại phòng -> nạp danh sách phòng theo loại, reset panel gán
            $('#selectLoaiPhongAssign').on('change', async function() {
                await refreshAssignPhongDropdown();
            });

            // Search trong bảng tiện nghi
            $('#searchTienNghi').on('input', function() {
                renderTienNghiTable(ALL_TIEN_NGHI);
            });

            // Lọc checkbox panel gán tiện nghi
            $('#filterCheckbox').on('input', function() {
                renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
            });

            // Tick tiện nghi panel gán
            $('#checkboxTienNghiList').on('change', '.chk-tiennghi', function() {
                const id = Number($(this).val());
                if (this.checked) {
                    if (!SELECTED_TN_IDS.includes(id)) SELECTED_TN_IDS.push(id);
                } else {
                    SELECTED_TN_IDS = SELECTED_TN_IDS.filter(x => x !== id);
                }
            });

            // Open create tiện nghi
            $('#btnOpenCreate').on('click', function() {
                $('#tnId').val('');
                $('#TenTienNghi').val('');
                $('#modalTitle').text('Thêm tiện nghi');
                new bootstrap.Modal(document.getElementById('modalCreateEdit')).show();
            });

            // Submit create/edit tiện nghi
            $('#btnSubmitCreateEdit').on('click', async function() {
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
                    await loadPhongTable(); // tiện nghi hiển thị trong bảng phòng cũng thay đổi
                    const instance = bootstrap.Modal.getInstance(document.getElementById('modalCreateEdit'));
                    if (instance) instance.hide();
                } catch (e) {
                    showAlert('danger', e.message || 'Có lỗi xảy ra khi lưu tiện nghi.');
                    console.error(e);
                }
            });

            // Confirm delete tiện nghi
            $('#btnConfirmDelete').on('click', async function() {
                const id = $('#deleteId').val();
                try {
                    const json = await apiFetch(`${API_BASE}/tien-nghi/${id}`, {
                        method: 'DELETE'
                    });
                    if (!json || json.success !== true) throw new Error(json?.message || 'Không thể xóa');
                    showAlert('success', 'Đã xóa tiện nghi');
                    await loadTienNghi();
                    await loadPhongTable();
                    const instance = bootstrap.Modal.getInstance(document.getElementById('modalDelete'));
                    if (instance) instance.hide();
                } catch (e) {
                    showAlert('danger', e.message || 'Không thể xóa');
                    console.error(e);
                }
            });

            // On room change (dropdown gán tiện nghi)
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
                    ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(Number(x.IDTienNghi))).map(x => x.TenTienNghi)
                );
            });

            // Save assignments tiện nghi-phòng (panel bên phải)
            $('#btnSaveAssign').on('click', async function() {
                const pid = $('#selectPhong').val();
                if (!pid) return showAlert('warning', 'Hãy chọn phòng trước khi lưu.');
                try {
                    const json = await syncPhongTienNghi(pid, SELECTED_TN_IDS);
                    if (!json || json.success !== true) throw new Error(json?.message || 'Không thể lưu gán tiện nghi.');
                    const assigned = (json.data || []);
                    SELECTED_TN_IDS = assigned.map(x => Number(x.IDTienNghi));
                    renderCurrentAssigned(assigned.map(x => x.TenTienNghi));
                    await loadPhongTable(); // cập nhật lại danh sách phòng (cột tiện nghi)
                    showAlert('success', 'Đã lưu gán tiện nghi cho phòng.');
                } catch (e) {
                    showAlert('danger', e.message || 'Không thể lưu gán tiện nghi.');
                    console.error(e);
                }
            });

            // Search phòng (bảng)
            $('#searchPhong').on('input', function() {
                renderPhongTable(PHONG_TABLE);
            });

            // Lọc tiện nghi trong Modal Phòng
            $('#pFilterTienNghi').on('input', function() {
                renderPTienNghiList(ALL_TIEN_NGHI, P_SELECTED_TN_IDS);
            });

            // Tick tiện nghi trong Modal Phòng
            $('#pTienNghiList').on('change', '.p-chk-tiennghi', function() {
                const id = Number($(this).val());
                if (this.checked) {
                    if (!P_SELECTED_TN_IDS.includes(id)) P_SELECTED_TN_IDS.push(id);
                } else {
                    P_SELECTED_TN_IDS = P_SELECTED_TN_IDS.filter(x => x !== id);
                }
            });

            // Submit create/edit phòng (kèm sync tiện nghi)
            $('#btnSubmitCreateEditPhong').on('click', async function() {
                const id = $('#pId').val();
                const payload = {
                    IDLoaiPhong: Number($('#pIDLoaiPhong').val()),
                    SoPhong: ($('#pSoPhong').val() || '').trim(),
                    XepHangSao: ($('#pXepHangSao').val() ? Number($('#pXepHangSao').val()) : null),
                    TrangThai: $('#pTrangThai').val() || 'Trống',
                    MoTa: $('#pMoTa').val() || null
                };
                if (!payload.SoPhong) return showAlert('warning', 'Vui lòng nhập Số phòng');
                if (!payload.IDLoaiPhong) return showAlert('warning', 'Vui lòng chọn Loại phòng');

                let url = `${API_BASE}/phong`,
                    method = 'POST';
                if (id) {
                    url = `${API_BASE}/phong/${id}`;
                    method = 'PUT';
                }

                try {
                    const json = await apiFetch(url, {
                        method,
                        body: payload
                    });
                    if (!json || json.success !== true) throw new Error(json?.message || 'Không thể lưu phòng');

                    // Lấy ID phòng đã lưu (trong trường hợp tạo mới)
                    const savedId = id ? Number(id) : Number(json?.data?.IDPhong);
                    if (!savedId) throw new Error('Không xác định được ID phòng sau khi lưu.');

                    // Sync tiện nghi kèm theo
                    await syncPhongTienNghi(savedId, P_SELECTED_TN_IDS);

                    // Cập nhật UI
                    showAlert('success', id ? 'Đã cập nhật phòng' : 'Đã tạo phòng');
                    await loadPhongs(); // reload dropdown
                    await loadPhongTable(); // reload bảng

                    // Nếu dropdown đang chọn chính phòng vừa sửa thì cập nhật panel bên phải
                    const currentPid = $('#selectPhong').val();
                    if (String(currentPid) === String(savedId)) {
                        SELECTED_TN_IDS = [...P_SELECTED_TN_IDS];
                        renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
                        renderCurrentAssigned(
                            ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(Number(x.IDTienNghi))).map(x => x.TenTienNghi)
                        );
                    }

                    const instance = bootstrap.Modal.getInstance(document.getElementById('modalCreateEditPhong'));
                    if (instance) instance.hide();
                } catch (e) {
                    showAlert('danger', e.message || 'Không thể lưu phòng');
                    console.error(e);
                }
            });

            // Confirm delete phòng
            $('#btnConfirmDeletePhong').on('click', async function() {
                const id = $('#deletePhongId').val();
                try {
                    const json = await apiFetch(`${API_BASE}/phong/${id}`, {
                        method: 'DELETE'
                    });
                    if (!json || json.success !== true) throw new Error(json?.message || 'Không thể xóa phòng');
                    showAlert('success', 'Đã xóa phòng');
                    await loadPhongs();
                    await loadPhongTable();
                    const instance = bootstrap.Modal.getInstance(document.getElementById('modalDeletePhong'));
                    if (instance) instance.hide();
                } catch (e) {
                    showAlert('danger', e.message || 'Không thể xóa phòng');
                    console.error(e);
                }
            });
        });
    </script>
</body>
</html>