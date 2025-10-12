@extends('layouts.layout2')

@section('title', 'Phòng')
@section('content')
  <!-- Body -->
  <div class="app-body">
    <!-- Form ẩn: CHỈ CHỈNH SỬA -->
    <div id="roomFormWrap" class="collapse">
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
          <h6 class="mb-3"><i class="bi bi-pencil-square me-2"></i>Chỉnh sửa phòng</h6>

          <form id="roomForm" class="row g-3" autocomplete="off">
            <div class="col-md-3">
              <label class="form-label">Mã phòng (IDPhong)</label>
              <input type="text" name="IDPhong" class="form-control" placeholder="VD: P001" />
            </div>
            <div class="col-md-3">
              <label class="form-label">Số phòng</label>
              <input type="text" name="SoPhong" class="form-control" placeholder="VD: 101" />
            </div>
            <div class="col-md-3">
              <label class="form-label">Mã loại phòng</label>
              <input type="text" name="IDLoaiPhong" class="form-control" placeholder="VD: LP001" />
            </div>
            <div class="col-md-3">
              <label class="form-label">Tên loại phòng</label>
              <input type="text" name="TenPhong" class="form-control" placeholder="VD: Deluxe" />
            </div>

            <div class="col-md-6">
              <label class="form-label">Mô tả</label>
              <textarea name="MoTa" class="form-control" rows="3" placeholder="Mô tả phòng..."></textarea>
            </div>
            <div class="col-md-3">
              <label class="form-label">Giá phòng</label>
              <input type="number" name="GiaPhong" class="form-control" placeholder="VD: 800000" />
            </div>
            <div class="col-md-3">
              <label class="form-label">Số người tối đa</label>
              <input type="number" name="SoNguoiToiDa" class="form-control" placeholder="VD: 4" />
            </div>

            <div class="col-md-3">
              <label class="form-label">Xếp hạng</label>
              <select name="XepHangSao" class="form-select">
                <option value="">Chọn...</option>
                <option value="1">1 sao</option>
                <option value="2">2 sao</option>
                <option value="3">3 sao</option>
                <option value="4">4 sao</option>
                <option value="5">5 sao</option>
              </select>
            </div>

            <div class="col-md-9">
              <label class="form-label">Url ảnh phòng</label>
              <input type="text" name="UrlAnhPhong" class="form-control" placeholder="VD: room1.jpg hoặc https://..." />
            </div>

            <div class="col-12 d-flex gap-2 mt-2">
              <button type="button" class="btn btn-warning" id="btnUpdateRoom" disabled>
                <i class="bi bi-save me-1"></i>Cập nhật phòng
              </button>
              <button type="reset" class="btn btn-outline-secondary" id="btnResetForm">
                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
              </button>
            </div>

            <!-- Khóa gốc để PUT + dự phòng đổi khóa -->
            <input type="hidden" id="roomOriginalKey" />
            <input type="hidden" id="roomOriginalIDPhong" />
            <input type="hidden" id="roomOriginalSoPhong" />
          </form>
        </div>
      </div>
    </div>

    <!-- Bảng danh sách -->
    <div class="card-body p-3" style="padding-left: 0; padding-right: 0; margin-left: -15px; margin-right: -15px;">
      <div class="table-responsive mt-4" style="margin-left: -15px; margin-right: -15px;">
        <table class="table table-striped table-hover table-bordered" style="border-collapse: collapse; width: 100%; border-radius: 0.5rem; overflow: hidden; table-layout: fixed;">
          <thead class="table-dark">
            <tr>
              <th class="text-center py-2" style="width: 5%;">STT</th>
              <th class="text-center py-2" style="width: 8%;">Mã Loại Phòng</th>
              <th class="text-center py-2" style="width: 8%;">Mã Phòng</th>
              <th class="text-center py-2" style="width: 8%;">Số phòng</th>
              <th class="text-center py-2" style="width: 20%;">Tên loại phòng</th>
              <th class="text-center py-2" style="width: 30%;">Mô tả</th>
              <th class="text-center py-2" style="width: 10%;">Giá phòng</th>
              <th class="text-center py-2" style="width: 10%;">Số người tối đa</th>
              <th class="text-center py-2" style="width: 10%;">Xếp hạng</th>
              <th class="text-center py-2" style="width: 10%;">Ảnh phòng</th>
              <th class="text-center py-2" style="width: 10%;">Trạng thái</th>
              <th class="text-center py-2" style="width: 10%; border-top-right-radius: 0.5rem;">Hành động</th>
            </tr>
          </thead>
          <tbody id="roomTableBody">
            <!-- Render bằng JS -->
          </tbody>
        </table>
      </div>
    </div>

    <div class="app-footer text-center mb-3">
      <span class="small">©Bootstrap Gallery 2024</span>
    </div>
  </div>
  <!-- /Body -->
