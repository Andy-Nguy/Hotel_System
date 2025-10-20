<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/facilities.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:56:19 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>The Cappa Luxury Hotel</title>
    <meta name="description" content="THE CAPPA is a modern, elegant HTML template for luxury hotels, resorts, and vacation rentals. Fully responsive, customizable, and perfect for hospitality websites.">
    <meta name="author" content="THE CAPPA Luxury Hotel Template by DuruThemes">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="/HomePage/img/favicon.png" type="image/png" sizes="32x32">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300;400&amp;family=Barlow:wght@400&amp;family=Gilda+Display&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/HomePage/css/plugins.css" />
    <link rel="stylesheet" href="/HomePage/css/style.css" />
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
    <!-- Header Banner -->
    <div class="banner-header section-padding valign bg-img bg-fixed" data-overlay-dark="3" data-background="/HomePage/img/slider/5.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-left caption mt-90">
                    <h5>Get in touch</h5>
                    <h1>Contact Us</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact -->
    <section class="contact section-padding">
        <div class="container">
            <div class="row mb-90">
                <div class="col-md-6 mb-60">
                    <h3>The Cappa Luxury Hotel</h3>
                    <p>Khách sạn của chúng tôi mang đến trải nghiệm lưu trú độc đáo và thoải mái, được thiết kế để phục vụ mọi nhu cầu của quý khách. Quý khách sẽ tìm thấy sự riêng tư tuyệt đối, cùng với dịch vụ chuyên nghiệp và tận tâm, đảm bảo một kỳ nghỉ thư giãn và đáng nhớ.</p>
                    <div class="reservations mb-30">
                        <div class="icon"><span class="flaticon-call"></span></div>
                        <div class="text">
                            <p>Reservation</p> <a href="tel:855-100-4444">855 100 4444</a>
                        </div>
                    </div>
                    <div class="reservations mb-30">
                        <div class="icon"><span class="flaticon-envelope"></span></div>
                        <div class="text">
                            <p>Email Info</p> <a href="mailto:info@luxuryhotel.com">info@luxuryhotel.com</a>
                        </div>
                    </div>
                    <div class="reservations">
                        <div class="icon"><span class="flaticon-location-pin"></span></div>
                        <div class="text">
                            <p>Address</p> 140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Thành phố Hồ Chí Minh 700000
                        </div>
                    </div>
                </div>
            </div>
            <!-- Map Section -->
            <div class="row">
                <div class="col-md-12 map animate-box" data-animate-effect="fadeInUp">
                    <iframe src="https://www.google.com/maps?q=140%20L%C3%AA%20Tr%E1%BB%8Bng%20T%E1%BA%A5n%2C%20T%C3%A2y%20Th%E1%BA%A1nh%2C%20T%C3%A2n%20Ph%C3%BA%2C%20Th%C3%A0nh%20ph%E1%BB%91%20H%E1%BB%93%20Ch%C3%AD%20Minh%20700000%2C%20Vietnam&hl=vi&output=embed" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>
    <!-- Reservation & Booking Form -->
    <?php echo $__env->make('partials.reservation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Footer -->
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- jQuery -->
    <script src="/HomePage/js/jquery-3.7.1.min.js"></script>
    <script src="/HomePage/js/jquery-migrate-3.5.0.min.js"></script>
    <script src="/HomePage/js/modernizr-2.6.2.min.js"></script>
    <script src="/HomePage/js/imagesloaded.pkgd.min.js"></script>
    <script src="/HomePage/js/jquery.isotope.v3.0.2.js"></script>
    <script src="/HomePage/js/pace.js"></script>
    <script src="/HomePage/js/popper.min.js"></script>
    <script src="/HomePage/js/bootstrap.min.js"></script>
    <script src="/HomePage/js/scrollIt.min.js"></script>
    <script src="/HomePage/js/jquery.waypoints.min.js"></script>
    <script src="/HomePage/js/jquery.stellar.min.js"></script>
    <script src="/HomePage/js/owl.carousel.min.js"></script>
    <script src="/HomePage/js/jquery.stellar.min.js"></script>
    <script src="/HomePage/js/jquery.magnific-popup.js"></script>
    <script src="/HomePage/js/YouTubePopUp.js"></script>
    <script src="/HomePage/js/select2.js"></script>
    <script src="/HomePage/js/datepicker.js"></script>
    <script src="/HomePage/js/smooth-scroll.min.js"></script>
    <script src="/HomePage/js/custom.js"></script>
</body>

<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/facilities.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:56:19 GMT -->
</html>
<?php /**PATH I:\Ky_06_2025_2026\php\New folder\Hotel_System\service\resources\views/Orther_user/contact.blade.php ENDPATH**/ ?>