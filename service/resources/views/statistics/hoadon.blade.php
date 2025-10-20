<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Quản lý Khách hàng - Adminlite</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <a href="{{ route('hoadon.index') }}">
                        <img src="{{ asset('assets/images/logo.svg') }}" class="logo" alt="AdminLite" />
                    </a>
                </div>
                <div class="sidebarMenuScroll">
                    <ul class="sidebar-menu">
                        <li class="active current-page">
                            <a href="{{ route('hoadon.index') }}">
                                <i class="bi bi-box"></i>
                                <span class="menu-text">Hoá đơn</span>
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
                        <a href="{{ route('hoadon.index') }}">
                            <img src="{{ asset('assets/images/logo-sm.svg') }}" class="logo" alt="AdminLite" />
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
                    <form id="hoadon-filter-form" method="GET" action="{{ route('hoadon.index') }}">
                        <div class="row g-3 align-items-end filter-controls">
                            <div class="col-md-2">
                                <label class="form-label">Từ ngày</label>
                                <input type="date" name="from" class="form-control" value="{{ request()->get('from', date('Y-m-01')) }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Đến ngày</label>
                                <input type="date" name="to" class="form-control" value="{{ request()->get('to', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select">
                                    {{-- default to 2 (Đã thanh toán) when no status provided --}}
                                    <option value="0" {{ request()->get('status', '2') === '0' ? 'selected' : '' }}>Tất cả</option>
                                    <option value="1" {{ request()->get('status', '2') == '1' ? 'selected' : '' }}>Chưa thanh toán</option>
                                    <option value="2" {{ request()->get('status', '2') == '2' ? 'selected' : '' }}>Đã thanh toán</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tìm kiếm</label>
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control" placeholder="Số CT/Ghi chú" value="{{ request()->get('q') }}">
                                    <button class="btn btn-primary" type="submit">Lọc</button>
                                    <button id="btn-print-list" type="button" class="btn btn-outline-secondary ms-2">In</button>
                                    <button id="btn-csv-export" type="button" class="btn btn-outline-success ms-2">Xuất CSV</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Results: invoices table -->
                    <div class="mt-4">
                        <div id="invoices-loading" class="text-center py-3" style="display:none">Đang tải...</div>
                        <div id="invoices-empty" class="text-center py-3" style="display:none">Không tìm thấy hoá đơn nào.</div>
                        <div class="table-responsive" id="invoices-table-wrap" style="display:none">
                            <table class="table table-striped" id="invoices-table">
                                <thead>
                                    <tr>
                                        <th>Mã hóa đơn</th>
                                        <th>Ngày lập</th>
                                        <th>Tổng tiền</th>
                                        <th>Tiền thanh toán</th>
                                        <th>Trạng thái</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <nav aria-label="Page navigation" id="invoices-pager" style="display:none">
                            <ul class="pagination justify-content-center"></ul>
                        </nav>
                    </div>

                    <!-- Printable template (hidden) -->
                    <div id="print-area" style="display:none">
                        <div style="padding:20px; font-family: Arial, Helvetica, sans-serif; color:#000;">
                            <h3>Danh sách Hoá đơn</h3>
                            <div id="print-meta" style="margin-bottom:12px"></div>
                            <table id="print-table" style="width:100%; border-collapse: collapse; font-size:12px;">
                                <thead>
                                    <tr>
                                        <th style="border:1px solid #ddd; padding:8px; text-align:left">Mã hóa đơn</th>
                                        <th style="border:1px solid #ddd; padding:8px; text-align:left">Ngày lập</th>
                                        <th style="border:1px solid #ddd; padding:8px; text-align:right">Tổng tiền</th>
                                        <th style="border:1px solid #ddd; padding:8px; text-align:right">Tiền thanh toán</th>
                                        <th style="border:1px solid #ddd; padding:8px; text-align:left">Trạng thái</th>
                                        <th style="border:1px solid #ddd; padding:8px; text-align:left">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div id="print-footer" style="margin-top:16px; display:flex; justify-content:space-between; align-items:flex-end">
                                <div>
                                    <div>Tổng số lượng: <span id="print-count"></span></div>
                                    <div>Tổng tiền: <span id="print-sum"></span></div>
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
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/overlay-scroll/custom-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
    (function($){
        function fmtMoney(v){
            if (v === null || v === undefined) return '';
            return parseFloat(v).toLocaleString('vi-VN', {minimumFractionDigits:2, maximumFractionDigits:2});
        }

        function statusLabel(val){
            if (val === null) return 'Chưa thanh toán';
            var v = parseInt(val);
            if (v === 1) return 'Chưa thanh toán';
            if (v === 2) return 'Đã thanh toán';
            return '';
        }

        function renderInvoices(data){
            var $wrap = $('#invoices-table-wrap');
            var $tbody = $('#invoices-table tbody');
            $tbody.empty();

            if (!data || !data.data || data.data.length === 0){
                $wrap.hide();
                $('#invoices-pager').hide();
                $('#invoices-empty').show();
                return;
            }

            $('#invoices-empty').hide();
            $wrap.show();

            data.data.forEach(function(row){
                var tr = '<tr>'+
                    '<td>'+ (row.IDHoaDon || '') +'</td>'+
                    '<td>'+ (row.NgayLap ? new Date(row.NgayLap).toLocaleString() : '') +'</td>'+
                    '<td>'+ fmtMoney(row.TongTien || row.TongTienHoaDon || 0) +'</td>'+
                    '<td>'+ fmtMoney(row.TienThanhToan || 0) +'</td>'+
                    '<td>'+ statusLabel(row.TrangThaiThanhToan) +'</td>'+
                    '<td>'+ (row.GhiChu || '') +'</td>'+
                    '</tr>';
                $tbody.append(tr);
            });

            renderPager(data);
        }

        function renderPager(data){
            var $pager = $('#invoices-pager');
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

        function fetchInvoices(params){
            params = params || {};
            // ensure 10 rows per page
            params.per_page = params.per_page || 10;
            $('#invoices-loading').show();
            $('#invoices-empty').hide();
            $('#invoices-table-wrap').hide();
            $('#invoices-pager').hide();

            $.ajax({
                url: '/api/hoadon',
                data: params,
                method: 'GET',
                success: function(resp){
                    $('#invoices-loading').hide();
                    renderInvoices(resp);
                },
                error: function(xhr){
                    $('#invoices-loading').hide();
                    $('#invoices-empty').text('Lỗi khi tải dữ liệu').show();
                }
            });
        }

        $(function(){
            var $form = $('#hoadon-filter-form');

            $form.on('submit', function(e){
                e.preventDefault();
                var data = {};
                $form.serializeArray().forEach(function(f){
                    if (f.value !== null && f.value !== '') data[f.name] = f.value;
                });
                fetchInvoices(data);
            });

            $('#invoices-pager').on('click', 'a.page-link', function(e){
                e.preventDefault();
                var page = $(this).data('page');
                if (!page) return;
                var params = {};
                $form.serializeArray().forEach(function(f){ if (f.value !== null && f.value !== '') params[f.name] = f.value; });
                params.page = page;
                fetchInvoices(params);
            });

            // Print all filtered results (fetch all pages then print)
            $('#btn-print-list').on('click', function(){
                var meta = {};
                $form.serializeArray().forEach(function(f){ meta[f.name] = f.value; });

                // prepare API params based on form (request all results)
                var params = {};
                $form.serializeArray().forEach(function(f){ if (f.value !== null && f.value !== '') params[f.name] = f.value; });
                // request all results (cap to avoid OOM)
                var cap = 5000; // maximum rows to fetch for printing
                params.per_page = cap;

                $('#invoices-loading').show();
                $.ajax({
                    url: '/api/hoadon',
                    data: params,
                    method: 'GET',
                    success: function(resp){
                        $('#invoices-loading').hide();
                        var list = resp && resp.data ? resp.data : [];
                        var $printTbody = $('#print-table tbody');
                        $printTbody.empty();
                        var totalSum = 0;
                        var count = 0;

                        list.forEach(function(row){
                            var id = row.IDHoaDon || '';
                            var ngay = row.NgayLap ? new Date(row.NgayLap).toLocaleString() : '';
                            var tongText = fmtMoney(row.TongTien || row.TongTienHoaDon || 0);
                            var thanhtoanText = fmtMoney(row.TienThanhToan || 0);
                            var trangthai = statusLabel(row.TrangThaiThanhToan);
                            var ghichu = row.GhiChu || '';

                            totalSum += parseFloat((row.TongTien || row.TongTienHoaDon || 0) || 0);
                            count += 1;

                            var tr = '<tr>'+
                                '<td style="border:1px solid #ddd; padding:8px">'+id+'</td>'+
                                '<td style="border:1px solid #ddd; padding:8px">'+ngay+'</td>'+
                                '<td style="border:1px solid #ddd; padding:8px; text-align:right">'+tongText+'</td>'+
                                '<td style="border:1px solid #ddd; padding:8px; text-align:right">'+thanhtoanText+'</td>'+
                                '<td style="border:1px solid #ddd; padding:8px">'+trangthai+'</td>'+
                                '<td style="border:1px solid #ddd; padding:8px">'+ghichu+'</td>'+
                                '</tr>';
                            $printTbody.append(tr);
                        });

                        var metaHtml = '<div>Từ ngày: '+(meta.from||'')+'</div>'+
                            '<div>Đến ngày: '+(meta.to||'')+'</div>'+
                            '<div>Trạng thái: '+(meta.status==1 ? 'Chưa thanh toán' : (meta.status==2 ? 'Đã thanh toán' : 'Tất cả'))+'</div>'+
                            '<div>Thời gian in: '+(new Date()).toLocaleString()+'</div>';
                        $('#print-meta').html(metaHtml);
                        $('#print-count').text(count);
                        $('#print-sum').text(fmtMoney(totalSum));

                        // open print window
                        var content = $('#print-area').html();
                        var w = window.open('', '_blank');
                        w.document.open();
                        w.document.write('<!doctype html><html><head><title>In danh sách Hoá đơn</title>');
                        w.document.write('<meta charset="utf-8" />');
                        w.document.write('<style>body{font-family: Arial, Helvetica, sans-serif; color:#000} table{width:100%; border-collapse:collapse} th,td{border:1px solid #ddd; padding:8px}</style>');
                        w.document.write('</head><body>');
                        w.document.write(content);
                        w.document.write('</body></html>');
                        w.document.close();
                        w.focus();
                        setTimeout(function(){ w.print(); w.close(); }, 300);
                    },
                    error: function(){
                        $('#invoices-loading').hide();
                        alert('Lỗi khi tải dữ liệu in.');
                    }
                });
            });

            // CSV export of currently displayed rows
            $('#btn-csv-export').on('click', function(){
                var meta = {};
                $form.serializeArray().forEach(function(f){ meta[f.name] = f.value; });

                var rows = [];
                // header meta rows
                rows.push(['Danh sách Hoá đơn']);
                rows.push(['Từ ngày', meta.from || '']);
                rows.push(['Đến ngày', meta.to || '']);
                var statusText = (meta.status==1 ? 'Chưa thanh toán' : (meta.status==2 ? 'Đã thanh toán' : 'Tất cả'));
                rows.push(['Trạng thái', statusText]);
                rows.push(['Thời gian xuất', (new Date()).toLocaleString()]);
                rows.push([]);

                // table header
                rows.push(['Mã hóa đơn','Ngày lập','Tổng tiền','Tiền thanh toán','Trạng thái','Ghi chú']);

                var totalSum = 0;
                var count = 0;

                $('#invoices-table tbody tr').each(function(){
                    var cols = $(this).find('td');
                    var id = cols.eq(0).text().trim();
                    var ngay = cols.eq(1).text().trim();
                    var tong = cols.eq(2).text().trim();
                    var thanhtoan = cols.eq(3).text().trim();
                    var trangthai = cols.eq(4).text().trim();
                    var ghichu = cols.eq(5).text().trim();

                    // parse numeric for sum
                    var num = parseFloat(tong.replace(/\./g,'').replace(/,/g,'.').replace(/[^0-9\-\.]/g,'')) || 0;
                    totalSum += num;
                    count += 1;

                    rows.push([id, ngay, tong, thanhtoan, trangthai, ghichu]);
                });

                rows.push([]);
                rows.push(['Tổng số lượng', count]);
                rows.push(['Tổng tiền', fmtMoney(totalSum)]);

                // build CSV
                var csv = rows.map(function(r){
                    return r.map(function(cell){
                        if (cell === null || cell === undefined) return '';
                        var s = cell.toString();
                        // escape quotes
                        if (s.indexOf(',') >= 0 || s.indexOf('"') >= 0 || s.indexOf('\n') >= 0) {
                            s = '"' + s.replace(/"/g,'""') + '"';
                        }
                        return s;
                    }).join(',');
                }).join('\n');

                // prepend UTF-8 BOM so Excel (Windows) recognizes UTF-8 and displays Vietnamese correctly
                var blob = new Blob(["\uFEFF" + csv], {type: 'text/csv;charset=utf-8;'});
                var url = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                var filename = 'hoadon_' + (new Date()).toISOString().slice(0,19).replace(/[:T]/g,'-') + '.csv';
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                setTimeout(function(){ URL.revokeObjectURL(url); a.remove(); }, 5000);
            });

            var initial = {};
            var qs = location.search.replace(/^\?/, '');
            qs && qs.split('&').forEach(function(pair){
                var parts = pair.split('=');
                if (parts[0]) initial[decodeURIComponent(parts[0])] = decodeURIComponent(parts[1]||'');
            });
            // if status not present in URL, use the select's current value (defaulted to Đã thanh toán)
            if (!initial.status) {
                var s = $form.find('select[name="status"]').val();
                if (s) initial.status = s;
            }
            fetchInvoices(initial);
        });
    })(jQuery);
    </script>
    </body>
    </html>