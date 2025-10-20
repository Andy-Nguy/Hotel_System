<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/about.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:56:16 GMT -->
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
    <div class="banner-header section-padding valign bg-img bg-fixed" data-overlay-dark="4" data-background="/HomePage/img/slider/1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 caption mt-90">
                    <h5>Luxury Hotel</h5>
                    <h1>About Us</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- About -->
    <?php echo $__env->make('partials.about', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Facilties -->
    <?php echo $__env->make('partials.facilities', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Team -->
    <section class="team section-padding bg-cream">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-subtitle">Professionals</div>
                    <div class="section-title">Meet The Team</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 owl-carousel owl-theme">
                    <div class="item">
                        <div class="img"> <img src="/HomePage/img/team/3.jpg" alt=""> </div>
                        <div class="info">
                            <h6>Nguyễn Phương Anh</h6>
                            <p>2001220152</p>
                            <div class="social valign">
                                <div class="full-width"> 
                                   <p>nguyenphuonganh061024@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="img"> 
                        <img src="/HomePage/img/team/7.jpg" alt=""> </div>
                        <div class="info">
                            <h6>Nguyễn Tô Duy Anh</h6>
                            <p>2001220215</p>
                            <div class="social valign">
                                <div class="full-width"> 
                                    <p>duyanh05012004@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="img"> <img src="/HomePage/img/team/2.jpg" alt=""> </div>
                        <div class="info">
                            <h6>Nguyễn Dương Lệ Chi</h6>
                            <p>2001220524</p>
                            <div class="social valign">
                                <div class="social valign">
                                    <div class="full-width"> 
                                       <p>nguyenduonglechi.1922@gmail.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="img"> <img src="/HomePage/img/team/6.jpg" alt=""> </div>
                        <div class="info">
                            <h6>Nguyễn Vương Hồng Đào</h6>
                            <p>2001220867</p>
                            <div class="social valign">
                                <div class="full-width"> 
                                   <p>nguyenvuonghongdao2004@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials -->
    <?php echo $__env->make('partials.testiominals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/about.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:56:17 GMT -->
</html>
<?php /**PATH I:\Ky_06_2025_2026\php\New folder\Hotel_System\service\resources\views/Orther_user/about.blade.php ENDPATH**/ ?>