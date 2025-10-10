<div class="container mt-4" data-init="initPhong" data-page="phong">
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