<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
$apiBaseEnv = trim(env('API_URL', ''), "/"); // set API_URL in .env if remote, e.g. http://127.0.0.1:8001
// final API prefix used by helpers - falls back to local dispatch via /api
$apiPrefix = $apiBaseEnv ? ($apiBaseEnv . '/api') : '/api';

$callApi = function(string $endpoint, int $timeout = 5) use ($apiPrefix) {
    try {
        // if caller passed a full URL, use it
        if (preg_match('#^https?://#i', $endpoint)) {
            $resp = Http::timeout($timeout)->get($endpoint);
            return $resp->ok() ? $resp->json() : null;
        }

        // normalize endpoint to start with /api/...
        $normalized = preg_replace('#^/+#', '/', $endpoint);
        if (strpos($normalized, '/api/') !== 0) {
            $normalized = '/api' . (strpos($normalized, '/') === 0 ? $normalized : '/' . $normalized);
        }

        // if API prefix is remote, call remote API via HTTP client
        if (preg_match('#^https?://#', $apiPrefix)) {
            $url = rtrim($apiPrefix, '/') . $normalized; // $apiPrefix already contains /api when remote
            $resp = Http::timeout($timeout)->get($url);
            return $resp->ok() ? $resp->json() : null;
        }

        // else perform internal dispatch (same Laravel app)
        $subRequest = Request::create($normalized, 'GET');
        // Use the HTTP kernel to handle the internal subrequest
        /** @var \Illuminate\Contracts\Http\Kernel $httpKernel */
        $httpKernel = app()->make(\Illuminate\Contracts\Http\Kernel::class);
        $subResponse = $httpKernel->handle($subRequest);
        $status = $subResponse->getStatusCode();
        if ($status >= 200 && $status < 300) {
            return json_decode($subResponse->getContent(), true);
        }
        return null;
    } catch (\Throwable $e) {
        logger()->error("callApi error for [$endpoint]: " . $e->getMessage());
        return null;
    }
};
// Temporary debug endpoint: exposes what Laravel sees for a request
Route::get('/__debug/request-info', function (Request $request) {
    try {
        return response()->json([
            'path_info' => $request->getPathInfo(),
            'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
            'query' => $request->query(),
            'server' => [
                'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'] ?? null,
                'REQUEST_URI' => $_SERVER['REQUEST_URI'] ?? null,
                'PHP_SELF' => $_SERVER['PHP_SELF'] ?? null,
                'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'] ?? null,
                'ORIG_PATH_INFO' => $_SERVER['ORIG_PATH_INFO'] ?? null,
            ],
        ]);
    } catch (\Throwable $e) {
        return response()->json(['error' => 'debug-failed', 'message' => $e->getMessage()]);
    }
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Trang chính
Route::get('/', function (Request $request) use ($callApi) {
    $data = $callApi('/api/loaiphongs') ?: [];
    $rooms = is_array($data) ? $data : [];

    // Attach first_phong_id (Pxxx) for each room type so "Details" links can point to an actual room
    foreach ($rooms as $i => $r) {
        $rooms[$i]['first_phong_id'] = null;
        if (!empty($r['IDLoaiPhong'])) {
            $list = $callApi('/api/phongs/loai/' . urlencode($r['IDLoaiPhong']));
            if (is_array($list) && count($list) > 0) {
                // list may be associative or numeric-indexed; retrieve first item
                $first = array_values($list)[0] ?? null;
                if (is_array($first) && !empty($first['IDPhong'])) {
                    $rooms[$i]['first_phong_id'] = $first['IDPhong'];
                }
            }
        }
    }

    // Fetch services to render on the homepage (server-side)
    $svcData = $callApi('/api/dichvu') ?: [];
    $services = is_array($svcData) ? $svcData : [];

    return view('welcome', compact('rooms', 'services'));
});


/*
 |-----------------------------------------------------------------------
 | Rooms by type view (rooms2)
 | expects /rooms2?type=LP001
 |-----------------------------------------------------------------------
 */
$rooms2Handler = function (Request $request) use ($callApi) {
    $type = $request->query('type', null);
    if (!$type) {
        return redirect('/'); // fallback
    }

    $roomsDetail = $callApi('/api/phongs/loai/' . urlencode($type)) ?: [];
    $typeInfo = $callApi('/api/loaiphongs/' . urlencode($type));
    $typeName = is_array($typeInfo) ? ($typeInfo['TenLoaiPhong'] ?? ($typeInfo['ten'] ?? null)) : null;

    // Fetch services to render on the rooms2 page (same as homepage)
    $svcData = $callApi('/api/dichvu') ?: [];
    $services = is_array($svcData) ? $svcData : [];

    return view('rooms2', compact('roomsDetail', 'services', 'typeName' ,'type'));
};

// register both URIs -> same handler
Route::get('/rooms2.php', $rooms2Handler);
Route::get('/rooms2', $rooms2Handler);


/*
 |-----------------------------------------------------------------------
 | Room details route
 | Template links use /roomdetails?id=... (and legacy /roomdetails.php?id=...)
 |-----------------------------------------------------------------------
 */
