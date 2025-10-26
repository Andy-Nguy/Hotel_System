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
    @include('partials.menu')

    <!-- Logo & Menu Burger -->

    @include('partials.logo&menuburger')

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
    @include('partials.about')
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
                        // If $img already contains a path or full URL, use it as-is.
                        if (preg_match('#^https?://#i', $img)) {
                            $imgUrl = $img;
                        } elseif (strpos($img, '/') !== false) {
                            // contains a path fragment; ensure it starts with a single '/'
                            $imgUrl = (strpos($img, '/') === 0) ? $img : '/' . $img;
                        } else {
                            // treat as filename only and encode safely
                            $imgUrl = '/HomePage/img/rooms/' . rawurlencode(basename($img)); // root-relative
                        }
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
                                                <?php
                                                // Prefer explicit APP_URL from environment (so links use e.g. http://127.0.0.1:8000)
                                                $envAppUrl = trim(env('APP_URL', ''), "/ ");
                                                if ($envAppUrl) {
                                                    $appUrl = $envAppUrl;
                                                } else {
                                                    $appUrl = config('app.url') ?: ((isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] . '://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? '127.0.0.1:8000'));
                                                }
                                                // ensure no trailing slash
                                                $roomdetailsBase = rtrim($appUrl, '/') . '/roomdetails';
                                                $detailsUrl = $roomdetailsBase . '?id=' . urlencode($detailsId);
                                                ?>
                                                <a href="<?php echo htmlspecialchars($detailsUrl, ENT_QUOTES, 'UTF-8'); ?>">Details <i class="ti-arrow-right"></i></a>
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
    @include('partials.pricing', ['services' => $services ?? []])
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
    @include('partials.facilities')
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
    @include('partials.testiominals')
    <!-- Services -->
    @include('partials.services')
    <!-- News -->
    @include('partials.news')
    <!-- Reservation & Clients-->
    @include('partials.reservation')

    <!-- Footer -->
    @include('partials.footer')
    <!-- Availability modal for the homepage: used by the Check Now form -->
    <div class="modal fade" id="availabilityModal" tabindex="-1" role="dialog" aria-labelledby="availabilityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="availabilityModalLabel">Available Rooms</h5>
                </div>
                <div class="modal-body">
                    <div id="availabilityModalBody" class="row"></div>
                </div>
            </div>
        </div>
    </div>
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
<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:56:06 GMT -->
</body>
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
// --- Auto-refresh services when staff adds new service ---
(function(){
    // read last known service id from server by fetching /api/dichvu and taking highest ID number
    async function fetchLatestServiceId(){
        try {
            const resp = await fetch('/api/public-services');
            if (!resp.ok) return null;
            const list = await resp.json();
            if (!Array.isArray(list) || list.length === 0) return null;
            // extract numeric part and return max
            let max = 0;
            list.forEach(dv => {
                const m = String(dv.IDDichVu||'').match(/(\d+)/);
                if (m) max = Math.max(max, parseInt(m[1],10));
            });
            return 'DV' + String(max).padStart(3,'0');
        } catch(e){
            return null;
        }
    }

    let lastSeen = null;
    (async function init(){
        lastSeen = await fetchLatestServiceId();
        // poll every 10 seconds
        setInterval(async function(){
            try {
                const url = '/api/public-services/updates' + (lastSeen ? ('?after=' + encodeURIComponent(lastSeen)) : '');
                const r = await fetch(url);
                if (!r.ok) return;
                const body = await r.json();
                if (body && Array.isArray(body.data) && body.data.length > 0) {
                    console.log('New service(s) detected, reloading index...');
                    // reload to let customers see new services
                    location.reload();
                }
            } catch(e) {
                // ignore polling errors
            }
        }, 10000);
    })();
})();
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
  window.location.href = '{!! url('/', [], false) !!}';  // Render thành '/' → Browser tự thêm origin (127.0.0.1:8000)
}


