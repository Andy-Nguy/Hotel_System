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
    <style>
        /* small localized style for price currency superscript */
        .price-currency {
            font-size: 0.6em;
            vertical-align: super;
            margin-left: 2px;
            color: #8c6b4a; /* subtle brown similar to design */
        }
        .price-number { font-weight: 300; color: #8c6b4a; }
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
    <!-- Simplified Menu (rooms-only) -->
    @include('partials.menu')
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
                <div class="col-md-12" id="rooms-list">
                    <?php
                        // Simple server-side pagination: show up to 5 rooms per page.
                        $perPage = 5;
                        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
                        $total = is_array($roomsDetail) ? count($roomsDetail) : 0;
                        $pages = $total > 0 ? (int) ceil($total / $perPage) : 1;
                        $typeParam = isset($_GET['type']) ? rawurlencode($_GET['type']) : (isset($type) ? rawurlencode($type) : '');
                        $offset = ($page - 1) * $perPage;
                        $roomsPage = [];
                        if (!empty($roomsDetail) && is_array($roomsDetail)) {
                            $roomsPage = array_slice($roomsDetail, $offset, $perPage);
                        }
                    ?>

                    <?php if (!empty($roomsPage) && is_array($roomsPage)): ?>
                        <?php foreach ($roomsPage as $i => $room): ?>
                            <?php $idx = $offset + $i; ?>
                            <?php
                                $img = isset($room['UrlAnhPhong']) ? $room['UrlAnhPhong'] : '1.jpg';
                                // prefer slider images if present, otherwise fall back to rooms
                                $sliderPath = public_path('HomePage/img/slider/' . $img);
                                if (file_exists($sliderPath)) {
                                    $imgUrl = '/HomePage/img/slider/' . rawurlencode(basename($img));
                                } else {
                                    // If $img already contains a path or URL, use it; otherwise build rooms path
                                    if (preg_match('#^https?://#i', $img)) {
                                        $imgUrl = $img;
                                    } elseif (strpos($img, '/') !== false) {
                                        $imgUrl = (strpos($img, '/') === 0) ? $img : '/' . $img;
                                    } else {
                                        $imgUrl = '/HomePage/img/rooms/' . rawurlencode(basename($img));
                                    }
                                }

                                // <-- add these definitions to avoid "Undefined variable"
                                $title  = $room['TenPhong'] ?? ($room['TenPhong'] ?? 'Room');
                            ?>
                            <?php $leftClass = ($idx % 2) ? ' left' : ''; ?>
                            <div class="rooms2 mb-90<?php echo $leftClass; ?> animate-box" data-animate-effect="fadeInUp">
                                <figure><img src="<?php echo $imgUrl; ?>" alt="" class="img-fluid"></figure>
                                <div class="caption">
                                    <?php
                                        // Display price, room number and max people (SoNguoiToiDa) when available
                                        $priceNumber = isset($room['GiaCoBanMotDem']) ? number_format($room['GiaCoBanMotDem']) : null;
                                        $roomNumber = !empty($room['SoPhong']) ? htmlspecialchars($room['SoPhong']) : 'Room';
                                        $maxPeople = isset($room['SoNguoiToiDa']) && $room['SoNguoiToiDa'] !== '' ? (int) $room['SoNguoiToiDa'] : null;
                                    ?>
                                    <h3>
                                        <?php echo $roomNumber; ?>  -  
                                        
                                        <?php if ($priceNumber !== null): ?>
                                            <span class="price-number"><?php echo $priceNumber; ?></span>
                                            <small class="text-muted price-currency" aria-hidden="true">đ</small>
                                        <?php else: ?>
                                            Liên hệ
                                        <?php endif; ?>
                                         <span class="price-number"> / Ngày</span>
                                    </h3>

                                    <h4>
                                        <a href="<?php echo '/roomdetails.php?id=' . urlencode($room['IDPhong'] ?? ''); ?>">
                                            <?php echo htmlspecialchars($title); ?>
                                        </a>
                                    </h4>
                                    <?php
                                        $description = $room['MoTa'] ?? '';
                                        $wordLimit = 20; // số từ muốn hiển thị

                                        $words = explode(' ', strip_tags($description));
                                        if (count($words) > $wordLimit) {
                                            $shortDescription = implode(' ', array_slice($words, 0, $wordLimit)) . '...';
                                        } else {
                                            $shortDescription = implode(' ', $words);
                                        }
                                    ?>
                                    <p><?php echo htmlspecialchars($shortDescription); ?></p>

                                    <?php if ($maxPeople !== null): ?>
                                        <p class="text-muted h6 fw-bold mb-2">
                                            <i class="flaticon-group" aria-hidden="true" style="margin-right:8px"></i>
                                            Tối đa: <?php echo $maxPeople; ?> người
                                        </p>
                                    <?php endif; ?>
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
                                    <?php endif; ?>
                                    <hr class="border-2">
                                    <div class="info-wrapper">
                                        <div class="more">
                                            <a href="<?php echo '/roomdetails.php?id=' . urlencode($room['IDPhong'] ?? ''); ?>" class="link-btn" tabindex="0">
                                                Details <i class="ti-arrow-right"></i>
                                            </a>
                                        </div>
                                        <div class="butn-dark"> <a href="/rooms2?type=<?php echo urlencode($type); ?>" data-scroll-nav="1"><span>Đặt Ngay</span></a> </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php if ($pages > 1): ?>
                            <nav aria-label="Rooms pagination" class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <?php $prev = max(1, $page - 1); ?>
                                    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?<?php echo $typeParam !== '' ? 'type=' . $typeParam . '&' : ''; ?>page=<?php echo $prev; ?>" aria-label="Previous">&laquo;</a>
                                    </li>

                                    <?php for ($p = 1; $p <= $pages; $p++): ?>
                                        <li class="page-item <?php echo $p === $page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?<?php echo $typeParam !== '' ? 'type=' . $typeParam . '&' : ''; ?>page=<?php echo $p; ?>"><?php echo $p; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php $next = min($pages, $page + 1); ?>
                                    <li class="page-item <?php echo $page >= $pages ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?<?php echo $typeParam !== '' ? 'type=' . $typeParam . '&' : ''; ?>page=<?php echo $next; ?>" aria-label="Next">&raquo;</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
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
    @include('partials.pricing', ['services' => $services ?? []])
    <!-- Reservation & Booking Form -->
    @include('partials.reservation')
    <!-- Footer -->
    @include('partials.footer')
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
                // Read adults/children selects (order in markup: Adults, Children, Rooms)
                const selectElems = form.querySelectorAll('.select2.select');
                let adults = 1, children = 0;
                if (selectElems && selectElems.length >= 2) {
                    adults = parseInt(selectElems[0].value, 10) || adults;
                    children = parseInt(selectElems[1].value, 10) || children;
                } else {
                    const aEl = form.querySelector('select[name="adults"]');
                    const cEl = form.querySelector('select[name="children"]');
                    if (aEl) adults = parseInt(aEl.value, 10) || adults;
                    if (cEl) children = parseInt(cEl.value, 10) || children;
                }
                const totalGuests = (adults || 0) + (children || 0);

                const url = new URL('/api/rooms/available/by_type', window.location.origin);
                // The API expects 'room_type_id' (backend validation message shows this). Send that param.
                if (type) url.searchParams.set('room_type_id', type);
                if (checkIn) url.searchParams.set('check_in', checkIn);
                if (checkOut) url.searchParams.set('check_out', checkOut);
                // provide guests hint to the API if supported
                if (totalGuests) url.searchParams.set('guests', totalGuests);

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

                // Client-side filtering by capacity: only show rooms that can fit totalGuests
                function getRoomCapacity(r) {
                    const raw = r.capacity || r.SucChua || r.SoNguoi || r.SoNguoiToiDa || r.MaxGuests || r.maxGuests || r.SoNguoiToiDa;
                    const n = parseInt(raw, 10);
                    return isNaN(n) ? 0 : n;
                }

                const filteredRooms = (totalGuests && Array.isArray(rooms)) ? rooms.filter(r => getRoomCapacity(r) >= totalGuests) : rooms;

                // If API returned an empty array but included a message or error, show it
                if ((!filteredRooms || filteredRooms.length === 0)) {
                    const serverMsg = (data && (data.message || data.error || data.msg)) ? (data.message || data.error || data.msg) : null;
                    const debugSnippet = serverMsg ? escapeHtml(String(serverMsg)) : (data && data.__rawText ? escapeHtml(String(data.__rawText)) : '');
                    modalBody.innerHTML = `\
                        <div class="col-12 text-center py-4">\
                            Không có phòng phù hợp cho ngày và số lượng khách bạn chọn. Vui lòng thử chọn ngày khác hoặc thay đổi số lượng khách, hoặc liên hệ khách sạn để hỗ trợ.\
                            ${debugSnippet ? ('<div class="mt-2 small text-muted">Info: ' + debugSnippet + '</div>') : '' }\
                        </div>`;
                } else {
                    modalBody.innerHTML = filteredRooms.map(room => {
                        const id = room.IDPhong || room.id || room.MaPhong || room.SoPhong || '';
                        const title = room.TenPhong || room.TenLoaiPhong || room.name || room.Ten || room.ten || ('Room ' + (room.SoPhong || room.IDPhong || ''));
                        // Do not show MoTa
                        const images = room.UrlAnhPhong ? [room.UrlAnhPhong] : (room.images || room.HinhAnh || room.hinh_anh || []);
                        const img = (Array.isArray(images) && images.length) ? images[0] : (room.image || room.AnhDaiDien || 'HomePage/img/rooms/1.jpg');
                        const capacity = (room.SoNguoiToiDa !== undefined && room.SoNguoiToiDa !== null) ? room.SoNguoiToiDa : (room.capacity || room.SucChua || room.SoNguoi || '');
                        const priceRaw = (room.GiaCoBanMotDem !== undefined && room.GiaCoBanMotDem !== null)
                            ? room.GiaCoBanMotDem
                            : (room.Gia !== undefined && room.Gia !== null ? room.Gia : (room.price || room.gia || ''));
                        let displayPrice = '';
                        if (priceRaw !== '' && priceRaw !== null && priceRaw !== undefined) {
                            const n = (typeof priceRaw === 'number') ? priceRaw : Number(String(priceRaw).replace(/[^0-9.-]+/g, ''));
                            if (!isNaN(n)) {
                                displayPrice = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', maximumFractionDigits: 0 }).format(n);
                            } else {
                                displayPrice = String(priceRaw);
                            }
                        }
                        return `\
                            <div class="col-md-6 mb-3">\
                                <div class="card">\
                                    <div style="height:180px;overflow:hidden;display:flex;align-items:center;justify-content:center">\
                                        <img src="${'/HomePage/img/slider/'}${img}" alt="${title}" style="width:100%;height:100%;object-fit:cover">\
                                    </div>\
                                    <div class="card-body">\
                                        <h5 class="card-title">${title} ${id?('<small class="text-muted">'+id+'</small>'):''}</h5>\
                                        <p class="mb-1"><small class="text-muted">Số người: ${capacity}</small></p>\
                                        ${displayPrice?('<p class="mb-0"><strong>'+displayPrice+'</strong></p>'):''}\
                                    </div>\
                                    <div class="card-footer">\
                                        <a href="/roomdetails.php?id=${id}" class="btn btn-sm btn-outline-primary">Chi tiết</a>\
                                        <a href="/booking?room=${id}&check_in=${encodeURIComponent(checkIn)}&check_out=${encodeURIComponent(checkOut)}" class="btn btn-sm btn-primary">Đặt ngay</a>\
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