@endsection

@section('scripts')
<script>
  // Custom page script: Edit + Update only
  // CHỌN KHÓA UPDATE:
  // - Nếu API update theo IDPhong: 'IDPhong' (khuyến nghị)
  // - Nếu API update theo SoPhong: 'SoPhong'
  const KEY_FIELD = 'IDPhong';

  let ROOMS = [];

  // Add: ensure axios is present (load from CDN if missing)
  async function ensureAxios() {
    if (window.axios) return;
    await new Promise((resolve, reject) => {
      const s = document.createElement('script');
      s.src = 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
      s.onload = resolve;
      s.onerror = () => reject(new Error('Failed to load axios CDN'));
      document.head.appendChild(s);
    });
  }

  // Add: set axios defaults after it exists
  function setupAxiosDefaults() {
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    if (csrfMeta && window.axios) window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfMeta.content;
    if (window.axios) window.axios.defaults.headers.common['Accept'] = 'application/json';
  }

  function getKey(room) {
    return room?.[KEY_FIELD] || room?.IDPhong || room?.SoPhong || '';
  }
  function imgSrc(url) {
    if (!url) return '/img/slider/default.jpg';
    return /^https?:\/\//i.test(url) ? url : ('/img/slider/' + url);
  }
  function cleanPayload(obj) {
    const out = {};
    Object.entries(obj).forEach(([k, v]) => {
      if (v !== null && v !== '') out[k] = v;
    });
    return out;
  }

  async function loadRooms() {
    try {
      const response = await window.axios.get('/api/phongs');
      const rooms = Array.isArray(response.data) ? response.data : (response.data.data || []);
      ROOMS = rooms;
      renderRooms(rooms);
    } catch (error) {
      console.error('Lỗi API:', error.response ? error.response.data : error.message);
      document.getElementById('roomTableBody').innerHTML =
        '<tr><td colspan="12" class="text-center py-3">Không thể tải danh sách phòng.</td></tr>';
    }
  }

  function renderRooms(rooms) {
    const tbody = document.getElementById('roomTableBody');
    tbody.innerHTML = '';
    if (!rooms.length) {
      tbody.innerHTML = '<tr><td colspan="12" class="text-center py-3">Không có phòng nào.</td></tr>';
      return;
    }
    const frag = document.createDocumentFragment();

    rooms.forEach((room, index) => {
      let stars = '';
      if (room.XepHangSao) {
        for (let i = 0; i < room.XepHangSao; i++) stars += '<i class="bi bi-star-fill text-warning"></i>';
      } else stars = '<span class="text-muted">N/A</span>';

      const statusContent = room.status ? `<span class="badge bg-secondary">${room.status}</span>` : `
        <div class="dropdown">
          <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Edit
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="changeStatus(this, 'Đang sử dụng', '${room.SoPhong}')">Phòng đang sử dụng</a></li>
            <li><a class="dropdown-item" href="#" onclick="changeStatus(this, 'Phòng hư', '${room.SoPhong}')">Phòng hư</a></li>
          </ul>
        </div>
      `;

      const tr = document.createElement('tr');
      tr.classList.add('align-middle');
      tr.innerHTML = `
        <td class="text-left">${index + 1}</td>
        <td class="text-left">${room.IDLoaiPhong || 'N/A'}</td>
        <td class="text-left">${room.IDPhong || 'N/A'}</td>
        <td class="text-left">${room.SoPhong || 'N/A'}</td>
        <td class="text-left">${room.TenPhong || 'N/A'}</td>
        <td class="text-left">${room.MoTa || 'N/A'}</td>
        <td class="text-left">${room.GiaPhong ?? 'N/A'}</td>
        <td class="text-left">${room.SoNguoiToiDa ?? 'N/A'}</td>
        <td class="text-left">${stars}</td>
        <td class="text-left">
          <img src="${imgSrc(room.UrlAnhPhong)}" width="60" height="60" class="rounded" loading="lazy" alt="Hình ảnh phòng"
               onerror="this.src='https://picsum.photos/60/60';">
        </td>
        <td class="text-left">${statusContent}</td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-outline-secondary btn-edit-room" data-index="${index}">
            Edit
          </button>
        </td>
      `;
      frag.appendChild(tr);
    });

    tbody.appendChild(frag);
  }

  function openForm() {
    const wrap = document.getElementById('roomFormWrap');
    if (!wrap) return;
    const inst = bootstrap.Collapse.getOrCreateInstance(wrap, { toggle: false });
    inst.show();
    setTimeout(() => wrap.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
  }

  function fillForm(room) {
    const f = document.getElementById('roomForm');
    const set = (n, v) => { if (f.elements[n]) f.elements[n].value = v ?? ''; };

    set('IDPhong', room.IDPhong);
    set('SoPhong', room.SoPhong);
    set('IDLoaiPhong', room.IDLoaiPhong);
    set('TenPhong', room.TenPhong);
    set('MoTa', room.MoTa);
    set('GiaPhong', room.GiaPhong);
    set('SoNguoiToiDa', room.SoNguoiToiDa);
    set('XepHangSao', room.XepHangSao);
    set('UrlAnhPhong', room.UrlAnhPhong);

    // Lưu cả 2 khóa để fallback
    document.getElementById('roomOriginalKey').value = getKey(room);
    document.getElementById('roomOriginalIDPhong').value = room.IDPhong || '';
    document.getElementById('roomOriginalSoPhong').value = room.SoPhong || '';
    document.getElementById('btnUpdateRoom').disabled = false;
  }

  function payloadFromForm() {
    const f = document.getElementById('roomForm');
    const v = (n) => f.elements[n] ? f.elements[n].value : '';
    return {
      IDPhong: v('IDPhong').trim() || null,
      SoPhong: v('SoPhong').trim() || null,
      IDLoaiPhong: v('IDLoaiPhong').trim() || null,
      TenPhong: v('TenPhong').trim() || null,
      MoTa: v('MoTa').trim() || null,
      GiaPhong: v('GiaPhong') ? Number(v('GiaPhong')) : null,
      SoNguoiToiDa: v('SoNguoiToiDa') ? Number(v('SoNguoiToiDa')) : null,
      XepHangSao: v('XepHangSao') ? Number(v('XepHangSao')) : null,
      UrlAnhPhong: v('UrlAnhPhong').trim() || null
    };
  }

  function getAxiosErrText(err) {
    if (!err.response) return `Network error: ${err.message}`;
    const { status, statusText, data } = err.response;
    let msg = '';
    if (data?.message) msg += data.message;
    if (data?.errors) {
      const lines = [];
      Object.keys(data.errors).forEach(k => {
        const arr = Array.isArray(data.errors[k]) ? data.errors[k] : [data.errors[k]];
        arr.forEach(v => lines.push(`${k}: ${v}`));
      });
      if (lines.length) msg += (msg ? '\n' : '') + lines.join('\n');
    }
    if (!msg) msg = typeof data === 'string' ? data : JSON.stringify(data);
    return `[${status} ${statusText}] ${msg}`;
  }

  async function doPut(url, payload) {
    return window.axios.put(url, payload, { headers: { 'Content-Type': 'application/json' } });
  }

  async function updateRoom() {
    const originalKey = document.getElementById('roomOriginalKey').value;
    if (!originalKey) {
      alert('Vui lòng bấm Edit ở một dòng để chọn phòng cần cập nhật.');
      return;
    }
    const payload = cleanPayload(payloadFromForm());

    let url = `/api/phongs/${encodeURIComponent(originalKey)}`;
    console.log('PUT', url, payload);

    try {
      await doPut(url, payload);
      alert('Cập nhật phòng thành công!');
      await loadRooms();
    } catch (err) {
      const altID = document.getElementById('roomOriginalIDPhong').value;
      const altSO = document.getElementById('roomOriginalSoPhong').value;
      const tryAlt = KEY_FIELD === 'IDPhong' ? altSO : altID;
      if (tryAlt && tryAlt !== originalKey) {
        try {
          const altUrl = `/api/phongs/${encodeURIComponent(tryAlt)}`;
          console.warn('Retry PUT with alt key:', altUrl);
          await doPut(altUrl, payload);
          alert('Cập nhật phòng thành công!');
          return await loadRooms();
        } catch (err2) {
          console.error('Update error (alt):', err2);
          alert('Không thể cập nhật phòng.\n' + getAxiosErrText(err2));
          return;
        }
      }
      console.error('Update error:', err);
      alert('Không thể cập nhật phòng.\n' + getAxiosErrText(err));
    }
  }

  function bindEvents() {
    // Click Edit trong bảng
    document.getElementById('roomTableBody').addEventListener('click', function (e) {
      const btn = e.target.closest('.btn-edit-room');
      if (!btn) return;
      const idx = Number(btn.dataset.index);
      const room = ROOMS[idx];
      if (!room) return;
      fillForm(room);
      openForm();
    });

    // Nút cập nhật
    document.getElementById('btnUpdateRoom').addEventListener('click', updateRoom);

    // Reset form -> tắt nút cập nhật
    document.getElementById('btnResetForm').addEventListener('click', function () {
      document.getElementById('roomOriginalKey').value = '';
      document.getElementById('roomOriginalIDPhong').value = '';
      document.getElementById('roomOriginalSoPhong').value = '';
      document.getElementById('btnUpdateRoom').disabled = true;
    });

    // Nút ba gạch bên trái cũng toggle form
    const leftBtn = document.querySelector('.pin-sidebar');
    const formWrap = document.getElementById('roomFormWrap');
    if (leftBtn && formWrap) {
      leftBtn.addEventListener('click', function () {
        const c = bootstrap.Collapse.getOrCreateInstance(formWrap, { toggle: false });
        c.toggle();
      });
    }
  }

  // Load lần đầu
  document.addEventListener('DOMContentLoaded', async function () {
    try {
      await ensureAxios();
      setupAxiosDefaults();
      await loadRooms();
      bindEvents();
    } catch (e) {
      console.error('Axios init failed:', e);
      document.getElementById('roomTableBody').innerHTML =
        '<tr><td colspan="12" class="text-center py-3">Không thể tải danh sách phòng (thiếu axios).</td></tr>';
    }
  });

  // Đổi trạng thái nhanh (giữ nguyên theo SoPhong)
  function changeStatus(element, status, roomNumber) {
    if (confirm(`Xác nhận chuyển sang ${status} cho phòng ${roomNumber}?`)) {
      window.axios.put(`/api/phongs/${roomNumber}`, { status: status })
        .then(() => {
          element.closest('td').innerHTML = `<span class="badge bg-secondary">${status}</span>`;
          alert(`Cập nhật trạng thái thành ${status} cho phòng ${roomNumber} thành công!`);
        })
        .catch(error => {
          console.error('Lỗi cập nhật:', error.response ? error.response.data : error.message);
          alert('Không thể cập nhật trạng thái. Vui lòng kiểm tra console (F12).');
        });
    }
  }
</script>
@endsection
