<?php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Thông tin tài khoản - The Cappa Luxury Hotel</title>
    <meta name="description" content="THE CAPPA is a modern, elegant HTML template for luxury hotels, resorts, and vacation rentals.">
    <meta name="author" content="THE CAPPA Luxury Hotel Template by DuruThemes">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="HomePage/img/favicon.png" type="image/png" sizes="32x32">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300;400&family=Barlow:wght@400&family=Gilda+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="HomePage/css/plugins.css" />
    <link rel="stylesheet" href="HomePage/css/style.css" />
    <style>
        .profile-container {
           position: relative;
            background: white;
            padding: 50px;
            border-radius: 5px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
            max-width: 700px;
            margin: 0 auto;
        }
            /* Wide variant for bookings area */
    .profile-container.wide { max-width: 1400px; }
        /* Bigger table and more breathing room for booking rows */
        .booking-table td, .booking-table th { padding: 14px 12px; vertical-align: middle; }
        .booking-table { font-size: 15px; }
        .booking-card { padding: 16px; }
    /* inline details for current booking (compact, vintage) */
    .current-booking-details { background: rgba(250,245,240,0.6); border:1px solid rgba(115,90,69,0.06); border-radius:8px; margin-top:12px; padding:12px; }
    .current-booking-details .small { color:#6f5a49; }
        .booking-detail-modal { position: fixed; left: 0; right: 0; top: 0; bottom: 0; background: rgba(0,0,0,0.4); display:none; align-items:center; justify-content:center; z-index:1050; }
        .booking-detail-modal .modal-inner { background:#fff; padding:28px; border-radius:8px; width:96%; max-width:1200px; box-shadow:0 10px 48px rgba(0,0,0,0.24);} 
        @media (min-width:1400px) {
            .booking-detail-modal .modal-inner { max-width:1400px; }
        }
        /* keep modal compact and allow scrolling when content is long */
        .booking-detail-modal { align-items: center; }
        .booking-detail-modal .modal-inner { max-height: 78vh; display: flex; flex-direction: column; }
        .booking-detail-modal .modal-body { overflow-y: auto; /* scroll inside modal */ max-height: calc(78vh - 100px); }

        /* summary grid: distribute items evenly across the row and wrap when needed */
        .booking-summary-grid { display:flex; flex-wrap:wrap; gap:12px; }
        .booking-summary-grid .summary-item { flex: 1 1 180px; min-width: 140px; }
        .booking-summary-grid .summary-item .label { font-size:12px; color:#666; }
        .booking-summary-grid .summary-item .value { font-weight:700; }
    
            /* Invoice grid: evenly distribute invoice fields in the modal bottom area */
    /* use CSS grid for precise column alignment and centering like the screenshot */
    .invoice-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap:18px; margin-top:8px; align-items:center; text-align:center; }
    .invoice-grid .invoice-item { background: transparent; padding:6px 6px; border-radius:6px; }
    .invoice-grid .invoice-item .label { font-size:12px; color:#8b6d56; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px; }
    .invoice-grid .invoice-item .value { font-family:'Gilda Display', serif; font-weight:700; color:#2f221c; font-size:1.05rem; }
    .booking-detail-services { max-height: 280px; overflow:auto; }
        .booking-detail-modal .modal-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
        .booking-detail-modal .close-btn { background:none; border:0; font-size:20px; }
    .booking-detail-services table th { border-bottom: 1px solid rgba(115,90,69,0.08); color:#7a5e4a; font-weight:700; font-size:13px; padding:8px 6px; }
    .booking-detail-services table td { border-bottom: 1px dashed rgba(115,90,69,0.04); color:#3b2e2a; font-weight:700; padding:10px 6px; }
    .booking-detail-services table tbody tr td { font-weight:700; }
    /* tighten modal inner spacing to match screenshot proportions */
    .booking-detail-modal .modal-inner { padding:22px; }
        .profile-info {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #f0f0f0;
        }
        .profile-info:last-of-type {
            border-bottom: none;
        }
        .profile-label {
            font-family: 'Barlow', sans-serif;
            font-size: 13px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
            font-weight: 400;
        }
        .profile-value {
            font-family: 'Gilda Display', serif;
            font-size: 20px;
            color: #222;
            font-weight: 400;
        }
        .profile-title {
            text-align: center;
            margin-bottom: 40px;
            font-family: 'Gilda Display', serif;
            font-size: 32px;
            color: #222;
        }
        /* Editing mode: make inputs visually match the static values to avoid layout shifts */
        .profile-container.editing .profile-value input.form-control,
        .profile-container.editing .profile-value input[type="date"],
        .profile-container.editing .profile-value input[type="tel"] {
            font-family: 'Gilda Display', serif;
            font-size: 20px;
            color: #222;
            padding: 6px 10px;
            height: auto;
            border: 1px solid #eee;
            border-radius: 6px;
            box-shadow: none;
            width: 100%;
            box-sizing: border-box;
        }
        .profile-container.editing .profile-info { margin-bottom: 18px; }
        /* Labels and values alignment */
        .profile-label { font-size: 12px; letter-spacing: 2px; margin-bottom: 6px; }
        .profile-value { min-height: 36px; }
        .profile-value input.form-control { padding: 8px 12px; }
        .logout-btn {
            width: 100%;
            margin-top: 30px;
        }
        /* transient overlay alert inside profile container (does not affect layout) */
        .profile-notice-overlay {
            position: absolute;
            left: 50%;
            /* place the notice above the container so it doesn't cover the title */
            top: -34px;
            transform: translateX(-50%);
            z-index: 9999;
            min-width: 260px;
            max-width: calc(100% - 60px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader-bg"></div>
    <div id="preloader">
        <div id="preloader-status">
            <div class="preloader-position loader"> <span></span> </div>
        </div>
    </div>
    <!-- Progress scroll totop -->
    <div class="progress-wrap cursor-pointer">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- Menu -->
    <?php echo $__env->make('partials.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Logo & Menu Burger -->
    <header class="cappa-header">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-6 col-md-6 cappa-logo-wrap">
                    <a href="index.html" class="cappa-logo"><img src="HomePage/img/logo.png" alt=""></a>
                </div>
                <!-- Menu Burger -->
                <div class="col-6 col-md-6 text-right cappa-wrap-burger-wrap"> 
                    <a href="#" class="cappa-nav-toggle cappa-js-cappa-nav-toggle"><i></i></a> 
                </div>
            </div>
        </div>
    </header>
    <!-- Header Banner -->
    <div class="banner-header section-padding valign bg-img bg-fixed" data-overlay-dark="3" data-background="HomePage/img/slider/5.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-left caption mt-90">
                    <h5>Xin chào</h5>
                    <h1><?php echo e($user->HoTen); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile Section -->
    <section class="contact section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="profile-container">
                        <h3 class="profile-title">Thông tin cá nhân</h3>

                        <div class="row gx-3 gy-2 align-items-start">
                            <div class="col-md-6">
                                <div class="profile-info" id="profile-hoTen">
                                    <div class="profile-label">Họ tên</div>
                                    <div class="profile-value" id="val-HoTen"><?php echo e($user->HoTen); ?></div>
                                </div>

                                <div class="profile-info" id="profile-phone">
                                    <div class="profile-label">Số điện thoại</div>
                                    <div class="profile-value" id="val-SoDienThoai"><?php echo e($user->SoDienThoai ?? 'Chưa cập nhật'); ?></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-info" id="profile-email">
                                    <div class="profile-label">Email</div>
                                    <div class="profile-value" id="val-Email"><?php echo e($user->Email); ?></div>
                                </div>

                                <div class="profile-info" id="profile-birth">
                                    <div class="profile-label">Ngày sinh</div>
                                    <div class="profile-value" id="val-NgaySinh"><?php echo e($user->NgaySinh ?? 'Chưa cập nhật'); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-3" style="margin-top:18px">
                            <button id="edit-profile-btn" type="button" class="butn-dark2 logout-btn"><span>Chỉnh sửa</span></button>
                            <button type="button" onclick="logoutFromProfile()" class="butn-dark2 logout-btn">
                                <span>Đăng xuất</span>
                            </button>
                        </div>

                        <!-- Hidden form used only to provide action URL and CSRF token for JS -->
                        <form id="edit-profile-form" method="POST" action="<?php echo e(route('taikhoan.update', [], false)); ?>" style="display:none">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="email" value="<?php echo e($user->Email); ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Bookings Section -->
    <section class="contact section-padding">
        <div class="container-fluid px-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="profile-container wide" id="bookings-container" style="max-width: calc(100% - 80px);">
                        <h3 class="profile-title">Phòng đang đặt &amp; Lịch sử đặt phòng</h3>

                        <div class="row" id="bookings-content">
                            <div class="col-12 mb-4">
                                        <div class="card p-3 booking-card">
                                            <h5>Phòng đang đặt</h5>
                                            <div id="current-bookings">
                                                <p class="text-muted">Chưa có phòng đang đặt</p>
                                            </div>
                                        </div>
                                    </div>

                            <div class="col-12">
                                <div class="card p-3 booking-card">
                                    <h5>Lịch sử đặt phòng</h5>
                                    <div id="booking-history">
                                        <p class="text-muted">Đang tải lịch sử đặt phòng...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- jQuery -->
    <script src="HomePage/js/jquery-3.7.1.min.js"></script>
    <script src="HomePage/js/jquery-migrate-3.5.0.min.js"></script>
    <script src="HomePage/js/modernizr-2.6.2.min.js"></script>
    <script src="HomePage/js/imagesloaded.pkgd.min.js"></script>
    <script src="HomePage/js/jquery.isotope.v3.0.2.js"></script>
    <script src="HomePage/js/pace.js"></script>
    <script src="HomePage/js/popper.min.js"></script>
    <script src="HomePage/js/bootstrap.min.js"></script>
    <script src="HomePage/js/scrollIt.min.js"></script>
    <script src="HomePage/js/jquery.waypoints.min.js"></script>
    <script src="HomePage/js/owl.carousel.min.js"></script>
    <script src="HomePage/js/jquery.stellar.min.js"></script>
    <script src="HomePage/js/jquery.magnific-popup.js"></script>
    <script src="HomePage/js/YouTubePopUp.js"></script>
    <script src="HomePage/js/select2.js"></script>
    <script src="HomePage/js/datepicker.js"></script>
    <script src="HomePage/js/smooth-scroll.min.js"></script>
    <script src="HomePage/js/custom.js"></script>
    
    <script>
    // In-place profile editor (fixed): avoid duplicate labels, normalize date input
    document.addEventListener('DOMContentLoaded', function () {
    const editBtn = document.getElementById('edit-profile-btn');
    const form = document.getElementById('edit-profile-form');
    const csrfInput = form ? form.querySelector('input[name="_token"]') : null;
    let savedTopControls = null; // will hold the removed top controls while editing

        function normalizeDateForInput(value) {
            if (!value) return '';
            // convert dd/mm/yyyy or dd-mm-yyyy to yyyy-mm-dd
            const m = value.match(/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/);
            if (m) {
                const d = m[1].padStart(2,'0');
                const mo = m[2].padStart(2,'0');
                return `${m[3]}-${mo}-${d}`;
            }
            // already yyyy-mm-dd?
            if (/^\d{4}-\d{2}-\d{2}$/.test(value)) return value;
            // fallback: return value unchanged
            return value;
        }

        function createInputElement(name, value, type='text') {
            const input = document.createElement('input');
            input.className = 'form-control';
            input.name = name;
            input.type = type;
            input.value = (value === 'Chưa cập nhật') ? '' : value;
            return input;
        }

        function enterEditMode() {
            // prevent re-entering if already editing
            if (document.getElementById('inline-controls')) return;

            const hoTenVal = document.getElementById('val-HoTen').textContent.trim();
            const soDTVal = document.getElementById('val-SoDienThoai').textContent.trim();
            const ngayValRaw = document.getElementById('val-NgaySinh').textContent.trim();
            const emailVal = document.getElementById('val-Email').textContent.trim();
            const ngayVal = normalizeDateForInput(ngayValRaw);

            // replace profile-value content with inputs (no extra labels)
            const elHo = document.getElementById('val-HoTen');
            elHo.innerHTML = '';
            elHo.appendChild(createInputElement('HoTen', hoTenVal, 'text'));

            const elPhone = document.getElementById('val-SoDienThoai');
            elPhone.innerHTML = '';
            elPhone.appendChild(createInputElement('SoDienThoai', soDTVal, 'tel'));

            const elBirth = document.getElementById('val-NgaySinh');
            elBirth.innerHTML = '';
            const dateInput = createInputElement('NgaySinh', ngayVal, 'date');
            elBirth.appendChild(dateInput);

            // Make email appear as an input but read-only
            const elEmail = document.getElementById('val-Email');
            if (elEmail) {
                elEmail.innerHTML = '';
                const emailInput = createInputElement('Email', emailVal, 'email');
                emailInput.readOnly = true;
                emailInput.setAttribute('readonly', 'readonly');
                // slightly muted appearance for non-editable
                emailInput.style.backgroundColor = '#fff';
                elEmail.appendChild(emailInput);
            }

            // hide the original top buttons (Chỉnh sửa / Đăng xuất) while editing
            // and insert the inline Save/Cancel exactly where those controls live.
            // Using Bootstrap's 'd-none' class is more reliable than direct style toggling.
            const topControls = document.querySelector('.profile-container > .d-flex.gap-2');
            let controlsInsertBefore = null;
            if (topControls) {
                savedTopControls = topControls; // keep reference so we can restore later
                // add a utility class to hide it
                savedTopControls.classList.add('d-none');
                controlsInsertBefore = topControls; // we'll insert our inline controls before this node
            }

            // show Save/Cancel inline controls under the profile container
            const controls = document.createElement('div');
            controls.className = 'd-flex gap-2';
            controls.id = 'inline-controls';
            controls.style.marginTop = '18px';

            // create Save button styled like the original brown buttons
            const saveBtn = document.createElement('button');
            saveBtn.className = 'butn-dark2 logout-btn';
            const saveSpan = document.createElement('span');
            saveSpan.textContent = 'Lưu';
            saveBtn.appendChild(saveSpan);

            // create Cancel button styled like the original brown buttons
            const cancelBtn = document.createElement('button');
            cancelBtn.className = 'butn-dark2 logout-btn';
            const cancelSpan = document.createElement('span');
            cancelSpan.textContent = 'Hủy';
            cancelBtn.appendChild(cancelSpan);

            controls.appendChild(saveBtn);
            controls.appendChild(cancelBtn);

            // insert controls where the top-controls were, or at end as a fallback
            const parent = document.querySelector('.profile-container');
            if (controlsInsertBefore && controlsInsertBefore.parentNode) {
                controlsInsertBefore.parentNode.insertBefore(controls, controlsInsertBefore);
            } else {
                parent.appendChild(controls);
            }
            // mark container as editing so CSS rules apply
            parent.classList.add('editing');

            cancelBtn.addEventListener('click', function (e) {
                e.preventDefault();
                // restore original text
                document.getElementById('val-HoTen').textContent = hoTenVal;
                document.getElementById('val-SoDienThoai').textContent = soDTVal;
                document.getElementById('val-NgaySinh').textContent = ngayValRaw;
                document.getElementById('val-Email').textContent = emailVal;
                controls.remove();
                // remove editing flag
                parent.classList.remove('editing');
                // restore top buttons by removing the d-none class
                if (savedTopControls) {
                    savedTopControls.classList.remove('d-none');
                    savedTopControls = null;
                }
            });

            saveBtn.addEventListener('click', function (e) {
                e.preventDefault();

                // read values from the visible inputs
                const hoInput = document.querySelector('#val-HoTen input[name="HoTen"]');
                const phoneInput = document.querySelector('#val-SoDienThoai input[name="SoDienThoai"]');
                const dateInput = document.querySelector('#val-NgaySinh input[name="NgaySinh"]');

                const hoVal = hoInput ? hoInput.value.trim() : '';
                const phoneVal = phoneInput ? phoneInput.value.trim() : '';
                const dateVal = dateInput ? dateInput.value : '';

                // client-side validation for phone: allow empty, otherwise require 7-15 digits
                const phoneDigits = phoneVal.replace(/\D/g, '');
                const phoneErrorId = 'phone-error-msg';
                // remove previous error if present
                const prevErr = document.getElementById(phoneErrorId);
                if (prevErr) prevErr.remove();
                if (phoneVal && (phoneDigits.length < 7 || phoneDigits.length > 15)) {
                    const err = document.createElement('div');
                    err.id = phoneErrorId;
                    // smaller and bold text
                    err.className = 'text-danger small fw-bold';
                    err.style.marginTop = '6px';
                    err.style.fontSize = '12px';
                    err.style.fontWeight = '700';
                    err.textContent = 'Số điện thoại không hợp lệ.';
                    const phoneWrapper = document.getElementById('val-SoDienThoai');
                    phoneWrapper.appendChild(err);
                    return; // prevent submit
                }

                // determine email: prefer hidden form input, fallback to localStorage
                const emailInput = form.querySelector('input[name="email"]');
                const emailVal = (emailInput && emailInput.value) ? emailInput.value : (localStorage.getItem('email') || '');
                if (!emailVal) {
                    alert('Không tìm thấy email người dùng để cập nhật. Vui lòng đăng nhập lại.');
                    return;
                }

                // build payload for API
                const payload = {
                    email: emailVal,
                    HoTen: hoVal,
                    SoDienThoai: phoneVal,
                    NgaySinh: dateVal
                };

                // send to API endpoint (stateless) then reload profile route on success
                fetch('/api/taikhoan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': (csrfInput ? csrfInput.value : '')
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(payload)
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data && data.success) {
                        // Update visible values in-place and restore controls instead of navigating away
                        const displayHo = document.getElementById('val-HoTen');
                        const displayPhone = document.getElementById('val-SoDienThoai');
                        const displayBirth = document.getElementById('val-NgaySinh');

                        displayHo.textContent = hoVal || 'Chưa cập nhật';
                        displayPhone.textContent = phoneVal || 'Chưa cập nhật';

                        // display date in ISO form (yyyy-mm-dd) to match original layout
                        function formatDateForDisplay(d) {
                            if (!d) return 'Chưa cập nhật';
                            // already ISO yyyy-mm-dd -> return as-is
                            if (/^\d{4}-\d{2}-\d{2}$/.test(d)) return d;
                            // try convert dd/mm/yyyy -> yyyy-mm-dd
                            const m = d.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
                            if (m) {
                                const dd = m[1].padStart(2, '0');
                                const mm = m[2].padStart(2, '0');
                                const yy = m[3];
                                return yy + '-' + mm + '-' + dd;
                            }
                            return d;
                        }
                        displayBirth.textContent = formatDateForDisplay(dateVal);

                        // restore email display (the edit mode replaced it with a readonly input)
                        try {
                            const displayEmail = document.getElementById('val-Email');
                            if (displayEmail) {
                                // prefer explicit emailVal from the form if present
                                const hiddenEmail = form.querySelector('input[name="email"]');
                                const shownEmail = (hiddenEmail && hiddenEmail.value) ? hiddenEmail.value : (localStorage.getItem('email') || '');
                                displayEmail.textContent = shownEmail || 'Chưa cập nhật';
                            }
                        } catch (e) { /* ignore */ }

                        // remove inline controls and editing state
                        const inline = document.getElementById('inline-controls');
                        if (inline) inline.remove();
                        parent.classList.remove('editing');
                        if (savedTopControls) {
                            savedTopControls.classList.remove('d-none');
                            savedTopControls = null;
                        }

                        // show transient success alert as an overlay inside profile-container (no layout shift)
                        const alertId = 'profile-save-success';
                        let existing = document.getElementById(alertId);
                        if (existing) existing.remove();
                        const alertDiv = document.createElement('div');
                        alertDiv.id = alertId;
                        alertDiv.className = 'alert alert-success profile-notice-overlay';
                        alertDiv.style.padding = '10px 16px';
                        alertDiv.style.margin = '0';
                        alertDiv.style.textAlign = 'center';
                        alertDiv.textContent = 'Lưu thông tin thành công.';
                        // append to the profile container so it's positioned relative to it
                        parent.appendChild(alertDiv);
                        // auto-dismiss after 3 seconds with fade-out
                        setTimeout(function () {
                            if (!alertDiv) return;
                            alertDiv.style.transition = 'opacity 300ms ease, transform 300ms ease';
                            alertDiv.style.opacity = '0';
                            alertDiv.style.transform = 'translateX(-50%) translateY(-8px)';
                            setTimeout(function () { if (alertDiv && alertDiv.parentNode) alertDiv.parentNode.removeChild(alertDiv); }, 320);
                        }, 3000);

                    } else {
                        const msg = (data && data.message) ? data.message : 'Lỗi khi lưu thông tin.';
                        alert(msg);
                    }
                })
                .catch(function (err) {
                    console.error('Error updating profile via API', err);
                    alert('Lỗi kết nối khi lưu thông tin. Vui lòng thử lại.');
                });
            });

        }

        editBtn && editBtn.addEventListener('click', enterEditMode);
    });

    // avoid redeclaring globals when partial already set them
    window.PROFILE_PATH = window.PROFILE_PATH || "<?php echo route('taikhoan', [], false); ?>";
    window.LOGIN_PATH = window.LOGIN_PATH || "<?php echo route('login', [], false); ?>";
    window.HOME_PATH = window.HOME_PATH || '<?php echo url('/', [], false); ?>';

    function goToProfile(event) {
        event.preventDefault();
        
        const role = localStorage.getItem('role');
        const email = localStorage.getItem('email');
        
        if (role && email && parseInt(role) === 1) {
            const profileUrl = (window.PROFILE_PATH || '/') + '?email=' + encodeURIComponent(email);
            window.location.href = profileUrl;
        } else {
            localStorage.setItem('redirect_after_login', window.PROFILE_PATH || '/');
            alert('Vui lòng đăng nhập để xem thông tin tài khoản.');
            window.location.href = window.LOGIN_PATH || '/login';
        }
    }

    function logoutFromProfile() {
        if (confirm('Bạn có chắc chắn muốn đăng xuất?')) {
            console.log(" Đăng xuất từ trang profile: xóa localStorage và về trang chủ");
            localStorage.clear();
            window.location.href = HOME_PATH;
        }
    }

    // Kiểm tra xem người dùng đã đăng nhập chưa
    document.addEventListener('DOMContentLoaded', function() {
        const role = localStorage.getItem('role');
        const email = localStorage.getItem('email');
        
        console.log("🔍 Kiểm tra đăng nhập - Role:", role, "Email:", email);
        
        // Nếu chưa đăng nhập, chuyển về trang login
        if (!role || !email || parseInt(role) !== 1) {
            console.log(" Chưa đăng nhập hoặc không phải user, chuyển về login");
            localStorage.setItem('redirect_after_login', PROFILE_PATH);
            alert('Vui lòng đăng nhập để xem thông tin tài khoản.');
            window.location.href = LOGIN_PATH;
        }
        // After authentication check, try to load bookings
        loadBookings(email);
    });

    // Fetch and render booking history / current booking
    function loadBookings(email) {
        if (!email) return;
        // store profile email globally so modal handlers can refresh bookings
        window._profileEmail = email;
    // New layout: top section (full-width) is current bookings -> #current-bookings
    // bottom section (full-width) is booking history -> #booking-history
    const currentEl = document.getElementById('current-bookings'); // shows rooms currently booked
    const historyEl = document.getElementById('booking-history'); // shows past bookings

        // Friendly no-API fallback
        function showEmpty() {
            if (historyEl) historyEl.innerHTML = '<p class="text-muted">Chưa có lịch sử đặt phòng.</p>';
            if (currentEl) currentEl.innerHTML = '<p class="text-muted">Chưa có phòng đang đặt.</p>';
        }

        function fmtDate(d) {
            if (!d) return '';
            const m = d.match(/^(\d{4})-(\d{2})-(\d{2})$/);
            if (m) return m[3] + '/' + m[2] + '/' + m[1];
            return d;
        }

        function fmtMoney(v) {
            if (v === null || v === undefined) return '';
            try {
                // show integer with thousands separator and đ
                return Number(v).toLocaleString('vi-VN') + ' đ';
            } catch (e) { return v + ' đ'; }
        }

        fetch('/api/datphong?email=' + encodeURIComponent(email), { credentials: 'same-origin' })
            .then(function (res) {
                if (!res.ok) throw new Error('Không có API đặt phòng');
                return res.json();
            })
            .then(function (data) {
                if (!data) return showEmpty();

                // Render current bookings (array expected) and add a 'Chi tiết' action
                    if (Array.isArray(data.current) && data.current.length) {
                    currentEl.innerHTML = '';
                    window._bookingMap = window._bookingMap || {};
                    data.current.forEach(function (b) {
                        // store booking for later detail lookup
                        if (b.IDDatPhong) window._bookingMap[b.IDDatPhong] = b;
                        const card = document.createElement('div');
                        card.className = 'mb-3 border rounded p-2';
                        const row = document.createElement('div');
                        row.className = 'd-flex justify-content-between align-items-start';
                        const left = document.createElement('div');
                        left.innerHTML = `<strong>${escapeHtml(b.TenPhong || 'Phòng')}</strong><br><small class="text-muted">Số phòng: ${escapeHtml(b.SoPhong || '')}</small><br><small class="text-muted">Ngày đặt: ${escapeHtml(fmtDate(b.NgayDatPhong))}</small><br><small class="text-muted">Từ: ${escapeHtml(fmtDate(b.NgayNhanPhong || b.NgayDatPhong))} • Đến: ${escapeHtml(fmtDate(b.NgayTraPhong))}</small>`;
                        const right = document.createElement('div');
                        right.className = 'text-end';
                        // show cancel only when booking is not in 'Đang sử dụng' (TrangThai !== 3)
                        // Render Cancel button first (left) and give it a distinct color via 'btn-danger'
                        var actionsHtml = `<div class="small text-muted">${escapeHtml(b.TrangThaiLabel || '')}</div><div class="fw-bold">${escapeHtml(fmtMoney(b.TongTien))}</div><div style="margin-top:8px">`;
                        try {
                            if (parseInt(b.TrangThai) !== 3) {
                                actionsHtml += ` <button class="butn-dark2 btn-cancel-booking btn-danger" data-id="${escapeHtml(b.IDDatPhong || '')}" style="margin-right:8px;background:#c0392b;border-color:#c0392b;color:#fff"><span>Hủy</span></button>`;
                            }
                        } catch(e) { /* ignore parsing errors and fallback to showing cancel */ actionsHtml += ` <button class="butn-dark2 btn-cancel-booking btn-danger" data-id="${escapeHtml(b.IDDatPhong || '')}" style="margin-right:8px;background:#c0392b;border-color:#c0392b;color:#fff"><span>Hủy</span></button>`; }
                        // then the details toggle (right of cancel)
                        actionsHtml += `<button class="butn-dark2 btn-toggle-details" data-id="${escapeHtml(b.IDDatPhong || '')}"><span>Mở chi tiết</span></button>`;
                        actionsHtml += `</div>`;
                        right.innerHTML = actionsHtml;
                        row.appendChild(left);
                        row.appendChild(right);
                        card.appendChild(row);

                        // details container shown inline (will be populated by API)
                        const detailsDiv = document.createElement('div');
                        detailsDiv.className = 'current-booking-details';
                        detailsDiv.innerHTML = '<div class="small text-muted">Đang tải chi tiết đặt phòng...</div>';
                        card.appendChild(detailsDiv);

                        // append card first then fetch details for this booking
                        currentEl.appendChild(card);

                        // find the toggle button we injected into the row
                        const toggleBtn = row.querySelector('.btn-toggle-details');

                        // toggle behavior: fetch details only on first expand
                        (function(id, container, toggleBtn, cancelBtn){
                            let loaded = false;
                            toggleBtn.addEventListener('click', function(e){
                                e.preventDefault();
                                const open = container.style.display !== 'block';
                                if (open) {
                                    // open: fetch once
                                    container.style.display = 'block';
                                    toggleBtn.querySelector('span').textContent = 'Thu gọn';
                                    if (!loaded) {
                                        container.innerHTML = '<div class="small text-muted">Đang tải chi tiết đặt phòng...</div>';
                                        fetch('/api/datphong/' + encodeURIComponent(id), { credentials: 'same-origin' })
                                            .then(function(res){ if(!res.ok) throw new Error('Không tìm thấy chi tiết'); return res.json(); })
                                            .then(function(d){
                                                try {
                                                    var html = '';
                                                    if (d && d.HoaDon) {
                                                        var hd = d.HoaDon;
                                                        if (Array.isArray(hd.DichVus) && hd.DichVus.length) {
                                                            html += '<div class="small text-muted mb-2">Dịch vụ đã sử dụng</div>';
                                                            html += '<div class="table-responsive"><table class="table table-sm mb-0"><thead><tr><th class="text-start">Tên</th><th class="text-start">Thời gian</th><th class="text-end">Giá</th></tr></thead><tbody>';
                                                            hd.DichVus.forEach(function(s){ html += '<tr><td class="text-start">'+escapeHtml(s.TenDichVu||'')+'</td><td class="small text-muted text-start">'+escapeHtml(s.ThoiGianThucHien||'')+'</td><td class="text-end">'+escapeHtml(fmtMoney(s.TienDichVu||0))+'</td></tr>'; });
                                                            html += '</tbody></table></div>';
                                                        } else {
                                                            html += '<div class="small text-muted mb-2">Chưa sử dụng dịch vụ.</div>';
                                                        }
                                                        // invoice summary: include deposit and payment status
                                                        html += '<div class="invoice-grid" style="margin-top:10px;">';
                                                        html += '<div class="invoice-item"><div class="label">Mã hóa đơn</div><div class="value">'+escapeHtml(hd.IDHoaDon||'')+'</div></div>';
                                                        html += '<div class="invoice-item"><div class="label">Ngày lập</div><div class="value">'+escapeHtml(hd.NgayLap||'')+'</div></div>';
                                                        html += '<div class="invoice-item"><div class="label">Tiền đặt cọc</div><div class="value">'+escapeHtml(fmtMoney(hd.TienCoc||0))+'</div></div>';
                                                        html += '<div class="invoice-item"><div class="label">Tổng hóa đơn</div><div class="value">'+escapeHtml(fmtMoney(hd.TongTienHoaDon||hd.TongTien||0))+'</div></div>';
                                                        html += '<div class="invoice-item"><div class="label">Đã thanh toán</div><div class="value">'+escapeHtml(fmtMoney(hd.TienThanhToan||hd.TienDaThanhToan||0))+'</div></div>';
                                                        html += '<div class="invoice-item"><div class="label">Trạng thái thanh toán</div><div class="value">'+escapeHtml(hd.TrangThaiThanhToanLabel||hd.TrangThaiThanhToan||'')+'</div></div>';
                                                        html += '</div>';
                                                    } else {
                                                        html += '<div class="small text-muted">Chưa tạo hoá đơn.</div>';
                                                    }
                                                    container.innerHTML = html;
                                                    loaded = true;
                                                } catch(e) { container.innerHTML = '<div class="text-muted small">Lỗi khi hiển thị chi tiết.</div>'; }
                                            })
                                            .catch(function(err){ console.warn('Không thể tải chi tiết inline', err); container.innerHTML = '<div class="text-muted small">Chi tiết không thể tải.</div>'; });
                                    }
                                } else {
                                    // collapse
                                    container.style.display = 'none';
                                    toggleBtn.querySelector('span').textContent = 'Mở chi tiết';
                                }
                            });
                            // open a confirmation modal instead of calling API immediately
                            if (cancelBtn) {
                                cancelBtn.addEventListener('click', function(e){
                                    e.preventDefault();
                                    // open modal to confirm cancellation (modal will call API when confirmed)
                                    if (typeof window.openCancelModal === 'function') {
                                        window.openCancelModal(id);
                                    } else {
                                        // fallback: simple confirm
                                        if (!confirm('Bạn có chắc chắn muốn hủy đặt phòng này?')) return;
                                        cancelBtn.disabled = true;
                                        fetch('/api/datphong/' + encodeURIComponent(id) + '/cancel', { method: 'POST', credentials: 'same-origin', headers: { 'Content-Type': 'application/json' } })
                                            .then(function(res){ return res.json().then(function(body){ if (!res.ok) throw body; return body; }); })
                                            .then(function(json){ try { loadBookings(window._profileEmail); } catch(e){ if (card && card.parentNode) card.parentNode.removeChild(card); } })
                                            .catch(function(err){ console.error('Cancel failed', err); alert('Không thể hủy đặt phòng. Vui lòng thử lại.'); cancelBtn.disabled = false; });
                                    }
                                });
                            }
                        })(b.IDDatPhong, detailsDiv, row.querySelector('.btn-toggle-details'), row.querySelector('.btn-cancel-booking'));
                    });
                } else {
                    currentEl.innerHTML = '<p class="text-muted">Chưa có phòng đang đặt.</p>';
                }

                // Render history as a compact table with client-side pagination (5 rows per page)
                if (Array.isArray(data.history) && data.history.length) {
                    historyEl.innerHTML = '';
                    const table = document.createElement('table');
                    // booking-table class applies the project's booking paddings/typography
                    table.className = 'table table-sm booking-table';
                    table.innerHTML = `
                        <thead>
                            <tr>
                                <th>Số phòng</th>
                                <th>Phòng</th>
                                <th>Ngày đặt</th>
                                <th>Từ</th>
                                <th>Đến</th>
                                <th>Trạng thái</th>
                                <th class="text-end">Tổng</th>
                                <th class="text-end">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    `;
                    const tbody = table.querySelector('tbody');
                    window._bookingMap = window._bookingMap || {};

                    // Save history data for pagination and details
                    window._bookingHistory = Array.isArray(data.history) ? data.history.slice() : [];
                    const PAGE_SIZE = 5;

                    function renderHistoryPage(page) {
                        const history = window._bookingHistory || [];
                        const total = history.length;
                        const totalPages = Math.max(1, Math.ceil(total / PAGE_SIZE));
                        let p = parseInt(page, 10) || 1;
                        if (p < 1) p = 1;
                        if (p > totalPages) p = totalPages;

                        // clear tbody
                        tbody.innerHTML = '';

                        const start = (p - 1) * PAGE_SIZE;
                        const slice = history.slice(start, start + PAGE_SIZE);
                        slice.forEach(function (b) {
                            if (b.IDDatPhong) window._bookingMap[b.IDDatPhong] = b;
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${escapeHtml(b.SoPhong || '')}</td>
                                <td>${escapeHtml(b.TenPhong || '')}</td>
                                <td>${escapeHtml(fmtDate(b.NgayDatPhong))}</td>
                                <td>${escapeHtml(fmtDate(b.NgayNhanPhong || b.NgayDatPhong))}</td>
                                <td>${escapeHtml(fmtDate(b.NgayTraPhong))}</td>
                                <td>${escapeHtml(b.TrangThaiLabel || '')}<br><small class="text-muted">${escapeHtml(b.TrangThaiThanhToanLabel || '')}</small></td>
                                <td class="text-end">${escapeHtml(fmtMoney(b.TongTien))}</td>
                                <td class="text-end"><button class="butn-dark2 btn-sm btn-detail" data-id="${escapeHtml(b.IDDatPhong || '')}"><span>Chi tiết</span></button></td>
                            `;
                            tbody.appendChild(tr);
                        });

                        // build or update pagination controls
                        let pag = historyEl.querySelector('.booking-pagination');
                        if (!pag) {
                            pag = document.createElement('div');
                            pag.className = 'booking-pagination d-flex justify-content-between align-items-center mt-2';
                            historyEl.appendChild(pag);
                        }
                        // left: showing x-y of total
                        const from = total === 0 ? 0 : start + 1;
                        const to = Math.min(start + slice.length, total);
                        pag.innerHTML = `<div class="small text-muted">Hiển thị ${from}-${to} / ${total}</div>`;

                        // right: page buttons
                        const btnWrap = document.createElement('div');
                        btnWrap.className = 'btn-group';

                        const addPageButton = (label, target, disabled) => {
                            const b = document.createElement('button');
                            b.type = 'button';
                            b.className = 'butn-dark2 btn-sm';
                            b.style.marginLeft = '6px';
                            b.textContent = label;
                            if (disabled) b.disabled = true;
                            b.addEventListener('click', function (e) { renderHistoryPage(target); });
                            btnWrap.appendChild(b);
                        };

                        // Prev
                        addPageButton('« Trước', p - 1, p <= 1);

                        // show page numbers (if many pages, show window)
                        const maxButtons = 7;
                        let startPage = Math.max(1, p - Math.floor(maxButtons / 2));
                        let endPage = Math.min(totalPages, startPage + maxButtons - 1);
                        if (endPage - startPage + 1 < maxButtons) startPage = Math.max(1, endPage - maxButtons + 1);

                        for (let i = startPage; i <= endPage; i++) {
                            const b = document.createElement('button');
                            b.type = 'button';
                            b.className = 'butn-dark2 btn-sm';
                            b.style.marginLeft = '6px';
                            b.textContent = String(i);
                            if (i === p) {
                                b.disabled = true;
                                b.style.opacity = '0.7';
                            }
                            b.addEventListener('click', (function (pageNum) { return function () { renderHistoryPage(pageNum); }; })(i));
                            btnWrap.appendChild(b);
                        }

                        // Next
                        addPageButton('Sau »', p + 1, p >= totalPages);

                        pag.appendChild(btnWrap);
                    }

                    // put table inside a responsive wrapper so small screens scroll nicely
                    const wrap = document.createElement('div');
                    wrap.className = 'table-responsive';
                    wrap.appendChild(table);
                    historyEl.appendChild(wrap);
                    // initial pagination
                    renderHistoryPage(1);
                } else {
                    historyEl.innerHTML = '<p class="text-muted">Chưa có lịch sử đặt phòng.</p>';
                }
            })
            .catch(function (err) {
                console.log('Bookings API not available or failed:', err);
                showEmpty();
            });
    }

    // Booking detail modal helpers + markup
    (function(){
        // inject modal markup into DOM (stacked layout: booking summary large on top, invoice+services below)
        const modalHtml = `
            <div id="booking-detail-modal" class="booking-detail-modal" style="display:none;">
                <div class="modal-inner">
                    <div class="modal-header">
                        <h5 class="modal-title">Chi tiết đặt phòng</h5>
                        <button class="close-btn" id="booking-modal-close">×</button>
                    </div>
                    <div class="modal-body p-0" id="booking-modal-body">
                        <div class="p-3" id="booking-modal-top">
                            <!-- booking summary injected here (large) -->
                        </div>
                        <div class="border-top p-3" id="booking-modal-bottom">
                            <!-- invoice + services injected here -->
                        </div>
                    </div>
                    <div class="modal-footer text-end">
                        <button class="butn-dark2" id="booking-modal-close-2"><span>Đóng</span></button>
                    </div>
                </div>
            </div>
        `;
        try { document.body.insertAdjacentHTML('beforeend', modalHtml); } catch(e) {}

        window.openBookingModal = function(id) {
            const top = document.getElementById('booking-modal-top');
            const bottom = document.getElementById('booking-modal-bottom');
            const modal = document.getElementById('booking-detail-modal');
            if (!modal || !top || !bottom) return alert('Modal không khả dụng');
            // show placeholders while loading
            top.innerHTML = '<p class="text-muted">Đang tải...</p>';
            bottom.innerHTML = '<p class="text-muted">Đang tải...</p>';
            modal.style.display = 'flex';

            fetch('/api/datphong/' + encodeURIComponent(id), { credentials: 'same-origin' })
                .then(function(res) { if (!res.ok) throw new Error('Không tìm thấy chi tiết'); return res.json(); })
                .then(function(data) {
                    function fmtDate(d){ if(!d) return ''; const m=d.match(/^(\\d{4})-(\\d{2})-(\\d{2})$/); if(m) return m[3]+'/'+m[2]+'/'+m[1]; return d; }
                    function fmtMoney(v){ try { return Number(v).toLocaleString('vi-VN')+' đ'; } catch(e){ return v+' đ'; } }

                    // Top (booking summary) - grid layout for even spacing
                    const topParts = [];
                    topParts.push(`<h4 class="mb-3" style="font-size:1.4rem; margin-bottom:0.4rem">Đặt phòng — ${escapeHtml(data.TenPhong||'')}</h4>`);
                    topParts.push('<div class="booking-summary-grid">');
                    const addItem = (label, value) => (`<div class="summary-item"><div class="label">${label}</div><div class="value">${value}</div></div>`);
                    topParts.push(addItem('Mã đặt phòng', escapeHtml(data.IDDatPhong||id)));
                    topParts.push(addItem('Số phòng', escapeHtml(data.SoPhong||'')));
                    topParts.push(addItem('Ngày đặt', escapeHtml(fmtDate(data.NgayDatPhong||''))));
                    topParts.push(addItem('Từ', escapeHtml(fmtDate(data.NgayNhanPhong||data.NgayDatPhong||''))));
                    topParts.push(addItem('Đến', escapeHtml(fmtDate(data.NgayTraPhong||''))));
                    topParts.push(addItem('Tổng tiền phòng', escapeHtml(fmtMoney(data.TongTienPhong||data.TongTien||0))));
                    topParts.push(addItem('Trạng thái đặt phòng', escapeHtml(data.TrangThaiDatPhongLabel||data.TrangThaiDatPhong||'')));
                    topParts.push(addItem('Thanh toán đặt phòng', escapeHtml(data.TrangThaiThanhToanLabel||data.TrangThaiThanhToan||'')));
                    topParts.push('</div>');
                    top.innerHTML = topParts.join('');

                    // Bottom: invoice + services
                    const bottomParts = [];
                    if (data.HoaDon) {
                        const hd = data.HoaDon;
                        // Services first
                        if (Array.isArray(hd.DichVus) && hd.DichVus.length) {
                            let table = '<div class="small text-muted mb-1">Dịch vụ đã sử dụng</div>';
                            table += '<div class="booking-detail-services table-responsive"><table class="table table-sm mb-0"><thead><tr><th>Tên</th><th>Thời gian</th><th class="text-end">Giá</th></tr></thead><tbody>';
                            hd.DichVus.forEach(function(s) {
                                table += `<tr><td>${escapeHtml(s.TenDichVu||'')}</td><td class="small text-muted">${escapeHtml(s.ThoiGianThucHien||'')}</td><td class="text-end">${escapeHtml(fmtMoney(s.TienDichVu||0))}</td></tr>`;
                            });
                            table += '</tbody></table></div>';
                            bottomParts.push(table);
                        } else {
                            bottomParts.push('<p class="text-muted small">Chưa sử dụng dịch vụ.</p>');
                        }

                        // Then show invoice summary as an evenly-distributed grid
                        bottomParts.push(`<hr>`);
                        bottomParts.push(`<div class="invoice-grid">`);
                        bottomParts.push(`<div class="invoice-item"><div class="label">Mã hóa đơn</div><div class="value">${escapeHtml(hd.IDHoaDon||'')}</div></div>`);
                        bottomParts.push(`<div class="invoice-item"><div class="label">Ngày lập</div><div class="value">${escapeHtml(hd.NgayLap||'')}</div></div>`);
                        bottomParts.push(`<div class="invoice-item"><div class="label">Tổng hóa đơn</div><div class="value">${escapeHtml(fmtMoney(hd.TongTienHoaDon||hd.TongTien||0))}</div></div>`);
                        // extra spacing items for nicer distribution on wide screens (optional fields)
                        bottomParts.push(`<div class="invoice-item"><div class="label">Tiền đặt cọc</div><div class="value">${escapeHtml(fmtMoney(hd.TienCoc||0))}</div></div>`);
                        bottomParts.push(`<div class="invoice-item"><div class="label">Đã thanh toán</div><div class="value">${escapeHtml(fmtMoney(hd.TienThanhToan||hd.TienDaThanhToan||0))}</div></div>`);
                        bottomParts.push(`<div class="invoice-item"><div class="label">Trạng thái thanh toán</div><div class="value">${escapeHtml(hd.TrangThaiThanhToanLabel||hd.TrangThaiThanhToan||'')}</div></div>`);
                        bottomParts.push(`</div>`);
                    } else {
                        bottomParts.push('<p class="text-muted">Chưa tạo hoá đơn cho đặt phòng này.</p>');
                    }
                    bottom.innerHTML = bottomParts.join('');
                })
                .catch(function(err) {
                    console.error('Error loading booking details', err);
                    const b = (window._bookingMap && window._bookingMap[id]) ? window._bookingMap[id] : null;
                    if (b) {
                        top.innerHTML = `<p><strong>Mã:</strong> ${escapeHtml(b.IDDatPhong||'')}</p><p><strong>Phòng:</strong> ${escapeHtml(b.TenPhong||'')}</p><p><strong>Số phòng:</strong> ${escapeHtml(b.SoPhong||'')}</p>`;
                        bottom.innerHTML = '<p class="text-muted">Chi tiết dịch vụ không thể tải.</p>';
                    } else {
                        top.innerHTML = '<p class="text-danger">Không thể tải chi tiết đặt phòng.</p>';
                        bottom.innerHTML = '';
                    }
                });
        };
        window.closeBookingModal = function(){ const modal=document.getElementById('booking-detail-modal'); if(modal) modal.style.display='none'; };
        document.addEventListener('click', function(e){
            const btn = e.target.closest && e.target.closest('.btn-detail');
            if (btn) { const id = btn.getAttribute('data-id'); window.openBookingModal(id); }
        });
        document.addEventListener('click', function(e){ if(e.target && (e.target.id==='booking-modal-close' || e.target.id==='booking-modal-close-2')) window.closeBookingModal(); });
    })();

    /* Cancel confirmation modal + handlers */
    (function(){
        const cancelHtml = `
            <div id="booking-cancel-modal" class="booking-detail-modal" style="display:none;">
                <div class="modal-inner">
                    <div class="modal-header">
                        <h5 class="modal-title">Xác nhận hủy đặt phòng</h5>
                        <button class="close-btn" id="cancel-modal-close">×</button>
                    </div>
                    <div class="modal-body p-3" id="cancel-modal-body">
                        <!-- content injected: message and meta -->
                        <p id="cancel-modal-message" class="mb-3 small text-muted"></p>
                    </div>
                    <div class="modal-footer text-end">
                        <button class="butn-dark2" id="cancel-confirm-btn" style="margin-right:10px;background:#c0392b;border-color:#c0392b;color:#fff"><span>Xác nhận hủy</span></button>
                        <button class="butn-dark2" id="cancel-modal-cancel" style="margin-left:6px"><span>Đóng</span></button>
                    </div>
                </div>
            </div>
        `;
        try { document.body.insertAdjacentHTML('beforeend', cancelHtml); } catch(e) {}

        let pendingCancelId = null;

        window.openCancelModal = function(id) {
            pendingCancelId = id;
            const modal = document.getElementById('booking-cancel-modal');
            const msg = document.getElementById('cancel-modal-message');
            // get booking data from client-side map if available
            const b = (window._bookingMap && window._bookingMap[id]) ? window._bookingMap[id] : null;
            if (msg) {
                if (b) {
                    const from = b.NgayNhanPhong || b.NgayDatPhong || '';
                    const to = b.NgayTraPhong || '';
                    // use escaped content to avoid XSS, but inject HTML for emphasis
                    const room = escapeHtml(b.TenPhong || 'Phòng');
                    const fromEsc = escapeHtml(from);
                    const toEsc = escapeHtml(to);
                    msg.innerHTML = `<div style="font-size:1.1rem;line-height:1.3"><strong>Bạn muốn huỷ tại ${room} từ ngày ${fromEsc} đến ngày ${toEsc} không?</strong></div><div style="margin-top:6px;color:#c0392b;font-weight:600">Tiền cọc của bạn có nguy cơ bị mất!</div>`;
                } else {
                    msg.innerHTML = '<div style="font-size:1.1rem;line-height:1.3">Bạn có chắc chắn muốn hủy đặt phòng này?</div>';
                }
            }
            if (modal) modal.style.display = 'flex';
        };

        window.closeCancelModal = function(){ const modal=document.getElementById('booking-cancel-modal'); if(modal) modal.style.display='none'; pendingCancelId = null; };

        document.getElementById && document.addEventListener('click', function(e){
            if (e.target && (e.target.id === 'cancel-modal-close' || e.target.id === 'cancel-modal-cancel')) {
                window.closeCancelModal();
            }
        });

        const confirmBtn = document.getElementById('cancel-confirm-btn');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function(e){
                if (!pendingCancelId) return;
                confirmBtn.disabled = true;
                fetch('/api/datphong/' + encodeURIComponent(pendingCancelId) + '/cancel', { method: 'POST', credentials: 'same-origin', headers: { 'Content-Type': 'application/json' } })
                    .then(function(res){ return res.json().then(function(body){ if (!res.ok) throw body; return body; }); })
                    .then(function(json){
                        try { loadBookings(window._profileEmail); } catch(e){ }
                        // Show success message in modal and replace footer with a Close button
                        try {
                            const modal = document.getElementById('booking-cancel-modal');
                            const msg = document.getElementById('cancel-modal-message');
                            if (msg) {
                                msg.innerHTML = '<div style="font-size:1.1rem;color:#2d6a4f;font-weight:700">Đã huỷ phòng thành công!<br/>Mong gặp lại quý khách vào lần tới.</div>';
                            }
                            if (modal) {
                                const footer = modal.querySelector('.modal-footer');
                                if (footer) {
                                    footer.innerHTML = '<button class="butn-dark2" id="cancel-success-close" style="margin-left:6px"><span>Đóng</span></button>';
                                    const cb = document.getElementById('cancel-success-close');
                                    if (cb) cb.addEventListener('click', function(){ window.closeCancelModal(); });
                                }
                            }
                        } catch(e) {
                            // fallback: close modal
                            try { window.closeCancelModal(); } catch(ex){}
                        }
                    })
                    .catch(function(err){ console.error('Cancel failed', err); alert('Không thể hủy đặt phòng. Vui lòng thử lại.'); confirmBtn.disabled = false; });
            });
        }
    })();

    // Small helper to avoid XSS in DOM insertion
    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>"']/g, function (s) {
            return ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            })[s];
        });
    }
    </script>
    <script>
    function goToHome(event) {
        event.preventDefault();
        window.location.href = '/';
    }
</script>
</body>
</html><?php /**PATH I:\Ky_06_2025_2026\php\New folder\Hotel_System\service\resources\views/taikhoan.blade.php ENDPATH**/ ?>