$roomdetailsHandler = function (Request $request) use ($callApi) {
    $rawId = $request->query('id', null);
    $room = null;
    $resolvedId = null;

    // Nếu truyền ID phòng (Pxxx) thì lấy chi tiết phòng, nếu truyền ID loại lấy phòng đầu tiên của loại
    if ($rawId) {
        if (is_string($rawId) && substr($rawId,0,1) === 'P') {
            $room = $callApi('/api/phongs/' . urlencode($rawId)) ?: null;
        } else {
            $list = $callApi('/api/phongs/loai/' . urlencode($rawId));
            $room = (is_array($list) && count($list)) ? array_values($list)[0] : null;
        }
        $resolvedId = $room['IDPhong'] ?? $rawId;
    }

    // Lấy danh sách loại phòng để hiển thị "Phòng Tương Tự"
    $rooms = $callApi('/api/loaiphongs') ?: [];

    // Bổ sung thông tin phòng đại diện (first_phong_id, ảnh, giá) nếu API loaiphongs không trả đủ
    foreach ($rooms as $i => $type) {
        $typeId = $type['IDLoaiPhong'] ?? null;
        if (!$typeId) continue;
        $list = $callApi('/api/phongs/loai/' . urlencode($typeId));
        $first = (is_array($list) && count($list)) ? array_values($list)[0] : null;
        if ($first) {
            $rooms[$i]['first_phong_id'] = $first['IDPhong'] ?? null;
            if (empty($rooms[$i]['UrlAnhLoaiPhong'])) {
                $rooms[$i]['UrlAnhLoaiPhong'] = $first['UrlAnhPhong'] ?? null;
            }
            if (empty($rooms[$i]['GiaCoBanMotDem'])) {
                $rooms[$i]['GiaCoBanMotDem'] = $first['Gia'] ?? null;
            }
        }
    }

    // expose $id for the view (compact expects 'id')
    $id = $rawId;

    // Quick debug endpoint: if ?debug=1 is present, return JSON instead of rendering
    if ($request->query('debug') == '1') {
        try {
            return response()->json([
                'rawId' => $rawId,
                'resolvedId' => $resolvedId,
                'room_found' => is_array($room) && !empty($room),
                'room_sample' => is_array($room) ? array_slice($room, 0, 10) : $room,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'debug-failed', 'message' => $e->getMessage()]);
        }
    }

    // Debug: log resolution result so we can see if a room was found
    try {
        logger()->info('roomdetails.route.result', [
            'rawId' => $rawId,
            'resolvedId' => $resolvedId,
            'room_found' => is_array($room) && !empty($room),
        ]);
    } catch (\Throwable $e) {
        // do nothing — logging must not break the response
    }

    // For debugging: return the view with an extra header so we can confirm what rendered
    try {
        $response = response()->view('roomdetails', compact('id','room','resolvedId','rooms'));
        $response->header('X-Rendered-View', 'roomdetails');
        return $response;
    } catch (\Throwable $e) {
        // fallback to plain view if response() helper fails for any reason
        return view('roomdetails', compact('id','room','resolvedId','rooms'));
    }
};

// Register both URIs -> same handler (prefer /roomdetails without .php)
Route::get('/roomdetails', $roomdetailsHandler);
Route::get('/roomdetails.php', $roomdetailsHandler);


// --- CỤM ROUTE ĐĂNG KÝ ---
// Route GET để hiển thị form đăng ký
Route::get('/register', function () {
    return view('login_auth.register');
})->name('register.form');

// Route POST để xử lý việc gửi OTP
Route::post('/register', [AuthController::class, 'register'])->name('register.action');

// Route POST để xác thực OTP và tạo tài khoản
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.action');


// --- CỤM ROUTE ĐĂNG NHẬP ---
Route::get('/login', function () {
    return view('login_auth.login');
})->name('login.form');

// (Bạn có thể thêm route POST cho login ở đây sau)

require __DIR__.'/auth.php';


Route::get('/tiennghi', function () {
    return view('amenties.tiennghi');
})->name('tiennghi.index');
// Restaurant page (legacy URI: /restaurant.html)
Route::get('/restaurant', function () {
    return view('Orther_user.restaurant');
});
Route::get('/restaurant.html', function () {
    return view('Orther_user.restaurant');
});
// Spa & Wellness page (both /spa-wellness and legacy /spa-wellness.html)
Route::get('/spa-wellness', function () {
    return view('Orther_user.spa_wellness');
});
Route::get('/spa-wellness.html', function () {
    return view('Orther_user.spa_wellness');
});
// About page (both /about and legacy /about.html)
Route::get('/about', function () {
    return view('Orther_user.about');
});
Route::get('/about.html', function () {
    return view('Orther_user.about');
});
// Services page (both /services and legacy /services.html)
Route::get('/services', function () {
    return view('Orther_user.services');
});

Route::get('/facilities', function () {
    return view('Orther_user.facilities');
});


Route::get('/faq', function () {
    return view('Orther_user.faq');
});
Route::get('/contact', function () {
    return view('Orther_user.contact');
});


Route::get('/taikhoan', [AuthController::class, 'taikhoan'])->name('taikhoan');
// POST route to update profile information (HoTen, SoDienThoai, NgaySinh)
Route::post('/taikhoan', [AuthController::class, 'updateProfile'])->name('taikhoan.update');