<?php
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:55:30 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>The Cappa Luxury Hotel</title>
    <meta name="description"
        content="THE CAPPA is a modern, elegant HTML template for luxury hotels, resorts, and vacation rentals. Fully responsive, customizable, and perfect for hospitality websites.">
    <meta name="author" content="THE CAPPA Luxury Hotel Template by DuruThemes">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="/HomePage/img/favicon.png" type="image/png" sizes="32x32">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300;400&amp;family=Barlow:wght@400&amp;family=Gilda+Display&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/HomePage/css/plugins.css" />
    <link rel="stylesheet" href="/HomePage/css/style.css" />
    <style>
        .rooms1 .position-re.small {
            height: 420px;
        }   /* top row (index 0-2) */
        .rooms1 .position-re.large {
            height: 320px;
        }   /* bottom row (index >=3) â€” giáº£m láº¡i */
        .rooms1 .position-re img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        
        @media (max-width: 991px) {

            .rooms1 .position-re.small,
            .rooms1 .position-re.large {
                height: 260px;
            }
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
    <?php echo $__env->make('partials.logo&menuburger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Slider -->
    <header class="header slider-fade">
        <div class="owl-carousel owl-theme">
            <!-- The opacity on the image is made with "data-overlay-dark="number". You can change it using the numbers 0-9. -->
            <div class="text-center item bg-img" data-overlay-dark="2" data-background="/HomePage/img/slider/2.jpg">
                <div class="v-middle caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <span>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                </span>
                                <h4>Luxury Hotel & Best Resort</h4>
                                <h1>Enjoy a Luxury Experience</h1>
                                <div class="butn-light mt-30 mb-30"> <a href="#" data-scroll-nav="1"><span>Rooms &
                                            Suites</span></a> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center item bg-img" data-overlay-dark="2" data-background="/HomePage/img/slider/3.jpg">
                <div class="v-middle caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <span>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                </span>
                                <h4>Unique Place to Relax & Enjoy</h4>
                                <h1>The Perfect Base For You</h1>
                                <div class="butn-light mt-30 mb-30"> <a href="#" data-scroll-nav="1"><span>Rooms &
                                            Suites</span></a> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center item bg-img" data-overlay-dark="3" data-background="/HomePage/img/slider/1.jpg">
                <div class="v-middle caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <span>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                </span>
                                <h4>The Ultimate Luxury Experience</h4>
                                <h1>Enjoy The Best Moments of Life</h1>
                                <div class="butn-light mt-30 mb-30"> <a href="#" data-scroll-nav="1"><span>Rooms &
                                            Suites</span></a> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- About -->
    <?php echo $__env->make('partials.about', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Rooms -->
    <section class="rooms1 section-padding bg-cream" data-scroll-index="1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-subtitle">The Cappa Luxury Hotel</div>
                    <div class="section-title">Rooms & Suites</div>
                </div>
            </div>
            <div class="row">
                <?php if (!empty($rooms) && is_array($rooms)): ?>
                    <?php foreach ($rooms as $index => $room): ?>
                        <?php
                        $colClass = ($index >= 3) ? 'col-md-6' : 'col-md-4';
                        $img = isset($room['UrlAnhLoaiPhong']) ? $room['UrlAnhLoaiPhong'] : '1.jpg';
                        $name = isset($room['TenLoaiPhong']) ? $room['TenLoaiPhong'] : '';
                        $idLoai = isset($room['IDLoaiPhong']) ? $room['IDLoaiPhong'] : '';
                        // determine price from room data - prefer GiaCoBanMotDem, then Gia
                        $price = '';
                        if (isset($room['GiaCoBanMotDem']) && $room['GiaCoBanMotDem'] !== null) {
                            $price = $room['GiaCoBanMotDem'];
                        } elseif (isset($room['Gia']) && $room['Gia'] !== null) {
                            $price = $room['Gia'];
                        }
                        $displayPrice = ($price !== '' && $price !== null) ? number_format((float) $price, 0, '.', ',') .  '₫' : '';
                        $imgUrl = '/HomePage/img/rooms/' . rawurlencode($img); // root-relative
                        ?>
                        <div class="<?php echo $colClass; ?>">
                            <div class="item">
                                <div class="position-re o-hidden">
                                    <?php $sizeClass = ($index >= 3) ? 'large' : 'small'; ?>
                                    <div class="position-re o-hidden <?php echo $sizeClass; ?>">
                                        <img src="<?php echo $imgUrl; ?>" alt="<?php echo htmlspecialchars($name); ?>">
                                    </div>
                                </div>
                                <span class="category"><a
                                        href="<?php echo '/rooms2?type=' . rawurlencode($idLoai); ?>">Book</a></span>
                                <div class="con">
                                    <h6><a href="room-details.html"><?php echo $displayPrice; ?></a></h6>
                                    <h5><a href="room-details.html"><?php echo htmlspecialchars($name); ?></a></h5>
                                    <div class="line"></div>
                                    <div class="row facilities">
                                        <div class="col col-md-7">
                                            <ul>
                                                <li><i class="flaticon-bed"></i></li>
                                                <li><i class="flaticon-bath"></i></li>
                                                <li><i class="flaticon-breakfast"></i></li>
                                                <li><i class="flaticon-towel"></i></li>
                                            </ul>
                                        </div>
                                        <div class="col col-md-5 text-end">
                                            <?php
                                            $detailsId = isset($room['first_phong_id']) && $room['first_phong_id'] ? $room['first_phong_id'] : $idLoai;
                                            ?>
                                            <div class="permalink">
                                                <a href="<?php echo url('/roomdetails', [], false) . '?id=' . urlencode($detailsId); ?>">Details <i
                                                        class="ti-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p>No rooms available at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Pricing -->
    <?php echo $__env->make('partials.pricing', ['services' => $services ?? []], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Promo Video -->
    <section class="video-wrapper video section-padding bg-img bg-fixed" data-overlay-dark="3"
        data-background="HomePage/img/slider/2.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <span><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i
                            class="star-rating"></i><i class="star-rating"></i></span>
                    <div class="section-subtitle"><span>The Cappa Luxury Hotel</span></div>
                    <div class="section-title"><span>Promotional Video</span></div>
                </div>
            </div>
            <div class="row">
                <div class="text-center col-md-12">
                    <a class="vid" href="https://youtu.be/7BGNAGahig8">
                        <div class="vid-butn">
                            <span class="icon">
                                <i class="ti-control-play"></i>
                            </span>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>
    <!-- Facilities -->
    <?php echo $__env->make('partials.facilities', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Booking Search -->
    <section class="section-padding bg-cream">
        <div class="container">
            <div class="section-subtitle">Check Now</div>
            <div class="section-title">Search Rooms</div>
            <div class="booking-inner clearfix">
                <form class="form1 clearfix">
                    <div class="col1 c1">
                        <div class="input1_wrapper">
                            <label>Check in</label>
                            <div class="input1_inner">
                                <input type="text" class="form-control input datepicker" placeholder="Check in">
                            </div>
                        </div>
                    </div>
                    <div class="col1 c2">
                        <div class="input1_wrapper">
                            <label>Check out</label>
                            <div class="input1_inner">
                                <input type="text" class="form-control input datepicker" placeholder="Check out">
                            </div>
                        </div>
                    </div>
                    <div class="col2 c3">
                        <div class="select1_wrapper">
                            <label>Adults</label>
                            <div class="select1_inner">
                                <select class="select2 select" style="width: 100%">
                                    <option value="1">1 Adult</option>
                                    <option value="2">2 Adults</option>
                                    <option value="3">3 Adults</option>
                                    <option value="4">4 Adults</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col2 c4">
                        <div class="select1_wrapper">
                            <label>Children</label>
                            <div class="select1_inner">
                                <select class="select2 select" style="width: 100%">
                                    <option value="1">Children</option>
                                    <option value="1">1 Child</option>
                                    <option value="2">2 Children</option>
                                    <option value="3">3 Children</option>
                                    <option value="4">4 Children</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col2 c5">
                        <div class="select1_wrapper">
                            <label>Rooms</label>
                            <div class="select1_inner">
                                <select class="select2 select" style="width: 100%">
                                    <option value="1">1 Room</option>
                                    <option value="2">2 Rooms</option>
                                    <option value="3">3 Rooms</option>
                                    <option value="4">4 Rooms</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col3 c6">
                        <button type="submit" class="btn-form1-submit">Check Now</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Testimonials -->
    <?php echo $__env->make('partials.testiominals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Services -->
    <?php echo $__env->make('partials.services', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- News -->
    <?php echo $__env->make('partials.news', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Reservation & Clients-->
    <?php echo $__env->make('partials.reservation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
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
<!-- Navigation scripts moved to partial: resources/views/partials/menu.blade.php -->
</body>

<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:56:06 GMT -->

</html>
<script>
console.log("📂 [AuthCheck] Script bắt đầu chạy...");

const token = localStorage.getItem("token");
const user = localStorage.getItem("userName");

console.log("🔍 Token:", token ? "Đã có" : "Không có");
console.log("👤 User name:", user || "(chưa có)");

document.addEventListener("DOMContentLoaded", () => {
  console.log("🌐 DOM đã load hoàn tất...");

  const display = document.querySelector("#userDisplay");
  const logoutBtn = document.querySelector("#logoutBtn");

  if (token) {
    // ✅ Nếu đã login
    if (display) {
      display.textContent = user || "Người dùng";
      console.log("👋 Đã hiển thị tên:", user);
    }
    if (logoutBtn) {
      logoutBtn.style.display = "inline-block";
    }
  } else {
    // ❌ Nếu chưa login
    if (display) {
      display.textContent = "Khách vãng lai";
      console.log("👤 Người dùng chưa đăng nhập → hiển thị Khách vãng lai");
    }
    if (logoutBtn) {
      logoutBtn.style.display = "none";
    }
  }
});

function logout() {
  console.log("🚪 Đăng xuất: xóa localStorage và chuyển về trang chủ");
  localStorage.clear(); // Xóa token, userName, role, email, v.v.
  
  // Chuyển về trang chủ (sử dụng URL tương đối để giữ host:port)
  window.location.href = '<?php echo url('/', [], false); ?>';  // Render thành '/' → Browser tự thêm origin (127.0.0.1:8000)
}
</script><?php /**PATH I:\Ky_06_2025_2026\php\New folder\Hotel_System\service\resources\views/welcome.blade.php ENDPATH**/ ?>