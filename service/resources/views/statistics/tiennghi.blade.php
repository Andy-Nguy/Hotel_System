@extends('layouts.layout2')

@section('title', 'Tiện nghi')

{{-- (MỚI) Thêm CSS để đồng bộ UI --}}
@push('styles')
<style>
    /* === Styles đồng bộ từ Checkout === */
    .form-label.styled {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: #1e3a8a;
        font-weight: 600;
        letter-spacing: 0.3px;
        font-size: 0.9rem;
        margin-bottom: 4px;
        /* Consistent spacing */
    }

    .form-control.styled,
    .form-select.styled {
        border: 1px solid #d1e0ff;
        background: #ffffff;
        color: #1e3a8a;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        border-radius: 10px;
        padding: 0.6rem;
        font-size: 0.95rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        /* Subtle shadow */
    }

    .form-control.styled:focus,
    .form-select.styled:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
        outline: none;
        background: #f9fbff;
    }

    .input-group-text.styled {
        background: #ffffff;
        border: 1px solid #d1e0ff;
        color: #60a5fa;
        transition: all 0.3s ease;
        border-radius: 10px 0 0 10px;
        padding: 0.6rem;
    }

    .form-control.styled.in-group {
        border-radius: 0 10px 10px 0;
        border-left: 0;
    }

    .form-select.styled.in-group {
        /* Specific for selects in group */
        border-radius: 0 10px 10px 0;
        border-left: 0;
    }

    .input-group-text.styled.bg-primary {
        /* Specific for colored icons */
        background: #60a5fa;
        border-color: #60a5fa;
        color: white;
    }

    .btn.styled {
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        border-radius: 10px;
        padding: 0.6rem 1.2rem;
        font-size: 0.95rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
    }

    .btn-sm.styled {
        /* Adjust padding for small buttons */
        padding: 0.35rem 0.8rem;
        font-size: 0.85rem;
    }

    .btn-primary.styled {
        background: linear-gradient(90deg, #60a5fa, #93c5fd);
        border: none;
        color: #ffffff;
    }

    .btn-primary.styled:hover {
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-primary.styled:disabled {
        background: linear-gradient(90deg, #a5b4fc, #c7d2fe);
        opacity: 0.7;
        cursor: not-allowed;
    }


    .btn-outline-secondary.styled,
    .btn-outline-primary.styled,
    .btn-outline-dark.styled,
    .btn-outline-danger.styled {
        border: 1px solid #d1e0ff;
        color: #1e3a8a;
        background-color: #fff;
        /* Ensure bg for shadow */
    }

    .btn-outline-secondary.styled:hover,
    .btn-outline-primary.styled:hover,
    .btn-outline-dark.styled:hover {
        background: #e6f0ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-outline-danger.styled {
        color: #dc3545;
        border-color: #f8d7da;
    }

    .btn-outline-danger.styled:hover {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
    }

    /* Button group styling */
    .btn-group.styled .btn {
        border-radius: 10px !important;
        /* Individual radius, force override */
        margin-right: 0.25rem;
        /* Spacing between buttons */
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        /* Subtle shadow */
    }

    .btn-group.styled .btn:last-child {
        margin-right: 0;
    }

    /* (SỬA) Style active cho button group */
    .btn-group.styled .btn.active {
        background-color: #60a5fa;
        color: white;
        border-color: #60a5fa !important;
        /* Quan trọng: Ghi đè border */
        box-shadow: 0 2px 5px rgba(96, 165, 250, 0.3);
    }


    .table-styled {
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border-collapse: separate;
        /* Needed for border-radius */
        border-spacing: 0;
    }

    .table-styled thead {
        background: linear-gradient(90deg, #60a5fa, #93c5fd);
        color: #ffffff;
    }

    .table-styled th {
        padding: 0.8rem;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        /* Ngăn header xuống dòng */
    }

    .table-styled tbody td {
        text-align: center;
        vertical-align: middle;
        padding: 0.6rem;
        /* Giảm padding body */
    }

    .table-styled th.sortable {
        cursor: pointer;
        user-select: none;
    }

    /* (SỬA) Style mũi tên sort rõ ràng hơn */
    .table-styled th.sortable::after {
        content: ' ';
        display: inline-block;
        width: 1em;
        height: 1em;
        margin-left: .3em;
        vertical-align: -.2em;
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23a0aec0'%3e%3cpath fill-rule='evenodd' d='M4.646 9.646a.5.5 0 0 1 .708 0L8 12.293l2.646-2.647a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 0-.708zM8 4a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5A.5.5 0 0 1 8 4zM4.646 6.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8 3.707 5.354 6.354a.5.5 0 0 1-.708 0z'/%3e%3c/svg%3e");
        opacity: 0.5;
    }

    .table-styled th.sortable.asc::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath fill-rule='evenodd' d='M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z'/%3e%3c/svg%3e");
        opacity: 0.9;
    }

    .table-styled th.sortable.desc::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath fill-rule='evenodd' d='M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z'/%3e%3c/svg%3e");
        opacity: 0.9;
    }

    .table-styled td.text-start {
        text-align: left !important;
    }

    .table-styled th.text-start {
        text-align: left !important;
    }

    .table-styled td.text-end {
        text-align: right !important;
    }

    .table-styled th.text-end {
        text-align: right !important;
    }

    /* Modal Styling */
    .modal-content.styled {
        border-radius: 16px;
        border: none;
        background: linear-gradient(180deg, #f9fbff, #e6f0ff);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .modal-header.styled {
        border-bottom: 1px solid #d1e0ff;
        position: relative;
        padding: 0.75rem 1.25rem;
    }

    .modal-header.styled .modal-title {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        color: #1e3a8a;
        font-size: 1.1rem;
    }

    .modal-header.styled .decorator-line {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #60a5fa, #a78bfa);
    }

    .modal-footer.styled {
        border-top: 1px solid #d1e0ff;
        padding: 0.75rem 1.25rem;
    }

    .modal-body.styled .form-label {
        font-family: 'Inter', sans-serif;
        color: #1e3a8a;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .modal-body.styled .form-control,
    .modal-body.styled .form-select {
        border: 1px solid #d1e0ff;
        background: #ffffff;
        color: #1e3a8a;
        border-radius: 10px;
        padding: 0.6rem;
    }

    .modal-body.styled .form-control:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
        background: #f9fbff;
    }

    .modal-footer.styled .btn-danger {
        /* Nút Xóa trong modal footer */
        background: linear-gradient(90deg, #ef4444, #f87171);
        border: none;
        color: white;
    }

    .modal-footer.styled .btn-danger:hover {
        background: linear-gradient(90deg, #dc2626, #ef4444);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
    }


    /* === End Styles đồng bộ === */

    /* Tab styling */
    .nav-pills .nav-link {
        border-radius: 10px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        transition: all 0.3s ease;
        color: #1e3a8a;
        margin-right: 0.5rem;
        background-color: #e0e7ff;
        /* Lighter inactive */
        border: 1px solid #c7d2fe;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        color: #fff;
        background: linear-gradient(90deg, #60a5fa, #93c5fd);
        box-shadow: 0 4px 12px rgba(96, 165, 250, 0.4);
        /* Stronger shadow */
        border: 1px solid transparent;
        /* Remove border on active */
        transform: translateY(-1px);
        /* Slight lift */
    }

    .nav-pills .nav-link:hover:not(.active) {
        background-color: #c7d2fe;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }


    /* Checkbox list container */
    .form-check-box-list {
        max-height: 320px;
        overflow-y: auto;
        border: 1px solid #d1e0ff;
        /* Match input border */
        border-radius: 10px;
        /* Match input radius */
        padding: .75rem;
        /* Increased padding */
        background: #fff;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
        /* Inner shadow */
    }

    .form-check-box-list.disabled {
        pointer-events: none;
        opacity: .6;
        background-color: #f8f9fa;
    }

    .form-check-box-list .form-check:not(:last-child) {
        margin-bottom: 0.35rem;
    }

    /* Spacing between checkboxes */
    .form-check-box-list .form-check-label {
        cursor: pointer;
    }

    /* Cursor pointer for labels */


    /* Overlay loading */
    .table-overlay,
    .assign-overlay {
        position: absolute;
        inset: 0;
        background: rgba(249, 251, 255, .85);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        border-radius: 12px;
        backdrop-filter: blur(2px);
        /* Blur effect */
    }

    /* Amenity label clickable filter in rooms table */
    #tablePhong .amenity-label {
        display: inline-block;
        background-color: #e0e7ff;
        color: #1e3a8a;
        padding: 3px 10px;
        border-radius: 12px;
        margin: 2px;
        font-size: .8rem;
        cursor: pointer;
        border: 1px solid #c7d2fe;
        transition: all 0.2s ease;
    }

    #tablePhong .amenity-label:hover {
        background-color: #c7d2fe;
        transform: translateY(-1px);
    }

    /* Toolbar sticky trong khu vực gán */
    .assign-toolbar {
        position: sticky;
        top: -1px;
        background: rgba(249, 251, 255, 0.9);
        backdrop-filter: blur(4px);
        z-index: 5;
        padding: .65rem 0;
        border-bottom: 1px solid #d1e0ff;
        margin-bottom: 0.75rem !important;
    }

    /* Nâng cấp toolbar */

    /* Chip tiện nghi hiện tại */
    #currentAssigned .amenity-chip {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        background: linear-gradient(90deg, #60a5fa, #93c5fd);
        color: #fff;
        border-radius: 16px;
        padding: 3px 10px;
        margin: 3px;
        font-size: .85rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    #currentAssigned .amenity-chip .remove {
        cursor: pointer;
        opacity: .7;
        font-weight: bold;
        font-size: 1.1em;
        line-height: 1;
    }

    /* Tăng kích thước nút X */
    #currentAssigned .amenity-chip .remove:hover {
        opacity: 1;
        transform: scale(1.1);
    }

    /* Hiệu ứng hover */

    /* Assign select row styling */
    .assign-select-row .form-label {
        font-weight: 600;
        color: #1e3a8a;
    }

    /* Use styled color */
    .assign-select-row .form-select {
        font-size: 1rem;
        padding: 0.75rem 1rem;
    }

    /* Larger selects */
    .assign-select-row .input-group-text i {
        line-height: 1;
        font-size: 1.1rem;
    }

    .form-select:disabled {
        background-color: #f8f9fa !important;
        border: 1px solid #d1e0ff;
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    {{-- khu vực hiển thị alert --}}
    <div id="alertArea"></div>

    <!-- Tabs điều hướng -->
    <ul class="nav nav-pills mb-4" id="amenitiesTabs" role="tablist"> {{-- Tăng mb --}}
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-manage-tab" data-bs-toggle="pill" data-bs-target="#tab-manage" type="button" role="tab">
                <i class="bi bi-gear-fill me-1"></i> Quản lý & gán tiện nghi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-rooms-tab" data-bs-toggle="pill" data-bs-target="#tab-rooms" type="button" role="tab">
                <i class="bi bi-door-open-fill me-1"></i> Phòng & tiện nghi
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Tab 1: Quản lý & gán -->
        <div class="tab-pane fade show active" id="tab-manage" role="tabpanel" aria-labelledby="tab-manage-tab">
            <div class="row g-4"> {{-- Tăng khoảng cách g --}}
                <div class="col-lg-6">
                    {{-- (ĐÃ SỬA) Card Danh sách tiện nghi --}}
                    <div class="card border-0 shadow-lg" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
                        <div class="card-body py-4 px-4" style="position: relative;">
                            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="form-label styled mb-0" style="font-size: 1.1rem;">
                                    <i class="bi bi-list-stars me-2" style="color: #60a5fa;"></i> Danh sách tiện nghi
                                    <span class="badge bg-secondary rounded-pill ms-2 px-2" id="amenitiesCount">0</span> {{-- Rounded pill badge --}}
                                </h5>
                                <button id="btnOpenCreate" class="btn btn-primary btn-sm styled shadow-sm">
                                    <i class="bi bi-plus-lg me-1"></i> Thêm
                                </button>
                            </div>

                            <!-- input-group search + clear -->
                            <div class="input-group mb-3">
                                <span class="input-group-text styled"><i class="bi bi-search"></i></span>
                                <input type="text" id="searchTienNghi" class="form-control styled in-group shadow-sm" placeholder="Tìm tiện nghi...">
                                <button class="btn btn-outline-secondary styled shadow-sm" id="clearSearchTienNghi" title="Xóa tìm kiếm" style="border-radius: 0 10px 10px 0; border-left-width: 0;">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>

                            <!-- Lọc nhanh + sắp xếp -->
                            <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                                <div class="btn-group btn-group-sm styled" role="group" aria-label="filters">
                                    <button class="btn btn-outline-secondary styled active filter-tn" data-filter="all">Tất cả</button>
                                    <button class="btn btn-outline-secondary styled filter-tn" data-filter="selected">Đã chọn</button>
                                    <button class="btn btn-outline-secondary styled filter-tn" data-filter="unselected">Chưa chọn</button>
                                </div>
                                <div class="ms-md-auto d-flex align-items-center gap-2">
                                    <span class="small text-muted">Sắp xếp:</span>
                                    {{-- Nút sắp xếp riêng biệt --}}
                                    <div class="btn-group btn-group-sm styled" role="group" aria-label="sort">
                                        {{-- (SỬA) Bỏ icon mặc định, JS sẽ thêm icon --}}
                                        <button class="btn btn-outline-dark styled sort-tn" data-key="IDTienNghi">ID</button>
                                        <button class="btn btn-outline-dark styled sort-tn active" data-key="TenTienNghi">Tên</button>
                                    </div>
                                </div>
                            </div>

                            <div class="position-relative" id="amenitiesTableWrap">
                                {{-- Table style --}}
                                <table class="table table-hover align-middle m-0 table-styled" id="tableTienNghi">
                                    <thead>
                                        <tr>
                                            <th id="thTnId" class="sortable text-start" style="width: 20%;">ID</th>
                                            <th id="thTnName" class="sortable text-start asc" style="width: 55%;">Tên tiện nghi</th> {{-- Mặc định sort tên --}}
                                            <th class="text-end" style="width: 25%;">Thao tác</th>
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
                </div>

                <div class="col-lg-6">
                    {{-- Card Gán tiện nghi --}}
                    <div class="card border-0 shadow-lg" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
                        <div class="card-body py-4 px-4 position-relative">
                            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>

                            <h5 class="form-label styled mb-3" style="font-size: 1.1rem;"><i class="bi bi-node-plus-fill me-2" style="color: #60a5fa;"></i>Gán tiện nghi cho phòng</h5>

                            <div class="row g-3 align-items-end mb-3 assign-select-row">
                                <div class="col-md-6">
                                    <label class="form-label styled mb-1">Loại phòng</label>
                                    <div class="input-group">
                                        <span class="input-group-text styled bg-primary"><i class="bi bi-building"></i></span>
                                        {{-- Select style --}}
                                        <select id="selectLoaiPhongAssign" class="form-select styled in-group shadow-sm"></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label styled mb-1">Phòng</label>
                                    <div class="input-group">
                                        <span class="input-group-text styled bg-primary"><i class="bi bi-door-closed"></i></span>
                                        <select id="selectPhong" class="form-select styled in-group shadow-sm" disabled></select>
                                    </div>
                                </div>
                            </div>

                            {{-- Thông tin chọn lựa style --}}
                            <div id="assignSelectionInfo" class="alert alert-light border-light-subtle py-2 px-3 small mb-3 shadow-sm" role="alert" style="background-color: #e6f0ff; border-color: #d1e0ff !important;">
                                <i class="bi bi-info-circle me-1 text-primary"></i> Chưa chọn loại phòng/phòng.
                            </div>


                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="applyAllInType" disabled style="cursor: pointer; transform: scale(1.1);"> {{-- Scale switch --}}
                                <label class="form-check-label" for="applyAllInType" id="applyAllLabel" style="cursor: pointer;">
                                    Áp dụng cho tất cả phòng thuộc loại đã chọn
                                </label>
                            </div>

                            <div class="mb-3">
                                <input type="text" id="filterCheckbox" class="form-control styled mb-2 shadow-sm" placeholder="Tìm tiện nghi trong danh sách...">

                                <!-- sticky toolbar -->
                                <div class="assign-toolbar d-flex justify-content-between align-items-center">
                                    <div class="btn-group btn-group-sm styled" role="group">
                                        <button class="btn btn-outline-primary styled" id="btnSelectAll">
                                            <i class="bi bi-check2-square me-1"></i>Chọn hết
                                        </button>
                                        <button class="btn btn-outline-secondary styled" id="btnClearAll">
                                            <i class="bi bi-square me-1"></i>Bỏ hết
                                        </button>
                                        <button class="btn btn-outline-dark styled" id="btnInvert">
                                            <i class="bi bi-shuffle me-1"></i>Đảo chọn
                                        </button>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="small text-muted">Đã chọn: <b id="selectedCount">0</b></span>
                                        <span id="unsavedBadge" class="badge bg-warning text-dark border border-warning-subtle rounded-pill d-none">Chưa lưu</span> {{-- Rounded pill badge --}}
                                    </div>
                                </div>

                                <div id="checkboxTienNghiList" class="form-check-box-list"></div>
                            </div>

                            <div class="mb-3">
                                <strong class="form-label styled">Tiện nghi hiện tại của phòng:</strong>
                                <div id="currentAssigned" class="mt-1"></div>
                            </div>
                            <button id="btnSaveAssign" class="btn btn-primary styled w-100 shadow-sm" disabled>Lưu gán tiện nghi</button>

                            <!-- overlay loading -->
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
            <div class="row">
                <div class="col-12">
                    {{-- Card Bảng phòng --}}
                    <div class="card border-0 shadow-lg" style="border-radius: 16px; overflow: hidden; background: linear-gradient(180deg, #f9fbff, #e6f0ff);">
                        <div class="card-body py-4 px-4" style="position: relative;">
                            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #60a5fa, #a78bfa);"></div>

                            <h5 class="form-label styled mb-3" style="font-size: 1.1rem; display:flex; align-items:center; gap:.5rem;">
                                <i class="bi bi-door-open-fill" style="color: #60a5fa;"></i>
                                <span>Danh sách phòng và tiện nghi</span>
                                <span class="badge bg-secondary rounded-pill ms-1 px-2" id="roomsCount">0</span>
                            </h5>

                            {{-- Style chip lọc --}}
                            <div id="roomFilterChips" class="mb-3"></div>
                            <!-- input-group search + clear -->
                            <div class="input-group mb-3">
                                <span class="input-group-text styled"><i class="bi bi-search"></i></span>
                                <input type="text" id="searchPhong" class="form-control styled in-group shadow-sm" placeholder="Tìm phòng...">
                                <button class="btn btn-outline-secondary styled shadow-sm" id="clearSearchPhong" title="Xóa tìm kiếm" style="border-radius: 0 10px 10px 0; border-left-width: 0;">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                            <div class="position-relative" id="roomsTableWrap">
                                {{-- Table style --}}
                                <table class="table table-hover align-middle m-0 table-styled" id="tablePhong">
                                    <thead>
                                        <tr>
                                            <th id="thRoomId" class="sortable" style="width: 5%;">ID</th>
                                            <th id="thRoomSoPhong" class="sortable" style="width: 10%;">Số phòng</th>
                                            <th id="thRoomLoai" class="sortable" style="width: 15%;">Loại phòng</th>
                                            <th id="thRoomTrangThai" class="sortable" style="width: 10%;">Trạng thái</th>
                                            <th style="width: 60%;">Tiện nghi</th>
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

<!-- (ĐÃ SỬA) Modal Create/Edit Tiện nghi -->
<div class="modal fade" id="modalCreateEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content styled">
            <div class="modal-header styled">
                <h5 class="modal-title" id="modalTitle">Thêm tiện nghi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                <div class="decorator-line"></div>
            </div>
            <div class="modal-body styled">
                <input type="hidden" id="tnId" />
                <div class="mb-3">
                    <label for="TenTienNghi" class="form-label">Tên tiện nghi</label> {{-- Thêm for --}}
                    <input type="text" id="TenTienNghi" class="form-control" placeholder="VD: Điều hòa, Ấm đun nước..." required /> {{-- Thêm required --}}
                </div>
            </div>
            <div class="modal-footer styled">
                <button type="button" class="btn btn-outline-secondary styled" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary styled" id="btnSubmitCreateEdit">Lưu</button>
            </div>
        </div>
    </div>
</div>

<!-- (ĐÃ SỬA) Modal Confirm Delete Tiện nghi -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content styled">
            <div class="modal-header styled">
                <h5 class="modal-title">Xóa tiện nghi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button> {{-- Thêm aria-label --}}
                <div class="decorator-line"></div>
            </div>
            <div class="modal-body styled">
                <p>Bạn chắc chắn muốn xóa tiện nghi: <strong id="deleteName"></strong>?</p>
                <input type="hidden" id="deleteId" />
                <div class="small text-danger"> {{-- Dùng text-danger --}}
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    Lưu ý: Các gán tiện nghi của phòng sẽ được gỡ tự động.
                </div>
            </div>
            <div class="modal-footer styled">
                <button type="button" class="btn btn-outline-secondary styled" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger styled" id="btnConfirmDelete">Xóa</button> {{-- Dùng class styled --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- (SCRIPT JS GIỮ NGUYÊN) --}}
<script>
    const API_BASE = '/api';
    let ALL_TIEN_NGHI = [];
    let SELECTED_TN_IDS = [];
    let PHONG_TABLE = [];
    let ALL_LOAI_PHONG = [];

    // Trạng thái UI
    let AMENITY_FILTER_MODE = 'all'; // all | selected | unselected
    let SORT_STATE = {
        tn: { key: 'TenTienNghi', dir: 'asc' },
        rooms: { key: 'IDPhong', dir: 'asc' }
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
            TenTienNghi: x.TenTienNghi,
            isLocked: !!x.isLocked
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
    function isAmenityLockedLocal(id) {
        try {
            // Fallback compute: if any room with this amenity is not 'Trống'
            const idStr = String(id);
            for (const p of PHONG_TABLE || []) {
                const st = (p.TrangThai || '').toLowerCase();
                if (st && st !== 'trống' && st !== 'trong' && st !== 'phòng trống') {
                    const tns = Array.isArray(p.TienNghis) ? p.TienNghis : [];
                    if (tns.some(t => String(t.IDTienNghi) === idStr)) return true;
                }
            }
        } catch (e) { /* noop */ }
        return false;
    }

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
                const locked = (typeof x.isLocked !== 'undefined') ? !!x.isLocked : isAmenityLockedLocal(x.IDTienNghi);
                html += `<tr>
					<td>${x.IDTienNghi}</td>
					<td>${x.TenTienNghi}</td>
					<td class="text-end">
						<button class="btn btn-sm btn-outline-primary btn-edit me-1" data-id="${x.IDTienNghi}" data-name="${x.TenTienNghi}" ${locked ? 'disabled title="Không thể sửa khi đang được phòng sử dụng"' : ''}><i class="bi bi-pencil"></i></button>
						<button class="btn btn-sm btn-outline-danger btn-delete" data-id="${x.IDTienNghi}" ${locked ? 'disabled title="Không thể xóa khi đang được phòng sử dụng"' : ''}><i class="bi bi-trash"></i></button>
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
            if ($(this).prop('disabled')) {
                showAlert('warning', 'Không thể sửa tiện nghi đang được phòng sử dụng. Chỉ phòng trống mới cho phép.');
                return;
            }
            $('#tnId').val(id);
            $('#TenTienNghi').val(name);
            $('#modalTitle').text('Sửa tiện nghi');
            new bootstrap.Modal(document.getElementById('modalCreateEdit')).show();
        });
        $('.btn-delete').on('click', function() {
            const id = String($(this).data('id'));
            if ($(this).prop('disabled')) {
                showAlert('warning', 'Không thể xóa tiện nghi đang được phòng sử dụng. Chỉ phòng trống mới cho phép.');
                return;
            }
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

    // (GỘP) Render danh sách tiện nghi đang gán (hỗ trợ mảng string hoặc object)
    // Cho phép truyền:
    //  - ['Điều hòa', 'TV']
    //  - [{ id:'1', name:'Điều hòa' }, ...]
    //  - [{ IDTienNghi:'1', TenTienNghi:'Điều hòa' }, ...]
    // Hàm linh hoạt để tránh lỗi khi thay đổi nơi gọi
    function renderCurrentAssigned(items) {
        const container = $('#currentAssigned');
        container.empty();
        const list = Array.isArray(items) ? items : [];
        if (!list.length) {
            container.html('<i>Chưa có tiện nghi nào được gán</i>');
            return;
        }
        const normalized = list.map(it => {
            if (typeof it === 'string') return { id: null, name: it };
            if (it && typeof it === 'object') {
                if ('name' in it || 'id' in it) return { id: it.id ?? null, name: it.name ?? '' };
                if ('TenTienNghi' in it || 'IDTienNghi' in it) return { id: String(it.IDTienNghi ?? ''), name: it.TenTienNghi ?? '' };
            }
            return { id: null, name: String(it) };
        });

        if (!normalized.length) {
            container.html('<i>Chưa có tiện nghi nào được gán</i>');
            return;
        }

        normalized.forEach(it => {
            container.append(
                `<span class="amenity-chip" data-id="${it.id ?? ''}">
                    ${it.name}
                    <a class="remove text-white-50" data-id="${it.id ?? ''}" title="Bỏ tiện nghi">×</a>
                </span>`
            );
        });

        // remove chip -> bỏ chọn tương ứng
        container.off('click', '.remove').on('click', '.remove', function(e) {
            e.preventDefault();
            const id = String($(this).data('id'));
            if (id && id !== 'null' && id !== 'undefined') {
                SELECTED_TN_IDS = SELECTED_TN_IDS.filter(x => x !== id);
                $(`#chk-${id}`).prop('checked', false);
                $('#selectedCount').text(SELECTED_TN_IDS.length);
            } else {
                // Nếu không có id (được truyền bằng tên), xóa theo tên
                const name = $(this).closest('.amenity-chip').text().trim();
                // rebuild từ tên
                const itemsNow = ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(String(x.IDTienNghi)))
                    .map(x => ({ id: String(x.IDTienNghi), name: x.TenTienNghi }))
                    .filter(x => x.name !== name);
                SELECTED_TN_IDS = itemsNow.map(x => String(x.id));
                $('#selectedCount').text(SELECTED_TN_IDS.length);
            }
            const itemsNow = ALL_TIEN_NGHI.filter(x => SELECTED_TN_IDS.includes(String(x.IDTienNghi)))
                .map(x => ({ id: String(x.IDTienNghi), name: x.TenTienNghi }));
            renderCurrentAssigned(itemsNow);
            setDirty(!areArraysEqual(SELECTED_TN_IDS, ASSIGNED_ORIG_IDS));
        });
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

    // Render bảng phòng (hỗ trợ lọc theo tiện nghi + sắp xếp)
    function renderPhongTable(data) {
        // Helper: render trạng thái với badge màu
        const statusBadge = (stRaw) => {
            const st = String(stRaw || '').trim().toLowerCase();
            if (!stRaw) return '';
            if (st === 'trống' || st === 'trong' || st === 'phòng trống') {
                return `<span class="badge bg-success">${stRaw}</span>`;
            }
            if (st.includes('đang')) {
                return `<span class="badge bg-warning text-dark">${stRaw}</span>`;
            }
            if (st.includes('bảo trì') || st.includes('bao tri') || st.includes('bảo dưỡng')) {
                return `<span class="badge bg-secondary">${stRaw}</span>`;
            }
            return `<span class="badge bg-secondary">${stRaw}</span>`;
        };

        const q = vnNormalize($('#searchPhong').val() || '');
        let filtered = data.filter(x => {
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

        // Sort theo state
        const { key: rKey = 'IDPhong', dir: rDir = 'asc' } = (SORT_STATE.rooms || {});
        const toVal = (obj, k) => {
            let v = obj?.[k];
            if (k === 'IDPhong' || k === 'SoPhong') {
                const n = Number(v);
                return isNaN(n) ? Number.MAX_SAFE_INTEGER : n;
            }
            return vnNormalize(String(v ?? ''));
        };
        filtered.sort((a, b) => {
            const va = toVal(a, rKey), vb = toVal(b, rKey);
            if (va < vb) return rDir === 'asc' ? -1 : 1;
            if (va > vb) return rDir === 'asc' ? 1 : -1;
            return 0;
        });

        let html = '';
        if (filtered.length === 0) {
            html = `<tr><td colspan="5" class="empty-state py-4"><i class="bi bi-inbox me-1"></i> Không có dữ liệu phòng</td></tr>`;
        } else {
            filtered.forEach(x => {
                const amenities = Array.isArray(x.TienNghis) ? x.TienNghis : [];
                const amenitiesHtml = amenities.length > 0 ?
                    amenities.map(t => `<span class="amenity-label amenity-filter-chip" data-name="${t.TenTienNghi}">${t.TenTienNghi}</span>`).join(' ') :
                    '<i>Chưa có tiện nghi</i>';
                html += `<tr class="phong-row cursor-pointer" data-id="${x.IDPhong}">
					<td>${x.IDPhong}</td>
					<td>${x.SoPhong}</td>
					<td>${x.TenLoaiPhong || ''}</td>
					<td>${statusBadge(x.TrangThai)}</td>
					<td>${amenitiesHtml}</td>
				</tr>`;
            });
        }
        $('#tablePhong tbody').html(html);
        $('#roomsCount').text(filtered.length);

        // Cập nhật mũi tên sort ở header bảng phòng
        $('#thRoomId, #thRoomSoPhong, #thRoomLoai, #thRoomTrangThai')
            .removeClass('asc desc');
        const keyToTh = {
            IDPhong: '#thRoomId',
            SoPhong: '#thRoomSoPhong',
            TenLoaiPhong: '#thRoomLoai',
            TrangThai: '#thRoomTrangThai'
        };
        const thSel = keyToTh[rKey];
        if (thSel) $(thSel).addClass(rDir === 'asc' ? 'asc' : 'desc');

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

        // Sắp xếp bảng phòng
        $('#thRoomId').on('click', function() {
            const key = 'IDPhong';
            SORT_STATE.rooms.dir = (SORT_STATE.rooms.key === key && SORT_STATE.rooms.dir === 'asc') ? 'desc' : 'asc';
            SORT_STATE.rooms.key = key;
            renderPhongTable(PHONG_TABLE);
        });
        $('#thRoomSoPhong').on('click', function() {
            const key = 'SoPhong';
            SORT_STATE.rooms.dir = (SORT_STATE.rooms.key === key && SORT_STATE.rooms.dir === 'asc') ? 'desc' : 'asc';
            SORT_STATE.rooms.key = key;
            renderPhongTable(PHONG_TABLE);
        });
        $('#thRoomLoai').on('click', function() {
            const key = 'TenLoaiPhong';
            SORT_STATE.rooms.dir = (SORT_STATE.rooms.key === key && SORT_STATE.rooms.dir === 'asc') ? 'desc' : 'asc';
            SORT_STATE.rooms.key = key;
            renderPhongTable(PHONG_TABLE);
        });
        $('#thRoomTrangThai').on('click', function() {
            const key = 'TrangThai';
            SORT_STATE.rooms.dir = (SORT_STATE.rooms.key === key && SORT_STATE.rooms.dir === 'asc') ? 'desc' : 'asc';
            SORT_STATE.rooms.key = key;
            renderPhongTable(PHONG_TABLE);
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
                // Đóng khung sửa để hiển thị thông báo rõ ràng khi không thể chỉnh sửa
                const modalEl = document.getElementById('modalCreateEdit');
                const instance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                try { instance.hide(); } catch (ignore) {}
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
