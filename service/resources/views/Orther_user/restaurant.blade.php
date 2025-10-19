<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/restaurant.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:56:18 GMT -->
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
    @include('partials.menu')
    <!-- Logo & Menu Burger -->
    @include('partials.logo&menuburger')
    <!-- Restaurant Slider -->
    <header class="header slider">
        <div class="owl-carousel owl-theme">
            <!-- The opacity on the image is made with "data-overlay-dark="number". You can change it using the numbers 0-9. -->
            <div class="text-center item bg-img" data-overlay-dark="3" data-background="/HomePage/img/restaurant/1.jpg"></div>
            <div class="text-center item bg-img" data-overlay-dark="3" data-background="/HomePage/img/restaurant/2.jpg"></div>
            <div class="text-center item bg-img" data-overlay-dark="3" data-background="/HomePage/img/restaurant/3.jpg"></div>
        </div>
        <!-- arrow down -->
        <div class="arrow bounce text-center">
            <a href="#" data-scroll-nav="1" class=""> <i class="ti-arrow-down"></i> </a>
        </div>
    </header>
    <!-- Restaurant Content -->
    <section class="rooms-page section-padding" data-scroll-index="1">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-left"> 
                    <span>
                        <i class="star-rating"></i>
                        <i class="star-rating"></i>
                        <i class="star-rating"></i>
                        <i class="star-rating"></i>
                        <i class="star-rating"></i>
                    </span>
                    <div class="section-subtitle">Trải Nghiệm Thức Tỉnh Các Giác Quan</div>
                    <div class="section-title">Nhà Hàng (The Restaurant)</div>
                </div>
                <div class="col-md-12">
                    <p class="mb-30">Dưới sự dẫn dắt của Bếp trưởng Micheal Martin, The Restaurant nổi tiếng với ẩm thực xuất sắc và không gian độc đáo. Phòng ăn lộng lẫy có ba khu bếp mở (studio kitchens), cho phép quý khách thưởng thức trực tiếp hình ảnh và âm thanh của nghệ thuật ẩm thực đang được trình diễn.
                        <br>
                        Thực đơn là sự kết hợp tinh tế giữa phong cách Á và Âu, với tuyển chọn các món ăn cổ điển được yêu thích cùng những sáng tạo mới đầy hấp dẫn để quý khách khám phá.
                        <br>
                        Các tín đồ phô mai chắc chắn sẽ bị cuốn hút bởi Hầm Rượu và Phô mai (The Wine and Cheese Cellar), được bao bọc bởi tường kính cao năm mét. Tại đây, đội ngũ nhân viên am hiểu của chúng tôi sẽ giới thiệu cho quý khách những tuyệt tác ẩm thực vĩ đại nhất của New York.
                    </p>
                    <h6>Giờ Hoạt Động</h6>
                    <ul class="list-unstyled page-list mb-30">
                        <li>
                            <div class="page-list-icon"> <span class="ti-time"></span> </div>
                            <div class="page-list-text">
                                <p>Bữa sáng: 7.00 sáng – 11.00 sáng (Hàng ngày)</p>
                            </div>
                        </li>
                        <li>
                            <div class="page-list-icon"> <span class="ti-time"></span> </div>
                            <div class="page-list-text">
                                <p>Bữa trưa: 12.00 trưa – 2.00 chiều (Hàng ngày)</p>
                            </div>
                        </li>
                        <li>
                            <div class="page-list-icon"> <span class="ti-time"></span> </div>
                            <div class="page-list-text">
                                <p>Bữa tối: Mở cửa từ 6:30 tối, nhận gọi món cuối lúc 10:00 tối (Hàng ngày)</p>
                            </div>
                        </li>
                    </ul>
                    <h6>Quy Định Trang Phục (Dress Code)</h6>
                    <p>Lịch sự/Thanh lịch thường ngày (Không được phép mặc quần đùi, đội mũ hoặc mang dép/sandal).</p>
                    <h6>Sân Hiên (Terrace)</h6>
                    <p>Chỉ phục vụ đồ uống</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Restaurant Menu -->
    <section id="menu" class="restaurant-menu menu section-padding bg-blck">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-subtitle"><span>Luxury Hotel</span></div>
                    <div class="section-title"><span>Restaurant Menu</span></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="tabs-icon col-md-10 offset-md-1 text-center">
                            <div class="owl-carousel owl-theme">
                                <div id="tab-1" class="active item">
                                    <h6>Món Khai Vị</h6>
                                </div>
                                <div id="tab-2" class="item">
                                    <h6>Món Chính</h6>
                                </div>
                                <div id="tab-3" class="item">
                                    <h6>Các Loại Gỏi/Salad</h6>
                                </div>
                                <div id="tab-4" class="item">
                                    <h6>Rượu Vang</h6>
                                </div>
                                <div id="tab-5" class="item">
                                    <h6>Ăn Sáng</h6>
                                </div>
                                <div id="tab-6" class="item">
                                    <h6>Tráng Miệng (Dessert)</h6>
                                </div>
                            </div>
                        </div>
                        <div class="restaurant-menu-content col-md-12">
                            <!-- Starters -->
                            <div id="tab-1-content" class="cont active">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="menu-info">
                                            <h5>Mozzarella Dippers <span class="price">270000đ</span></h5>
                                            <p>Phô mai Mozzarella que chiên giòn, dùng kèm sốt Marinara.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Onion Rings <span class="price">320000đ</span></h5>
                                            <p>Hành tây chiên giòn, sốt aioli khói.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Fried Jalapeno <span class="price">52000đ</span></h5>
                                            <p>Đồ chua jalapeno chiên, sốt cheddar</p>
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-2">
                                        <div class="menu-info">
                                            <h5>Buffalo Wings <span class="price">370000đ</span></h5>
                                            <p>Đùi gà chiên cay, sốt phô mai xanh, cà rốt, cần tây</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Chilli Con Carne <span class="price">320000đ</span></h5>
                                            <p>Thịt bò xay cay, thịt xông khói, đậu kidney</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Potato Skins <span class="price">42000đ</span></h5>
                                            <p>Vỏ khoai tây giòn; có hai lựa chọn: thịt xông khói & phô mai Cheddar hoặc rau củ.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Mains -->
                            <div id="tab-2-content" class="cont">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="menu-info">
                                            <h5>Rusty’s Burger <span class="price">270000đ</span></h5>
                                            <p>Bánh mì kẹp sườn bò xé hun khói, sốt BBQ, phô mai Cheddar và hành tây chiên giòn.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Cajun Fish Steak <span class="price">320000đ</span></h5>
                                            <p>Cá chẽm (seabass) phi lê tẩm gia vị Cajun, khoai tây bi chiên giòn, dùng kèm salad.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Southern Fried Chicken <span class="price">520000đ</span></h5>
                                            <p>Ức gà tẩm bột Cajun chiên kiểu miền Nam, khoai tây chiên và sốt mật ong mù tạt.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-2">
                                        <div class="menu-info">
                                            <h5>Crab Cake <span class="price">370000đ</span></h5>
                                            <p>Bánh cua tẩm bột chiên, dùng kèm sốt Tartar và salad táo & thì là.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Baby Back Ribs <span class="price">320000đ</span></h5>
                                            <p>Sườn heo non (baby pork ribs) phết sốt BBQ, dùng kèm salad bắp cải (coleslaw) và khoai tây chiên.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Smokehouse Combo <span class="price">420000đ</span></h5>
                                            <p>Thịt bò ức (brisket) hun khói, sườn và xúc xích hun khói, dùng kèm salad bắp cải (coleslaw) và bánh mì bắp.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Salads -->
                            <div id="tab-3-content" class="cont">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="menu-info">
                                            <h5>Ceaser Salad <span class="price">47000đ</span></h5>
                                            <p>Xà lách Romaine, bánh mì nướng giòn (croutons), phô mai Parmigiano, dùng với sốt Caesar.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Waldorf Salad <span class="price">52000đ</span></h5>
                                            <p>Xà lách, cần tây, táo, nho, óc chó, sốt Waldorf</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Quinoa & Avocado Salad <span class="price">52000đ</span></h5>
                                            <p>Hạt Quinoa, bơ (avocado), xà lách hỗn hợp. Hạt các loại, trái cây sấy và tươi.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-2">
                                        <div class="menu-info">
                                            <h5>Grilled Salmon Salad <span class="price">37000đ</span></h5>
                                            <p>Cá hồi nướng, rau xanh hỗn hợp, nụ bạch hoa (capers), lát cam tươi.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Chicken Cobb Salad <span class="price">32000đ</span></h5>
                                            <p>Xà lách Iceberg, cà chua bi, phô mai xanh (blue cheese), bơ (avocado), thịt xông khói (bacon).</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Salad Chicken <span class="price">42000đ</span></h5>
                                            <p> Sốt Caesar. Tùy chọn thêm ức gà nướng.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Wine -->
                            <div id="tab-4-content" class="cont">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="menu-info">
                                            <h5>Château d'Yquem 2011 <span class="price">4000000đ</span></h5>
                                            <p>Dessert Wine, Bordeaux, Graves, Sauternes</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Alvear Cream NV <span class="price">300000đ</span></h5>
                                            <p>Dessert, Fortified Wine, Andalucia</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Chateau D'yquem 1990 <span class="price">9000000đ</span></h5>
                                            <p>Dessert Wine, Bordeaux, Graves, Sauternes</p>
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-2">
                                        <div class="menu-info">
                                            <h5>La Grande Année 2007 <span class="price">4000000đ</span></h5>
                                            <p>Rượu vang Hồng (Rosé), Champagne (Pháp)</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Sine Qua Non 2012 <span class="price">5200000đ</span></h5>
                                            <p>Syrah, Shiraz & Blends, California</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>W.S. Keyes Winery 2006 <span class="price">2400000đ</span></h5>
                                            <p>Merlot, California, Napa, Howell Mountain</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Breakfast -->
                            <div id="tab-5-content" class="cont">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="menu-info">
                                            <h5>Egg Benedict <span class="price">600000đ</span></h5>
                                            <p>Bánh muffin Anh, thịt bò, sốt Hollandaise, trứng chần.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Texas Benedict <span class="price">300000đ</span></h5>
                                            <p>Bánh muffin Anh, sườn non, sốt BBQ, trứng chần.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Rusty’s Omlette <span class="price">220000đ</span></h5>
                                            <p>Phô mai Mozzarella, phô mai Cheddar, hành tây caramen hóa, đậu đen.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-2">
                                        <div class="menu-info">
                                            <h5>Salmon Bagel <span class="price">300000đ</span></h5>
                                            <p>Cá hồi xông khói, phô mai kem, thì là, xà lách Rocket, hành tây đỏ.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Breakfast Bagel <span class="price">330000đ</span></h5>
                                            <p>Sô cô la, kẹo dẻo Marshmallow, thanh bánh quy.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Rusty’s Pancake <span class="price">400000đ</span></h5>
                                            <p>Dâu tây, sô cô la trắng, sô cô la đen, Crispearls</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Dessert -->
                            <div id="tab-6-content" class="cont">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="menu-info">
                                            <h5>Bourbon Pecan Pie <span class="price">67000đ</span></h5>
                                            <p>Bánh nhân hạt hồ đào (pecan) ngâm Bourbon, dùng kèm kem Vanilla.</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>New York Cheesecake <span class="price">50000đ</span></h5>
                                            <p>Bánh phô mai, dùng kèm salad dâu tây và chanh xanh (lime).</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Rusty’s ice-cream <span class="price">32000đ</span></h5>
                                            <p>Kem Vanilla, kem Bourbon, kem Cookie và kem Sô cô la.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-2">
                                        <div class="menu-info">
                                            <h5>S’mores <span class="price">40000đ</span></h5>
                                            <p>Bánh quy sô cô la chip, kẹo dẻo Marshmallow nướng, và sô cô la</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Rocky Road <span class="price">42000đ</span></h5>
                                            <p>Sô cô la, kẹo dẻo Marshmallow, thanh bánh quy</p>
                                        </div>
                                        <div class="menu-info">
                                            <h5>Apple & Pear Crumble <span class="price">42000đ</span></h5>
                                            <p>Quả lê và táo caramel, vụn yến mạch, kem vanilla</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testiominals -->
    @include('partials.testiominals')
    <!-- Footer -->
    @include('partials.footer')
    <!-- jQuery -->
    <script src="/HomePage/js/jquery-3.7.1.min.js"></script>
    <script src="/HomePage/js/jquery-migrate-3.5.0.min.js"></script>
    <script src="/HomePage/js/modernizr-2.6.2.min.js"></script>
    <script src="/HomePage/js/imagesloaded.pkgd.min.js"></script>
    <script src="/HomePage/js/jquery.isotope.v3.0.2.js"></script>
    <script src="/HomePage/js/jquery.magnific-popup.min.js"></script>
    <script src="/HomePage/js/pace.js"></script>
    <script src="/HomePage/js/popper.min.js"></script>
    <script src="/HomePage/js/bootstrap.min.js"></script>
    <script src="/HomePage/js/scrollIt.min.js"></script>
    <script src="/HomePage/js/jquery.waypoints.min.js"></script>
    <script src="/HomePage/js/jquery.stellar.min.js"></script>
    <script src="/HomePage/js/owl.carousel.min.js"></script>
    <script src="/HomePage/js/jquery.magnific-popup.js"></script>
    <script src="/HomePage/js/YouTubePopUp.js"></script>
    <script src="/HomePage/js/select2.js"></script>
    <script src="/HomePage/js/datepicker.js"></script>
    <script src="/HomePage/js/smooth-scroll.min.js"></script>
    <script src="/HomePage/js/custom.js"></script>
</body>

<!-- Mirrored from duruthemes.com/demo/html/cappa/demo6-light/restaurant.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 18 Sep 2025 01:56:18 GMT -->
</html>
