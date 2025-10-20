<!-- Menu Partial -->
<div class="cappa-wrap">
    <div class="cappa-wrap-inner">
        <nav class="cappa-menu">
            <ul>
               <li>
                <a href="#" onclick="goToHome(event)">Home</a>
                </li>
                <li><a href="/about">About</a></li>
                <li><a href="/restaurant">Restaurant</a></li>
                <li><a href="/spa-wellness">Spa Wellness</a></li>
                <li class="cappa-menu-sub"><a href='#'>Pages <i class="ti-angle-down"></i></a>
                    <ul>
                        <li><a href="/services">Services</a></li>
                        <li><a href="/facilities">Facilities</a></li>
                        <li><a href="/faq">F.A.Qs</a></li>
                    </ul>
                </li>
               <li id="profile-link">
        <a href="#" onclick="goToProfile(event)">ACCOUNT</a>
    </li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </nav>
        <div class="cappa-menu-footer">
            <div class="reservation">
                <a href="tel:8551004444">
                    <div class="icon d-flex justify-content-center align-items-center">
                        <i class="flaticon-call"></i>
                    </div>
                    <div class="call">Reservation<br><span>855 100 4444</span></div>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    // Blade render URL thực tế trước khi JS chạy

    // Sử dụng URL TƯƠNG ĐỐI để tránh lặp host – Browser tự giữ origin (127.0.0.1:8000)
    // assign to window.* to avoid redeclaring consts in pages that also declare them
    window.PROFILE_PATH = window.PROFILE_PATH || "<?php echo route('taikhoan', [], false); ?>";  // /taikhoan
    window.LOGIN_PATH = window.LOGIN_PATH || "<?php echo route('login', [], false); ?>";      // /login
    window.HOME_PATH = window.HOME_PATH || "<?php echo url('/', [], false); ?>";             // /

    function goToProfile(event) {
        event.preventDefault();
        
        const role = localStorage.getItem('role');
        const email = localStorage.getItem('email');
        
        if (role && email && parseInt(role) === 1) {
            // Ghép query email vào path tương đối
            const profileUrl = (window.PROFILE_PATH || '/') + '?email=' + encodeURIComponent(email);
            window.location.href = profileUrl;  // Browser giữ host:port → http://127.0.0.1:8000/taikhoan?email=...
        } else {
            localStorage.setItem('redirect_after_login', window.PROFILE_PATH || '/');
            alert('Vui lòng đăng nhập để xem thông tin tài khoản.');
            window.location.href = window.LOGIN_PATH || '/login';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const role = localStorage.getItem('role');
        const email = localStorage.getItem('email');
        const profileItem = document.getElementById('profile-menu-item');
        const loginItem = document.getElementById('login-menu-item');
        
        if (role && email && parseInt(role) === 1) {
            if (profileItem) profileItem.style.display = 'list-item';
            if (loginItem) loginItem.style.display = 'none';
        } else {
            if (profileItem) profileItem.style.display = 'none';
            if (loginItem) loginItem.style.display = 'list-item';
        }
    });

    // navigate home helper (was previously duplicated in welcome.blade.php)
    function goToHome(event) {
        event.preventDefault();
        // If an explicit override is set (useful for testing), prefer it.
        // Example: window.HOME_OVERRIDE = 'http://127.0.0.1:8000';
        if (window.HOME_OVERRIDE) {
            window.location.href = window.HOME_OVERRIDE;
            return;
        }

        // If HOME_PATH is just '/', prefer the dev-server origin
        var defaultDevOrigin = 'http://127.0.0.1:8000';
        var homePath = (window.HOME_PATH || '/');

        try {
            // If Blade rendered an absolute URL (e.g. http://localhost/), rewrite
            // any localhost host to the dev-server origin while preserving path/query.
            if (/^https?:\/\//i.test(homePath)) {
                var parsed = new URL(homePath);
                if (parsed.hostname === 'localhost') {
                    // preserve pathname + search + hash
                    var suffix = (parsed.pathname || '') + (parsed.search || '') + (parsed.hash || '');
                    window.location.href = defaultDevOrigin + suffix;
                    return;
                }
                // Not localhost — just navigate to whatever HOME_PATH is.
                window.location.href = homePath;
                return;
            }
        } catch (e) {
            // URL parsing failed; fall back to simpler logic below
            console.warn('goToHome: URL parse failed, falling back', e);
        }

        // If HOME_PATH is just '/' or empty, jump to dev origin; else use the relative path.
        if (homePath === '/' || homePath === '') {
            window.location.href = defaultDevOrigin + '/';
        } else {
            window.location.href = homePath;
        }
    }
</script>
<?php /**PATH I:\Ky_06_2025_2026\php\New folder\Hotel_System\service\resources\views/partials/menu.blade.php ENDPATH**/ ?>