<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/spa-wellness.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:56:18 GMT -->
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
    <header class="cappa-header">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-6 col-md-6 cappa-logo-wrap">
                    <a href="index.html" class="cappa-logo"><img src="/HomePage/img/logo.png" alt=""></a>
                </div>
                <!-- Menu Burger -->
                <div class="col-6 col-md-6 text-right cappa-wrap-burger-wrap"> <a href="#" class="cappa-nav-toggle cappa-js-cappa-nav-toggle"><i></i></a> </div>
            </div>
        </div>
    </header>
    <!-- Spa-Wellness Slider -->
    <header class="header slider">
        <div class="owl-carousel owl-theme">
            <!-- The opacity on the image is made with "data-overlay-dark="number". You can change it using the numbers 0-9. -->
            <div class="text-center item bg-img" data-overlay-dark="3" data-background="/HomePage/img/spa/3.jpg"></div>
            <div class="text-center item bg-img" data-overlay-dark="3" data-background="/HomePage/img/spa/1.jpg"></div>
            <div class="text-center item bg-img" data-overlay-dark="3" data-background="/HomePage/img/spa/2.jpg"></div>
        </div>
        <!-- arrow down -->
        <div class="arrow bounce text-center">
            <a href="#" data-scroll-nav="1" class=""> <i class="ti-arrow-down"></i> </a>
        </div>
    </header>
    <!-- Spa-Wellness Content -->
    <section class="rooms-page section-padding" data-scroll-index="1">
        <div class="container">
            <div class="row">
                <div class="col-md-12"> <span><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i><i class="star-rating"></i></span>
                    <div class="section-subtitle">Vô Vàn Cách Để Thư Giãn</div>
                    <div class="section-title">Spa & Chăm Sóc Sức Khỏe</div>
                    <p class="mb-30">Khu Spa & Wellness của chúng tôi là ốc đảo thanh bình, nơi thời gian dường như ngừng lại để quý khách hoàn toàn thư thái. Quý khách sẽ được chào đón bằng hương thơm dịu nhẹ và âm nhạc êm ái, kiến tạo nên một hành trình tái tạo năng lượng tuyệt đối.<br>
                        Tại đây, chúng tôi cung cấp các liệu pháp trị liệu chuyên sâu và massage phục hồi năng lượng, được cá nhân hóa theo nhu cầu. Các gói trị liệu signature kết hợp tinh hoa Đông - Tây, sử dụng thảo dược tự nhiên và khoáng chất cao cấp, giúp thư giãn cơ bắp sâu và lưu thông cơ thể tối ưu.<br>
                        Đội ngũ chuyên viên tận tâm và giàu kinh nghiệm của chúng tôi là yếu tố then chốt tạo nên sự khác biệt. Mỗi chuyên viên đều được đào tạo chuyên sâu về giải phẫu học và nghệ thuật trị liệu, cam kết mang lại trải nghiệm chính xác và hiệu quả nhất. Họ sẽ lắng nghe nhu cầu của quý khách để tùy chỉnh áp lực, loại tinh dầu và kỹ thuật phù hợp, giúp quý khách cân bằng cơ thể và tâm trí một cách hoàn hảo. Mục tiêu tối thượng của chúng tôi là đảm bảo rằng mỗi khoảnh khắc quý khách dành tại Spa đều là sự đầu tư xứng đáng cho sức khỏe và mang lại một trải nghiệm nghỉ dưỡng thực sự trọn vẹn, vượt xa mọi mong đợi.
                    </p>
                </div>
                <div class="col-md-12">
                    <div class="reservations">
                        <div class="icon"><span class="flaticon-call"></span></div>
                        <div class="text">
                            <p>Reservations</p> <a href="tel:855-100-4444">855 100 4444</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services -->
    <section class="services section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 p-0 animate-box" data-animate-effect="fadeInLeft">
                    <div class="img left">
                        <img src="/HomePage/img/spa/3.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-6 p-0 bg-cream valign animate-box" data-animate-effect="fadeInRight">
                    <div class="content">
                        <div class="cont text-left">
                            <div class="info">
                                <h6>Experiences</h6>
                            </div>
                            <h4>Trung tâm Spa (Spa Center)</h4>
                            <p>Trung tâm Spa là nơi lý tưởng để quý khách trốn khỏi sự hối hả của cuộc sống, đắm mình vào các liệu pháp thư giãn cao cấp. Chúng tôi cam kết mang đến những khoảnh khắc tĩnh lặng và phục hồi sức khỏe tuyệt vời nhất.</p>
                            <p><span class="flaticon-clock"></span> Giờ mở cửa hàng ngày: 7:00 sáng – 9:00 tối </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 bg-cream p-0 order2 valign animate-box" data-animate-effect="fadeInLeft">
                    <div class="content">
                        <div class="cont text-left">
                            <div class="info">
                                <h6>Modern</h6>
                            </div>
                            <h4>Trung tâm Thể hình <br>Fitness Center</h4>
                            <p>Trung tâm Thể hình được trang bị đầy đủ các thiết bị tập luyện hiện đại, giúp quý khách dễ dàng duy trì thói quen rèn luyện sức khỏe. Không gian thoáng đãng, kích thích tinh thần thể thao.</p>
                            <p><span class="flaticon-clock"></span> Giờ mở cửa hàng ngày: 6:00 sáng – 9:00 tối </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-0 order1 animate-box" data-animate-effect="fadeInRight">
                    <div class="img">
                        <img src="/HomePage/img/spa/2.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 p-0 animate-box" data-animate-effect="fadeInLeft">
                    <div class="img left">
                        <img src="/HomePage/img/spa/1.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-6 p-0 bg-cream valign animate-box" data-animate-effect="fadeInRight">
                    <div class="content">
                        <div class="cont text-left">
                            <div class="info">
                                <h6>Experiences</h6>
                            </div>
                            <h4>Câu lạc bộ Sức khỏe & Hồ bơi <br>The Health Club & Pool</h4>
                            <p>Câu lạc bộ Sức khỏe & Hồ bơi mang đến một không gian thư giãn hoàn hảo. Quý khách có thể bơi lội trong làn nước mát, hoặc đơn giản là nằm dài thư giãn bên hồ bơi để tận hưởng ánh nắng và sự yên bình.</p>
                            <p><span class="flaticon-clock"></span> Giờ mở cửa hàng ngày: 10:00 sáng – 7:00 tối </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Faqs -->
    <section class="section-padding bg-cream">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-subtitle">F.A.Qs</div>
                    <div class="section-title">Quy Định Tại Spa</div>
                </div>
                <div class="col-md-12">
                    <ul class="accordion-box clearfix">
                        <li class="accordion block">
                            <div class="acc-btn">Thời Gian Đến (Arriving at The Spa)</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">Xin quý khách vui lòng có mặt tại Spa 15 phút trước giờ hẹn trị liệu để có đủ thời gian tận hưởng sự bình yên và tĩnh lặng của không gian Spa. Việc đến muộn sẽ làm giảm thời gian trị liệu của quý khách.</div>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">Điện Thoại Di Động</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">Xin quý khách vui lòng không sử dụng điện thoại di động trong khuôn viên Spa. Vui lòng luôn giữ điện thoại ở chế độ im lặng (silent mode) trong suốt thời gian quý khách ở đây.</div>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">Vật Dụng Cá Nhân Có Giá Trị</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">Chúng tôi có cung cấp nơi an toàn để quý khách cất giữ vật dụng cá nhân bên trong khu vực Spa. Tuy nhiên, chúng tôi không chịu trách nhiệm về bất kỳ tổn thất hoặc hư hỏng nào. Chúng tôi khuyến nghị quý khách nên cất giữ các vật dụng có giá trị bên trong két sắt an toàn đặt trong phòng khách sạn/suite của mình.</div>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">Vấn Đề Sức Khỏe Cần Lưu Ý (Health Matters)</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">Vui lòng thông báo cho chúng tôi về các tình trạng sức khỏe của quý khách như huyết áp cao, dị ứng, cũng như việc mang thai hoặc bất kỳ mối quan tâm nào liên quan đến sức khỏe khi quý khách đặt lịch hẹn. Chúng tôi không khuyến nghị quý khách sử dụng đồ uống có cồn trước, ngay sau các liệu pháp spa, hoặc trước khi sử dụng bất kỳ tiện nghi nào trong khu Spa và Câu lạc bộ Sức khỏe.</div>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">Quy Định Dành Cho Trẻ Em</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">Độ tuổi tối thiểu để vào Spa, Câu lạc bộ Sức khỏe (The Health Club) và khu vực trị liệu bằng nước nóng/lạnh (hydrothermal facilities) là 16 tuổi. Trẻ em dưới 16 tuổi có thể sử dụng hồ bơi của khách sạn nếu có người lớn/phụ huynh đi kèm.</div>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">An Toàn (Safety)</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">Độ sâu tối đa của hồ bơi là 1.60 mét. Không có nhân viên cứu hộ túc trực tại hồ bơi. Trẻ em chỉ được phép sử dụng hồ bơi nếu có người lớn/phụ huynh giám hộ đi kèm.</div>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">Quy Định Về Hút Thuốc (Smoking)</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">Xin quý khách lưu ý không được phép hút thuốc trong khu vực Spa, Câu lạc bộ Sức khỏe (The Health Club) hoặc phòng xông hơi (sauna).</div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Testiominals -->
    <?php echo $__env->make('partials.testiominals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Footer -->
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- jQuery -->
    <script src="/HomePage/js/jquery-3.7.1.min.js"></script>
    <script src="/HomePage/js/jquery-migrate-3.5.0.min.js"></script>
    <script src="/HomePage/js/modernizr-2.6.2.min.js"></script>
    <script src="/HomePage/js/imagesloaded.pkgd.min.js"></script>
    <script src="/HomePage/js/jquery.isotope.v3.0.2.js"></script>
    <script src="/HomePage/js/jquery.waypoints.min.js"></script>
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

<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/spa-wellness.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:56:19 GMT -->
</html>
<?php /**PATH I:\Ky_06_2025_2026\php\New folder\Hotel_System\service\resources\views/Orther_user/spa_wellness.blade.php ENDPATH**/ ?>