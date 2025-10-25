<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Đặt phòng - The Cappa Luxury Hotel</title>
    <link rel="icon" href="HomePage/img/favicon.png" type="image/png" sizes="32x32">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300;400&family=Barlow:wght@400&family=Gilda+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="HomePage/css/plugins.css" />
    <link rel="stylesheet" href="HomePage/css/style.css" />
    <style>
        .booking-page {
            background-color: #f8f5f0;
            padding: 100px 0 50px;
        }
        
        .booking-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .booking-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .booking-header h1 {
            font-family: 'Gilda Display', serif;
            font-size: 48px;
            color: #aa8453;
            margin-bottom: 15px;
        }
        
        .booking-header p {
            font-family: 'Barlow', sans-serif;
            color: #666;
            font-size: 16px;
        }
        
        .booking-steps {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
            position: relative;
        }
        
        .booking-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 25%;
            right: 25%;
            height: 2px;
            background: #ddd;
            z-index: 0;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
            flex: 1;
            max-width: 200px;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 2px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #999;
            margin-bottom: 10px;
            transition: all 0.3s;
        }
        
        .step.active .step-number {
            background: #aa8453;
            border-color: #aa8453;
            color: white;
        }
        
        .step.completed .step-number {
            background: #4CAF50;
            border-color: #4CAF50;
            color: white;
        }
        
        .step-label {
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            color: #666;
            text-align: center;
        }
        
        .booking-content {
            background: white;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        }
        
        .booking-section {
            display: none;
        }
        
        .booking-section.active {
            display: block;
            animation: fadeIn 0.5s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .section-title {
            font-family: 'Gilda Display', serif;
            font-size: 28px;
            color: #aa8453;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .booking-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .room-details-card {
            background: #f8f5f0;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .room-details-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        
        .room-details-content {
            padding: 25px;
        }
        
        .room-details-content h3 {
            font-family: 'Gilda Display', serif;
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }
        
        .room-features {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 20px 0;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            color: #666;
        }
        
        .feature-item i {
            color: #aa8453;
        }
        
        .booking-summary-card {
            background: #f8f5f0;
            border-radius: 8px;
            padding: 25px;
        }
        
        .booking-summary-card h3 {
            font-family: 'Gilda Display', serif;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-family: 'Barlow', sans-serif;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .summary-item:last-child {
            border-bottom: none;
        }
        
        .summary-item span:first-child {
            color: #666;
        }
        
        .summary-item span:last-child {
            font-weight: 500;
            color: #333;
        }
        
        .summary-item.total {
            border-top: 2px solid #aa8453;
            padding-top: 20px;
            margin-top: 20px;
            font-weight: bold;
            font-size: 20px;
            color: #aa8453;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            font-family: 'Barlow', sans-serif;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #aa8453;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .payment-method {
            border: 2px solid #f0f0f0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .payment-method:hover,
        .payment-method.selected {
            border-color: #aa8453;
            background: #fefdfb;
        }
        
        .special-requests {
            resize: vertical;
            min-height: 100px;
        }
        
        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 15px;
        }
        
        .btn {
            padding: 14px 35px;
            border: none;
            border-radius: 4px;
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-primary {
            background: #aa8453;
            color: white;
        }
        
        .btn-primary:hover {
            background: #8a6a43;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(170, 132, 83, 0.3);
        }
        
        .btn-secondary {
            background: #f0f0f0;
            color: #666;
        }
        
        .btn-secondary:hover {
            background: #e0e0e0;
        }
        
        .success-message {
            text-align: center;
            padding: 50px 20px;
        }
        
        .success-icon {
            display: inline-block;
            width: 80px;
            height: 80px;
            line-height: 80px;
            border-radius: 50%;
            background: #4CAF50;
            color: white;
            font-size: 40px;
            margin-bottom: 20px;
        }
        
        .success-message h2 {
            font-family: 'Gilda Display', serif;
            font-size: 36px;
            color: #aa8453;
            margin-bottom: 15px;
        }
        
        .success-message p {
            font-family: 'Barlow', sans-serif;
            color: #666;
            margin-bottom: 10px;
        }
        
        .confirmation-details {
            background: #f8f5f0;
            border-radius: 8px;
            padding: 30px;
            margin: 30px auto;
            max-width: 600px;
            text-align: left;
        }
        
        @media (max-width: 768px) {
            .booking-grid {
                grid-template-columns: 1fr;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .booking-steps {
                overflow-x: auto;
                justify-content: flex-start;
                padding-bottom: 10px;
            }
            
            .booking-steps::before {
                display: none;
            }
            
            .step {
                min-width: 100px;
            }
            
            .booking-content {
                padding: 25px 20px;
            }
            
            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Top alert container -->
    <div id="topAlertContainer" style="position:fixed; top:20px; left:50%; transform:translateX(-50%); z-index:2000; width:90%; max-width:600px; display:none;"></div>
    <!-- Progress scroll totop -->
    <div class="progress-wrap cursor-pointer">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <!-- Header -->
    <header class="cappa-header" style="position: fixed; top: 0; width: 100%; z-index: 999; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-md-6 cappa-logo-wrap">
                    <a href="./" class="cappa-logo"><img src="HomePage/img/logo.png" alt="Cappa Luxury Hotel"></a>
                </div>
                <!-- <div class="col-6 col-md-6 text-right">
                    <a href="./" style="font-family: 'Barlow', sans-serif; color: #aa8453; font-weight: 500;">← Back to Home</a>
                </div> -->
            </div>
        </div>
    </header>

    <!-- Booking Page -->
    <div class="booking-page">
        <div class="booking-container">
            <!-- Header -->
            <div class="booking-header">
                    <h1>Hoàn tất đặt phòng</h1>
                    <p>Kiểm tra thông tin đặt phòng của bạn và tiến hành thanh toán</p>
            </div>

            <!-- Progress Steps -->
            <div class="booking-steps">
                <div class="step completed" data-step="1">
                    <div class="step-number">✓</div>
                    <div class="step-label">Chi tiết đặt phòng</div>
                </div>
                <div class="step active" data-step="2">
                    <div class="step-number">2</div>
                    <div class="step-label">Thông tin khách</div>
                </div>
                <div class="step" data-step="3">
                    <div class="step-number">3</div>
                    <div class="step-label">Thanh toán</div>
                </div>
                <div class="step" data-step="4">
                    <div class="step-number">4</div>
                    <div class="step-label">Xác nhận</div>
                </div>
            </div>

            <!-- Booking Content -->
            <div class="booking-content">
                <!-- Step 1: Review Booking -->
                <div class="booking-section active" data-section="1">
                    <h2 class="section-title">Kiểm tra lại đặt phòng</h2>
                    
                    <div class="booking-grid">
                        <div class="room-details-card">
                            <img id="roomImage" src="HomePage/img/rooms/1.jpg" alt="Room">
                            <div class="room-details-content">
                                <h3 id="roomName">Phòng Deluxe</h3>
                                <div class="room-features">
                                    <div class="feature-item">
                                        <i class="flaticon-bed"></i>
                                        <span>King Size Bed</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="flaticon-bath"></i>
                                        <span>Private Bathroom</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="flaticon-wifi"></i>
                                        <span>Free WiFi</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="flaticon-breakfast"></i>
                                        <span>Breakfast Included</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="flaticon-towel"></i>
                                        <span>Pool & Spa Access</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="booking-summary-card">
                            <h3>Tóm tắt đặt phòng</h3>
                            <div class="summary-item">
                                <span>Ngày nhận phòng:</span>
                                <span id="displayCheckIn">-</span>
                            </div>
                            <div class="summary-item">
                                <span>Ngày trả phòng:</span>
                                <span id="displayCheckOut">-</span>
                            </div>
                            <div class="summary-item">
                                <span>Số đêm:</span>
                                <span id="displayNights">-</span>
                            </div>
                            <div class="summary-item">
                                <span>Loại phòng:</span>
                                <span id="displayRoomType">-</span>
                            </div>
                            <div class="summary-item">
                                <span>Giá mỗi đêm:</span>
                                <span id="displayPricePerNight">-</span>
                            </div>
                            <div class="summary-item total">
                                <span>Tổng tiền:</span>
                                <span id="displayTotal">0₫</span>
                            </div>
                        </div>
                    </div>

                    <h2 class="section-title">Thông tin khách</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Họ *</label>
                            <input type="text" id="firstName" required>
                        </div>
                        <div class="form-group">
                            <label>Tên *</label>
                            <input type="text" id="lastName" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Địa chỉ Email *</label>
                            <input type="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại *</label>
                            <input type="tel" id="phone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Yêu cầu đặc biệt (không bắt buộc)</label>
                        <textarea id="specialRequests" class="special-requests" placeholder="Vui lòng ghi yêu cầu đặc biệt (nhận phòng sớm, trả phòng muộn, chế độ ăn đặc biệt, v.v.)"></textarea>
                    </div>

                    <div class="btn-group">
                        <button class="btn btn-secondary" onclick="window.location.href='/'">Hủy đặt phòng</button>
                        <button class="btn btn-primary" onclick="goToPayment()">Tiến hành thanh toán</button>
                    </div>
                </div>

                <!-- Step 2: Payment -->
                <div class="booking-section" data-section="2">
                    <h2 class="section-title">Thông tin thanh toán</h2>

                    <div class="booking-summary-card" style="margin-bottom: 30px;">
                        <h3>Tóm tắt cuối cùng</h3>
                        <div class="summary-item">
                            <span>Tên khách:</span>
                            <span id="summaryGuestName">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Email:</span>
                            <span id="summaryEmail">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Điện thoại:</span>
                            <span id="summaryPhone">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Check-In:</span>
                            <span id="summaryCheckIn">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Check-Out:</span>
                            <span id="summaryCheckOut">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Phòng:</span>
                            <span id="summaryRoom">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Khách:</span>
                            <span id="summaryGuests">-</span>
                        </div>
                        <div class="summary-item total">
                            <span>Tổng tiền:</span>
                            <span id="summaryTotal">0₫</span>
                        </div>
                    </div>

                    <h3 style="font-family: 'Gilda Display', serif; margin-bottom: 20px; color: #333;">Chọn phương thức thanh toán</h3>
                    <div class="payment-methods">
                        <div class="payment-method" onclick="selectPayment('credit', this)">
                            <div style="font-family: 'Barlow', sans-serif; font-weight: 500; font-size: 16px;">💳 Thẻ tín dụng</div>
                        </div>
                        <div class="payment-method" onclick="selectPayment('debit', this)">
                            <div style="font-family: 'Barlow', sans-serif; font-weight: 500; font-size: 16px;">💳 Thẻ ghi nợ</div>
                        </div>
                        <div class="payment-method" onclick="selectPayment('paypal', this)">
                            <div style="font-family: 'Barlow', sans-serif; font-weight: 500; font-size: 16px;">🅿️ PayPal</div>
                        </div>
                        <div class="payment-method" onclick="selectPayment('bank', this)">
                            <div style="font-family: 'Barlow', sans-serif; font-weight: 500; font-size: 16px;">🏦 Chuyển khoản ngân hàng</div>
                        </div>
                    </div>

                    <div id="cardDetails" style="display: none;">
                        <div class="form-group">
                            <label>Số thẻ *</label>
                            <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Hạn thẻ (MM/YY) *</label>
                                <input type="text" id="expiryDate" placeholder="MM/YY" maxlength="5">
                            </div>
                            <div class="form-group">
                                <label>CVV *</label>
                                <input type="text" id="cvv" placeholder="123" maxlength="4">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tên chủ thẻ *</label>
                            <input type="text" id="cardName" placeholder="John Doe">
                        </div>
                    </div>

                    <div id="paypalDetails" style="display: none;">
                        <p style="font-family: 'Barlow', sans-serif; color: #666; padding: 20px; background: #f8f5f0; border-radius: 8px;">
                            Bạn sẽ được chuyển tới PayPal để hoàn tất thanh toán một cách an toàn.
                        </p>
                    </div>

                    <div id="bankDetails" style="display: none;">
                        <div style="font-family: 'Barlow', sans-serif; color: #666; padding: 20px; background: #f8f5f0; border-radius: 8px;">
                            <p style="margin-bottom: 10px;"><strong>Thông tin chuyển khoản:</strong></p>
                            <p>Ngân hàng: International Bank</p>
                            <p>Số tài khoản: 1234567890</p>
                            <p>SWIFT Code: INTLUS33</p>
                            <p style="margin-top: 15px; color: #aa8453;"><em>Vui lòng ghi mã tham chiếu đặt phòng trong phần ghi chú khi chuyển tiền.</em></p>
                        </div>
                    </div>

                    <div class="btn-group">
                        <button class="btn btn-secondary" onclick="prevStep(1)">Quay lại</button>
                        <button class="btn btn-primary" onclick="completeBooking()">Hoàn tất đặt phòng</button>
                    </div>
                </div>

                <!-- Step 3: Confirmation -->
                <div class="booking-section" data-section="3">
                    <div class="success-message">
                        <div class="success-icon">✓</div>
                        <h2>Đặt phòng thành công!</h2>
                        <p>Cảm ơn bạn đã chọn The Cappa Luxury Hotel</p>
                        
                        <div class="confirmation-details">
                            <div class="summary-item">
                                <span>Mã xác nhận:</span>
                                <span id="confirmationNumber" style="color: #aa8453; font-weight: bold;">-</span>
                            </div>
                            <div class="summary-item">
                                    <span>Tên khách:</span>
                                <span id="confirmGuestName">-</span>
                            </div>
                            <div class="summary-item">
                                    <span>Email:</span>
                                <span id="confirmEmail">-</span>
                            </div>
                            <div class="summary-item">
                                    <span>Loại phòng:</span>
                                <span id="confirmRoom">-</span>
                            </div>
                            <div class="summary-item">
                                    <span>Ngày nhận phòng:</span>
                                <span id="confirmCheckIn">-</span>
                            </div>
                            <div class="summary-item">
                                    <span>Ngày trả phòng:</span>
                                <span id="confirmCheckOut">-</span>
                            </div>
                            <div class="summary-item total">
                                    <span>Tổng đã thanh toán:</span>
                                    <span id="confirmTotal">0₫</span>
                            </div>
                        </div>

                            <p style="margin-top: 20px;">Một email xác nhận đã được gửi đến địa chỉ email của bạn.</p>
                            <p>Chúng tôi mong được đón tiếp bạn!</p>
                        
                        <div style="margin-top: 40px;">
                            <button class="btn btn-primary" onclick="window.location.href='/'">Quay về trang chủ</button>
                            <button class="btn btn-secondary" onclick="window.print()" style="margin-left: 15px;">In xác nhận</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Booking state
        const bookingData = {
            selectedRoom: null,
            checkIn: null,
            checkOut: null,
            roomName: '',
            roomPrice: 0,
            nights: 0,
            total: 0,
            guestInfo: {},
            paymentMethod: null
        };

        // Paths (rendered by Blade so routes are correct relative URLs)
        const LOGIN_PATH = '{!! route('login', [], false) !!}';

        // Initialize and load booking from backend API (no mock data)
        document.addEventListener('DOMContentLoaded', function() {
            loadBookingFromURL();
        });

        async function loadBookingFromURL() {
            const params = new URLSearchParams(window.location.search);

            // Get booking details from URL (room id may be numeric or string like 'P003')
            const rawRoom = params.get('room');
            const roomId = rawRoom !== null ? rawRoom : null;
            const checkIn = params.get('check_in') || new Date().toISOString().split('T')[0];
            const checkOut = params.get('check_out') || new Date(Date.now() + 86400000).toISOString().split('T')[0];

            bookingData.selectedRoom = roomId;
            bookingData.checkIn = checkIn;
            bookingData.checkOut = checkOut;

            // Authentication check: if user is not logged in, show a modal prompting to login
            const userEmail = localStorage.getItem('email');
            if (!userEmail) {
                // Save redirect for after login
                localStorage.setItem('redirect_after_login', window.location.pathname + window.location.search);

                // Show a brief alert banner, then show modal (Bootstrap) as non-dismissible (force login)
                showAuthAlert('Bạn chưa đăng nhập — bạn sẽ được chuyển tới trang đăng nhập để tiếp tục đặt phòng.');
                if (window.jQuery && typeof window.jQuery('#loginRequiredModal').modal === 'function') {
                    // small delay so the banner is visible before modal appears
                    setTimeout(() => window.jQuery('#loginRequiredModal').modal({ backdrop: 'static', keyboard: false, show: true }), 600);
                } else {
                    // Fallback: show banner briefly then redirect to login (no cancel)
                    setTimeout(() => { window.location.href = LOGIN_PATH; }, 1200);
                }

                // stop further processing until user acts
                return;
            }

            // Auto-fill guest info from localStorage if available
            const storedName = localStorage.getItem('userName') || '';
            const storedPhone = localStorage.getItem('phone') || '';
            const nameParts = storedName.trim().split(/\s+/);
            const firstNamePrefill = nameParts.length ? nameParts.shift() : '';
            const lastNamePrefill = nameParts.length ? nameParts.join(' ') : '';

            // Fill guest form fields if present
            const firstEl = document.getElementById('firstName');
            const lastEl = document.getElementById('lastName');
            const emailEl = document.getElementById('email');
            const phoneEl = document.getElementById('phone');
            if (firstEl && !firstEl.value) firstEl.value = firstNamePrefill;
            if (lastEl && !lastEl.value) lastEl.value = lastNamePrefill;
            if (emailEl && !emailEl.value) emailEl.value = userEmail;
            if (phoneEl && !phoneEl.value) phoneEl.value = storedPhone;

            // Seed bookingData.guestInfo so updatePaymentSummary works immediately
            bookingData.guestInfo = {
                firstName: firstEl ? firstEl.value.trim() : firstNamePrefill,
                lastName: lastEl ? lastEl.value.trim() : lastNamePrefill,
                email: userEmail,
                phone: phoneEl ? phoneEl.value.trim() : storedPhone,
                adults: document.getElementById('adults') ? document.getElementById('adults').value : '2',
                children: document.getElementById('children') ? document.getElementById('children').value : '0',
                specialRequests: document.getElementById('specialRequests') ? document.getElementById('specialRequests').value : ''
            };

            // Fetch room details from API
            try {
                const room = await fetchRoomDetails(roomId);
                if (room) {
                    bookingData.roomName = room.name || room.TenPhong || '';
                    bookingData.roomPrice = Number(room.price || room.Gia || room.GiaCoBanMotDem || 0) || 0;

                    // Calculate nights and total
                    const checkInDate = new Date(bookingData.checkIn);
                    const checkOutDate = new Date(bookingData.checkOut);
                    bookingData.nights = Math.max(1, Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24)));
                    bookingData.total = bookingData.roomPrice * bookingData.nights;

                    // Update UI
                    document.getElementById('roomImage').src = room.image || room.UrlAnhPhong || room.UrlAnhLoaiPhong || 'HomePage/img/rooms/1.jpg';
                    document.getElementById('roomName').textContent = bookingData.roomName;
                    document.getElementById('displayCheckIn').textContent = formatDate(bookingData.checkIn);
                    document.getElementById('displayCheckOut').textContent = formatDate(bookingData.checkOut);
                    document.getElementById('displayNights').textContent = bookingData.nights + (bookingData.nights === 1 ? ' đêm' : ' đêm');
                    document.getElementById('displayRoomType').textContent = bookingData.roomName;
                    document.getElementById('displayPricePerNight').textContent = formatCurrency(bookingData.roomPrice);
                    document.getElementById('displayTotal').textContent = formatCurrency(bookingData.total);
                }
            } catch (err) {
                console.error('Failed to load room details', err);
            }
        }

        // Fetch room details from backend API and normalize
        async function fetchRoomDetails(roomId) {
            if (!roomId) return null;
            const endpoint = '/api/phongs/' + encodeURIComponent(roomId);
            try {
                const resp = await fetch(endpoint, { method: 'GET', headers: { 'Accept': 'application/json' } });
                if (!resp.ok) {
                    console.warn('Room API returned', resp.status);
                    return null;
                }
                const data = await resp.json();
                // API may return { success: true, data: {...} } or raw object
                const raw = data && data.data ? data.data : data;
                if (!raw) return null;
                // Normalize to simple shape: { id, name, price, image }
                return {
                    id: raw.IDPhong || raw.id || roomId,
                    name: raw.TenPhong || raw.ten || raw.name || '',
                    price: raw.Gia || raw.GiaCoBanMotDem || raw.price || 0,
                    image: raw.UrlAnhPhong || raw.UrlAnhLoaiPhong || raw.UrlAnh || raw.HinhAnh || null,
                    raw
                };
            } catch (e) {
                console.error('fetchRoomDetails error', e);
                return null;
            }
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return dateString;
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('vi-VN', options);
        }

        function formatCurrency(amount) {
            const n = Number(amount) || 0;
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', maximumFractionDigits: 0 }).format(n);
        }

        function nextStep(step) {
            if (step === 2) {
                // Validate guest information
                const firstName = document.getElementById('firstName').value.trim();
                const lastName = document.getElementById('lastName').value.trim();
                const email = document.getElementById('email').value.trim();
                const phone = document.getElementById('phone').value.trim();

                if (!firstName || !lastName || !email || !phone) {
                    alert('Vui lòng điền đầy đủ các trường bắt buộc');
                    return;
                }

                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert('Vui lòng nhập địa chỉ email hợp lệ');
                    return;
                }

                bookingData.guestInfo = {
                    firstName,
                    lastName,
                    email,
                    phone,
                    adults: document.getElementById('adults').value,
                    children: document.getElementById('children').value,
                    specialRequests: document.getElementById('specialRequests').value
                };

                updatePaymentSummary();
            }

            showStep(step);
        }

        // Save pending booking and navigate to payment page
        function goToPayment() {
            // validate guest information (reuse nextStep validations)
            const firstNameEl = document.getElementById('firstName');
            const lastNameEl = document.getElementById('lastName');
            const emailEl = document.getElementById('email');
            const phoneEl = document.getElementById('phone');

            const firstName = firstNameEl ? firstNameEl.value.trim() : '';
            const lastName = lastNameEl ? lastNameEl.value.trim() : '';
            const email = emailEl ? emailEl.value.trim() : '';
            const phone = phoneEl ? phoneEl.value.trim() : '';

            if (!firstName || !lastName || !email || !phone) {
                alert('Vui lòng điền đầy đủ các trường bắt buộc');
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Vui lòng nhập địa chỉ email hợp lệ');
                return;
            }

            // update bookingData.guestInfo
            bookingData.guestInfo = {
                firstName,
                lastName,
                email,
                phone,
                adults: document.getElementById('adults') ? document.getElementById('adults').value : '2',
                children: document.getElementById('children') ? document.getElementById('children').value : '0',
                specialRequests: document.getElementById('specialRequests') ? document.getElementById('specialRequests').value : ''
            };

            // ensure computed fields (nights, total) exist
            if (!bookingData.nights) {
                const checkInDate = new Date(bookingData.checkIn);
                const checkOutDate = new Date(bookingData.checkOut);
                bookingData.nights = Math.max(1, Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24)));
            }
            if (!bookingData.total) {
                bookingData.total = (bookingData.roomPrice || 0) * bookingData.nights;
            }

            // Store a pending booking for the payment page to consume
            try {
                const pending = {
                    roomId: bookingData.selectedRoom,
                    roomName: bookingData.roomName,
                    roomPrice: bookingData.roomPrice,
                    checkIn: bookingData.checkIn,
                    checkOut: bookingData.checkOut,
                    nights: bookingData.nights,
                    total: bookingData.total,
                    guestInfo: bookingData.guestInfo
                };
                localStorage.setItem('pendingBooking', JSON.stringify(pending));
            } catch (e) {
                console.warn('Unable to save pendingBooking to localStorage', e);
            }

            // Navigate to payment page with minimal query params for convenience
            const params = new URLSearchParams({ room: bookingData.selectedRoom || '', total: bookingData.total || 0 });
            window.location.href = '/payment?' + params.toString();
        }

        function prevStep(step) {
            showStep(step);
        }

        function showStep(step) {
            document.querySelectorAll('.booking-section').forEach(section => {
                section.classList.remove('active');
            });
            document.querySelector(`[data-section="${step}"]`).classList.add('active');

            // Update progress steps
            document.querySelectorAll('.step').forEach((s, index) => {
                s.classList.remove('active', 'completed');
                if (index + 1 < step) {
                    s.classList.add('completed');
                    s.querySelector('.step-number').textContent = '✓';
                } else if (index + 1 === step) {
                    s.classList.add('active');
                    s.querySelector('.step-number').textContent = index + 1;
                } else {
                    s.querySelector('.step-number').textContent = index + 1;
                }
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function updatePaymentSummary() {
            document.getElementById('summaryGuestName').textContent = `${bookingData.guestInfo.firstName} ${bookingData.guestInfo.lastName}`;
            document.getElementById('summaryEmail').textContent = bookingData.guestInfo.email;
            document.getElementById('summaryPhone').textContent = bookingData.guestInfo.phone;
            document.getElementById('summaryCheckIn').textContent = formatDate(bookingData.checkIn);
            document.getElementById('summaryCheckOut').textContent = formatDate(bookingData.checkOut);
            document.getElementById('summaryRoom').textContent = bookingData.roomName;
            document.getElementById('summaryGuests').textContent = `${bookingData.guestInfo.adults} người lớn, ${bookingData.guestInfo.children} trẻ em`;
            document.getElementById('summaryTotal').textContent = formatCurrency(bookingData.total || 0);
        }

        function selectPayment(method, el) {
            bookingData.paymentMethod = method;

            // Update selected state
            document.querySelectorAll('.payment-method').forEach(pm => {
                pm.classList.remove('selected');
            });
            if (el && el.classList) el.classList.add('selected');

            // Hide all payment details
            document.getElementById('cardDetails').style.display = 'none';
            document.getElementById('paypalDetails').style.display = 'none';
            document.getElementById('bankDetails').style.display = 'none';

            // Show relevant payment details
            if (method === 'credit' || method === 'debit') {
                document.getElementById('cardDetails').style.display = 'block';
            } else if (method === 'paypal') {
                document.getElementById('paypalDetails').style.display = 'block';
            } else if (method === 'bank') {
                document.getElementById('bankDetails').style.display = 'block';
            }
        }

        function completeBooking() {
            if (!bookingData.paymentMethod) {
                alert('Vui lòng chọn phương thức thanh toán');
                return;
            }

            // Validate card details if credit/debit selected
            if (bookingData.paymentMethod === 'credit' || bookingData.paymentMethod === 'debit') {
                const cardNumber = document.getElementById('cardNumber').value.trim();
                const expiryDate = document.getElementById('expiryDate').value.trim();
                const cvv = document.getElementById('cvv').value.trim();
                const cardName = document.getElementById('cardName').value.trim();

                if (!cardNumber || !expiryDate || !cvv || !cardName) {
                    alert('Vui lòng điền đầy đủ thông tin thẻ');
                    return;
                }

                // Basic card number validation (should be 13-19 digits)
                const cardNumberClean = cardNumber.replace(/\s/g, '');
                if (cardNumberClean.length < 13 || cardNumberClean.length > 19) {
                    alert('Vui lòng nhập số thẻ hợp lệ');
                    return;
                }

                // Basic expiry date validation (MM/YY format)
                const expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
                if (!expiryRegex.test(expiryDate)) {
                    alert('Vui lòng nhập hạn thẻ theo định dạng MM/YY');
                    return;
                }

                // CVV validation (3-4 digits)
                if (cvv.length < 3 || cvv.length > 4) {
                    alert('Vui lòng nhập mã CVV hợp lệ');
                    return;
                }
            }

            // Generate confirmation number
            const confirmationNumber = 'CPL' + Date.now().toString().slice(-8);
            
            // Update confirmation page
            document.getElementById('confirmationNumber').textContent = confirmationNumber;
            document.getElementById('confirmGuestName').textContent = `${bookingData.guestInfo.firstName} ${bookingData.guestInfo.lastName}`;
            document.getElementById('confirmEmail').textContent = bookingData.guestInfo.email;
            document.getElementById('confirmRoom').textContent = bookingData.roomName;
            document.getElementById('confirmCheckIn').textContent = formatDate(bookingData.checkIn);
            document.getElementById('confirmCheckOut').textContent = formatDate(bookingData.checkOut);
            document.getElementById('confirmTotal').textContent = formatCurrency(bookingData.total || 0);

            // Show confirmation page
            showStep(3);

            // Here you would normally send the booking data to your server
            console.log('Booking completed:', {
                confirmationNumber,
                ...bookingData
            });
        }

        // Card number formatting
        document.getElementById('cardNumber')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });

        // Expiry date formatting
        document.getElementById('expiryDate')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            e.target.value = value;
        });

        // CVV - numbers only
        document.getElementById('cvv')?.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });

        // Phone number formatting
        document.getElementById('phone')?.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^\d+\-\(\)\s]/g, '');
        });
    </script>
    <!-- Login required modal -->
    <div class="modal fade" id="loginRequiredModal" tabindex="-1" role="dialog" aria-labelledby="loginRequiredLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginRequiredLabel">Cần đăng nhập</h5>
                    <!-- no close button: user must login -->
                </div>
                <div class="modal-body">
                    <p>Vui lòng đăng nhập để tiếp tục đặt phòng. Bạn sẽ được chuyển về trang này sau khi đăng nhập.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="loginNowBtn" class="btn btn-primary">Đăng nhập</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('loginNowBtn')?.addEventListener('click', function() {
            // redirect to login page (LOGIN_PATH is rendered earlier)
            window.location.href = LOGIN_PATH;
        });
    </script>

    <script>
        // Show a temporary top alert message (Vietnamese). type: 'info'|'danger'|'success'
        function showAuthAlert(message, type = 'info', timeout = 3000) {
            const container = document.getElementById('topAlertContainer');
            if (!container) return;
            container.innerHTML = `<div class="alert alert-${type}" role="alert" style="margin:0;">
                ${message}
            </div>`;
            container.style.display = 'block';
            setTimeout(() => {
                container.style.display = 'none';
                container.innerHTML = '';
            }, timeout);
        }
    </script>
</body>
</html>