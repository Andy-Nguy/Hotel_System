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
        .booking-detail-modal { position: fixed; left: 0; right: 0; top: 0; bottom: 0; background: rgba(0,0,0,0.4); display:none; align-items:center; justify-content:center; z-index:1050; }
        .booking-detail-modal .modal-inner { background:#fff; padding:20px; border-radius:6px; width:90%; max-width:600px; box-shadow:0 6px 30px rgba(0,0,0,0.2);} 
        .booking-detail-modal .modal-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
        .booking-detail-modal .close-btn { background:none; border:0; font-size:20px; }
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
    <div class="cappa-wrap">
        <div class="cappa-wrap-inner">
            <nav class="cappa-menu">
                <ul>
                   <li>
                    <a href="#" onclick="goToHome(event)">Home</a>
                    </li>
                    <li><a href="about.html">About</a></li>
                    <li class='cappa-menu-sub'><a href='#'>Rooms &amp; Suites <i class="ti-angle-down"></i></a>
                        <ul>
                            <li><a href='rooms.html'>Rooms 1</a></li>
                            <li><a href='rooms2.html'>Rooms 2</a></li>
                            <li><a href='room-details.html'>Room Details</a></li>
                        </ul>
                    </li>
                    <li><a href="restaurant.html">Restaurant</a></li>
                    <li><a href="spa-wellness.html">Spa Wellness</a></li>
                    <li class="cappa-menu-sub"><a href='#'>Pages <i class="ti-angle-down"></i></a>
                        <ul>
                            <li><a href="services.html">Services</a></li>
                            <li><a href="facilities.html">Facilites</a></li>
                            <li><a href="gallery.html">Gallery</a></li>
                        </ul>
                    </li>
                    <li class="active"><a href="#" onclick="goToProfile(event)">Tài khoản</a></li>
                    <li><a href="contact.html">Contact</a></li>
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
                    <h1>{{ $user->HoTen }}</h1>
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
                                    <div class="profile-value" id="val-HoTen">{{ $user->HoTen }}</div>
                                </div>

                                <div class="profile-info" id="profile-phone">
                                    <div class="profile-label">Số điện thoại</div>
                                    <div class="profile-value" id="val-SoDienThoai">{{ $user->SoDienThoai ?? 'Chưa cập nhật' }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-info" id="profile-email">
                                    <div class="profile-label">Email</div>
                                    <div class="profile-value" id="val-Email">{{ $user->Email }}</div>
                                </div>

                                <div class="profile-info" id="profile-birth">
                                    <div class="profile-label">Ngày sinh</div>
                                    <div class="profile-value" id="val-NgaySinh">{{ $user->NgaySinh ?? 'Chưa cập nhật' }}</div>
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
                        <form id="edit-profile-form" method="POST" action="{{ route('taikhoan.update', [], false) }}" style="display:none">
                            @csrf
                            <input type="hidden" name="email" value="{{ $user->Email }}">
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
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-column footer-about">
                            <h3 class="footer-title">About Hotel</h3>
                            <p class="footer-about-text">Welcome to the best five-star deluxe hotel in New York. Hotel elementum sesue the aucan vestibulum aliquam justo in sapien rutrum volutpat.</p>
                        </div>
                    </div>
                    <div class="col-md-3 offset-md-1">
                        <div class="footer-column footer-explore clearfix">
                            <h3 class="footer-title">Explore</h3>
                            <ul class="footer-explore-list list-unstyled">
                                <li><a href="index.html">Home</a></li>
                                <li><a href="rooms.html">Rooms & Suites</a></li>
                                <li><a href="restaurant.html">Restaurant</a></li>
                                <li><a href="spa-wellness.html">Spa & Wellness</a></li>
                                <li><a href="about.html">About Hotel</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-column footer-contact">
                            <h3 class="footer-title">Contact</h3>
                            <p class="footer-contact-text">1616 Broadway NY, New York 10001<br>United States of America</p>
                            <div class="footer-contact-info">
                                <p class="footer-contact-phone"><span class="flaticon-call"></span> 855 100 4444</p>
                                <p class="footer-contact-mail">info@luxuryhotel.com</p>
                            </div>
                            <div class="footer-about-social-list">
                                <a href="#"><i class="ti-instagram"></i></a>
                                <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                                <a href="#"><i class="ti-youtube"></i></a>
                                <a href="#"><i class="ti-facebook"></i></a>
                                <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="footer-bottom-inner">
                            <p class="footer-bottom-copy-right">© Copyright 2022 by <a href="#">DuruThemes.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
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

    const PROFILE_PATH = "{!! route('taikhoan', [], false) !!}";
    const LOGIN_PATH = "{!! route('login', [], false) !!}";
    const HOME_PATH = '{!! url('/', [], false) !!}';

    function goToProfile(event) {
        event.preventDefault();
        
        const role = localStorage.getItem('role');
        const email = localStorage.getItem('email');
        
        if (role && email && parseInt(role) === 1) {
            const profileUrl = PROFILE_PATH + '?email=' + encodeURIComponent(email);
            window.location.href = profileUrl;
        } else {
            localStorage.setItem('redirect_after_login', PROFILE_PATH);
            alert('Vui lòng đăng nhập để xem thông tin tài khoản.');
            window.location.href = LOGIN_PATH;
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
                        card.className = 'mb-3 border rounded p-2 d-flex justify-content-between align-items-start';
                        const left = document.createElement('div');
                        left.innerHTML = `<strong>${escapeHtml(b.TenPhong || 'Phòng')}</strong><br><small class="text-muted">Số phòng: ${escapeHtml(b.SoPhong || '')}</small><br><small class="text-muted">Ngày đặt: ${escapeHtml(fmtDate(b.NgayDatPhong))}</small><br><small class="text-muted">Từ: ${escapeHtml(fmtDate(b.NgayNhanPhong || b.NgayDatPhong))} • Đến: ${escapeHtml(fmtDate(b.NgayTraPhong))}</small>`;
                        const right = document.createElement('div');
                        right.className = 'text-end';
                        right.innerHTML = `<div class="small text-muted">${escapeHtml(b.TrangThaiLabel || '')}</div><div class="fw-bold">${escapeHtml(fmtMoney(b.TongTien))}</div><div style="margin-top:8px"><button class="butn-dark2 btn-detail" data-id="${escapeHtml(b.IDDatPhong || '')}"><span>Chi tiết</span></button></div>`;
                        card.appendChild(left);
                        card.appendChild(right);
                        currentEl.appendChild(card);
                    });
                } else {
                    currentEl.innerHTML = '<p class="text-muted">Chưa có phòng đang đặt.</p>';
                }

                // Render history as a compact table with client-side pagination (5 rows per page)
                if (Array.isArray(data.history) && data.history.length) {
                    historyEl.innerHTML = '';
                    const table = document.createElement('table');
                    table.className = 'table table-sm';
                    table.innerHTML = `
                        <thead>
                            <tr>
                                <th>Mã</th>
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
                                <td>${escapeHtml(b.IDDatPhong || '')}</td>
                                <td>${escapeHtml(b.SoPhong || '')}</td>
                                <td>${escapeHtml(b.TenPhong || '')}</td>
                                <td>${escapeHtml(fmtDate(b.NgayDatPhong))}</td>
                                <td>${escapeHtml(fmtDate(b.NgayNhanPhong || b.NgayDatPhong))}</td>
                                <td>${escapeHtml(fmtDate(b.NgayTraPhong))}</td>
                                <td>${escapeHtml(b.TrangThaiLabel || '')}<br><small class="text-muted">${escapeHtml(b.TrangThaiThanhToanLabel || '')}</small></td>
                                <td class="text-end">${escapeHtml(fmtMoney(b.TongTien))}</td>
                                <td class="text-end"><button class="butn-dark2 btn-detail" data-id="${escapeHtml(b.IDDatPhong || '')}"><span>Chi tiết</span></button></td>
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

                    // append table and initial pagination
                    historyEl.appendChild(table);
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
        // inject modal markup into DOM
        const modalHtml = `
            <div id="booking-detail-modal" class="booking-detail-modal" style="display:none;">
                <div class="modal-inner">
                    <div class="modal-header">
                        <h5 class="modal-title">Chi tiết đặt phòng</h5>
                        <button class="close-btn" id="booking-modal-close">×</button>
                    </div>
                    <div class="modal-body" id="booking-modal-body"></div>
                    <div class="modal-footer text-end">
                        <button class="butn-dark2" id="booking-modal-close-2"><span>Đóng</span></button>
                    </div>
                </div>
            </div>
        `;
        try { document.body.insertAdjacentHTML('beforeend', modalHtml); } catch(e) {}

        window.openBookingModal = function(id) {
            if (!window._bookingMap || !window._bookingMap[id]) return alert('Chi tiết không tìm thấy');
            const b = window._bookingMap[id];
            const body = document.getElementById('booking-modal-body');
            function fmtDate(d){ if(!d) return ''; const m=d.match(/^(\d{4})-(\d{2})-(\d{2})$/); if(m) return m[3]+'/'+m[2]+'/'+m[1]; return d; }
            function fmtMoney(v){ try { return Number(v).toLocaleString('vi-VN')+' đ'; } catch(e){ return v+' đ'; } }
                body.innerHTML = `
                <p><strong>Mã:</strong> ${escapeHtml(b.IDDatPhong||'')}</p>
                <p><strong>Phòng:</strong> ${escapeHtml(b.TenPhong||'')}</p>
                <p><strong>Số phòng:</strong> ${escapeHtml(b.SoPhong||'')}</p>
                <p><strong>Ngày đặt:</strong> ${escapeHtml(fmtDate(b.NgayDatPhong||''))}</p>
                <p><strong>Từ:</strong> ${escapeHtml(fmtDate(b.NgayNhanPhong||b.NgayDatPhong))} <strong>Đến:</strong> ${escapeHtml(fmtDate(b.NgayTraPhong))}</p>
                <p><strong>Trạng thái:</strong> ${escapeHtml(b.TrangThaiLabel||'')}</p>
                <p><strong>Thanh toán:</strong> ${escapeHtml(b.TrangThaiThanhToanLabel||'')}</p>
                <p><strong>Tổng:</strong> ${escapeHtml(fmtMoney(b.TongTien))}</p>
            `;
            const modal = document.getElementById('booking-detail-modal'); if(modal) modal.style.display='flex';
        };
        window.closeBookingModal = function(){ const modal=document.getElementById('booking-detail-modal'); if(modal) modal.style.display='none'; };
        document.addEventListener('click', function(e){
            const btn = e.target.closest && e.target.closest('.btn-detail');
            if (btn) { const id = btn.getAttribute('data-id'); window.openBookingModal(id); }
        });
        document.addEventListener('click', function(e){ if(e.target && (e.target.id==='booking-modal-close' || e.target.id==='booking-modal-close-2')) window.closeBookingModal(); });
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
</html>