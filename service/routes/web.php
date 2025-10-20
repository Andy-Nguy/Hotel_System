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
        $subResponse = app()->handle($subRequest);
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

    return view('welcome', compact('rooms'));
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

    return view('rooms2', compact('roomsDetail', 'type', 'typeName'));
};

// register both URIs -> same handler
Route::get('/rooms2.php', $rooms2Handler);
Route::get('/rooms2', $rooms2Handler);


/*
 |-----------------------------------------------------------------------
 | Room details route
 | Template links use /roomdetails.php?id=...
 |-----------------------------------------------------------------------
 */
Route::get('/roomdetails.php', function (Request $request) use ($callApi) {
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

    return view('roomdetails', compact('id','room','resolvedId','rooms'));
});


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
Route::get('/taikhoan', [AuthController::class, 'taikhoan'])->name('taikhoan');

//DuyAnh 
// Booking page route (support both /booking and /booking.php links)
Route::get('/booking', function (Request $request) {
    // The booking view reads URL params via client-side JS (room, check_in, check_out)
    return view('booking');
});
Route::get('/booking.php', function (Request $request) {
    return view('booking');
});

// Payment page routes (support both /payment and /payment.php links)
Route::get('/payment', function (Request $request) {
    // Payment page will read pending booking data from localStorage or URL params
    return view('payment');
});
Route::get('/payment.php', function (Request $request) {
    return view('payment');
});

// Confirmation page routes (support both /confirmation and /confirmation.php links)
Route::get('/confirmation', function (Request $request) {
    return view('confirmation');
});
Route::get('/confirmation.php', function (Request $request) {
    return view('confirmation');
});

// Note: Pay-at-hotel is handled inline on the payment page (no separate route)