<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Adminlite Dashboard Template')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Meta -->
    <meta name="description" content="Marketplace for Bootstrap Admin Dashboards" />
    <meta name="author" content="Bootstrap Gallery" />
    <link rel="canonical" href="https://www.bootstrap.gallery/">
    <meta property="og:url" content="https://www.bootstrap.gallery/">
    <meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
    <meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
    <meta property="og:type" content="Website">
    <meta property="og:site_name" content="Bootstrap Gallery">
    <link rel="shortcut icon" href="assets/images/favicon.svg" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- *************
			************ CSS Files *************
		************* -->
    <link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css" />
    <link rel="stylesheet" href="assets/css/main.min.css" />

    <!-- *************
			************ Vendor Css Files *************
		************ -->

    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />
    {{-- Styles injected from pages --}}
    @stack('styles')
</head>

<body>
    <!-- Page wrapper starts -->
    <div class="page-wrapper">

        <!-- Main container starts -->
        <div class="main-container">

            <!-- Sidebar wrapper starts -->
            <nav id="sidebar" class="sidebar-wrapper">

                <!-- App brand starts -->
                <div class="app-brand p-3 mb-3">
                    <a href="/admin">
                        <img src="assets/images/logo.svg" class="logo" alt="AdminLite Bootstrap Template" />
                    </a>
                </div>
                <!-- App brand ends -->

                <!-- Sidebar menu starts -->
                <div class="sidebarMenuScroll">
                    <ul class="sidebar-menu">
                        <li class="{{ request()->routeIs('admin.index') ? 'active current-page' : '' }}">
                            <!-- <a href="{{ route('admin.index') }}">
                                <i class="bi bi-pie-chart"></i> {{-- (hoặc icon bạn muốn) --}}
                                <span class="menu-text">Biểu đồ</span>
                            </a> -->
                        </li>

                        @php
                        $statsActive = request()->routeIs('datphong.index') || request()->routeIs('hoadon.index') || request()->routeIs('khachhang.index');
                        @endphp
                        <li class="treeview {{ $statsActive ? 'active current-page' : '' }}">
                            <a href="#!">
                                <i class="bi bi-stickies"></i>
                                <span class="menu-text">Thống kê</span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ request()->routeIs('datphong.index') ? 'active current-page' : '' }}">
                                    <a href="{{ route('datphong.index') }}">
                                        <i class="bi bi-calendar-check"></i> {{-- (hoặc icon bạn muốn) --}}
                                        <span class="menu-text">Đặt Phòng</span>
                                    </a>
                                </li>

                                <li class="{{ request()->routeIs('hoadon.index') ? 'active current-page' : '' }}">
                                    <a href="{{ route('hoadon.index') }}">
                                        <i class="bi bi-receipt"></i> {{-- (hoặc icon bạn muốn) --}}
                                        <span class="menu-text">Hoá đơn</span>
                                    </a>
                                </li>

                                <li class="{{ request()->routeIs('khachhang.index') ? 'active current-page' : '' }}">
                                    <a href="{{ route('khachhang.index') }}">
                                        <i class="bi bi-people"></i> {{-- (hoặc icon bạn muốn) --}}
                                        <span class="menu-text">Khách hàng</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="{{ request()->routeIs('booking.direct') ? 'active current-page' : '' }}">

                            <a href="{{ route('booking.direct') }}">

                                <i class="bi bi-box"></i>

                                <span class="menu-text">Đặt Phòng Trực Tiếp</span>

                            </a>

                        </li>

                        <li class="{{ request()->is('xacnhan') ? 'active current-page' : '' }}">
                            <a href="{{ url('/xacnhan') }}">
                                <i class="bi bi-calendar-check"></i>
                                <span class="menu-text">Xác nhận Đặt phòng</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('checkout.*') ? 'active current-page' : '' }}">
                            <a href="{{ route('checkout.index') }}">
                                <i class="bi-cash-coin"></i>
                                <span class="menu-text">Checkout</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('room.index') ? 'active current-page' : '' }}">
                            <a href="{{ route('room.index') }}">
                                <i class="bi bi-door-open"></i>
                                <span class="menu-text">Phòng</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('dichvu.index') ? 'active current-page' : '' }}">
                            <a href="{{ route('dichvu.index') }}">
                                <i class="bi bi-box"></i>
                                <span class="menu-text">Dịch Vụ</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('tiennghi.index') ? 'active current-page' : '' }}">
                            <a href="{{ route('tiennghi.index') }}">
                                <i class="bi bi-box"></i>
                                <span class="menu-text">Tiện Nghi</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar menu ends -->

                <!-- Sidebar settings starts -->
                <div class="sidebar-settings gap-1 d-lg-flex d-none">
                    <a href="{{ route('welcome') }}" class="settings-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-custom-class="custom-tooltip-secondary" title="Trang chủ">
                        <i class="bi bi-power"></i>
                    </a>
                </div>
                <!-- Sidebar settings ends -->

            </nav>
            <!-- Sidebar wrapper ends -->

            <!-- App container starts -->
            <div class="app-container">

                <!-- App header starts -->
                <div class="app-header d-flex align-items-center">

                    <!-- Toggle buttons starts -->
                    <div class="d-flex">
                        <button class="pin-sidebar">
                            <i class="bi bi-list lh-1"></i>
                        </button>
                    </div>
                    <!-- Toggle buttons ends -->

                    <!-- Breadcrumb starts -->
                    <div class="d-flex align-items-center ms-3">
                        <h5 class="m-0">Quản lý @yield('title')</h5>
                    </div>
                    <!-- Breadcrumb end -->

                    <!-- App brand sm starts -->
                    <div class="app-brand-sm d-lg-none d-flex">
                        <a href="/admin">
                            <img src="assets/images/logo-sm.svg" class="logo" alt="AdminLite Bootstrap Template" />
                        </a>
                    </div>
                </div>
                <!-- App header ends -->

                <!-- App body starts -->
                <div class="app-body">
                    @yield('content')
                </div>
                <!-- App body ends -->

                <!-- App footer starts -->
                <!-- App footer ends -->

            </div>
            <!-- App container ends -->

        </div>
        <!-- Main container ends -->

    </div>
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

    @yield('scripts')
</body>

</html>
