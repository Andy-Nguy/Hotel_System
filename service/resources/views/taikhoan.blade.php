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
            background: white;
            padding: 50px;
            border-radius: 5px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
            max-width: 700px;
            margin: 0 auto;
        }
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
        .logout-btn {
            width: 100%;
            margin-top: 30px;
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
                    <h1>Thông tin tài khoản</h1>
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
                        
                        <div class="profile-info">
                            <div class="profile-label">Họ tên</div>
                            <div class="profile-value">{{ $user->HoTen }}</div>
                        </div>
                        
                        <div class="profile-info">
                            <div class="profile-label">Email</div>
                            <div class="profile-value">{{ $user->Email }}</div>
                        </div>
                        
                        <div class="profile-info">
                            <div class="profile-label">Số điện thoại</div>
                            <div class="profile-value">{{ $user->SoDienThoai ?? 'Chưa cập nhật' }}</div>
                        </div>
                        
                        <div class="profile-info">
                            <div class="profile-label">Ngày sinh</div>
                            <div class="profile-value">{{ $user->NgaySinh ?? 'Chưa cập nhật' }}</div>
                        </div>
                        
                        <button type="button" onclick="logoutFromProfile()" class="butn-dark2 logout-btn">
                            <span>Đăng xuất</span>
                        </button>
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
    console.log("📂 [ProfilePage] Script bắt đầu chạy...");

    // Blade render URL thực tế trước khi JS chạy
    const PROFILE_PATH = '{!! route('taikhoan', [], false) !!}';
    const LOGIN_PATH = '{!! route('login', [], false) !!}';
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
            console.log("🚪 Đăng xuất từ trang profile: xóa localStorage và về trang chủ");
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
            console.log("❌ Chưa đăng nhập hoặc không phải user, chuyển về login");
            localStorage.setItem('redirect_after_login', PROFILE_PATH);
            alert('Vui lòng đăng nhập để xem thông tin tài khoản.');
            window.location.href = LOGIN_PATH;
        }
    });
    </script>
    <script>
    function goToHome(event) {
        event.preventDefault();
        window.location.href = '/';
    }
</script>
</body>
</html>