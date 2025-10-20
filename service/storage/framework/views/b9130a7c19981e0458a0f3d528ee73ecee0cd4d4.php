<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Quản lý Đặt Phòng - Adminlite</title>

    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.svg')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/bootstrap/bootstrap-icons.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/main.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css')); ?>" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        .cursor-pointer {
            cursor: pointer
        }

        .form-check-box-list {
            max-height: 360px;
            overflow: auto;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }
        /* Center non-money table data horizontally */
        #bookings-table thead th,
        #bookings-table tbody td {
            text-align: center;
            vertical-align: middle;
        }
        /* Preserve right alignment for money columns */
        #bookings-table tbody td[style*="text-align:right"],
        #bookings-table thead th[style*="text-align:right"] {
            text-align: right !important;
        }
        /* Print table: same centering rules */
        #print-table thead th,
        #print-table tbody td { text-align: center; }
        #print-table tbody td[style*="text-align:right"] { text-align: right !important; }
        /* Unified filter controls */
        .filter-controls .form-control,
        .filter-controls .form-select,
        .filter-controls .btn {
            height: 44px;
            padding-top: 6px;
            padding-bottom: 6px;
            line-height: 1.2;
        }
        .filter-controls .form-label { margin-bottom:6px; }
        .filter-controls .input-group .form-control { height:44px; }
        .filter-controls .btn{ display:inline-flex; align-items:center; }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="main-container">

            <!-- Sidebar -->
            <nav id="sidebar" class="sidebar-wrapper">
                <div class="app-brand p-3 mb-3">
                    <a href="<?php echo e(route('datphong.index')); ?>">
                        <img src="<?php echo e(asset('assets/images/logo.svg')); ?>" class="logo" alt="AdminLite" />
                    </a>
                </div>
                <div class="sidebarMenuScroll">
                    <ul class="sidebar-menu">
                        <li class="active current-page">
                            <a href="<?php echo e(route('datphong.index')); ?>">
                                <i class="bi bi-box"></i>
                                <span class="menu-text">Đặt phòng</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="sidebar-settings gap-1 d-lg-flex d-none">
                    <a href="#" class="settings-icon" data-bs-toggle="tooltip" title="Profile">
                        <i class="bi bi-person"></i>
                    </a>
                </div>
            </nav>
            <!-- Sidebar ends -->

            <!-- App container -->
            <div class="app-container">
                <!-- Header -->
                <div class="app-header d-flex align-items-center">
                    <div class="d-flex">
                        <button class="pin-sidebar">
                            <i class="bi bi-list lh-1"></i>
                        </button>
                    </div>
                    <div class="d-flex align-items-center ms-3">
                        <h5 class="m-0">Quản lý Hoá đơn</h5>
                    </div>
                    <div class="app-brand-sm d-lg-none d-flex ms-auto">
                        <a href="<?php echo e(route('datphong.index')); ?>">
                            <img src="<?php echo e(asset('assets/images/logo-sm.svg')); ?>" class="logo" alt="AdminLite" />
                        </a>
                    </div>
                    <div class="header-actions">
                        <div class="d-flex">
                            <button class="toggle-sidebar">
                                <i class="bi bi-list lh-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Header ends -->

                <!-- Body -->
                <div class="app-body p-3">
                    <form id="datphong-filter-form" method="GET" action="<?php echo e(route('datphong.index')); ?>">
                        <div class="row g-3 align-items-end filter-controls">
                            <div class="col-md-2">
                                <label class="form-label">Từ ngày</label>
                                <input type="date" name="from" class="form-control" value="<?php echo e(request()->get('from', date('Y-m-01'))); ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Đến ngày</label>
                                <input type="date" name="to" class="form-control" value="<?php echo e(request()->get('to', date('Y-m-d'))); ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select">
                                    
                                    <option value="0" <?php echo e(request()->get('status', '2') === '0' ? 'selected' : ''); ?>>Đã huỷ</option>
                                    <option value="1" <?php echo e(request()->get('status', '2') == '1' ? 'selected' : ''); ?>>Chờ xác nhận</option>
                                    <option value="2" <?php echo e(request()->get('status', '2') == '2' ? 'selected' : ''); ?>>Đã xác nhận</option>
                                    <option value="3" <?php echo e(request()->get('status', '2') == '3' ? 'selected' : ''); ?>>Đang sử dụng</option>
                                    <option value="4" <?php echo e(request()->get('status', '2') == '4' ? 'selected' : ''); ?>>Đã hoàn thành</option>
                                    <option value="-1" <?php echo e(request()->get('status', '2') == '-1' ? 'selected' : ''); ?>>Tất cả</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tìm kiếm</label>
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control" placeholder="Số CT/Ghi chú" value="<?php echo e(request()->get('q')); ?>">
                                    <button class="btn btn-primary" type="submit">Lọc</button>
                                    <button id="btn-print-list" type="button" class="btn btn-outline-secondary ms-2">In</button>
                                    <button id="btn-csv-export" type="button" class="btn btn-outline-success ms-2">Xuất CSV</button>
                                </div>
                            </div>
                        </div>
                    </form>
                        <div class="mt-4">
                            <div id="bookings-loading" class="text-center py-3" style="display:none">Đang tải...</div>
                            <div id="bookings-empty" class="text-center py-3" style="display:none">Không tìm thấy đặt phòng nào.</div>
                            <div class="table-responsive" id="bookings-table-wrap" style="display:none">
                                <table class="table table-striped" id="bookings-table">
                                    <thead>
                                            <tr>
                                                <th>Mã đặt phòng</th>
                                                <th>Ngày đặt</th>
                                                <th>Phòng</th>
                                                <th>Từ</th>
                                                <th>Đến</th>
                                                <th>Tiền cọc</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <nav aria-label="Page navigation" id="bookings-pager" style="display:none">
                                <ul class="pagination justify-content-center"></ul>
                            </nav>

                            <!-- Hidden print area -->
                            <div id="print-area" style="display:none">
                                <div style="padding:20px; font-family: Arial, Helvetica, sans-serif; color:#000;">
                                    <h3>Danh sách Đặt phòng</h3>
                                    <div id="print-meta" style="margin-bottom:12px"></div>
                                    <table id="print-table" style="width:100%; border-collapse: collapse; font-size:12px;">
                                        <thead>
                                            <tr>
                                                <th style="border:1px solid #ddd; padding:8px; text-align:left">Mã đặt phòng</th>
                                                <th style="border:1px solid #ddd; padding:8px; text-align:left">Ngày đặt</th>
                                                <th style="border:1px solid #ddd; padding:8px; text-align:left">Phòng</th>
                                                <th style="border:1px solid #ddd; padding:8px; text-align:left">Từ</th>
                                                <th style="border:1px solid #ddd; padding:8px; text-align:left">Đến</th>
                                                <th style="border:1px solid #ddd; padding:8px; text-align:right">Tiền cọc</th>
                                                <th style="border:1px solid #ddd; padding:8px; text-align:right">Tổng tiền</th>
                                                <th style="border:1px solid #ddd; padding:8px; text-align:left">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div id="print-footer" style="margin-top:16px; display:flex; justify-content:space-between; align-items:flex-end">
                                        <div>
                                            <div>Tổng số lượng: <span id="print-count"></span></div>
                                            <div>Tổng tiền cọc: <span id="print-deposit"></span></div>
                                            <div>Tổng tiền: <span id="print-sum"></span></div>
                                            <div>Bằng chữ (Tổng tiền): <span id="print-sum-words"></span></div>
                                            <div>Bằng chữ (Tổng tiền cọc): <span id="print-deposit-words"></span></div>
                                        </div>
                                        <div style="text-align:center;">
                                            <div>Người lập</div>
                                            <div style="margin-top:60px">(Ký và ghi rõ họ tên)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                <!-- Body ends -->

            </div>
            <!-- App container ends -->
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/overlay-scroll/custom-scrollbar.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/custom.js')); ?>"></script>
    <script>
    (function($){
        function fmtMoney(v){
            if (v === null || v === undefined) return '';
            return parseFloat(v).toLocaleString('vi-VN', {minimumFractionDigits:0, maximumFractionDigits:0});
        }

        function statusLabel(val){
            if (val === null) return '';
            var v = parseInt(val);
            var map = {
                1: 'Chờ xác nhận',
                2: 'Đã xác nhận',
                0: 'Đã huỷ',
                3: 'Đang sử dụng',
                4: 'Hoàn thành'
            };
            return map[v] || '';
        }

        // Convert integer number (VND) to Vietnamese words (supports up to trillions reasonably)
        function numberToVietnameseWords(n){
            n = Math.round(Math.abs(parseFloat(n)||0));
            if (n === 0) return 'không đồng';
            var units = ['','một','hai','ba','bốn','năm','sáu','bảy','tám','chín'];
            var scales = ['','nghìn','triệu','tỷ','nghìn tỷ','triệu tỷ'];

            function threeDigitsToWords(num){
                var hundred = Math.floor(num/100);
                var tenUnit = num % 100;
                var ten = Math.floor(tenUnit/10);
                var unit = tenUnit%10;
                var parts = [];
                if (hundred>0) parts.push(units[hundred] + ' trăm');
                if (ten>1){
                    parts.push(units[ten] + ' mươi');
                    if (unit===1) parts.push('mốt');
                    else if (unit===5) parts.push('lăm');
                    else if (unit>0) parts.push(units[unit]);
                } else if (ten===1){
                    parts.push('mười');
                    if (unit===5) parts.push('lăm');
                    else if (unit>0) parts.push(units[unit]);
                } else if (ten===0 && unit>0){
                    // when there's a hundred part, say 'lẻ'
                    if (hundred>0) parts.push('lẻ');
                    parts.push(units[unit]);
                }
                return parts.join(' ');
            }

            var words = [];
            var scaleIndex = 0;
            while (n>0){
                var chunk = n % 1000;
                if (chunk>0){
                    var chunkWords = threeDigitsToWords(chunk);
                    if (scaleIndex>0) chunkWords = chunkWords + (scales[scaleIndex] ? ' ' + scales[scaleIndex] : '');
                    words.unshift(chunkWords);
                }
                n = Math.floor(n/1000);
                scaleIndex += 1;
            }
            var result = words.join(' ').replace(/\s+/g,' ').trim();
            // Capitalize first letter and append ' đồng'
            return result.charAt(0).toUpperCase() + result.slice(1) + ' đồng';
        }

        function renderBookings(resp){
            var $wrap = $('#bookings-table-wrap');
            var $tbody = $('#bookings-table tbody');
            $tbody.empty();

            if (!resp || !resp.data || resp.data.length === 0){
                $wrap.hide();
                $('#bookings-pager').hide();
                $('#bookings-empty').show();
                return;
            }

            $('#bookings-empty').hide();
            $wrap.show();

            resp.data.forEach(function(row){
                var tr = '<tr>'+
                    '<td>'+(row.IDDatPhong||'')+'</td>'+
                    '<td>'+(row.NgayDatPhong? new Date(row.NgayDatPhong).toLocaleString() : '')+'</td>'+
                    '<td>'+(row.TenPhong||'')+'</td>'+
                    '<td>'+(row.NgayNhanPhong? new Date(row.NgayNhanPhong).toLocaleDateString() : '')+'</td>'+
                    '<td>'+(row.NgayTraPhong? new Date(row.NgayTraPhong).toLocaleDateString() : '')+'</td>'+
                    '<td style="text-align:right">'+fmtMoney(row.TienCoc||0)+'</td>'+
                    '<td style="text-align:right">'+fmtMoney(row.TongTien||0)+'</td>'+
                    '<td>'+(statusLabel(row.TrangThai)||'')+'</td>'+
                    '</tr>';
                $tbody.append(tr);
            });

            renderPager(resp);
        }

        function renderPager(data){
            var $pager = $('#bookings-pager');
            var $list = $pager.find('.pagination');
            $list.empty();

            if (!data || !data.last_page || data.last_page <= 1){
                $pager.hide();
                return;
            }

            $pager.show();
            var current = data.current_page || 1;
            var last = data.last_page || 1;

            function addPage(page, text, active, disabled){
                var cls = 'page-item' + (active ? ' active' : '') + (disabled ? ' disabled' : '');
                var li = '<li class="'+cls+'"><a class="page-link" href="#" data-page="'+page+'">'+text+'</a></li>';
                $list.append(li);
            }

            addPage(1, '«', current === 1, current === 1);
            var start = Math.max(1, current - 2);
            var end = Math.min(last, current + 2);
            for (var p = start; p <= end; p++) addPage(p, p, p === current, false);
            addPage(last, '»', current === last, current === last);
        }

        function fetchBookings(params){
            params = params || {};
            params.per_page = params.per_page || 10;
            $('#bookings-loading').show();
            $('#bookings-empty').hide();
            $('#bookings-table-wrap').hide();
            $('#bookings-pager').hide();

            $.ajax({
                url: '/api/datphong/list',
                data: params,
                method: 'GET',
                success: function(resp){
                    $('#bookings-loading').hide();
                    renderBookings(resp);
                },
                error: function(){
                    $('#bookings-loading').hide();
                    $('#bookings-empty').text('Lỗi khi tải dữ liệu').show();
                }
            });
        }

        $(function(){
            var $form = $('#datphong-filter-form');

            $form.on('submit', function(e){
                e.preventDefault();
                var data = {};
                $form.serializeArray().forEach(function(f){ if (f.value !== null && f.value !== '') data[f.name] = f.value; });
                fetchBookings(data);
            });

            $('#bookings-pager').on('click', 'a.page-link', function(e){
                e.preventDefault();
                var page = $(this).data('page');
                if (!page) return;
                var params = {};
                $form.serializeArray().forEach(function(f){ if (f.value !== null && f.value !== '') params[f.name] = f.value; });
                params.page = page;
                fetchBookings(params);
            });

            // Print
            $('#btn-print-list').on('click', function(){
                var meta = {};
                $form.serializeArray().forEach(function(f){ meta[f.name] = f.value; });

                var params = {};
                $form.serializeArray().forEach(function(f){ if (f.value !== null && f.value !== '') params[f.name] = f.value; });
                params.per_page = 5000;

                $('#bookings-loading').show();
                $.ajax({ url: '/api/datphong/list', data: params, method: 'GET', success: function(resp){
                    $('#bookings-loading').hide();
                    var list = resp && resp.data ? resp.data : [];
                    var $printTbody = $('#print-table tbody');
                    $printTbody.empty();
                    var totalSum = 0, totalDeposit = 0, count = 0;

                    list.forEach(function(row){
                        var id = row.IDDatPhong || '';
                        var ngay = row.NgayDatPhong ? new Date(row.NgayDatPhong).toLocaleString() : '';
                        var phong = row.TenPhong || '';
                        var from = row.NgayNhanPhong ? new Date(row.NgayNhanPhong).toLocaleDateString() : '';
                        var to = row.NgayTraPhong ? new Date(row.NgayTraPhong).toLocaleDateString() : '';
                        var tiencoc = fmtMoney(row.TienCoc || 0);
                        var tong = fmtMoney(row.TongTien || 0);
                        var trangthai = statusLabel(row.TrangThai || '');

                        totalSum += parseFloat(row.TongTien || 0) || 0;
                        totalDeposit += parseFloat(row.TienCoc || 0) || 0;
                        count += 1;

                        var tr = '<tr>'+
                            '<td style="border:1px solid #ddd; padding:8px">'+id+'</td>'+
                            '<td style="border:1px solid #ddd; padding:8px">'+ngay+'</td>'+
                            '<td style="border:1px solid #ddd; padding:8px">'+phong+'</td>'+
                            '<td style="border:1px solid #ddd; padding:8px">'+from+'</td>'+
                            '<td style="border:1px solid #ddd; padding:8px">'+to+'</td>'+
                            '<td style="border:1px solid #ddd; padding:8px; text-align:right">'+tiencoc+'</td>'+
                            '<td style="border:1px solid #ddd; padding:8px; text-align:right">'+tong+'</td>'+
                            '<td style="border:1px solid #ddd; padding:8px">'+trangthai+'</td>'+
                            '</tr>';
                        $printTbody.append(tr);
                    });

                    var metaHtml = '<div>Từ ngày: '+(meta.from||'')+'</div>'+
                        '<div>Đến ngày: '+(meta.to||'')+'</div>'+
                        '<div>Trạng thái: '+(meta.status||'Tất cả')+'</div>'+
                        '<div>Thời gian in: '+(new Date()).toLocaleString()+'</div>';
                    $('#print-meta').html(metaHtml);
                    $('#print-count').text(count);
                    $('#print-deposit').text(fmtMoney(totalDeposit));
                    $('#print-sum').text(fmtMoney(totalSum));
                    try{
                        $('#print-sum-words').text(numberToVietnameseWords(totalSum));
                        $('#print-deposit-words').text(numberToVietnameseWords(totalDeposit));
                    }catch(e){ $('#print-sum-words').text(''); $('#print-deposit-words').text(''); }

                    var content = $('#print-area').html();
                    var w = window.open('', '_blank');
                    w.document.open();
                    w.document.write('<!doctype html><html><head><title>In danh sách Đặt phòng</title>');
                    w.document.write('<meta charset="utf-8" />');
                    w.document.write('<style>body{font-family: Arial, Helvetica, sans-serif; color:#000} table{width:100%; border-collapse:collapse} th,td{border:1px solid #ddd; padding:8px}</style>');
                    w.document.write('</head><body>');
                    w.document.write(content);
                    w.document.write('</body></html>');
                    w.document.close();
                    w.focus();
                    setTimeout(function(){ w.print(); w.close(); }, 300);
                }, error: function(){ $('#bookings-loading').hide(); alert('Lỗi khi tải dữ liệu in.'); } });
            });

            // CSV export
            $('#btn-csv-export').on('click', function(){
                var meta = {};
                $form.serializeArray().forEach(function(f){ meta[f.name] = f.value; });

                var rows = [];
                rows.push(['Danh sách Đặt phòng']);
                rows.push(['Từ ngày', meta.from || '']);
                rows.push(['Đến ngày', meta.to || '']);
                rows.push(['Trạng thái', meta.status || 'Tất cả']);
                rows.push(['Thời gian xuất', (new Date()).toLocaleString()]);
                rows.push([]);
                rows.push(['Mã đặt phòng','Ngày đặt','Phòng','Từ','Đến','Tiền cọc','Tổng tiền','Trạng thái']);

                var totalSum = 0; var totalDeposit = 0; var count = 0;
                $('#bookings-table tbody tr').each(function(){
                    var cols = $(this).find('td');
                    var id = cols.eq(0).text().trim();
                    var ngay = cols.eq(1).text().trim();
                    var phong = cols.eq(2).text().trim();
                    var from = cols.eq(3).text().trim();
                    var to = cols.eq(4).text().trim();
                    var tiencoc = cols.eq(5).text().trim();
                    var tong = cols.eq(6).text().trim();
                    var trangthai = cols.eq(7).text().trim();

                    var num = parseFloat(tong.replace(/\./g,'').replace(/,/g,'.').replace(/[^0-9\-\.]/g,'')) || 0;
                    var numDeposit = parseFloat(tiencoc.replace(/\./g,'').replace(/,/g,'.').replace(/[^0-9\-\.]/g,'')) || 0;
                    totalSum += num; totalDeposit += numDeposit; count += 1;

                    rows.push([id, ngay, phong, from, to, tiencoc, tong, trangthai]);
                });

                rows.push([]);
                rows.push(['Tổng số lượng', count]);
                rows.push(['Tổng tiền cọc', fmtMoney(totalDeposit)]);
                rows.push(['Tổng tiền', fmtMoney(totalSum)]);

                var csv = rows.map(function(r){ return r.map(function(cell){ if (cell === null || cell === undefined) return ''; var s = cell.toString(); if (s.indexOf(',')>=0||s.indexOf('"')>=0||s.indexOf('\n')>=0){ s = '"' + s.replace(/"/g,'""') + '"'; } return s; }).join(','); }).join('\n');
                var blob = new Blob(["\uFEFF" + csv], {type: 'text/csv;charset=utf-8;'});
                var url = URL.createObjectURL(blob);
                var a = document.createElement('a'); a.href = url; a.download = 'datphong_' + (new Date()).toISOString().slice(0,19).replace(/[:T]/g,'-') + '.csv'; document.body.appendChild(a); a.click(); setTimeout(function(){ URL.revokeObjectURL(url); a.remove(); }, 5000);
            });

            // initial load: if status not present, default to -1 (all)
            var initial = {};
            var qs = location.search.replace(/^\?/, '');
            qs && qs.split('&').forEach(function(pair){ var parts = pair.split('='); if (parts[0]) initial[decodeURIComponent(parts[0])] = decodeURIComponent(parts[1]||''); });
            if (!initial.status) {
                var s = $form.find('select[name="status"]').val(); if (s) initial.status = s; else initial.status = '-1';
            }
            fetchBookings(initial);
        });
    })(jQuery);
    </script>
    
    </body>
    </html><?php /**PATH I:\Ky_06_2025_2026\php\New folder\Hotel_System\service\resources\views/statistics/datphong.blade.php ENDPATH**/ ?>