// Page script for the Tiện nghi page. Exposed as window.initTiennghi() so it can be called after AJAX-injecting the partial.
window.initTiennghi = async function() {
    console.debug('[initTiennghi] initializer called');
    // API base and CSRF
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

    // Helpers UI (jQuery used in the page)
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
                data-mota="${(p.MoTa || '').replace(/\"/g,'&quot;')}">
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

    async function loadLoaiPhongAssign() {
        try {
            const json = await apiFetch(`${API_BASE}/loai-phong`);
            const data = (json && json.success) ? (json.data || []) : (json?.data || []);
            const sel = $('#selectLoaiPhongAssign');
            sel.empty().append(`<option value="">-- Chọn loại phòng --</option>`);
            data.forEach(lp => sel.append(`<option value="${lp.IDLoaiPhong}">${lp.TenLoaiPhong}</option>`));

            $('#selectPhong').prop('disabled', true).empty().append(`<option value="">-- Chọn phòng --</option>`);
            SELECTED_TN_IDS = [];
            renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
            renderCurrentAssigned([]);
        } catch (e) {
            showAlert('danger', `Không tải được loại phòng. ${e.message || ''}`);
            console.error(e);
        }
    }

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

    function resetAssignPanel() {
        SELECTED_TN_IDS = [];
        renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
        renderCurrentAssigned([]);
    }

    async function refreshAssignPhongDropdown() {
        const loaiId = $('#selectLoaiPhongAssign').val();
        await loadPhongsByLoai(loaiId);
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

    // Wire up page events (run once per injection)
    function wireEvents() {
        $('#selectLoaiPhongAssign').off('change').on('change', async function() {
            await refreshAssignPhongDropdown();
        });
        $('#searchTienNghi').off('input').on('input', function() { renderTienNghiTable(ALL_TIEN_NGHI); });
        $('#filterCheckbox').off('input').on('input', function() { renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS); });
        $('#checkboxTienNghiList').off('change').on('change', '.chk-tiennghi', function() {
            const id = Number($(this).val());
            if (this.checked) {
                if (!SELECTED_TN_IDS.includes(id)) SELECTED_TN_IDS.push(id);
            } else {
                SELECTED_TN_IDS = SELECTED_TN_IDS.filter(x => x !== id);
            }
        });

        $('#btnOpenCreate').off('click').on('click', function() {
            $('#tnId').val('');
            $('#TenTienNghi').val('');
            $('#modalTitle').text('Thêm tiện nghi');
            new bootstrap.Modal(document.getElementById('modalCreateEdit')).show();
        });

        $('#btnSubmitCreateEdit').off('click').on('click', async function() {
            const id = $('#tnId').val();
            const name = ($('#TenTienNghi').val() || '').trim();
            if (!name) return showAlert('warning', 'Vui lòng nhập Tên tiện nghi');

            let url = `${API_BASE}/tien-nghi`, method = 'POST';
            if (id) { url = `${API_BASE}/tien-nghi/${id}`; method = 'PUT'; }

            try {
                const json = await apiFetch(url, { method, body: { TenTienNghi: name } });
                if (!json || json.success !== true) throw new Error(json?.message || 'API trả về không hợp lệ.');
                showAlert('success', id ? 'Đã cập nhật tiện nghi' : 'Đã tạo tiện nghi');
                await loadTienNghi(); await loadPhongTable();
                const instance = bootstrap.Modal.getInstance(document.getElementById('modalCreateEdit')); if (instance) instance.hide();
            } catch (e) { showAlert('danger', e.message || 'Có lỗi xảy ra khi lưu tiện nghi.'); console.error(e); }
        });

        $('#btnConfirmDelete').off('click').on('click', async function() {
            const id = $('#deleteId').val();
            try { const json = await apiFetch(`${API_BASE}/tien-nghi/${id}`, { method: 'DELETE' });
                if (!json || json.success !== true) throw new Error(json?.message || 'Không thể xóa');
                showAlert('success', 'Đã xóa tiện nghi'); await loadTienNghi(); await loadPhongTable();
                const instance = bootstrap.Modal.getInstance(document.getElementById('modalDelete')); if (instance) instance.hide();
            } catch (e) { showAlert('danger', e.message || 'Không thể xóa'); console.error(e); }
        });

        $('#selectPhong').off('change').on('change', async function() {
            const pid = $(this).val();
            if (!pid) { SELECTED_TN_IDS = []; renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS); renderCurrentAssigned([]); return; }
            const ids = await fetchAssignedIds(pid); SELECTED_TN_IDS = ids; renderCheckboxList(ALL_TIEN_NGHI, SELECTED_TN_IDS);
            renderCurrentAssigned(ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(Number(x.IDTienNghi))).map(x => x.TenTienNghi));
        });

        $('#btnSaveAssign').off('click').on('click', async function() {
            const pid = $('#selectPhong').val(); if (!pid) return showAlert('warning', 'Hãy chọn phòng trước khi lưu.');
            try { const json = await syncPhongTienNghi(pid, SELECTED_TN_IDS); if (!json || json.success !== true) throw new Error(json?.message || 'Không thể lưu gán tiện nghi.');
                const assigned = (json.data || []); SELECTED_TN_IDS = assigned.map(x => Number(x.IDTienNghi)); renderCurrentAssigned(assigned.map(x => x.TenTienNghi)); await loadPhongTable(); showAlert('success', 'Đã lưu gán tiện nghi cho phòng.');
            } catch (e) { showAlert('danger', e.message || 'Không thể lưu gán tiện nghi.'); console.error(e); }
        });

        $('#searchPhong').off('input').on('input', function() { renderPhongTable(PHONG_TABLE); });
        $('#pFilterTienNghi').off('input').on('input', function() { renderPTienNghiList(ALL_TIEN_NGHI, P_SELECTED_TN_IDS); });
        $('#pTienNghiList').off('change').on('change', '.p-chk-tiennghi', function() { const id = Number($(this).val()); if (this.checked) { if (!P_SELECTED_TN_IDS.includes(id)) P_SELECTED_TN_IDS.push(id); } else { P_SELECTED_TN_IDS = P_SELECTED_TN_IDS.filter(x => x !== id); } });

        $('#btnSubmitCreateEditPhong').off('click').on('click', async function() {
            const id = $('#pId').val(); const payload = { IDLoaiPhong: Number($('#pIDLoaiPhong').val()), SoPhong: ($('#pSoPhong').val() || '').trim(), XepHangSao: ($('#pXepHangSao').val() ? Number($('#pXepHangSao').val()) : null), TrangThai: $('#pTrangThai').val() || 'Trống', MoTa: $('#pMoTa').val() || null };
            if (!payload.SoPhong) return showAlert('warning', 'Vui lòng nhập Số phòng'); if (!payload.IDLoaiPhong) return showAlert('warning', 'Vui lòng chọn Loại phòng');
            let url = `${API_BASE}/phong`, method = 'POST'; if (id) { url = `${API_BASE}/phong/${id}`; method = 'PUT'; }
            try { const json = await apiFetch(url, { method, body: payload }); if (!json || json.success !== true) throw new Error(json?.message || 'Không thể lưu phòng');
                const savedId = id ? Number(id) : Number(json?.data?.IDPhong); if (!savedId) throw new Error('Không xác định được ID phòng sau khi lưu.');
                await syncPhongTienNghi(savedId, P_SELECTED_TN_IDS);
                const instance = bootstrap.Modal.getInstance(document.getElementById('modalCreateEditPhong')); if (instance) instance.hide();
            } catch (e) { showAlert('danger', e.message || 'Không thể lưu phòng'); console.error(e); }
        });

        $('#btnConfirmDeletePhong').off('click').on('click', async function() { const id = $('#deletePhongId').val(); try { const json = await apiFetch(`${API_BASE}/phong/${id}`, { method: 'DELETE' }); if (!json || json.success !== true) throw new Error(json?.message || 'Không thể xóa phòng'); showAlert('success', 'Đã xóa phòng'); await loadPhongs(); await loadPhongTable(); const instance = bootstrap.Modal.getInstance(document.getElementById('modalDeletePhong')); if (instance) instance.hide(); } catch (e) { showAlert('danger', e.message || 'Không thể xóa phòng'); console.error(e); } });
    }

    // initialize page data and wire events
    await loadLoaiPhongAssign(); await loadTienNghi(); await loadPhongTable(); await loadLoaiPhongForModal(); wireEvents();

    // helper to re-run after ajax reinjection (optional)
    return {
        reload: async function() { await loadTienNghi(); await loadPhongTable(); wireEvents(); }
    };
};

// Note: this file only defines window.initTienNghi(). Do NOT auto-run here.