</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.booking-inner .form1') || document.getElementById('availability-form');
    if (!form) return;

    // Helper: robust modal show/hide that works with or without Bootstrap's jQuery plugin
    function showAvailabilityModal() {
        const modalEl = document.getElementById('availabilityModal');
        if (!modalEl) return;

        // If Bootstrap's modal is available, use it for correct behavior/backdrop handling
        if (window.jQuery && typeof window.jQuery('#availabilityModal').modal === 'function') {
            window.jQuery('#availabilityModal').modal('show');
            return;
        }

        // Fallback: manually show modal and backdrop and wire up dismiss buttons
        modalEl.classList.add('show');
        modalEl.style.display = 'block';
        modalEl.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');

        // Ensure single backdrop
        let backdrop = document.querySelector('.modal-backdrop');
        if (!backdrop) {
            backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
        } else {
            backdrop.classList.add('show');
        }

        // Wire up any elements with data-dismiss="modal" inside this modal
        const dismissEls = modalEl.querySelectorAll('[data-dismiss="modal"]');
        dismissEls.forEach(el => {
            // Avoid adding multiple listeners
            if (!el._availabilityDismissHandler) {
                el._availabilityDismissHandler = function(evt) {
                    evt && evt.preventDefault();
                    hideAvailabilityModal();
                };
                el.addEventListener('click', el._availabilityDismissHandler);
            }
        });
    }

    function hideAvailabilityModal() {
        const modalEl = document.getElementById('availabilityModal');
        if (!modalEl) return;

        if (window.jQuery && typeof window.jQuery('#availabilityModal').modal === 'function') {
            window.jQuery('#availabilityModal').modal('hide');
            return;
        }

        modalEl.classList.remove('show');
        modalEl.style.display = 'none';
        modalEl.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');

        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.parentNode.removeChild(backdrop);
    }

    // Close modal when clicking backdrop (fallback)
    document.addEventListener('click', function(e) {
        const backdrop = document.querySelector('.modal-backdrop');
        if (!backdrop) return;
        if (e.target === backdrop) hideAvailabilityModal();
    });

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const inputCheckIn = form.querySelector('#check_in') || form.querySelector('input[name="check_in"]') || form.querySelectorAll('.datepicker')[0];
        const inputCheckOut = form.querySelector('#check_out') || form.querySelector('input[name="check_out"]') || form.querySelectorAll('.datepicker')[1];
        const checkIn = inputCheckIn ? inputCheckIn.value : '';
        const checkOut = inputCheckOut ? inputCheckOut.value : '';

        // Small robust date parser to handle common formats (ISO or dd/mm/yyyy)
        function parseDateFlexible(s) {
            if (!s) return null;
            // If format contains '/', assume dd/mm/yyyy or d/m/yyyy
            if (s.indexOf('/') !== -1) {
                const parts = s.split('/').map(p => p.trim());
                if (parts.length === 3) {
                    // parts[0]=dd, parts[1]=mm, parts[2]=yyyy
                    return new Date(parts[2] + '-' + parts[1] + '-' + parts[0]);
                }
            }
            // Otherwise try direct Date parsing (ISO yyyy-mm-dd, or browser locale)
            const d = new Date(s);
            return isNaN(d.getTime()) ? null : d;
        }

        // Validate same-day or invalid range: disallow check-in == check-out or check_in > check_out
        const inDate = parseDateFlexible(checkIn);
        const outDate = parseDateFlexible(checkOut);
        if (inDate && outDate) {
            // Normalize times to midnight for comparison
            const inTime = new Date(inDate.getFullYear(), inDate.getMonth(), inDate.getDate()).getTime();
            const outTime = new Date(outDate.getFullYear(), outDate.getMonth(), outDate.getDate()).getTime();
            if (inTime >= outTime) {
                const modalBody = document.getElementById('availabilityModalBody');
                modalBody.innerHTML = '<div class="col-12 text-center py-4 text-warning">Không thể check-in và check-out cùng một ngày. Vui lòng chọn ngày check-out ít nhất 1 ngày sau check-in.</div>';
                showAvailabilityModal();
                return;
            }
        }

        const modalBody = document.getElementById('availabilityModalBody');
        modalBody.innerHTML = '<div class="col-12 text-center py-4">Loading...</div>';

        try {
            // Read adults/children selects (order in markup: Adults, Children, Rooms)
            const selectElems = form.querySelectorAll('.select2.select');
            let adults = 1, children = 0;
            if (selectElems && selectElems.length >= 2) {
                adults = parseInt(selectElems[0].value, 10) || adults;
                children = parseInt(selectElems[1].value, 10) || children;
            } else {
                // fallback: try to find selects by label fallback names
                const aEl = form.querySelector('select[name="adults"]');
                const cEl = form.querySelector('select[name="children"]');
                if (aEl) adults = parseInt(aEl.value, 10) || adults;
                if (cEl) children = parseInt(cEl.value, 10) || children;
            }
            const totalGuests = (adults || 0) + (children || 0);

            const url = new URL('/api/rooms/available', window.location.origin);
            if (checkIn) url.searchParams.set('check_in', checkIn);
            if (checkOut) url.searchParams.set('check_out', checkOut);
            // provide guests hint to the API if supported
            if (totalGuests) url.searchParams.set('guests', totalGuests);

            const res = await fetch(url.toString(), { credentials: 'same-origin' });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const data = await res.json();
            const rooms = Array.isArray(data) ? data : (data.rooms || data.data || []);

            // Client-side filtering by capacity: only show rooms that can fit totalGuests
            function getRoomCapacity(r) {
                const raw = r.capacity || r.SucChua || r.SoNguoi || r.SoNguoiToiDa || r.MaxGuests || r.maxGuests || r.SoNguoiToiDa;
                const n = parseInt(raw, 10);
                return isNaN(n) ? 0 : n;
            }

            const filteredRooms = (totalGuests && Array.isArray(rooms)) ? rooms.filter(r => getRoomCapacity(r) >= totalGuests) : rooms;

            if (!filteredRooms || filteredRooms.length === 0) {
                // Friendly Vietnamese message when no rooms are available
                modalBody.innerHTML = '<div class="col-12 text-center py-4">Không có phòng phù hợp cho ngày và số lượng khách bạn chọn. Vui lòng thử chọn ngày khác hoặc thay đổi số lượng khách, hoặc liên hệ khách sạn để hỗ trợ.</div>';
            } else {
                modalBody.innerHTML = filteredRooms.map(room => {
                    // Prefer DB field names from `Phong` table: IDPhong, TenPhong, SoPhong, MoTa (not shown), SoNguoiToiDa, GiaCoBanMotDem, UrlAnhPhong
                    const id = room.IDPhong || room.id || room.MaPhong || room.SoPhong || '';
                    const roomName=room.SoPhong
                    const title = room.TenPhong || room.TenLoaiPhong || room.name || room.Ten || room.ten || ('Room ' + (room.SoPhong || room.IDPhong || ''));
                    // Do NOT show description (MoTa) per request
                    const images = room.UrlAnhPhong ? [room.UrlAnhPhong] : (room.images || room.HinhAnh || room.hinh_anh || []);
                    const img = (Array.isArray(images) && images.length) ? images[0] : (room.image || room.AnhDaiDien || 'HomePage/img/rooms/1.jpg');
                    const capacity = (room.SoNguoiToiDa !== undefined && room.SoNguoiToiDa !== null) ? room.SoNguoiToiDa : (room.capacity || room.SucChua || room.SoNguoi || '');

                    // Extract price: prefer GiaCoBanMotDem, then Gia, then any price-like fields
                    const priceRaw = (room.GiaCoBanMotDem !== undefined && room.GiaCoBanMotDem !== null)
                        ? room.GiaCoBanMotDem
                        : (room.Gia !== undefined && room.Gia !== null ? room.Gia : (room.price || room.gia || ''));

                    // Format price as Vietnamese Dong (VND). Accept numeric strings and numbers.
                    let displayPrice = '';
                    if (priceRaw !== '' && priceRaw !== null && priceRaw !== undefined) {
                        const n = (typeof priceRaw === 'number') ? priceRaw : Number(String(priceRaw).replace(/[^0-9.-]+/g, ''));
                        if (!isNaN(n)) {
                            displayPrice = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', maximumFractionDigits: 0 }).format(n);
                        } else {
                            displayPrice = String(priceRaw);
                        }
                    }

                    return `
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div style="height:180px;overflow:hidden;display:flex;align-items:center;justify-content:center">
                                    <img src="HomePage/img/slider/${img}" alt="${title}" style="width:100%;height:100%;object-fit:cover">
                                </div>
                                <div class="card-body">\
                                    <h5 class="card-title">${title} ${roomName?('<small class="text-muted">'+roomName+'</small>'):''}</h5>\
                                    <p class="mb-1"><small class="text-muted">Số người: ${capacity}</small></p>\
                                    ${displayPrice?('<p class="mb-0"><strong>'+displayPrice+'</strong></p>'):''}\
                                </div>\
                                <div class="card-footer">\
                                    <a href="/roomdetails?id=${id}" class="btn btn-sm btn-outline-primary">Chi tiết</a>\
                                    <a href="/booking?room=${id}&check_in=${encodeURIComponent(checkIn)}&check_out=${encodeURIComponent(checkOut)}" class="btn btn-sm btn-primary">Đặt ngay</a>\
                                </div>\
                            </div>\
                        </div>`;
                }).join('\n');
            }

            // Show modal (uses Bootstrap if available, otherwise fallback)
            showAvailabilityModal();

        } catch (err) {
            console.error('Error fetching availability', err);
            // Friendly Vietnamese error message and guidance
            modalBody.innerHTML = '<div class="col-12 text-center py-4 text-danger">Không thể tải danh sách phòng. Có thể do lỗi mạng hoặc không có phòng cho ngày đã chọn. Vui lòng thử lại sau hoặc liên hệ chúng tôi để được hỗ trợ.</div>';
            showAvailabilityModal();
        }
    });
});
</script>
