<?php
// Pricing Partial (Blade-style clean)
// normalize $services so the partial accepts arrays, Collections, or null
if (!isset($services)) {
    $services = [];
} elseif (is_object($services) && method_exists($services, 'toArray')) {
    $services = $services->toArray();
} elseif (!is_array($services)) {
    $services = (array) $services;
}
?>
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
                    <?php if(!empty($services) && is_array($services)): ?>
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $img = $s['HinhDichVu'] ?? '1.jpg';
                                $imgUrl = '/HomePage/img/pricing/' . rawurlencode($img);
                                $name = $s['TenDichVu'] ?? 'Dịch vụ';
                                $price = isset($s['TienDichVu']) ? number_format((float)$s['TienDichVu'], 0, '.', ',') . '₫' : '';
                                $features = (!empty($s['ThongTin']) && is_array($s['ThongTin'])) ? $s['ThongTin'] : [];
                            ?>
                            <div class="pricing-card">
                                <img src="<?php echo e($imgUrl); ?>" alt="<?php echo e($name); ?>">
                                <div class="desc">
                                    <div class="name"><?php echo e($name); ?></div>
                                    <?php if($price): ?><div class="amount"><?php echo e($price); ?><span></span></div><?php endif; ?>
                                    <ul class="list-unstyled list">
                                        <?php if(!empty($features)): ?>
                                            <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><i class="ti-check"></i> <?php echo e($f['ThongTinDV'] ?? ''); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <li><i class="ti-close unavailable"></i>Không có thông tin</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="pricing-card">
                            <img src="HomePage/img/pricing/1.jpg" alt="">
                            <div class="desc">
                                <div class="name">Không có dịch vụ</div>
                            </div>
                        </div>
                    <?php endif; ?>
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

<?php /**PATH I:\Ky_06_2025_2026\php\New folder\Hotel_System\service\resources\views/partials/pricing.blade.php ENDPATH**/ ?>