<!-- Action-area and modals (captured once) -->
<div class="row g-4" data-init="initTiennghi" data-page="tiennghi">
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

<!-- Modals: include the modals so the partial works when injected via AJAX -->

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
