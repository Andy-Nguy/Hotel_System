<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Biểu đồ - Adminlite</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="page-wrapper">
        <div class="main-container">

            <!-- Sidebar -->
            <nav id="sidebar" class="sidebar-wrapper">
                <div class="app-brand p-3 mb-3">
                    <a href="{{ route('admin.index') }}">
                        <img src="{{ asset('assets/images/logo.svg') }}" class="logo" alt="AdminLite" />
                    </a>
                </div>
                <div class="sidebarMenuScroll">
                    <ul class="sidebar-menu">
                        <li class="active current-page">
                            <a href="{{ route('admin.index') }}">
                                <i class="bi bi-box"></i>
                                <span class="menu-text">Biểu đồ</span>
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
                        <h5 class="m-0">Biểu đồ</h5>
                    </div>
                    <div class="app-brand-sm d-lg-none d-flex ms-auto">
                        <a href="{{ route('admin.index') }}">
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
                <div class="app-body pt-2 pb-4" style="margin-top:4px;">
                    <div class="mt-1">
                        <div class="row">
                            <div class="col-lg-8">
                                <div style="width:100%; height:70vh;">
                                    <div style="background:#fff; padding:0; border-radius:6px; height:100%; box-shadow: 0 0 0 1px rgba(0,0,0,0.02); display:flex; flex-direction:column; overflow:hidden;">
                                        <div style="padding:16px;">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="m-0">Báo cáo doanh thu</h5>
                                                <div>
                                                    <div class="btn-group" role="group" aria-label="Quick select">
                                                        <input type="radio" class="btn-check" name="quickSelect" id="qs-weeks" autocomplete="off">
                                                        <label class="btn btn-outline-secondary" for="qs-weeks" data-mode="last_weeks"> Tuần</label>

                                                        <input type="radio" class="btn-check" name="quickSelect" id="qs-months" autocomplete="off" checked>
                                                        <label class="btn btn-outline-secondary" for="qs-months" data-mode="last_months"> Tháng</label>

                                                        <input type="radio" class="btn-check" name="quickSelect" id="qs-years" autocomplete="off">
                                                        <label class="btn btn-outline-secondary" for="qs-years" data-mode="last_years"> Năm</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="height:1px; background:#e9ecef; margin:0 8px;"></div>
                                        <div style="flex:1; position:relative;">
                                            <canvas id="incomeChart" style="width:100%; height:100%; display:block; position:absolute; left:0; top:0; right:0; bottom:0;"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4" style="border-left:1px solid #e9ecef; padding-left:10px;">
                                <!-- Right column: summary / details -->
                                <div id="chart-summary" class="p-3 border rounded" style="height:70vh; background:#fff; display:flex; flex-direction:column;">
                                    <h6 style="text-align:center; font-weight:700;">Phòng được yêu thích nhất</h6>
                                    <div id="summary-content" style="display:none;">Chọn khoảng thời gian để xem tóm tắt.</div>
                                    <hr />
                                    <div style="flex:1; display:flex; align-items:center; justify-content:center;">
                                        <div style="display:flex; align-items:center; gap:2px; width:100%;">
                                            <div id="topRoomsLegend" style="width:50%; padding-left:6px;">
                                                <!-- legend items go here -->
                                            </div>  
                                            <div style="width:50%; display:flex; align-items:center; justify-content:center; ">
                                                <canvas id="topRoomsChart" style="width:100%; height:180px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- small white card for top services -->
                                    <div style="margin-top:12px; background:#fff; border-radius:6px; padding:12px; box-shadow: 0 0 0 1px rgba(0,0,0,0.02);">
                                        <h6 style="margin:0 0 8px 0; font-size:14px;">Dịch vụ được yêu thích</h6>
                                        <div style="display:flex; align-items:center;">
                                            <div style="width:40%;">
                                                <canvas id="topServicesChart" style="width:100%; height:110px;"></canvas>
                                            </div>
                                            <div id="topServicesLegend" style="width:60%; padding-left:12px; font-size:13px;"></div>
                                        </div>
                                    </div>
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
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    (function($){
        var chart = null;

        function renderChart(labels, values, mode){
            var ctx = document.getElementById('incomeChart').getContext('2d');
            if (chart) chart.destroy();
            var maxVal = values.length ? Math.max.apply(null, values) : 0;
            var suggestedMax = Math.ceil((maxVal * 1.05) / 1000) * 1000;
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Thu nhập (' + (mode==='month'?'tháng': (mode==='week'?'tuần':'')) + ')',
                        data: values,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: suggestedMax || undefined,
                            ticks: {
                                maxTicksLimit: 6,
                                callback: function(v){
                                    // compact formatting: use K for thousands, M for millions
                                    function compact(n){
                                        if (n >= 1000000) {
                                            var m = n/1000000;
                                            return (Math.round(m*10)/10).toString().replace(/\.0$/, '') + 'M';
                                        } else if (n >= 1000) {
                                            var k = n/1000;
                                            return (Math.round(k*10)/10).toString().replace(/\.0$/, '') + 'K';
                                        }
                                        return n.toString();
                                    }
                                    return compact(v);
                                }
                            },
                            grid: { drawBorder: false }
                        },
                        x: { 
                            grid: { 
                                display: true,
                                color: '#e9ecef',
                                drawTicks: false,
                                drawBorder: false
                            },
                            ticks: {
                                autoSkip: false,
                                maxRotation: 0,
                                minRotation: 0
                            }
                        }
                    },
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context){
                                    var v = context.parsed && context.parsed.y !== undefined ? context.parsed.y : context.raw;
                                    return Number(v).toLocaleString('vi-VN') + ' đ';
                                }
                            }
                        }
                    },
                    layout: { padding: 6 }
                }
            });
        }

        function loadStats(mode, range){
            var params = { mode: mode, range: range || 5 };
            var $inputs = $('input[name="quickSelect"]');
            var $labels = $('.btn-group .btn');
            // disable UI while loading
            $inputs.prop('disabled', true);
            $labels.addClass('disabled');
            $.get('/api/hoadon/stats', params).done(function(resp){
                var data = resp && resp.data ? resp.data : [];
                var labels = data.map(function(d){ return d.label; });
                var values = data.map(function(d){ return d.total; });
                var chartMode = mode.indexOf('week')>=0 ? 'week' : (mode.indexOf('year')>=0 ? 'year' : 'month');
                renderChart(labels, values, chartMode);
                // update summary
                var total = values.reduce(function(s,v){ return s + (parseFloat(v)||0); }, 0);
                var cnt = values.length;
                var fmt = function(v){ return Number(v).toLocaleString('vi-VN'); };
                $('#summary-content').html('<div>Tổng: <strong>' + fmt(total) + ' đ</strong></div><div>Số mục: ' + cnt + '</div>');
            }).fail(function(){ alert('Lỗi khi tải dữ liệu thống kê'); }).always(function(){
                $inputs.prop('disabled', false);
                $labels.removeClass('disabled');
            });
        }

        $(function(){
            // when user selects a radio, load the corresponding stats
            $('input[name="quickSelect"]').on('change', function(){
                var $lbl = $('label[for="' + $(this).attr('id') + '"]');
                var mode = $lbl.data('mode');
                loadStats(mode, 5);
            });
            // initial load from checked radio
            var $checked = $('input[name="quickSelect"]:checked');
            if ($checked.length) {
                var initialMode = $('label[for="' + $checked.attr('id') + '"]').data('mode');
                loadStats(initialMode, 5);
            } else {
                // fallback
                loadStats('last_months', 5);
            }
        });

        // Top rooms pie chart
        var topRoomsChart = null;
        function renderTopRooms(data){
            var ctx = document.getElementById('topRoomsChart').getContext('2d');
            if (topRoomsChart) topRoomsChart.destroy();
            var labels = data.map(function(d){ return d.label; });
            var values = data.map(function(d){ return d.value; });
            var total = values.reduce(function(s,v){ return s + v; }, 0) || 1;
            var colors = ['#054A91','#1F78B4','#5DA5E6','#E6EFFA'];
            topRoomsChart = new Chart(ctx, {
                type: 'doughnut',
                data: { labels: labels, datasets: [{ data: values, backgroundColor: colors.slice(0, labels.length), hoverOffset: 6 }] },
                options: { responsive: true, maintainAspectRatio: false, cutout: '60%', plugins: { legend: { display: false } } }
            });
            // build vertical legend with percentages
            var html = '';
            for (var i=0;i<labels.length;i++){
                var pct = Math.round((values[i]/total)*100);
                html += '<div style="display:flex;align-items:center;margin-bottom:10px;font-size:13px;line-height:1.1;">';
                html += '<div style="width:12px;height:12px;background:'+colors[i]+';margin-right:8px;border-radius:2px;flex:0 0 auto;"></div>';
                html += '<div style="flex:1;">';
                html += '<div style="font-weight:600;">'+labels[i]+'</div>';
                html += '</div>';
                html += '<div style="margin-left:8px;color:#6c757d;flex:0 0 auto;">'+pct+'%</div>';
                html += '</div>';
            }
            $('#topRoomsLegend').html(html);
        }

        function loadTopRooms(){
            $.get('/api/datphong/top-rooms?limit=3').done(function(resp){
                var data = resp && resp.data ? resp.data : [];
                if (!data.length) {
                    $('#topRoomsLegend').html('<div class="text-muted">Không có dữ liệu</div>');
                    return;
                }
                renderTopRooms(data);
            }).fail(function(){ $('#topRoomsLegend').html('<div class="text-danger">Lỗi tải dữ liệu</div>'); });
        }

        // initial load for top rooms
        loadTopRooms();

        // Top services under income chart
        var topServicesChart = null;
        function renderTopServices(data){
            var ctx = document.getElementById('topServicesChart').getContext('2d');
            if (topServicesChart) topServicesChart.destroy();
            var labels = data.map(function(d){ return d.label; });
            var values = data.map(function(d){ return d.value; });
            var total = values.reduce(function(s,v){ return s + v; }, 0) || 1;
            var colors = ['#2c7bb6','#74a9cf','#a6bddb','#e6f0fa'];
            topServicesChart = new Chart(ctx, {
                type: 'doughnut',
                data: { labels: labels, datasets: [{ data: values, backgroundColor: colors.slice(0, labels.length) }] },
                options: { responsive: true, maintainAspectRatio: false, cutout: '60%', plugins: { legend: { display: false } } }
            });
            var html = '';
            for (var i=0;i<labels.length;i++){
                var pct = Math.round((values[i]/total)*100);
                html += '<div style="display:flex;align-items:center;margin-bottom:8px;">';
                html += '<div style="width:10px;height:10px;background:'+colors[i]+';margin-right:8px;border-radius:2px;"></div>';
                html += '<div style="flex:1;">'+labels[i]+'</div>';
                html += '<div style="color:#6c757d;">'+pct+'%</div>';
                html += '</div>';
            }
            $('#topServicesLegend').html(html);
        }

        function loadTopServices(){
            $.get('/api/dichvu/top-used?limit=4').done(function(resp){
                var data = resp && resp.data ? resp.data : [];
                if (!data.length) { $('#topServicesLegend').html('<div class="text-muted">Không có dữ liệu</div>'); return; }
                renderTopServices(data);
            }).fail(function(){ $('#topServicesLegend').html('<div class="text-danger">Lỗi tải dịch vụ</div>'); });
        }

        loadTopServices();
    })(jQuery);
    </script>
    
    </body>
    </html>