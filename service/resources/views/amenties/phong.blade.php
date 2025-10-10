

<!-- Legacy full-page HTML removed. Use the AJAX-capable view 'amenties.phong_v2' instead. -->
              <li>
                <!-- Legacy Phòng view removed. Use 'amenties.phong_v2' which supports AJAX partial rendering. -->
                @php /* placeholder to avoid legacy layout injection */ @endphp
                        <div class="d-flex align-items-center py-2">
                          <img src="assets/images/user3.png" class="img-3x me-3 rounded-5" alt="Web Dashboards" />
                          <div class="m-0">
                            <h4 class="mb-2">$330.00</h4>
                            <h6 class="mb-1">Sky Labs</h6>
                            <p class="m-0 small">
                              Invoice #99888<span class="badge bg-primary ms-2">Paid</span>
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="dropdown-item">
                        <div class="d-flex align-items-center py-2">
                          <img src="assets/images/user4.png" class="img-3x me-3 rounded-5" alt="Web Dashboards" />
                          <div class="m-0">
                            <h4 class="mb-2">$380.00</h4>
                            <h6 class="mb-1">Good Works Inc</h6>
                            <p class="m-0 small">
                              Invoice #99889<span class="badge bg-primary ms-2">Paid</span>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-grid m-3">
                      <a href="javascript:void(0)" class="btn btn-primary">View all</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="dropdown ms-4">
                <a id="userSettings" class="dropdown-toggle d-flex py-2 align-items-center" href="#!" role="button"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="assets/images/user3.png" class="rounded-4 img-3x" alt="Bootstrap Gallery" />
                  <div class="ms-2 text-truncate d-lg-flex flex-column d-none">
                    <p class="text-truncate m-0">Noble Moss</p>
                    <span class="small opacity-50 lh-1">Admin</span>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow-lg">
                  <a class="dropdown-item d-flex align-items-center" href="profile.html"><i
                      class="bi bi-person fs-5 me-2"></i>My Profile</a>
                  <a class="dropdown-item d-flex align-items-center" href="settings.html"><i
                      class="bi bi-gear fs-5 me-2"></i>Settings</a>
                  <a class="dropdown-item d-flex align-items-center" href="reset-password.html"><i
                      class="bi bi-slash-circle fs-5 me-2"></i>Reset Password</a>
                  <div class="mx-3 mt-2 d-grid">
                    <a href="login.html" class="btn btn-primary">Logout</a>
                  </div>
                </div>
              </div>
              <div class="d-flex">
                <button class="toggle-sidebar">
                  <i class="bi bi-list lh-1"></i>
                </button>
              </div>
            </div>
            <!-- App header actions ends -->

          </div>
          <!-- App header ends -->

          <!-- App body starts -->
          <div class="app-body">

            <!-- Row starts -->
            
            <!-- Row ends -->

         <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phòng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="m-0">Danh sách phòng</h3>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered rounded-3" style="border-collapse: separate; border-spacing: 0;">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center py-2" style="width:5%;">STT</th>
                            <th class="text-center py-2" style="width:8%;">ID Loại phòng</th>
                            <th class="text-center py-2" style="width:8%;">Số phòng</th>
                            <th class="text-center py-2" style="width:10%;">Tên loại phòng</th>
                            <th class="text-center py-2" style="width:15%;">Mô tả</th>
                            <th class="text-center py-2" style="width:8%;">Giá phòng</th>
                            <th class="text-center py-2" style="width:8%;">Số người tối đa</th>
                            <th class="text-center py-2" style="width:8%;">Xếp hạng</th>
                            <th class="text-center py-2" style="width:8%;">Trạng thái</th>
                            <th class="text-center py-2" style="width:7%;">Ảnh phòng</th>
                        </tr>
                    </thead>
                    <tbody id="roomTableBody">
                        <!-- Dữ liệu sẽ được load bằng JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="app-footer text-center mb-3">
    <span class="small">© Bootstrap Gallery 2024</span>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async function() {
    try {
        const response = await axios.get('/api/phongs', { headers: { 'Accept': 'application/json' } });
        // Dòng này sẽ nhận đúng dữ liệu dù API trả về mảng trực tiếp hay có key data
        const rooms = Array.isArray(response.data) ? response.data : (response.data.data || []);
        const tbody = document.getElementById('roomTableBody');
        tbody.innerHTML = '';

        if (rooms.length === 0) {
            tbody.innerHTML = '<tr><td colspan="10" class="text-center py-3">Không có phòng nào.</td></tr>';
            return;
        }

        const fragment = document.createDocumentFragment();

        rooms.forEach((room, index) => {
            const tr = document.createElement('tr');
            tr.classList.add('align-middle');

            // Hiển thị xếp hạng sao
            let stars = '';
            if (room.XepHangSao) {
                for (let i = 0; i < room.XepHangSao; i++) {
                    stars += '<i class="bi bi-star-fill text-warning"></i>';
                }
            } else {
                stars = '<span class="text-muted">N/A</span>';
            }

            tr.innerHTML = `
                <td class="text-center">${index + 1}</td>
                <td class="text-center">${room.IDLoaiPhong || 'N/A'}</td>
                <td class="text-center">${room.SoPhong || 'N/A'}</td>
                <td class="text-center">${room.TenPhong || 'N/A'}</td>
                <td class="text-center">${room.MoTa || 'N/A'}</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">${stars}</td>
                <td class="text-center">${room.TrangThai || 'N/A'}</td>
                <td class="text-center">
                    <img src="${room.UrlAnhPhong ? 'HomePage/img/slider/' + room.UrlAnhPhong : 'HomePage/img/slider/default.jpg'}"
                         width="60" height="60"
                         class="rounded"
                         loading="lazy"
                         alt="Hình ảnh phòng"
                         onerror="this.src='https://picsum.photos/60/60';">
                </td>
            `;

            fragment.appendChild(tr);
        });

        tbody.appendChild(fragment);
    } catch (error) {
        console.error('Lỗi API:', error.response ? error.response.data : error.message);
        alert('Không thể tải danh sách phòng. Vui lòng kiểm tra console (F12).');
    }
});
</script>

    <!-- Page wrapper ends -->

    <!-- *************
			************ JavaScript Files *************
		************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/moment.min.js"></script>

    <!-- *************
			************ Vendor Js Files *************
		************* -->

    <!-- Overlay Scroll JS -->
    <script src="assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/vendor/overlay-scroll/custom-scrollbar.js"></script>

    <!-- Apex Charts -->
    <script src="assets/vendor/apex/apexcharts.min.js"></script>
    <script src="assets/vendor/apex/custom/home/sparkline.js"></script>
    <script src="assets/vendor/apex/custom/home/revenue.js"></script>
    <script src="assets/vendor/apex/custom/home/sales.js"></script>
    <script src="assets/vendor/apex/custom/home/income.js"></script>
    <script src="assets/vendor/apex/custom/home/visits-conversions.js"></script>

    <!-- Rating -->
    <script src="assets/vendor/rating/raty.js"></script>
    <script src="assets/vendor/rating/raty-custom.js"></script>

    <!-- Custom JS files -->
    <script src="assets/js/custom.js"></script>
  </body>


<!-- Mirrored from www.bootstrapget.com/demos/templatemonster/adminlite-bootstrap-admin-panel/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 25 Nov 2024 15:56:54 GMT -->
</html>