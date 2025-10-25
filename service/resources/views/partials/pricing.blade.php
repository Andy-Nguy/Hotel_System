@php
// Pricing Partial (Blade-style clean)
// normalize $services so the partial accepts arrays, Collections, or null
if (!isset($services)) {
    $services = [];
} elseif (is_object($services) && method_exists($services, 'toArray')) {
    $services = $services->toArray();
} elseif (!is_array($services)) {
    $services = (array) $services;
}
@endphp
<section class="pricing section-padding bg-blck">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="section-subtitle"><span>Best Prices</span></div>
                <div class="section-title"><span>Dịch Vụ Bổ Sung</span></div>
                <p class="color-2">Chúng tôi mang đến mức giá tốt nhất cho kỳ nghỉ thư giãn và trọn vẹn của quý khách.</p>
                <p class="color-2">Tại đây, mọi trải nghiệm đều được chăm chút tỉ mỉ – từ không gian nghỉ dưỡng sang trọng đến dịch vụ tận tâm, giúp quý khách tận hưởng những khoảnh khắc yên bình và đáng nhớ nhất.</p>
                <p class="color-2">Khách sạn Cappa Luxury luôn sẵn sàng mang đến các dịch vụ bổ sung đa dạng, được thiết kế nhằm đáp ứng mọi nhu cầu nghỉ dưỡng và tiện nghi của quý khách.</p>
                <div class="reservations mb-30">
                    <div class="icon"><span class="flaticon-call"></span></div>
                    <div class="text">
                        <p class="color-2">Đặt phòng</p> <a href="tel:855-100-4444">855 100 4444</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="owl-carousel owl-theme">
                    @if (!empty($services) && is_array($services))
                        @foreach ($services as $i => $s)
                            @php
                                $img = $s['HinhDichVu'] ?? '1.jpg';
                                $imgUrl = '/HomePage/img/pricing/' . rawurlencode($img);
                                $name = $s['TenDichVu'] ?? 'Dịch vụ';
                                $price = isset($s['TienDichVu']) ? number_format((float)$s['TienDichVu'], 0, '.', ',') . '₫' : '';
                                $features = (!empty($s['ThongTin']) && is_array($s['ThongTin'])) ? $s['ThongTin'] : [];
                            @endphp
                            <div class="pricing-card">
                                <img src="{{ $imgUrl }}" alt="{{ $name }}">
                                <div class="desc">
                                    <div class="name">{{ $name }}</div>
                                    @if ($price)<div class="amount">{{ $price }}<span></span></div>@endif
                                    <ul class="list-unstyled list">
                                        @if (!empty($features))
                                            @foreach ($features as $f)
                                                <li><i class="ti-check"></i> {{ $f['ThongTinDV'] ?? '' }}</li>
                                            @endforeach
                                        @else
                                            <li><i class="ti-close unavailable"></i>Không có thông tin</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="pricing-card">
                            <img src="HomePage/img/pricing/1.jpg" alt="">
                            <div class="desc">
                                <div class="name">Không có dịch vụ</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<script>
// Safe, idempotent initializer: waits for jQuery and Owl Carousel, then initializes pricing carousel.
(function initPricingCarousel(){
    var delay = 150; // ms
    function ready() {
        if (window.jQuery && typeof jQuery.fn.owlCarousel === 'function') {
            jQuery(function($){
                $('.pricing .owl-carousel').each(function(){
                    var $el = $(this);
                    if ($el.data('owl-initialized')) return;
                    $el.owlCarousel({
                        loop: true,
                        margin: 30,
                        mouseDrag: true,
                        autoplay: false,
                        dots: true,
                        autoplayHoverPause: true,
                        nav: false,
                        responsive: {
                            0: { items: 1 },
                            600: { items: 1 },
                            1000: { items: 2 }
                        }
                    });
                    $el.data('owl-initialized', true);
                });
            });
        } else {
            setTimeout(ready, delay);
        }
    }
    ready();
})();
</script>

