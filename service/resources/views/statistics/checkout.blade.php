@extends('layouts.layout2')

@section('title', 'Checkout')

@section('content')
  <style>
  /* General Form Styles */
  .card, .modal-content { transition: transform 0.3s ease, box-shadow 0.3s ease; }
  .card:hover, .modal-content:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1); }

  .form-label {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #1e3a8a; font-weight: 600; letter-spacing: 0.3px;
  }
  .form-control, .form-select {
    border: 1px solid #d1e0ff; background: #ffffff; color: #1e3a8a; font-family: 'Inter', sans-serif; transition: all 0.3s ease;
  }
  .form-control:focus, .form-select:focus { border-color: #60a5fa; box-shadow: 0 0 0 4px rgba(96,165,250,0.2); outline: none; background: #f9fbff; }
  .input-group-text { background: #ffffff; border: 1px solid #d1e0ff; color: #60a5fa; transition: all 0.3s ease; }

  .btn-primary { background: linear-gradient(90deg, #60a5fa, #93c5fd); border: none; color: #fff; font-weight: 600; font-family: 'Inter', sans-serif; transition: all 0.3s ease; }
  .btn-primary:hover { background: linear-gradient(90deg, #3b82f6, #60a5fa); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(59,130,246,0.3); }
  .btn-success { background: linear-gradient(90deg, #22c55e, #4ade80); border: none; color: #fff; font-weight: 600; font-family: 'Inter', sans-serif; transition: all 0.3s ease; }
  .btn-success:hover { background: linear-gradient(90deg, #16a34a, #22c55e); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(34,197,94,0.3); }
  .btn-outline-secondary, .btn-outline-dark { border: 1px solid #d1e0ff; color: #1e3a8a; font-weight: 500; font-family: 'Inter', sans-serif; transition: all 0.3s; }
  .btn-outline-secondary:hover, .btn-outline-dark:hover { background: #e6f0ff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

  @media (max-width: 768px) {
    .form-label { font-size: 0.85rem; }
    .form-control, .form-select, .btn-sm, .btn { font-size: 0.9rem; padding: 0.5rem; }
    .row.g-3 { gap: 1.2rem !important; }
    .card-body, .modal-body { padding: 1.5rem !important; }
    .modal-content { transform: none !important; }
  }
  @media (max-width: 576px) {
    .form-label { font-size: 0.8rem; }
    .form-control, .form-select, .btn-sm, .btn { font-size: 0.85rem; padding: 0.45rem; }
    .row.g-3 { gap: 1rem !important; }
    .modal-footer, .modal-header { padding: 1rem !important; }
  }

  /* Bảng/Modal */
  #detailModal .modal-body { max-height: none !important; overflow-y: visible !important; }
  .table-responsive { overflow-y: visible !important; }
  .app-body { overflow-x: hidden; }

  /* CSS in hóa đơn kiểu khách sạn */
  @media print {
    body * { visibility: hidden; }
    #invoicePrint, #invoicePrint * { visibility: visible; }
    #invoicePrint { position: absolute; left: 0; top: 0; width: 100%; }
    @page { size: A5 portrait; margin: 12mm; } /* đổi A4 nếu muốn */
  }
  .invoice-box { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #0f172a; font-size: 12pt; }
  .invoice-head { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #d1e0ff; padding-bottom: 8px; margin-bottom: 8px; }
  .invoice-title { font-size: 16pt; font-weight: 700; color: #1e3a8a; }
  .invoice-meta { text-align: right; font-size: 10pt; color: #475569; }
  .invoice-hotel { font-size: 10pt; color: #334155; }
  .invoice-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
  .invoice-table th, .invoice-table td { border: 1px solid #d1e0ff; padding: 6px 8px; font-size: 11pt; }
  .invoice-table thead th { background: #f1f5ff; }
  .invoice-summary { margin-top: 10px; width: 100%; }
  .invoice-summary .row { display: flex; justify-content: space-between; padding: 4px 0; }
  .invoice-summary .row .label { color: #334155; }
  .invoice-summary .row .value { font-weight: 600; }
  .invoice-footer { margin-top: 12px; text-align: center; font-size: 10pt; color: #6b7280; }
  </style>

  <div class="app-body">
    <!-- Bộ lọc -->
    <div class="card border-0 shadow-lg mb-4" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
      <div class="card-body py-4 px-4" style="position: relative;">
        <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>
        <div class="row g-3 align-items-end">
          <div class="col-12 col-md-3 col-lg-2">
            <label for="filter-date" class="form-label mb-1 text-dark" style="font-size: 0.9rem;"><i class="bi bi-calendar3" style="color: #60a5fa;"></i> Ngày</label>
            <input type="date" id="filter-date" class="form-control form-control-sm shadow-sm" />
          </div>
          <div class="col-12 col-md-3 col-lg-2">
            <label for="filter-scope" class="form-label mb-1 text-dark" style="font-size: 0.9rem;"><i class="bi bi-funnel" style="color: #60a5fa;"></i> Scope</label>
            <select id="filter-scope" class="form-select form-select-sm shadow-sm">
              <option value="inhouse">Đang sử dụng</option>
              <option value="due_today">Trả phòng hôm nay</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-6">
            <label for="filter-q" class="form-label mb-1 text-dark" style="font-size: 0.9rem;"><i class="bi bi-search" style="color: #60a5fa;"></i> Tìm kiếm</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-white border-end-0"><i class="bi bi-search" style="color:#60a5fa;"></i></span>
              <input type="text" id="filter-q" class="form-control shadow-sm border-start-0" placeholder="Số phòng / Mã đặt / Tên KH / SĐT" />
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-2 d-flex">
            <button id="btn-refresh" class="btn btn-primary btn-sm w-100 shadow-sm"><i class="bi bi-arrow-clockwise me-1"></i>Tải</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Danh sách -->
    <div class="card border-0 shadow-lg mb-4" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
      <div class="card-body py-4 px-4" style="position: relative;">
        <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>
        <div class="table-responsive mt-2">
          <table class="table table-striped table-hover table-bordered" style="border-radius: 12px; overflow: hidden; background: #ffffff;">
            <thead style="background: linear-gradient(90deg, #60a5fa, #93c5fd); color: #ffffff;">
              <tr>
                <th class="text-center" style="width:10%;">Phòng</th>
                <th class="text-center" style="width:18%;">Khách hàng</th>
                <th class="text-center" style="width:24%;">Dịch vụ</th>
                <th class="text-center" style="width:10%;">Nhận</th>
                <th class="text-center" style="width:10%;">Trả</th>
                <th class="text-center" style="width:18%;">Trạng thái</th>
                <th class="text-center" style="width:10%;">Hành động</th>
              </tr>
            </thead>
            <tbody id="bookingTableBody"></tbody>
          </table>
        </div>
        <div class="d-flex justify-content-between align-items-center pager-wrap mt-3">
          <div id="pagingInfo" class="text-small text-muted" style="font-size: 0.85rem;"></div>
          <nav aria-label="Pagination"><ul id="pagination" class="pagination pagination-sm mb-0"></ul></nav>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal: Thêm dịch vụ -->
  <div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 16px;">
        <div class="modal-header py-3">
          <h6 class="modal-title"><i class="bi bi-plus-circle me-2" style="color: #60a5fa;"></i>Thêm dịch vụ</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body py-4">
          <div class="row g-3 align-items-end">
            <div class="col-12">
              <label for="sel-service-modal" class="form-label mb-1 text-dark">Dịch vụ</label>
              <select id="sel-service-modal" class="form-select shadow-sm"></select>
            </div>
            <div class="col-12">
              <label class="form-label mb-1 text-dark">Số lượng</label>
              <div class="input-group qty-wrap">
                <button class="btn btn-outline-secondary shadow-sm" type="button" id="btn-qty-dec"><i class="bi bi-dash-lg"></i></button>
                <input type="number" id="service-qty-modal" class="form-control text-center shadow-sm" min="1" value="1" />
                <button class="btn btn-outline-secondary shadow-sm" type="button" id="btn-qty-inc"><i class="bi bi-plus-lg"></i></button>
              </div>
              <div id="hint-money" class="hint-money mt-2" style="font-size: 0.85rem;">Tạm tính: 0đ</div>
            </div>
            <div class="col-12">
              <label for="service-time-modal" class="form-label mb-1 text-dark">Thời gian thực hiện</label>
              <input type="datetime-local" id="service-time-modal" class="form-control shadow-sm">
            </div>
          </div>
        </div>
        <div class="modal-footer py-3">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="button" id="btn-add-service-confirm" class="btn btn-primary">
            <i class="bi bi-check2-circle me-1"></i>Thêm
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal: Chi tiết -->
  <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" style="border-radius: 16px;">
        <div class="modal-header py-3">
          <h6 class="modal-title"><i class="bi bi-receipt me-2" style="color: #60a5fa;"></i>Chi tiết Checkout</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body py-4">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-2"><strong>Phòng:</strong> <span id="room-so-m"></span> - <span id="room-type-m"></span></div>
              <div class="mb-2"><strong>Khách hàng:</strong> <span id="kh-name-m"></span></div>
              <div class="mb-2 text-small" id="kh-email-m"></div>
            </div>
            <div class="col-md-6">
              <div class="mb-2"><strong>Nhận:</strong> <span id="bk-nhan-m"></span></div>
              <div class="mb-2"><strong>Trả:</strong> <span id="bk-tra-m"></span></div>
              <div class="mb-2 hide-on-print"><strong>Trạng thái:</strong> <span id="bk-status-m" class="badge badge-soft"></span></div>
              <div class="mb-2 hide-on-print"><strong>TT thanh toán:</strong> <span id="bk-paystatus-m" class="badge badge-soft"></span></div>
            </div>
          </div>

          <hr />

          <!-- Ghi chú hóa đơn -->
          <div class="row g-3 align-items-end">
            <div class="col-md-8">
              <label for="invoice-note-m" class="form-label mb-1 text-dark">Ghi chú hóa đơn</label>
              <input type="text" id="invoice-note-m" class="form-control shadow-sm" placeholder="Ghi chú..."/>
            </div>
            <div class="col-md-4">
              <button id="btn-save-note-m" class="btn btn-outline-secondary w-100"><i class="bi bi-save me-1"></i>Lưu ghi chú</button>
            </div>
          </div>

          <!-- Dịch vụ -->
          <div class="mt-4">
            <div class="section-title" id="title-new">Dịch vụ mới</div>
            <div id="service-lines-new"></div>
            <div class="section-title mt-3" id="title-old-label">Dịch vụ đã thanh toán trước</div>
            <div id="service-lines-old"></div>
          </div>

          <!-- Tổng hợp + Thanh toán -->
          <div class="mt-4 row">
            <div class="col-md-6">
              <h6 class="mb-2">Tổng hợp</h6>
              <ul class="list-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                <li class="list-group-item d-flex justify-content-between"><span>Tiền phòng</span><strong id="t-room-m">0</strong></li>
                <li class="list-group-item d-flex justify-content-between"><span>Tiền dịch vụ</span><strong id="t-service-m">0</strong></li>
                <li class="list-group-item d-flex justify-content-between list-group-item-light fw-bold border-top"><span>Tổng hóa đơn</span><strong id="t-grand-total-m">0</strong></li>
                <li class="list-group-item d-flex justify-content-between"><span>Tiền cọc</span><strong id="t-deposit-m">0</strong></li>
                <li class="list-group-item d-flex justify-content-between"><span>Đã thanh toán</span><strong id="t-paid-prev">0</strong></li>
                <li class="list-group-item d-flex justify-content-between list-group-item-info">
                  <span id="label-additional" class="fw-bold">Phát sinh mới (cần thu)</span><strong id="t-additional" class="text-danger fw-bold">0</strong>
                </li>
              </ul>
            </div>

            <div class="col-md-6 hide-on-print">
              <h6 class="mb-2">Thanh toán</h6>
              <button id="btn-open-qr" class="btn btn-outline-primary mb-3"><i class="bi bi-qr-code me-1"></i>QR thanh toán</button>
              <h6 class="mb-2">Thao tác</h6>
              <div class="d-flex gap-2 flex-wrap">
                <button id="btn-pay-m" class="btn btn-success"><i class="bi bi-cash-coin me-1"></i>Thu tiền (tiền mặt)</button>
                <button id="btn-complete-m" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>Hoàn tất trả phòng</button>
                <button id="btn-print-m" class="btn btn-outline-dark"><i class="bi bi-printer me-1"></i>In hóa đơn</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer py-3">
          <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast -->
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 2000">
    <div id="appToast" class="toast text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div id="appToastBody" class="toast-body">Đã thực hiện</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  <!-- Modal: QR -->
  <div class="modal fade" id="qrPayModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header py-2">
          <h6 class="modal-title"><i class="bi bi-qr-code me-2"></i>Quét QR thanh toán</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body text-center">
          <a id="qr-open" href="#" target="_blank" rel="noopener">
            <img id="qr-img-modal" alt="QR thanh toán" class="img-fluid bg-white border rounded p-2" style="max-width:260px" />
          </a>
        </div>
        <div class="modal-footer py-2">
          <button type="button" class="btn btn-success" id="btn-qr-paid-modal"><i class="bi bi-check2-circle me-1"></i>Đã nhận tiền (QR)</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Vùng ẩn để in hóa đơn -->
  <div id="invoicePrint" class="d-none"></div>

  <!-- JS assets -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <script>
    const API_BASE = "{{ url('/api') }}";

    // QR config
    const QR_CFG = { bank: 'bidv', account: '8639699999', accountName: 'Uy ban Trung uong Mat tran To quoc Viet Nam' };
    function buildVietQRUrl(cfg, amount, addInfo) {
      const base = `https://img.vietqr.io/image/${encodeURIComponent(cfg.bank)}-${encodeURIComponent(cfg.account)}-print.png`;
      const q = new URLSearchParams();
      if (amount > 0) q.set('amount', Math.round(amount));
      if (addInfo) q.set('addInfo', addInfo);
      if (cfg.accountName) q.set('accountName', cfg.accountName);
      return `${base}?${q.toString()}`;
    }
    function openQrPay(amount, addInfo) {
      const img = document.getElementById('qr-img-modal');
      const a = document.getElementById('qr-open');
      if (!img || !a) return;
      const moneyVal = Number(amount);
      if (!moneyVal || moneyVal <= 0 || !isFinite(moneyVal)) { showToast('Không có số tiền cần thu', 'danger'); return; }
      const url = buildVietQRUrl(QR_CFG, moneyVal, addInfo || '');
      img.onerror = () => window.open(url, '_blank', 'noopener');
      img.src = url; a.href = url;
      bootstrap.Modal.getOrCreateInstance(document.getElementById('qrPayModal')).show();
    }
    document.addEventListener('click', async (e) => {
      const openBtn = e.target.closest('#btn-open-qr');
      if (openBtn) { const amount = Number(openBtn.dataset.amount || 0); const addInfo = openBtn.dataset.addinfo || ''; openQrPay(amount, addInfo); }
      if (e.target.closest('#btn-qr-paid-modal')) {
        if (!currentId) return showToast('Chưa chọn đặt phòng', 'danger');
        if (!confirm('Xác nhận đã nhận tiền qua QR?')) return;
        try {
          await axios.post(`${API_BASE}/checkout/${currentId}/pay`);
          await loadDetailModal(currentId);
          if (typeof loadList === 'function') await loadList();
          showToast('Đã ghi nhận thanh toán (QR)', 'success');
          bootstrap.Modal.getInstance(document.getElementById('qrPayModal'))?.hide();
        } catch { showToast('Không thể ghi nhận thanh toán QR', 'danger'); }
      }
    });

    // State
    let currentId = null;
    let svcList = [];
    const SNAPSHOT = {};
    const ADDED_SV = new Map();
    const SERVICES_CACHE = new Map();
    const SERVICES_FETCHING = new Map();
    let CURRENT_SCOPE = 'inhouse';
    const PAGE = { size: 5, index: 1, total: 1 };
    let LIST = [];

    // Defaults axios
    (function () {
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
      if (token) axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
      axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
      axios.defaults.headers.common['Accept'] = 'application/json';
    })();

    // Utils
    function money(n){ return (Number(n || 0)).toLocaleString('vi-VN'); }
    function invMoney(n){ return (Number(n || 0)).toLocaleString('vi-VN') + 'đ'; }
    function todayStr(){ const d=new Date(); return `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`; }
    function normDateStr(s){ return (s || '').toString().trim().slice(0, 10); }
    function formatDateTime(isoString){
      if(!isoString) return '';
      try{ const d=new Date(isoString); const date=String(d.getDate()).padStart(2,'0'); const month=String(d.getMonth()+1).padStart(2,'0'); const year=d.getFullYear(); const hours=String(d.getHours()).padStart(2,'0'); const minutes=String(d.getMinutes()).padStart(2,'0'); return `${hours}:${minutes} ${date}/${month}/${year}`; }
      catch{ return (isoString || '').replace('T',' ').slice(0,16); }
    }
    function getCurrentDateTimeLocalString(){ const now=new Date(); now.setMinutes(now.getMinutes()-now.getTimezoneOffset()); return now.toISOString().slice(0,16); }
    function textPayStatus(n){ switch(Number(n)){ case 2:return'Đã thanh toán'; case 1:return'Chưa thanh toán'; case 0:return'Đã cọc'; case -1:return'Chưa cọc'; default:return n; } }
    function textBookingStatus(n){ switch(Number(n)){ case 0:return'Đã hủy'; case 1:return'Chờ xác nhận'; case 2:return'Đã xác nhận'; case 3:return'Đang sử dụng'; case 4:return'Hoàn thành'; default:return n; } }
    function getBookingId(it){ const id=it?.IDDatPhong ?? it?.booking?.IDDatPhong ?? it?.ID ?? ''; return id ? String(id) : ''; }
    function getDisplayRoomNo(item){ return item?.phong?.SoPhong || item?.room?.SoPhong || item?.SoPhong || '-'; }
    function getDisplayRoomType(item){ return item?.phong?.TenLoaiPhong || item?.room?.TenLoaiPhong || item?.TenLoaiPhong || ''; }
    function getDisplayCustomerName(item){ return item?.khach_hang?.HoTen || item?.customer?.HoTen || item?.HoTen || ''; }
    function showToast(message, type='success', delay=2300){ const el=document.getElementById('appToast'); const body=document.getElementById('appToastBody'); if(!el||!body) return alert(message); body.textContent=message; el.className=`toast text-bg-${type} border-0`; const t=bootstrap.Toast.getOrCreateInstance(el,{delay}); t.show(); }
    function escHtml(s){ return String(s || '').replace(/[&<>"']/g, t => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[t])); }

    // Parse "10.000đ", "10,000.00", 10000 → 10000
    function toAmount(v) {
      if (v === null || v === undefined) return 0;
      if (typeof v === 'number' && isFinite(v)) return v;
      const s = String(v).replace(/[^\d.,-]/g, '').trim();
      if (!s) return 0;
      const hasComma = s.includes(',');
      const hasDot = s.includes('.');
      if (hasComma && hasDot) {
        const vn = s.replace(/\./g, '').replace(',', '.'); const vnNum = Number(vn);
        if (isFinite(vnNum)) return vnNum;
        const us = s.replace(/,/g, ''); const usNum = Number(us);
        return isFinite(usNum) ? usNum : 0;
      } else if (hasDot && !hasComma) {
        const tryThousands = s.replace(/\./g, ''); const tNum = Number(tryThousands);
        if (isFinite(tNum)) return tNum;
        const num = Number(s); return isFinite(num) ? num : 0;
      } else if (hasComma && !hasDot) {
        const tryThousands = s.replace(/,/g, ''); const tNum = Number(tryThousands);
        if (isFinite(tNum)) return tNum;
        const num = Number(s.replace(',', '.')); return isFinite(num) ? num : 0;
      }
      const num = Number(s); return isFinite(num) ? num : 0;
    }
    // Lấy giá 1 dòng dịch vụ theo nhiều tên trường
    function getLinePrice(l) {
      const candidates = [ l?.TienDichVu, l?.DonGia, l?.Gia, l?.Price, l?.ThanhTien, l?.amount, l?.tong_tien, l?.thanh_tien ];
      for (const c of candidates) {
        const val = toAmount(c);
        if (val) return val;
      }
      return 0;
    }

    // Dịch vụ chips
    function ensureAddedMap(id){ if(!ADDED_SV.has(id)) ADDED_SV.set(id,new Map()); return ADDED_SV.get(id); }
    function addAddedService(id,name,qty){ const map=ensureAddedMap(id); const old=map.get(name)||0; map.set(name, old+qty); }
    function chipsFromMap(mapObj){ if(!mapObj||mapObj.size===0) return ''; let html=''; mapObj.forEach((qty,name)=>{ html+=`<span class="sv-chip">${name}${qty>1?`<span class="qty">x${qty}</span>`:''}</span>`; }); return html; }

    // Service panel (ĐÃ BỎ "1 mục")
    function renderServicePanelHTML(id){
      const serverMap = SERVICES_CACHE.get(id);
      const addedMap = ADDED_SV.get(id);
      const hasServer = serverMap && serverMap.size > 0;
      const hasAdded = addedMap && addedMap.size > 0;
      const header = `<div class="sv-header"><div class="sv-title"><i class="bi bi-bag-check"></i>Dịch vụ</div></div>`;
      const blockServer = `
        <div class="sv-block">
          <div class="sv-label"><i class="bi bi-bag-check"></i>Đã sử dụng</div>
          ${hasServer ? `<div class="sv-chips">${chipsFromMap(serverMap)}</div>` : `<div class="sv-empty">Không có</div>`}
        </div>`;
      const blockAdded = `
        <div class="sv-block">
          <div class="sv-label"><i class="bi bi-plus-circle"></i>Mới thêm</div>
          ${hasAdded ? `<div class="sv-chips">${chipsFromMap(addedMap)}</div>` : `<div class="sv-empty">Chưa thêm</div>`}
        </div>`;
      return `<div class="sv-panel">${header}${blockServer}${blockAdded}</div>`;
    }
    function setServiceCellLoading(id){
      const el=document.getElementById(`sv-cell-${id}`); if(!el) return;
      el.innerHTML = `
        <div class="sv-panel">
          <div class="sv-header"><div class="sv-title"><i class="bi bi-bag-check"></i>Dịch vụ</div></div>
          <div class="sv-block"><div class="sv-label"><i class="bi bi-box-seam"></i>Có sẵn</div><div class="skeleton"></div><div class="skeleton" style="width:60%;"></div></div>
          <div class="sv-block"><div class="sv-label"><i class="bi bi-plus-circle"></i>Vừa thêm</div>${chipsFromMap(ADDED_SV.get(id)||new Map()) || '<div class="sv-empty">Chưa thêm</div>'}</div>
        </div>`;
    }
    function renderServiceCell(id){ const el=document.getElementById(`sv-cell-${id}`); if(!el) return; el.innerHTML=renderServicePanelHTML(id); el.setAttribute('data-loaded','1'); }
    function summarizeServerLines(lines){ const map=new Map(); (lines||[]).forEach(l=>{ const name=l.TenDichVu||l.IDDichVu||'Dịch vụ'; map.set(name,(map.get(name)||0)+1); }); return map; }
    async function fetchServerServices(id){
      if(SERVICES_CACHE.has(id)) return SERVICES_CACHE.get(id);
      if(SERVICES_FETCHING.has(id)) return SERVICES_FETCHING.get(id);
      const p=(async()=>{ try{ const rs=await axios.get(`${API_BASE}/checkout/${id}`); const lines=rs?.data?.data?.invoice?.lines||[]; const map=summarizeServerLines(lines); SERVICES_CACHE.set(id,map); return map; } catch{ const map=new Map(); SERVICES_CACHE.set(id,map); return map; } finally{ SERVICES_FETCHING.delete(id); }})();
      SERVICES_FETCHING.set(id,p); return p;
    }
    async function loadServiceCell(id){ const el=document.getElementById(`sv-cell-${id}`); if(!el) return; if(el.getAttribute('data-loaded')==='1') return; setServiceCellLoading(id); await fetchServerServices(id); renderServiceCell(id); }

    // Danh sách + phân trang
    function statusBadge(label,type='secondary',icon=''){ const iconHtml = icon?`<i class="bi ${icon} me-1"></i>`:''; return `<span class="badge rounded-pill bg-${type} text-white border-0">${iconHtml}${label}</span>`; }
    function buildStatusCell(item,scope='inhouse'){
      const stVal=Number(item?.TrangThai ?? item?.booking?.TrangThai);
      const payVal=Number(item?.TrangThaiThanhToan ?? item?.booking?.TrangThaiThanhToan);
      let stBadge; switch(stVal){ case 3:stBadge=statusBadge('Đang sử dụng','info','bi-door-open');break; case 4:stBadge=statusBadge('Hoàn thành','success','bi-check2-circle');break; case 2:stBadge=statusBadge('Đã xác nhận','primary','bi-check2');break; case 1:stBadge=statusBadge('Chờ xác nhận','warning','bi-hourglass-split');break; default:stBadge=statusBadge('Đã hủy','secondary','bi-x-circle'); }
      let payBadge; switch(payVal){ case 2:payBadge=statusBadge('Đã thanh toán','success','bi-cash-stack');break; case 1:payBadge=statusBadge('Chưa thanh toán','danger','bi-exclamation-circle');break; case 0:payBadge=statusBadge('Đã cọc','warning','bi-piggy-bank');break; default:payBadge=statusBadge('Chưa cọc','secondary','bi-dash-circle'); }
      if(scope==='inhouse') return `<div class="status-wrap"><div>${stBadge}</div></div>`;
      if(scope==='due_today') return `<div class="status-wrap"><div>${payBadge}</div></div>`;
      return `<div class="status-wrap"><div>${stBadge}</div><div>${payBadge}</div></div>`;
    }
    function bookingRowHtml(item, scope){
      const id=getBookingId(item);
      const soPhong=getDisplayRoomNo(item);
      const loaiPhong=getDisplayRoomType(item);
      const khName=getDisplayCustomerName(item);
      const ngayNhan=(item.NgayNhanPhong || item.booking?.NgayNhanPhong || '').slice(0,10);
      const ngayTra=(item.NgayTraPhong || item.booking?.NgayTraPhong || '').slice(0,10);
      const actionBtns = (scope==='inhouse')
        ? `<button class="btn btn-sm btn-outline-primary" onclick="openAddServiceModal('${id}')"><i class="bi bi-plus-circle me-1"></i>Thêm DV</button>`
        : `<button class="btn btn-sm btn-dark" onclick="openDetailModal('${id}')"><i class="bi bi-eye me-1"></i>Chi tiết</button>`;
      return `
        <tr>
          <td class="text-center break-anywhere"><div><strong>${soPhong}</strong></div><div class="text-small text-muted">${loaiPhong}</div></td>
          <td class="text-center break-anywhere"><div>${khName || '-'}</div></td>
          <td class="text-start align-middle"><div id="sv-cell-${id}"></div></td>
          <td class="text-center">${ngayNhan || ''}</td>
          <td class="text-center">${ngayTra || ''}</td>
          <td class="text-center status-cell">${buildStatusCell(item, scope)}</td>
          <td class="text-center"><div class="d-flex justify-content-center gap-1 flex-wrap">${actionBtns}</div></td>
        </tr>`;
    }
    function renderPager(current,total,windowSize){
      const ul=document.getElementById('pagination'); ul.innerHTML=''; if(!total||total<=1) return;
      const build=(text,page,disabled)=>{ const li=document.createElement('li'); li.className=`page-item ${disabled?'disabled':''}`; li.innerHTML=`<a class="page-link" href="#" data-page="${page}">${text}</a>`; return li; };
      ul.appendChild(build('«',1,current===1)); ul.appendChild(build('‹',current-1,current===1));
      const win=windowSize||5; let start=Math.max(1,current-Math.floor(win/2)); let end=start+win-1; if(end>total){ end=total; start=Math.max(1,end-win+1); }
      for(let p=start;p<=end;p++){ const li=document.createElement('li'); li.className=`page-item ${p===current?'active':''}`; li.innerHTML=`<a class="page-link" href="#" data-page="${p}">${p}</a>`; ul.appendChild(li); }
      ul.appendChild(build('›',current+1,current===total)); ul.appendChild(build('»',total,current===total));
    }
    function renderListPage(){
      const body=document.getElementById('bookingTableBody'); body.innerHTML='';
      if(!Array.isArray(LIST)||LIST.length===0){ body.innerHTML=`<tr><td colspan="7" class="text-center text-muted py-3">Không có dữ liệu</td></tr>`; renderPager(0,0,0); return; }
      const start=(PAGE.index-1)*PAGE.size; const items=LIST.slice(start,start+PAGE.size);
      const frag=document.createDocumentFragment();
      items.forEach(item=>{ const holder=document.createElement('tbody'); holder.innerHTML=bookingRowHtml(item, CURRENT_SCOPE); frag.appendChild(holder.firstElementChild); });
      body.appendChild(frag);
      items.forEach(item=>{ const id=getBookingId(item); loadServiceCell(id); });
      renderPager(PAGE.index, PAGE.total, 5);
    }
    function setPagedList(arr){ LIST=Array.isArray(arr)?arr:[]; PAGE.total=Math.max(1, Math.ceil(LIST.length/PAGE.size)); if(PAGE.index>PAGE.total) PAGE.index=PAGE.total; renderListPage(); }
    function setListError(message){ const body=document.getElementById('bookingTableBody'); body.innerHTML=`<tr><td colspan="7" class="text-center text-danger py-3">${message}</td></tr>`; renderPager(0,0,0); }

    async function fetchList(scope, selectedStr, q){
      const url=`${API_BASE}/checkout/list`; const params={scope, date:selectedStr}; if(q&&q.trim()) params.q=q.trim();
      const rs=await axios.get(url, { params }); return Array.isArray(rs.data?.data) ? rs.data.data : [];
    }
    async function loadList(){
      const dateInput=document.getElementById('filter-date').value || todayStr();
      const selectedStr=normDateStr(dateInput);
      const scopeEl=document.getElementById('filter-scope'); let scope=scopeEl.value; CURRENT_SCOPE=scope;
      const q=document.getElementById('filter-q').value || '';
      const allowed=['due_today','inhouse']; if(!allowed.includes(scope)){ scope='inhouse'; scopeEl.value='inhouse'; CURRENT_SCOPE='inhouse'; }
      PAGE.index=1;
      const body=document.getElementById('bookingTableBody'); body.innerHTML=`<tr><td colspan="7" class="text-center text-muted py-3">Đang tải...</td></tr>`;
      renderPager(0,0,0); SERVICES_FETCHING.clear(); SERVICES_CACHE.clear();
      try{ let list=(scope==='inhouse') ? await fetchList('inhouse', selectedStr, q) : await fetchList('due_today', selectedStr, q); setPagedList(list); }
      catch(e){ const msg=e?.response?.data?.message || e?.response?.data || e?.message || 'Lỗi tải danh sách.'; setListError('Lỗi tải danh sách: '+msg); }
    }

    // Service master list
    async function loadServices(){
      try{
        const rs=await axios.get(`${API_BASE}/services`); svcList=rs.data?.data || [];
        const sel=document.getElementById('sel-service-modal'); if(sel){ sel.innerHTML=''; (svcList||[]).forEach(s=>{ const opt=document.createElement('option'); opt.value=s.IDDichVu; opt.textContent=`${s.TenDichVu} (${money(s.TienDichVu)}đ)`; sel.appendChild(opt); }); }
        updateHintMoney();
      }catch(e){ console.error(e); }
    }

    // Snapshot cho hoá đơn
    function stableLineKey(l){ return String(l.IDChiTiet ?? l.ID ?? l.MaChiTiet ?? l.Ma ?? `${l.IDDichVu||''}|${l.ThoiGianThucHien||''}|${l.TienDichVu||0}|${l.TenDichVu||''}`); }
    function buildMulti(lines){ const map=new Map(); (lines||[]).forEach(l=>{ const k=stableLineKey(l); map.set(k,(map.get(k)||0)+1); }); return map; }
    function splitBySnapshot(lines, baseCounts){
      if(!baseCounts) return { oldLines:(lines||[]).slice(), newLines:[] };
      const tmp=new Map(baseCounts); const oldLines=[], newLines=[];
      (lines||[]).forEach(l=>{ const k=stableLineKey(l); const c=tmp.get(k)||0; if(c>0){ oldLines.push(l); tmp.set(k,c-1); } else { newLines.push(l); } });
      return { oldLines, newLines };
    }
    function ensureSnapshotIfSettled_setup(d, id){
      const payStatus=Number(d?.booking?.TrangThaiThanhToan);
      const isSettled = payStatus===2 || Number(d?.totals?.amount_due || 0)===0;
      if(isSettled && !SNAPSHOT[id]?.baseCounts){ SNAPSHOT[id] = { baseCounts: buildMulti(d?.invoice?.lines || []) }; }
    }
    async function ensureSnapshotIfSettled(id){
      try{ const rs=await axios.get(`${API_BASE}/checkout/${id}`); ensureSnapshotIfSettled_setup(rs.data?.data||{}, id); }catch(e){ }
    }

    function renderLinesTable(targetEl, lines) {
      const el = document.getElementById(targetEl);
      el.innerHTML = '';
      if (!lines || lines.length === 0) {
        el.innerHTML = '<div class="text-muted">Không có dịch vụ.</div>';
        return;
      }

      let total = 0;
      const bodyRows = (lines || []).map((l, i) => {
        const price = getLinePrice(l);
        total += price;
        return `
          <tr>
            <td>${i + 1}</td>
            <td class="break-anywhere">${l.TenDichVu || l.IDDichVu}</td>
            <td>${formatDateTime(l.ThoiGianThucHien)}</td>
            <td class="text-end">${money(price)}đ</td>
          </tr>`;
      }).join('');

      const tb = document.createElement('table');
      tb.className = 'table table-striped table-hover table-sm mb-0';
      tb.innerHTML = `
        <thead class="table-light">
          <tr>
            <th style="width:50px;">#</th>
            <th>Dịch vụ</th>
            <th style="width:180px;">Thời gian</th>
            <th class="text-end" style="width:160px;">Thành tiền</th>
          </tr>
        </thead>
        <tbody>${bodyRows}</tbody>
        <tfoot class="table-group-divider">
          <tr>
            <td colspan="3" class="text-end pe-3"><strong>Tổng cộng:</strong></td>
            <td class="text-end"><strong>${money(total)}đ</strong></td>
          </tr>
        </tfoot>`;
      el.appendChild(tb);
    }

    // Ghi chú: lấy từ DB và in
    function getNoteFromDetail(d){ return d?.invoice?.GhiChu ?? d?.invoice?.Note ?? d?.booking?.GhiChu ?? d?.GhiChu ?? ''; }

    // Modal chi tiết
    const detailModal = () => bootstrap.Modal.getOrCreateInstance(document.getElementById('detailModal'));
    window.openDetailModal = async function (id){ currentId=id; await loadDetailModal(id); detailModal().show(); }

    async function loadDetailModal(id){
      try{
        const rs=await axios.get(`${API_BASE}/checkout/${id}`);
        const d=rs.data.data;
        window.CURRENT_DETAIL = d; // để in

        // Đổ ghi chú lên input
        const noteInput = document.getElementById('invoice-note-m');
        if(noteInput){
          const note = getNoteFromDetail(d);
          noteInput.value = note;
          noteInput.placeholder = note ? '' : 'Chưa có ghi chú...';
          noteInput.dataset.orig = note;
          const saveBtn = document.getElementById('btn-save-note-m');
          if(saveBtn){
            const syncBtn = () => { saveBtn.disabled = (noteInput.value.trim() === (noteInput.dataset.orig || '').trim()); };
            syncBtn(); noteInput._syncBtn && noteInput.removeEventListener('input', noteInput._syncBtn);
            noteInput._syncBtn = syncBtn; noteInput.addEventListener('input', syncBtn);
          }
        }

        const roomNo=d.room?.SoPhong || d.phong?.SoPhong || '';
        document.getElementById('room-so-m').textContent = roomNo || '-';
        document.getElementById('room-type-m').textContent = d.room?.TenLoaiPhong || d.phong?.TenLoaiPhong || '';
        document.getElementById('kh-name-m').textContent = d.customer?.HoTen || d.khach_hang?.HoTen || '';
        const emailEl=document.getElementById('kh-email-m'); const email=d.customer?.Email || d.khach_hang?.Email || '';
        emailEl.textContent = email; emailEl.style.display = email ? '' : 'none';
        document.getElementById('bk-nhan-m').textContent = (d.booking?.NgayNhanPhong || '').slice(0,10);
        document.getElementById('bk-tra-m').textContent = (d.booking?.NgayTraPhong || '').slice(0,10);
        document.getElementById('bk-status-m').textContent = textBookingStatus(d.booking?.TrangThai);

        const payStatus=Number(d?.booking?.TrangThaiThanhToan);
        const oldServicesTitle=document.getElementById('title-old-label');
        if(oldServicesTitle) oldServicesTitle.textContent = (payStatus===2)?'Dịch vụ đã thanh toán trước':'Dịch vụ sử dụng';

        ensureSnapshotIfSettled_setup(d, id);
        const baseCounts = SNAPSHOT[id]?.baseCounts || null;

        const allLines = Array.isArray(d.invoice?.lines) ? d.invoice.lines : [];
        const { oldLines, newLines } = splitBySnapshot(allLines, baseCounts);
        renderLinesTable('service-lines-old', oldLines);
        const titleNew=document.getElementById('title-new'); const blockNew=document.getElementById('service-lines-new');
        if(payStatus===2){ titleNew.style.display=''; blockNew.style.display=''; renderLinesTable('service-lines-new', newLines); }
        else { titleNew.style.display='none'; blockNew.style.display='none'; blockNew.innerHTML=''; }

        const room=Number(d?.totals?.room_total||0);
        const deposit=Number(d?.totals?.deposit||0);
        const svcOld=oldLines.reduce((s,l)=>s+getLinePrice(l),0);
        const svcNew=newLines.reduce((s,l)=>s+getLinePrice(l),0);
        const svcTotal=svcOld+svcNew;
        const grandTotal=room+svcTotal;
        let paidPrev=0, additional=0, labelAdditional='Phát sinh mới (cần thu)';
        if(payStatus===2){ paidPrev=Math.max(0, room+svcOld-deposit); additional=Math.max(0, svcNew); }
        else if(payStatus===0){ const due=Number(d?.totals?.amount_due||0); paidPrev=deposit; additional=due; labelAdditional='Cần thu còn lại'; }
        else { const due=Number(d?.totals?.amount_due||0); paidPrev=Math.max(0, grandTotal-due); additional=due; labelAdditional='Cần thu còn lại'; }

        document.getElementById('t-room-m').textContent = money(room)+'đ';
        document.getElementById('t-service-m').textContent = money(svcTotal)+'đ';
        document.getElementById('t-grand-total-m').textContent = money(grandTotal)+'đ';
        document.getElementById('t-deposit-m').textContent = money(deposit)+'đ';
        document.getElementById('t-paid-prev').textContent = money(paidPrev)+'đ';
        document.getElementById('t-additional').textContent = money(additional)+'đ';
        document.getElementById('label-additional').textContent = labelAdditional;

        const rawPayText=textPayStatus(payStatus);
        const payText=(payStatus===2 && additional>0) ? 'Đã thanh toán trước • Phát sinh mới' : rawPayText;
        document.getElementById('bk-paystatus-m').textContent = payText;

        const statusSpan=document.getElementById('bk-status-m'); const paySpan=document.getElementById('bk-paystatus-m');
        const statusRow=statusSpan? statusSpan.closest('.mb-2'):null; const payRow=paySpan? paySpan.closest('.mb-2'):null;
        if(CURRENT_SCOPE==='inhouse'){ if(statusRow) statusRow.style.display=''; if(payRow) payRow.style.display='none'; }
        else if(CURRENT_SCOPE==='due_today'){ if(statusRow) statusRow.style.display='none'; if(payRow) payRow.style.display=''; }
        else { if(statusRow) statusRow.style.display=''; if(payRow) payRow.style.display=''; }

        const amountToCollect = (additional>0) ? additional : ((Number(d.booking?.TrangThaiThanhToan)!==2) ? Number(d?.totals?.amount_due||0) : 0);
        const btnQr=document.getElementById('btn-open-qr');
        if(btnQr){
          btnQr.dataset.amount=String(isFinite(amountToCollect)?amountToCollect:0);
          btnQr.dataset.addinfo = `Thanh toan tien phong P${roomNo} - ${d.booking?.IDDatPhong||id}`;
          btnQr.classList.toggle('d-none', !(amountToCollect>0));
          btnQr.disabled = !(amountToCollect>0);
        }
      }catch(e){ console.error('[loadDetailModal] error:', e); alert('Không thể tải chi tiết.'); }
    }

    // In hóa đơn (hotel style)
    const HOTEL = { name:'Khách sạn SNAKE', address:'140 Lê Trọng Tấn, Phường Tây Thạnh, TP.HCM', phone:'028 1234 5678', tax:'MST: 0123456789' };
    function diffNights(nhan,tra){ if(!nhan||!tra) return 1; try{ const d1=new Date(nhan), d2=new Date(tra); return Math.max(1, Math.round((d2-d1)/86400000)); } catch{ return 1; } }
    function groupServices(lines) {
      const map = new Map();
      (lines || []).forEach(l => {
        const name = l.TenDichVu || (l.IDDichVu ? `DV ${l.IDDichVu}` : 'Dịch vụ');
        const price = getLinePrice(l);
        const cur = map.get(name) || { qty: 0, total: 0 };
        cur.qty += 1; cur.total += price; map.set(name, cur);
      });
      return Array.from(map, ([name, v]) => ({
        name, qty: v.qty, unit: v.qty > 0 ? Math.round(v.total / v.qty) : v.total, total: v.total
      }));
    }
    function renderInvoiceHTML(d){
      const now=new Date(); const nowStr=`${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')} ${String(now.getDate()).padStart(2,'0')}/${String(now.getMonth()+1).padStart(2,'0')}/${now.getFullYear()}`;
      const roomNo=d?.room?.SoPhong || d?.phong?.SoPhong || d?.SoPhong || '';
      const roomType=d?.room?.TenLoaiPhong || d?.phong?.TenLoaiPhong || '';
      const guestName=d?.customer?.HoTen || d?.khach_hang?.HoTen || '';
      const checkin=(d?.booking?.NgayNhanPhong || '').slice(0,10);
      const checkout=(d?.booking?.NgayTraPhong || '').slice(0,10);
      const invoiceId=d?.booking?.IDDatPhong || d?.ID || '';
      const nights=diffNights(d?.booking?.NgayNhanPhong, d?.booking?.NgayTraPhong);
      const roomTotal=Number(d?.totals?.room_total || 0);
      const roomUnit=nights>0 ? Math.round(roomTotal/nights) : roomTotal;
      const lines=Array.isArray(d?.invoice?.lines) ? d.invoice.lines : [];
      const svcGrouped=groupServices(lines); const svcTotal=svcGrouped.reduce((s,it)=>s+Number(it.total||0),0);
      const deposit=Number(d?.totals?.deposit || 0);
      const grandTotal=roomTotal+svcTotal; const due=Number(d?.totals?.amount_due || 0);
      const paidPrev=Math.max(0, grandTotal - due);
      const note = getNoteFromDetail(d);

      const svcRows=svcGrouped.map((it,idx)=>`
        <tr>
          <td class="text-center">${idx+2}</td>
          <td>${escHtml(it.name)}</td>
          <td class="text-center">${it.qty}</td>
          <td class="text-end">${invMoney(it.unit)}</td>
          <td class="text-end">${invMoney(it.total)}</td>
        </tr>`).join('');

      return `
        <div class="invoice-box" id="invoiceBox">
          <div class="invoice-head">
            <div class="invoice-hotel">
              <div style="font-weight:700; font-size:13pt;">${escHtml(HOTEL.name)}</div>
              <div>${escHtml(HOTEL.address)}</div>
              <div>ĐT: ${escHtml(HOTEL.phone)}</div>
              <div>${escHtml(HOTEL.tax)}</div>
            </div>
            <div class="invoice-meta">
              <div class="invoice-title">PHIẾU THANH TOÁN</div>
              <div>Mã HĐ: ${escHtml(invoiceId)}</div>
              <div>Thời gian in: ${escHtml(nowStr)}</div>
            </div>
          </div>

          <div style="display:flex; justify-content:space-between; font-size: 10.5pt; margin-bottom:6px;">
            <div><div><strong>Phòng:</strong> ${escHtml(roomNo)} (${escHtml(roomType)})</div><div><strong>Nhận:</strong> ${escHtml(checkin)}</div></div>
            <div style="text-align:right;"><div><strong>Khách:</strong> ${escHtml(guestName)}</div><div><strong>Trả:</strong> ${escHtml(checkout)}</div></div>
          </div>

          ${note ? `<div style="font-size:10.5pt; margin-bottom:6px;"><strong>Ghi chú:</strong> ${escHtml(note)}</div>` : ''}

          <table class="invoice-table">
            <thead>
              <tr>
                <th style="width:50px;" class="text-center">#</th>
                <th>Nội dung</th>
                <th style="width:80px;" class="text-center">SL</th>
                <th style="width:130px;" class="text-end">Đơn giá</th>
                <th style="width:150px;" class="text-end">Thành tiền</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center">1</td>
                <td>Tiền phòng (${nights} đêm)</td>
                <td class="text-center">${nights}</td>
                <td class="text-end">${invMoney(roomUnit)}</td>
                <td class="text-end">${invMoney(roomTotal)}</td>
              </tr>
              ${svcRows || ''}
            </tbody>
          </table>

          <div class="invoice-summary">
            <div class="row"><span class="label">Tiền phòng</span><span class="value">${invMoney(roomTotal)}</span></div>
            <div class="row"><span class="label">Tiền dịch vụ</span><span class="value">${invMoney(svcTotal)}</span></div>
            <div class="row" style="border-top:1px dashed #d1e0ff; margin-top:6px; padding-top:6px;">
              <span class="label"><strong>Tổng cộng</strong></span><span class="value"><strong>${invMoney(grandTotal)}</strong></span>
            </div>
            <div class="row"><span class="label">Tiền cọc</span><span class="value">${invMoney(deposit)}</span></div>
            <div class="row"><span class="label">Đã thanh toán trước</span><span class="value">${invMoney(paidPrev)}</span></div>
            <div class="row" style="border-top:1px solid #d1e0ff; margin-top:6px; padding-top:6px;">
              <span class="label" style="font-weight:700; color:#dc2626;">Cần thu</span>
              <span class="value" style="font-weight:700; color:#dc2626;">${invMoney(due)}</span>
            </div>
          </div>

          <div class="invoice-footer">Xin cảm ơn Quý khách đã sử dụng dịch vụ!</div>
        </div>`;
    }
    function printInvoiceHotelStyle(){
      const d=window.CURRENT_DETAIL; if(!d){ alert('Vui lòng mở chi tiết trước khi in'); return; }
      const html=renderInvoiceHTML(d);
      const el=document.getElementById('invoicePrint'); el.innerHTML=html; el.classList.remove('d-none');
      window.print(); setTimeout(()=>{ el.classList.add('d-none'); el.innerHTML=''; }, 100);
    }

    // Form dịch vụ
    const addSvcModal = () => bootstrap.Modal.getOrCreateInstance(document.getElementById('addServiceModal'));
    window.openAddServiceModal = async function (id){
      currentId = id;
      await ensureSnapshotIfSettled(id); // chuẩn bị snapshot nếu đã settle
      const sel=document.getElementById('sel-service-modal');
      if (sel && sel.options.length) sel.selectedIndex=0;
      document.getElementById('service-qty-modal').value = 1;
      document.getElementById('service-time-modal').value = getCurrentDateTimeLocalString();
      updateHintMoney();
      addSvcModal().show();
    }
    function updateHintMoney(){
      const sel=document.getElementById('sel-service-modal');
      const qty=Math.max(1, Number(document.getElementById('service-qty-modal')?.value || 1));
      const iddv=sel?.value;
      const svc=(svcList||[]).find(s=>String(s.IDDichVu)===String(iddv));
      const price=Number(svc?.TienDichVu || 0);
      const hint=document.getElementById('hint-money'); if(hint) hint.textContent=`Tạm tính: ${money(price*qty)}đ`;
    }
    document.addEventListener('change', (e)=>{ if(e.target.id==='sel-service-modal' || e.target.id==='service-qty-modal') updateHintMoney(); });
    document.addEventListener('click', (e)=>{
      if(e.target.closest('#btn-qty-dec')){ const ip=document.getElementById('service-qty-modal'); ip.value=Math.max(1, Number(ip.value||1)-1); updateHintMoney(); }
      if(e.target.closest('#btn-qty-inc')){ const ip=document.getElementById('service-qty-modal'); ip.value=Math.max(1, Number(ip.value||1)+1); updateHintMoney(); }
    });
    async function addServiceForCurrent(){
      if(!currentId) return alert('Chưa chọn đặt phòng');
      const sel=document.getElementById('sel-service-modal');
      const iddv=sel.value;
      const qtyInput=document.getElementById('service-qty-modal');
      const qty=Math.max(1, Number(qtyInput.value || 1));
      const thoiGian=document.getElementById('service-time-modal').value;
      if(!thoiGian){ showToast('Vui lòng chọn thời gian thực hiện.', 'danger'); return; }
      const svc=(svcList||[]).find(s=>String(s.IDDichVu)===String(iddv));
      const name=svc?.TenDichVu || iddv;
      if(!confirm(`Xác nhận thêm dịch vụ: ${name}${qty>1?' x'+qty:''}?`)) return;
      const btn=document.getElementById('btn-add-service-confirm'); const oldHtml=btn.innerHTML; btn.disabled=true; btn.innerHTML=`<span class="spinner-border spinner-border-sm me-2"></span>Đang thêm...`;
      try{
        await axios.post(`${API_BASE}/checkout/${currentId}/add-service`, { IDDichVu: iddv, so_luong: qty, thoi_gian_thuc_hien: thoiGian });
        addAddedService(currentId, name, qty);
        renderServiceCell(currentId);
        showToast(`Đã thêm dịch vụ: ${name}${qty>1?' x'+qty:''}`, 'success');
        addSvcModal().hide();
        // Reload chi tiết để cập nhật tổng tiền ngay nếu đang mở
        if (document.getElementById('detailModal')?.classList.contains('show')) {
          try { await loadDetailModal(currentId); } catch {}
        }
      }catch(e){ console.error(e); const msg=e?.response?.data?.message || 'Không thể thêm dịch vụ.'; showToast(msg,'danger',3000); }
      finally{ btn.disabled=false; btn.innerHTML=oldHtml; }
    }

    // Lưu ghi chú (cập nhật CURRENT_DETAIL + disable nút khi không đổi)
    async function saveNoteModalOnly() {
      if (!currentId) return alert('Chưa chọn đặt phòng');
      const noteInput = document.getElementById('invoice-note-m');
      const note = noteInput?.value ?? '';
      try {
        await axios.put(`${API_BASE}/checkout/${currentId}/note`, { GhiChu: note });
        if (!window.CURRENT_DETAIL) window.CURRENT_DETAIL = {};
        if (!window.CURRENT_DETAIL.invoice) window.CURRENT_DETAIL.invoice = {};
        window.CURRENT_DETAIL.invoice.GhiChu = note;
        if (noteInput) {
          noteInput.dataset.orig = note;
          const saveBtn = document.getElementById('btn-save-note-m');
          if (saveBtn) saveBtn.disabled = true;
        }
        showToast('Đã lưu ghi chú', 'success');
      } catch (e) {
        console.error(e);
        showToast('Lỗi lưu ghi chú', 'danger');
      }
    }

    // Debounce + Bind events
    function debounce(fn, t=300){ let id; return (...a)=>{ clearTimeout(id); id=setTimeout(()=>fn.apply(this,a),t); }; }
    document.getElementById('btn-refresh').onclick = loadList;
    document.getElementById('btn-add-service-confirm').onclick = addServiceForCurrent;
    document.getElementById('btn-save-note-m').onclick = saveNoteModalOnly;
    document.getElementById('btn-pay-m').onclick = pay;
    document.getElementById('btn-complete-m').onclick = complete;
    document.getElementById('btn-print-m').onclick = printInvoiceHotelStyle;

    const scopeSel=document.getElementById('filter-scope');
    const dateInput=document.getElementById('filter-date');
    const qInput=document.getElementById('filter-q');
    scopeSel.addEventListener('change', debounce(loadList,120));
    dateInput.addEventListener('change', debounce(loadList,120));
    qInput.addEventListener('input', debounce(loadList,300));
    qInput.addEventListener('keydown', e=>{ if(e.key==='Enter'){ e.preventDefault(); loadList(); } });

    // Thanh toán/Hoàn tất
    async function pay(){
      if(!currentId) return alert('Chưa chọn đặt phòng');
      if(!confirm('Xác nhận thu tiền?')) return;
      try{
        await axios.post(`${API_BASE}/checkout/${currentId}/pay`);
        try{
          const rs2=await axios.get(`${API_BASE}/checkout/${currentId}`);
          const d2=rs2.data?.data || {};
          SNAPSHOT[currentId] = { baseCounts: buildMulti(d2?.invoice?.lines || []) };
          SERVICES_CACHE.delete(currentId); await fetchServerServices(currentId); renderServiceCell(currentId);
        }catch{}
        await loadDetailModal(currentId);
        if(typeof loadList==='function') await loadList();
        showToast('Đã ghi nhận thanh toán', 'success');
      }catch{ showToast('Không thể ghi nhận thanh toán.','danger'); }
    }
    async function complete(){
      if(!currentId) return alert('Chưa chọn đặt phòng');
      try{
        const check=await axios.get(`${API_BASE}/checkout/${currentId}`);
        const d=check.data?.data || {};
        const baseCounts=SNAPSHOT[currentId]?.baseCounts || null;
        const { newLines }=splitBySnapshot(d?.invoice?.lines || [], baseCounts);
        const additional=newLines.reduce((s,l)=>s+getLinePrice(l),0);
        const due=Number(d?.totals?.amount_due || 0);
        if((baseCounts && additional>0) || (!baseCounts && due>0)){
          if(!confirm('Còn tiền phải thu. Thu tiền và in hóa đơn trước khi hoàn tất?')) return;
          await axios.post(`${API_BASE}/checkout/${currentId}/pay`);
          printInvoiceHotelStyle();
          try{
            const rs2=await axios.get(`${API_BASE}/checkout/${currentId}`);
            const d2=rs2.data?.data || {};
            SNAPSHOT[currentId] = { baseCounts: buildMulti(d2?.invoice?.lines || []) };
          }catch{}
        }
        if(!confirm('Xác nhận hoàn tất trả phòng?')) return;
        await axios.post(`${API_BASE}/checkout/${currentId}/complete`);
        if(typeof loadList==='function') await loadList();
        if(document.getElementById('detailModal')?.classList.contains('show')) await loadDetailModal(currentId);
        showToast('Đã hoàn tất thanh toán','success');
      }catch{ showToast('Không thể hoàn tất thanh toán.','danger'); }
    }

    document.addEventListener('DOMContentLoaded', async ()=>{
      document.getElementById('filter-date').value = todayStr();
      document.getElementById('filter-scope').value = 'inhouse';
      CURRENT_SCOPE='inhouse';
      await loadServices();
      await loadList();
    });
  </script>
@endsection