// Page initializer for Phòng
window.initPhong = async function() {
    console.debug('[initPhong] called');
    const API_BASE = `${window.location.origin}/api`;
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    async function apiFetch(url, options = {}) {
        const headers = Object.assign({ 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF }, options.headers || {});
        const opts = Object.assign({ credentials: 'same-origin' }, options, { headers });
        if (opts.body && typeof opts.body === 'object' && !(opts.body instanceof FormData)) {
            opts.headers['Content-Type'] = opts.headers['Content-Type'] || 'application/json; charset=utf-8';
            opts.body = JSON.stringify(opts.body);
        }
        const res = await fetch(url, opts);
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        try { return await res.json(); } catch (e) { return null; }
    }

    function renderTable(items) {
        const tbody = document.querySelector('#tablePhong tbody');
        if (!tbody) return;
        tbody.innerHTML = '';
        if (!Array.isArray(items) || items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-3 small text-muted">Không có phòng.</td></tr>';
            return;
        }
        const frag = document.createDocumentFragment();
        items.forEach(p => {
            const tr = document.createElement('tr');
            const badges = (p.tien_nghi || []).map(t => `<span class="badge bg-secondary me-1 mb-1">${t.TenTienNghi}</span>`).join(' ');
            tr.innerHTML = `
                <td>${p.IDPhong}</td>
                <td>${p.SoPhong || ''}</td>
                <td>${p.TenLoaiPhong || ''}</td>
                <td>${p.XepHangSao ?? ''}</td>
                <td>${p.TrangThai || ''}</td>
                <td class="text-end">${badges}</td>
            `;
            frag.appendChild(tr);
        });
        tbody.appendChild(frag);
    }

    try {
        const json = await apiFetch(`${API_BASE}/phong?with=tiennghi`);
        const items = (json && json.success) ? (json.data || []) : (Array.isArray(json) ? json : (json?.data || []));
        console.debug('[initPhong] loaded items', (items || []).length);
        renderTable(items || []);
    } catch (e) {
        console.error('[initPhong] error loading phongs', e);
        const tbody = document.querySelector('#tablePhong tbody');
        if (tbody) tbody.innerHTML = '<tr><td colspan="6" class="text-center text-danger small">Không thể tải danh sách phòng.</td></tr>';
    }
};

// note: do not auto-run on file load; loader will call window.initPhong()
// Minimal page initializer for Phòng
window.initPhong = async function() {
    if (!document.getElementById('tablePhong')) return;
    console.debug('initPhong called');

    const API_BASE = `${window.location.origin}/api`;
    async function apiFetch(url) {
        const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' });
        if (!res.ok) throw new Error('API error');
        return res.json().catch(()=>null);
    }

    async function loadPhongTable() {
        try {
            const json = await apiFetch(`${API_BASE}/phong?with=tiennghi`);
            const items = (json && json.success) ? (json.data||[]) : (json?.data||[]);
            const tbody = document.querySelector('#tablePhong tbody');
            tbody.innerHTML = '';
            items.forEach(p => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${p.IDPhong}</td>
                    <td>${p.SoPhong||''}</td>
                    <td>${p.TenLoaiPhong||''}</td>
                    <td>${p.XepHangSao||''}</td>
                    <td>${p.TrangThai||''}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary btn-edit-phong" data-id="${p.IDPhong}"><i class="bi bi-pencil-square"></i></button>
                    </td>`;
                tbody.appendChild(tr);
            });
        } catch(e) { console.error(e); }
    }

    document.getElementById('searchPhong')?.addEventListener('input', function(){ /* optional filter */ });
    await loadPhongTable();
};
