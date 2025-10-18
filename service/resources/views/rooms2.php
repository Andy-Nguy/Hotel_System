<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/rooms2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:56:17 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>The Cappa Luxury Hotel</title>
    <meta name="description" content="THE CAPPA is a modern, elegant HTML template for luxury hotels, resorts, and vacation rentals. Fully responsive, customizable, and perfect for hospitality websites.">
    <meta name="author" content="THE CAPPA Luxury Hotel Template by DuruThemes">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="HomePage/img/favicon.png" type="image/png" sizes="32x32">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300;400&amp;family=Barlow:wght@400&amp;family=Gilda+Display&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="HomePage/css/plugins.css" />
    <link rel="stylesheet" href="HomePage/css/style.css" />
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
    <!-- Simplified Menu (rooms-only) -->
    <div class="cappa-wrap">
        <div class="cappa-wrap-inner">
            <nav class="cappa-menu">
                <ul>
                    <li><a href="rooms.html">Rooms</a></li>
                    <li><a href="rooms2.html" class="active">Rooms 2</a></li>
                    <li><a href="rooms3.html">Rooms 3</a></li>
                    <li><a href="room-details.html">Room Details</a></li>
                    <li><a href="#" class="reservation-link">Reservation: <strong>855 100 4444</strong></a></li>
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
                <div class="col-6 col-md-6 text-right cappa-wrap-burger-wrap"> <a href="#" class="cappa-nav-toggle cappa-js-cappa-nav-toggle"><i></i></a> </div>
            </div>
        </div>
    </header>
    <!-- Header Banner -->
    <div class="banner-header section-padding valign bg-img bg-fixed" data-overlay-dark="4" data-background="HomePage/img/slider/1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 caption mt-90">
                    <span><i class="star-rating"></i></span>
                    <h5>The Cappa Luxury Hotel</h5>
                    <h1><?php echo htmlspecialchars($typeName ?? 'Rooms & Suites'); ?></h1>
                </div>
			</div>
        </div>
    </div>
    <!-- Rooms -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if (!empty($roomsDetail) && is_array($roomsDetail)): ?>
                        <?php foreach ($roomsDetail as $idx => $room): ?>
                            <?php
                                $img = isset($room['UrlAnhPhong']) ? $room['UrlAnhPhong'] : '1.jpg';
                                // prefer slider images if present, otherwise fall back to rooms
                                $sliderPath = public_path('HomePage/img/slider/' . $img);
                                if (file_exists($sliderPath)) {
                                    $imgUrl = '/HomePage/img/slider/' . rawurlencode($img);
                                } else {
                                    $imgUrl = '/HomePage/img/rooms/' . rawurlencode($img);
                                }

                                // <-- add these definitions to avoid "Undefined variable"
                                $number = $room['SoPhong'] ?? '';
                                $title  = $room['TenPhong'] ?? ($room['TenPhong'] ?? 'Room');
                            ?>
                            <?php $leftClass = ($idx % 2) ? ' left' : ''; ?>
                            <div class="rooms2 mb-90<?php echo $leftClass; ?> animate-box" data-animate-effect="fadeInUp">
                                <figure><img src="<?php echo $imgUrl; ?>" alt="" class="img-fluid"></figure>
                                <div class="caption">
                                    <h3><?php echo $number ? htmlspecialchars($number) : 'Room'; ?></h3>
                                    <h4>
                                        <a href="<?php echo '/roomdetails.php?id=' . urlencode($room['IDPhong'] ?? ''); ?>">
                                            <?php echo htmlspecialchars($title); ?>
                                        </a>
                                    </h4>
                                    <p><?php echo htmlspecialchars($room['MoTa'] ?? ''); ?></p>
                                    <?php // Render amenities from the room's `tien_nghis` if available ?>
                                    <?php if (!empty($room['tien_nghis']) && is_array($room['tien_nghis'])): ?>
                                        <div class="row room-facilities">
                                            <?php foreach ($room['tien_nghis'] as $amenity): ?>
                                                <div class="col-md-4">
                                                    <ul>
                                                        <li><i class="ti-check"></i> <?php echo htmlspecialchars($amenity['TenTienNghi'] ?? ''); ?></li>
                                                    </ul>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <!-- fallback to original facilities when no amenities provided -->
                                        <div class="row room-facilities">
                                            <div class="col-md-4">
                                                <ul>
                                                    <li><i class="flaticon-group"></i> <?php echo htmlspecialchars($room['SoNguoiToiDa'] ?? ''); ?> Persons</li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <hr class="border-2">
                                    <div class="info-wrapper">
                                        <div class="more">
                                            <a href="<?php echo '/roomdetails.php?id=' . urlencode($room['IDPhong'] ?? ''); ?>" class="link-btn" tabindex="0">
                                                Details <i class="ti-arrow-right"></i>
                                            </a>
                                        </div>
                                        <div class="butn-dark"> <a href="/rooms2?type=<?php echo urlencode($type); ?>" data-scroll-nav="1"><span>Book Now</span></a> </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No rooms available at the moment.</p>
                    <?php endif; ?>
    </section>
    <!-- Booking Search -->
    <section class="section-padding bg-cream" data-scroll-index="1">
        <div class="container">
                <div class="section-subtitle">Availabilitiy</div>
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
    <!-- Pricing -->
    <section class="pricing section-padding bg-blck">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="section-subtitle"><span>Best Prices</span></div>
                    <div class="section-title"><span>Extra Services</span></div>
                    <p class="color-2">The best prices for your relaxing vacation. The utanislen quam nestibulum ac quame odion elementum sceisue the aucan.</p>
                    <p class="color-2">Orci varius natoque penatibus et magnis disney parturient monte nascete ridiculus mus nellen etesque habitant morbine.</p>
                    <div class="reservations mb-30">
                        <div class="icon"><span class="flaticon-call"></span></div>
                        <div class="text">
                            <p class="color-2">For information</p> <a href="tel:855-100-4444">855 100 4444</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="owl-carousel owl-theme">
                        <div class="pricing-card">
                            <img src="HomePage/img/pricing/1.jpg" alt="">
                            <div class="desc">
                                <div class="name">Room cleaning</div>
                                <div class="amount">$50<span>/ month</span></div>
                                <ul class="list-unstyled list">
                                    <li><i class="ti-check"></i> Hotel ut nisan the duru</li>
                                    <li><i class="ti-check"></i> Orci miss natoque vasa ince</li>
                                    <li><i class="ti-close unavailable"></i>Clean sorem ipsum morbin</li>
                                </ul>
                            </div>
                        </div>
                        <div class="pricing-card">
                            <img src="HomePage/img/pricing/2.jpg" alt="">
                            <div class="desc">
                                <div class="name">Drinks included</div>
                                <div class="amount">$30<span>/ daily</span></div>
                                <ul class="list-unstyled list">
                                    <li><i class="ti-check"></i> Hotel ut nisan the duru</li>
                                    <li><i class="ti-check"></i> Orci miss natoque vasa ince</li>
                                    <li><i class="ti-close unavailable"></i>Clean sorem ipsum morbin</li>
                                </ul>
                            </div>
                        </div>
                        <div class="pricing-card">
                            <img src="HomePage/img/pricing/3.jpg" alt="">
                            <div class="desc">
                                <div class="name">Room Breakfast</div>
                                <div class="amount">$30<span>/ daily</span></div>
                                <ul class="list-unstyled list">
                                    <li><i class="ti-check"></i> Hotel ut nisan the duru</li>
                                    <li><i class="ti-check"></i> Orci miss natoque vasa ince</li>
                                    <li><i class="ti-close unavailable"></i>Clean sorem ipsum morbin</li>
                                </ul>
                            </div>
                        </div>
                        <div class="pricing-card">
                            <img src="HomePage/img/pricing/4.jpg" alt="">
                            <div class="desc">
                                <div class="name">Safe & Secure</div>
                                <div class="amount">$15<span>/ daily</span></div>
                                <ul class="list-unstyled list">
                                    <li><i class="ti-check"></i> Hotel ut nisan the duru</li>
                                    <li><i class="ti-check"></i> Orci miss natoque vasa ince</li>
                                    <li><i class="ti-close unavailable"></i>Clean sorem ipsum morbin</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Reservation & Booking Form -->
    <section class="testimonials">
        <div class="background bg-img bg-fixed section-padding pb-0" data-background="HomePage/img/slider/2.jpg" data-overlay-dark="2">
            <div class="container">
                <div class="row">
                    <!-- Reservation -->
                    <div class="col-md-5 mb-30 mt-30">
                        <p><i class="star-rating"></i></p>
                        <h5>Each of our guest rooms feature a private bath, wi-fi, cable television and include full breakfast.</h5>
                        <div class="reservations mb-30">
                            <div class="icon color-1"><span class="flaticon-call"></span></div>
                            <div class="text">
                                <p class="color-1">Reservation</p> <a class="color-1" href="tel:855-100-4444">855 100 4444</a>
                            </div>
                        </div> 
                        <p><i class="ti-check"></i><small>Call us, it's toll-free.</small></p>
                    </div>
                    <!-- Booking From -->
                    <div class="col-md-5 offset-md-2">
                        <div class="booking-box">
                            <div class="head-box">
                                <h6>Rooms & Suites</h6>
                                <h4>Hotel Booking Form</h4>
                            </div>
                                <div class="section-title text-center">
                                    <h1><?php echo htmlspecialchars($typeName ?? 'Rooms &amp; Suites'); ?></h1>
                                    <p>Discover our comfortable and elegant rooms, designed for your perfect stay.</p>
                                </div>
                                            <div class="input1_wrapper">
                                                <label>Check in</label>
                                                <div class="input1_inner">
                                                    <input type="text" class="form-control input datepicker" placeholder="Check in">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input1_wrapper">
                                                <label>Check out</label>
                                                <div class="input1_inner">
                                                    <input type="text" class="form-control input datepicker" placeholder="Check out">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="select1_wrapper">
                                                <label>Adults</label>
                                                <div class="select1_inner">
                                                    <select class="select2 select" style="width: 100%">
                                                        <option value="0">Adults</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="select1_wrapper">
                                                <label>Children</label>
                                                <div class="select1_inner">
                                                    <select class="select2 select" style="width: 100%">
                                                        <option value="0">Children</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn-form1-submit mt-15">Check Availability</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Clients -->
    <section class="clients">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                <div class="owl-carousel owl-theme">
                    <div class="clients-logo">
                        <a href="#0"><img src="HomePage/img/clients/1.png" alt=""></a>
                    </div>
                    <div class="clients-logo">
                        <a href="#0"><img src="HomePage/img/clients/2.png" alt=""></a>
                    </div>
                    <div class="clients-logo">
                        <a href="#0"><img src="HomePage/img/clients/3.png" alt=""></a>
                    </div>
                    <div class="clients-logo">
                        <a href="#0"><img src="HomePage/img/clients/4.png" alt=""></a>
                    </div>
                    <div class="clients-logo">
                        <a href="#0"><img src="HomePage/img/clients/5.png" alt=""></a>
                    </div>
                    <div class="clients-logo">
                        <a href="#0"><img src="img/clients/6.png" alt=""></a>
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
                                
                                <div class="footer-language"> <i class="lni ti-world"></i>
                                    <select onchange="location = this.value;">
                                        <option value="#0">English</option>
                                        <option value="#0">German</option>
                                    </select>
                                </div>
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
    <!-- Availability modal helpers and room-by-type search -->
    <div class="modal fade" id="availabilityModalByType" tabindex="-1" role="dialog" aria-labelledby="availabilityModalByTypeLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="availabilityModalByTypeLabel">Available Rooms</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="availabilityByTypeBody" class="row"></div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.booking-inner .form1');
        if (!form) return;

        function showModal(elId) {
            const modalEl = document.getElementById(elId);
            if (!modalEl) return;
            if (window.jQuery && typeof window.jQuery('#' + elId).modal === 'function') {
                window.jQuery('#' + elId).modal('show');
                return;
            }
            modalEl.classList.add('show');
            modalEl.style.display = 'block';
            modalEl.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');
            let backdrop = document.querySelector('.modal-backdrop');
            if (!backdrop) {
                backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
            }
            const dismissEls = modalEl.querySelectorAll('[data-dismiss="modal"]');
            dismissEls.forEach(el => {
                if (!el._handler) {
                    el._handler = function(evt) { evt && evt.preventDefault(); hideModal(elId); };
                    el.addEventListener('click', el._handler);
                }
            });
        }

        function hideModal(elId) {
            const modalEl = document.getElementById(elId);
            if (!modalEl) return;
            if (window.jQuery && typeof window.jQuery('#' + elId).modal === 'function') {
                window.jQuery('#' + elId).modal('hide');
                return;
            }
            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
            modalEl.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.parentNode.removeChild(backdrop);
        }

        // parse dates like welcome page
        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function parseDateFlexible(s) {
            if (!s) return null;
            if (s.indexOf('/') !== -1) {
                const parts = s.split('/').map(p => p.trim());
                if (parts.length === 3) return new Date(parts[2] + '-' + parts[1] + '-' + parts[0]);
            }
            const d = new Date(s);
            return isNaN(d.getTime()) ? null : d;
        }

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const inputCheckIn = form.querySelector('#check_in') || form.querySelector('input[name="check_in"]') || form.querySelectorAll('.datepicker')[0];
            const inputCheckOut = form.querySelector('#check_out') || form.querySelector('input[name="check_out"]') || form.querySelectorAll('.datepicker')[1];
            const checkIn = inputCheckIn ? inputCheckIn.value : '';
            const checkOut = inputCheckOut ? inputCheckOut.value : '';

            const inDate = parseDateFlexible(checkIn);
            const outDate = parseDateFlexible(checkOut);
            if (inDate && outDate) {
                const inTime = new Date(inDate.getFullYear(), inDate.getMonth(), inDate.getDate()).getTime();
                const outTime = new Date(outDate.getFullYear(), outDate.getMonth(), outDate.getDate()).getTime();
                if (inTime >= outTime) {
                    const b = document.getElementById('availabilityByTypeBody');
                    b.innerHTML = '<div class="col-12 text-center py-4 text-warning">Không thể check-in và check-out cùng một ngày. Vui lòng chọn ngày check-out ít nhất 1 ngày sau check-in.</div>';
                    showModal('availabilityModalByType');
                    return;
                }
            }

            const modalBody = document.getElementById('availabilityByTypeBody');
            modalBody.innerHTML = '<div class="col-12 text-center py-4">Loading...</div>';

            try {
                // Retrieve current type from URL or window scope
                const urlParams = new URLSearchParams(window.location.search);
                const type = urlParams.get('type') || '';
                const url = new URL('/api/rooms/available/by_type', window.location.origin);
                // The API expects 'room_type_id' (backend validation message shows this). Send that param.
                if (type) url.searchParams.set('room_type_id', type);
                if (checkIn) url.searchParams.set('check_in', checkIn);
                if (checkOut) url.searchParams.set('check_out', checkOut);

                const res = await fetch(url.toString(), { credentials: 'same-origin' });

                // If server returns non-2xx show status and response body for debugging
                if (!res.ok) {
                    let bodyText;
                    try { bodyText = await res.text(); } catch (e) { bodyText = '<unable to read response body>'; }
                    console.error('rooms2: API returned non-OK', res.status, bodyText);
                    modalBody.innerHTML = `
                        <div class="col-12 text-center py-4 text-danger">
                            Lỗi khi gọi API (HTTP ${res.status}).<br>
                            ${escapeHtml(bodyText).slice(0, 300)}
                            <div class="mt-2 small text-muted">Kiểm tra console hoặc network tab để biết chi tiết.</div>
                        </div>`;
                    showModal('availabilityModalByType');
                    return;
                }

                const data = await res.json().catch(async (e) => {
                    const txt = await res.text().catch(()=>'');
                    console.error('rooms2: Failed to parse JSON', e, txt);
                    return {__rawText: txt};
                });

                // normalize rooms array from several possible shapes
                const rooms = Array.isArray(data) ? data : (data.rooms || data.data || data.items || []);

                // If API returned an empty array but included a message or error, show it
                if ((!rooms || rooms.length === 0)) {
                    const serverMsg = (data && (data.message || data.error || data.msg)) ? (data.message || data.error || data.msg) : null;
                    const debugSnippet = serverMsg ? escapeHtml(String(serverMsg)) : (data && data.__rawText ? escapeHtml(String(data.__rawText)) : '');
                    modalBody.innerHTML = `\
                        <div class="col-12 text-center py-4">\
                            Không có phòng phù hợp cho ngày bạn chọn. Vui lòng thử chọn ngày khác hoặc liên hệ khách sạn để hỗ trợ.\
                            ${debugSnippet ? ('<div class="mt-2 small text-muted">Info: ' + debugSnippet + '</div>') : '' }\
                        </div>`;
                } else {
                    modalBody.innerHTML = rooms.map(room => {
                        const id = room.id || room.MaPhong || room.IDPhong || '';
                        const title = room.name || room.TenPhong || room.Ten || room.ten || 'Room';
                        const desc = room.description || room.MoTa || room.mo_ta || '';
                        const images = room.images || room.HinhAnh || room.hinh_anh || [];
                        const img = (Array.isArray(images) && images.length) ? images[0] : (room.image || room.AnhDaiDien || 'HomePage/img/rooms/1.jpg');
                        const capacity = room.capacity || room.SucChua || room.SoNguoi || room.SoNguoiToiDa || '';
                        const price = room.price || room.Gia || room.gia || '';

                        return `\
                            <div class="col-md-6 mb-3">\
                                <div class="card">\
                                    <div style="height:180px;overflow:hidden;display:flex;align-items:center;justify-content:center">\
                                        <img src="${img}" alt="${title}" style="width:100%;height:100%;object-fit:cover">\
                                    </div>\
                                    <div class="card-body">\
                                        <h5 class="card-title">${title} ${id?('<small class="text-muted">#'+id+'</small>'):''}</h5>\
                                        ${desc?('<p class="card-text">'+desc+'</p>') : ''}\
                                        <p class="mb-1"><small class="text-muted">Capacity: ${capacity}</small></p>\
                                        ${price?('<p class="mb-0"><strong>'+price+'</strong></p>'):''}\
                                    </div>\
                                    <div class="card-footer">\
                                        <a href="/roomdetails.php?id=${id}" class="btn btn-sm btn-outline-primary">Details</a>\
                                        <a href="/booking?room=${id}&check_in=${encodeURIComponent(checkIn)}&check_out=${encodeURIComponent(checkOut)}" class="btn btn-sm btn-primary">Book Now</a>\
                                    </div>\
                                </div>\
                            </div>`;
                    }).join('\n');
                }

                showModal('availabilityModalByType');
            } catch (err) {
                console.error('Error fetching availability by type', err);
                modalBody.innerHTML = '<div class="col-12 text-center py-4 text-danger">Không thể tải danh sách phòng. Có thể do lỗi mạng hoặc không có phòng cho ngày đã chọn. Vui lòng thử lại sau hoặc liên hệ chúng tôi để được hỗ trợ.</div>';
                showModal('availabilityModalByType');
            }
        });
    });
    </script>
</body>

<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/rooms2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:56:17 GMT -->
</html>

