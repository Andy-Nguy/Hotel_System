<nav id="sidebar" class="sidebar-wrapper">
    <div class="app-brand p-3 mb-3">
        <a href="{{ route('tiennghi.index') }}">
            <img src="{{ asset('assets/images/logo.svg') }}" class="logo" alt="Admin" />
        </a>
    </div>

    <div class="sidebarMenuScroll">
        <ul class="sidebar-menu">
            <li class="menu-section">
                <a href="#" class="sidebar-link" data-ajax data-page="tiennghi">
                    <i class="bi bi-box"></i>
                    <span class="menu-text">Tiện nghi</span>
                </a>
            </li>
            <li class="menu-section">
                <a href="#" class="sidebar-link mt-sm" data-ajax data-page="phong">
                    <i class="bi bi-door-open"></i>
                    <span class="menu-text">Phòng</span>
                </a>
            </li>
        </ul>
    </div>

    <style>
        .sidebar-link { display:block; padding:.375rem .75rem; }
        .sidebar-link.mt-sm { margin-top:.5rem; }
    </style>

    <div class="sidebar-settings gap-1 d-lg-flex d-none">
        <a href="#" class="settings-icon" data-bs-toggle="tooltip" title="Profile">
            <i class="bi bi-person"></i>
        </a>
    </div>
</nav>