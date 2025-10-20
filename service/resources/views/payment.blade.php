<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment - The Cappa Luxury Hotel</title>
    <link rel="icon" href="HomePage/img/favicon.png" type="image/png" sizes="32x32">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300;400&family=Barlow:wght@400&family=Gilda+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="HomePage/css/plugins.css" />
    <link rel="stylesheet" href="HomePage/css/style.css" />
    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            font-family: 'Barlow', sans-serif;
            background: #f8f5f0;
        }
        
        .payment-page {
            min-height: 100vh;
            padding: 100px 0 50px;
        }
        
        .payment-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .payment-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .payment-header h1 {
            font-family: 'Gilda Display', serif;
            font-size: 42px;
            color: #aa8453;
            margin-bottom: 10px;
        }
        
        .payment-header p {
            color: #666;
            font-size: 16px;
        }
        
        .secure-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #4CAF50;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 13px;
            margin-top: 15px;
        }

        /* Booking steps (horizontal progress bar) */
        .booking-steps {
            display: flex;
            justify-content: center;
            margin: 20px auto 30px;
            position: relative;
            max-width: 900px;
        }

        .booking-steps::before {
            content: '';
            position: absolute;
            top: 22px; /* aligns with center of step-number */
            left: 5%;
            right: 5%;
            height: 2px;
            background: #e6e6e6;
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
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #fff;
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

        @media (max-width: 768px) {
            .booking-steps {
                overflow-x: auto;
                justify-content: flex-start;
                padding-bottom: 10px;
            }
            .booking-steps::before { display: none; }
            .step { min-width: 100px; }
        }
        
        .payment-layout {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
            align-items: start;
        }
        
        .payment-main {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        }
        
        .payment-sidebar {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            position: sticky;
            top: 100px;
        }
        
        .section-title {
            font-family: 'Gilda Display', serif;
            font-size: 24px;
            color: #333;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .payment-methods {
            display: grid;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .payment-method-card {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .payment-method-card:hover {
            border-color: #aa8453;
            background: #fefdfb;
        }
        
        .payment-method-card.active {
            border-color: #aa8453;
            background: #fefdfb;
            box-shadow: 0 4px 12px rgba(170, 132, 83, 0.15);
        }
        
        .payment-method-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background: #f8f5f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .payment-method-info {
            flex: 1;
        }
        
        .payment-method-info h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
            color: #333;
        }
        
        .payment-method-info p {
            margin: 0;
            font-size: 13px;
            color: #999;
        }
        
        .payment-method-radio {
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 50%;
            position: relative;
            transition: all 0.3s;
        }
        
        .payment-method-card.active .payment-method-radio {
            border-color: #aa8453;
        }
        
        .payment-method-card.active .payment-method-radio::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: #aa8453;
            border-radius: 50%;
        }
        
        .payment-form {
            display: none;
            animation: fadeIn 0.4s;
        }
        
        .payment-form.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            font-family: 'Barlow', sans-serif;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #aa8453;
            box-shadow: 0 0 0 3px rgba(170, 132, 83, 0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .form-row-3 {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 15px;
        }
        
        .card-brands {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        .card-brand {
            width: 45px;
            height: 30px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
            color: #666;
        }
        
        .order-summary {
            margin-bottom: 25px;
        }
        
        .room-preview {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .room-preview img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
        }
        
        .room-preview-info h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
            color: #333;
        }
        
        .room-preview-info p {
            margin: 0;
            font-size: 13px;
            color: #666;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
        }
        
        .summary-row span:first-child {
            color: #666;
        }
        
        .summary-row span:last-child {
            color: #333;
            font-weight: 500;
        }
        
        .summary-divider {
            height: 1px;
            background: #e0e0e0;
            margin: 20px 0;
        }
        
        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 20px;
            font-weight: bold;
            color: #aa8453;
            padding-top: 15px;
            border-top: 2px solid #aa8453;
        }
        
        .promo-code {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .promo-code input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 13px;
        }
        
        .promo-code button {
            padding: 10px 20px;
            background: #aa8453;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .promo-code button:hover {
            background: #8a6a43;
        }
        
        .btn {
            padding: 16px 40px;
            border: none;
            border-radius: 8px;
            font-family: 'Barlow', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 100%;
        }
        
        .btn-primary {
            background: #aa8453;
            color: white;
        }
        
        .btn-primary:hover {
            background: #8a6a43;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(170, 132, 83, 0.3);
        }
        
        .btn-primary:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        
        .security-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: #f8f5f0;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 13px;
            color: #666;
        }
        
        .security-info::before {
            content: '🔒';
            font-size: 18px;
        }
        
        .payment-info-box {
            background: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
        }
        
        .payment-info-box.success {
            background: #e8f5e9;
            border-color: #4CAF50;
        }
        
        .bank-details {
            background: #f8f5f0;
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px;
        }
        
        .bank-details p {
            margin: 8px 0;
            font-size: 14px;
        }
        
        .bank-details strong {
            color: #aa8453;
        }
        
        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
        
        .qr-code img {
            width: 200px;
            height: 200px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px;
            background: white;
        }
        
        .booking-protection {
            display: flex;
            gap: 20px;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #f0f0f0;
        }
        
        .protection-item {
            flex: 1;
            text-align: center;
        }
        
        .protection-item-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .protection-item h5 {
            margin: 0 0 5px 0;
            font-size: 14px;
            color: #333;
        }
        
        .protection-item p {
            margin: 0;
            font-size: 12px;
            color: #999;
        }
        
        @media (max-width: 1024px) {
            .payment-layout {
                grid-template-columns: 1fr;
            }
            
            .payment-sidebar {
                position: static;
                order: -1;
            }
        }
        
        @media (max-width: 768px) {
            .payment-main {
                padding: 25px 20px;
            }
            
            .payment-sidebar {
                padding: 20px;
            }
            
            .form-row,
            .form-row-3 {
                grid-template-columns: 1fr;
            }
            
            .booking-protection {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="cappa-header" style="position: fixed; top: 0; width: 100%; z-index: 999; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-md-6 cappa-logo-wrap">
                    <a href="index.html" class="cappa-logo"><img src="HomePage/img/logo.png" alt="Cappa Luxury Hotel"></a>
                </div>
                <div class="col-6 col-md-6 text-right">
                    <a href="booking.html" style="font-family: 'Barlow', sans-serif; color: #aa8453; font-weight: 500;">← Back to Booking</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Payment Page -->
    <div class="payment-page">
        <div class="payment-container">
            <!-- Header -->
            <div class="payment-header">
                <h1>Secure Payment</h1>
                <p>Complete your reservation with a secure payment</p>
                <!-- Progress Steps -->
                <div class="booking-steps" style="max-width:900px; margin:12px auto 0;">
                    <div class="step completed" data-step="1">
                        <div class="step-number">✓</div>
                        <div class="step-label">Booking Details</div>
                    </div>
                    <div class="step completed" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-label">Guest Information</div>
                    </div>
                    <div class="step active" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-label">Payment</div>
                    </div>
                    <div class="step" data-step="4">
                        <div class="step-number">4</div>
                        <div class="step-label">Confirmation</div>
                    </div>
                </div>
            </div>
 

            <!-- Payment Layout -->
            <div class="payment-layout">
                <!-- Main Payment Section -->
                <div class="payment-main">
                    <h2 class="section-title">Select Payment Method</h2>
                    
                    <div class="payment-methods">
                        <!-- Credit/Debit Card -->
                        <div class="payment-method-card active" onclick="selectPaymentMethod('card')">
                            <div class="payment-method-icon">💳</div>
                            <div class="payment-method-info">
                                <h4>Credit / Debit Card</h4>
                                <p>Visa, Mastercard, Amex, Discover</p>
                            </div>
                            <div class="payment-method-radio"></div>
                        </div>

                        <!-- PayPal -->
                        <div class="payment-method-card" onclick="selectPaymentMethod('paypal')">
                            <div class="payment-method-icon">🅿️</div>
                            <div class="payment-method-info">
                                <h4>PayPal</h4>
                                <p>Fast and secure PayPal checkout</p>
                            </div>
                            <div class="payment-method-radio"></div>
                        </div>

                        <!-- Bank Transfer -->
                        <div class="payment-method-card" onclick="selectPaymentMethod('bank')">
                            <div class="payment-method-icon">🏦</div>
                            <div class="payment-method-info">
                                <h4>Bank Transfer</h4>
                                <p>Direct bank transfer payment</p>
                            </div>
                            <div class="payment-method-radio"></div>
                        </div>

                        <!-- Pay at Hotel -->
                        <div class="payment-method-card" onclick="selectPaymentMethod('payathotel')">
                            <div class="payment-method-icon">🏨</div>
                            <div class="payment-method-info">
                                <h4>Pay at Hotel</h4>
                                <p>Reserve now and pay at the hotel upon arrival</p>
                            </div>
                            <div class="payment-method-radio"></div>
                        </div>
                    </div>

                    <!-- Card Payment Form -->
                    <div id="cardForm" class="payment-form active">
                        <h3 class="section-title">Card Details</h3>
                        
                        <div class="form-group">
                            <label>Card Number *</label>
                            <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19" required>
                            <div class="card-brands">
                                <div class="card-brand">VISA</div>
                                <div class="card-brand">MC</div>
                                <div class="card-brand">AMEX</div>
                                <div class="card-brand">DISC</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Cardholder Name *</label>
                            <input type="text" id="cardName" placeholder="John Doe" required>
                        </div>

                        <div class="form-row-3">
                            <div class="form-group">
                                <label>Expiry Date *</label>
                                <input type="text" id="expiryDate" placeholder="MM/YY" maxlength="5" required>
                            </div>
                            <div class="form-group">
                                <label>CVV *</label>
                                <input type="text" id="cvv" placeholder="123" maxlength="4" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" id="saveCard" style="width: auto; margin-right: 8px;">
                                Save card for future bookings
                            </label>
                        </div>
                    </div>

                    <!-- PayPal Form -->
                    <div id="paypalForm" class="payment-form">
                        <div class="payment-info-box">
                            <strong>PayPal Payment</strong><br>
                            You will be redirected to PayPal to complete your payment securely. After payment, you'll be returned to our site for confirmation.
                        </div>
                        <button class="btn btn-primary" onclick="processPayPal()">Continue to PayPal</button>
                    </div>

                    <!-- Bank Transfer Form -->
                    <div id="bankForm" class="payment-form">
                        <div class="payment-info-box">
                            <strong>Bank Transfer Instructions</strong><br>
                            Please transfer the total amount to the bank account below or scan the QR code to pay from your banking app. Your booking will be confirmed once we receive your payment.
                        </div>

                        <div class="bank-details">
                            <p><strong>Bank Name:</strong> International Luxury Bank</p>
                            <p><strong>Account Name:</strong> The Cappa Luxury Hotel</p>
                            <p><strong>Account Number:</strong> 1234567890123456</p>
                            <p><strong>SWIFT/BIC:</strong> INTLUS33XXX</p>
                            <p><strong>Reference:</strong> <span id="bookingRef">CPL12345678</span></p>
                        </div>

                        <div style="text-align:center; margin-top:16px;">
                            <img src="HomePage/img/qr_bank.png" alt="Bank QR" style="width:220px; height:220px; border:1px solid #e0e0e0; border-radius:8px; background:white; padding:8px;" />
                        </div>

                        <div class="payment-info-box success" style="margin-top: 20px;">
                            <strong>Important:</strong> Please include the reference number in your transfer notes to ensure quick processing.
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div id="billingAddress" style="margin-top: 30px;">
                        <h3 class="section-title">Billing Address</h3>
                        
                        <div class="form-group">
                            <label>
                                <input type="checkbox" id="sameAsGuest" checked style="width: auto; margin-right: 8px;" onchange="toggleBillingAddress()">
                                Same as guest information
                            </label>
                        </div>

                        <div id="billingFields" style="display: none;">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>First Name *</label>
                                    <input type="text" id="billingFirstName">
                                </div>
                                <div class="form-group">
                                    <label>Last Name *</label>
                                    <input type="text" id="billingLastName">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Street Address *</label>
                                <input type="text" id="billingAddress1" placeholder="Street address, P.O. box">
                            </div>

                            <div class="form-group">
                                <input type="text" id="billingAddress2" placeholder="Apartment, suite, unit, etc. (optional)">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>City *</label>
                                    <input type="text" id="billingCity">
                                </div>
                                <div class="form-group">
                                    <label>State / Province *</label>
                                    <input type="text" id="billingState">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Zip / Postal Code *</label>
                                    <input type="text" id="billingZip">
                                </div>
                                <div class="form-group">
                                    <label>Country *</label>
                                    <select id="billingCountry">
                                        <option value="">Select Country</option>
                                        <option value="US">United States</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="CA">Canada</option>
                                        <option value="AU">Australia</option>
                                        <option value="VN">Vietnam</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button class="btn btn-primary" onclick="processPayment()" style="margin-top: 30px;" id="submitPayment">
                        Complete Payment
                    </button>

                  

                    <div class="security-info">
                        Your payment information is encrypted and secure. We never store your complete card details.
                    </div>

                    <!-- Protection Features -->
                    <div class="booking-protection">
                        <div class="protection-item">
                            <div class="protection-item-icon">🛡️</div>
                            <h5>Secure Payment</h5>
                            <p>256-bit SSL encryption</p>
                        </div>
                        <div class="protection-item">
                            <div class="protection-item-icon">↩️</div>
                            <h5>Free Cancellation</h5>
                            <p>Cancel up to 24hrs before</p>
                        </div>
                        <div class="protection-item">
                            <div class="protection-item-icon">✓</div>
                            <h5>Instant Confirmation</h5>
                            <p>Get booking confirmation</p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar: Order Summary -->
                <div class="payment-sidebar">
                    <h3 class="section-title">Order Summary</h3>
                    
                    <div class="order-summary">
                        <div class="room-preview">
                            <img id="summaryRoomImage" src="HomePage/img/rooms/1.jpg" alt="Room">
                            <div class="room-preview-info">
                                <h4 id="summaryRoomName">Deluxe Room</h4>
                                <p id="summaryDates">Dec 20 - Dec 22, 2024</p>
                            </div>
                        </div>

                        <div class="summary-row">
                            <span>Room Rate</span>
                            <span id="summaryRoomRate">$250 × 2 nights</span>
                        </div>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="summarySubtotal">$500</span>
                        </div>
                        <div class="summary-row">
                            <span>Taxes & Fees</span>
                            <span id="summaryTaxes">$75</span>
                        </div>
                        <div class="summary-row" id="discountRow" style="display: none;">
                            <span style="color: #4CAF50;">Discount</span>
                            <span id="summaryDiscount" style="color: #4CAF50;">-$50</span>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-total">
                            <span>Total</span>
                            <span id="summaryTotalAmount">$575</span>
                        </div>
                    </div>

                    <div class="promo-code">
                        <input type="text" id="promoInput" placeholder="Promo code">
                        <button onclick="applyPromo()">Apply</button>
                    </div>

                    <div class="security-info" style="margin-top: 20px;">
                        All prices are in USD and include applicable taxes.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Payment state
        let selectedMethod = 'card';
        let bookingData = {
            room: 'Deluxe Room',
            roomImage: 'HomePage/img/rooms/1.jpg',
            checkIn: '2024-12-20',
            checkOut: '2024-12-22',
            nights: 2,
            pricePerNight: 250,
            subtotal: 500,
            taxes: 75,
            discount: 0,
            total: 575
        };

        // Load pending booking saved by booking page (localStorage) and apply to bookingData
        function loadPendingBooking() {
            try {
                const raw = localStorage.getItem('pendingBooking');
                if (!raw) return;
                const pending = JSON.parse(raw);
                if (!pending) return;

                // Map fields onto bookingData used by this page
                bookingData.room = pending.roomName || bookingData.room;
                bookingData.roomImage = pending.roomImage || bookingData.roomImage;
                bookingData.checkIn = pending.checkIn || bookingData.checkIn;
                bookingData.checkOut = pending.checkOut || bookingData.checkOut;
                bookingData.nights = pending.nights || bookingData.nights;
                bookingData.pricePerNight = pending.roomPrice || bookingData.pricePerNight;
                bookingData.subtotal = (bookingData.pricePerNight || 0) * (bookingData.nights || 1);
                bookingData.taxes = pending.taxes ?? bookingData.taxes;
                bookingData.total = pending.total || bookingData.total || bookingData.subtotal + (bookingData.taxes || 0);
                bookingData.roomId = pending.roomId || bookingData.roomId; // Add roomId
            } catch (e) {
                console.warn('Failed to load pendingBooking', e);
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadPendingBooking();
            loadBookingData();
            formatCardInputs();
        });

        function loadBookingData() {
            // Load from URL parameters or localStorage
            const params = new URLSearchParams(window.location.search);
            
            if (params.get('room')) {
                bookingData.room = decodeURIComponent(params.get('room'));
                bookingData.roomId = decodeURIComponent(params.get('room')); // Add roomId
            }
            if (params.get('total')) {
                bookingData.total = parseFloat(params.get('total'));
            }

            updateSummary();
        }

        function updateSummary() {
            document.getElementById('summaryRoomImage').src = bookingData.roomImage;
            document.getElementById('summaryRoomName').textContent = bookingData.room;
            document.getElementById('summaryDates').textContent = formatDateRange(bookingData.checkIn, bookingData.checkOut);
            document.getElementById('summaryRoomRate').textContent = `$${bookingData.pricePerNight} × ${bookingData.nights} nights`;
            document.getElementById('summarySubtotal').textContent = `$${bookingData.subtotal}`;
            document.getElementById('summaryTaxes').textContent = `$${bookingData.taxes}`;
            document.getElementById('summaryTotalAmount').textContent = `${bookingData.total}`;
            
            if (bookingData.discount > 0) {
                document.getElementById('discountRow').style.display = 'flex';
                document.getElementById('summaryDiscount').textContent = `-${bookingData.discount}`;
            }

            // Generate booking reference
            document.getElementById('bookingRef').textContent = 'CPL' + Date.now().toString().slice(-8);
        }

        function formatDateRange(start, end) {
            const options = { month: 'short', day: 'numeric', year: 'numeric' };
            const startDate = new Date(start).toLocaleDateString('en-US', options);
            const endDate = new Date(end).toLocaleDateString('en-US', options);
            return `${startDate} - ${endDate}`;
        }

        function selectPaymentMethod(method) {
            selectedMethod = method;
            
            // Update active card
            document.querySelectorAll('.payment-method-card').forEach(card => {
                card.classList.remove('active');
            });
            event.currentTarget.classList.add('active');

            // Hide all forms
            document.querySelectorAll('.payment-form').forEach(form => {
                form.classList.remove('active');
            });

            // Show selected form
            const forms = {
                'card': 'cardForm',
                'paypal': 'paypalForm',
                'bank': 'bankForm',
                'payathotel': 'payathotelForm'
            };

            document.getElementById(forms[method]).classList.add('active');

            // Update submit button text
            const submitBtn = document.getElementById('submitPayment');
            if (method === 'card') {
                submitBtn.textContent = 'Complete Payment';
                submitBtn.style.display = 'block';
            } else if (method === 'bank') {
                submitBtn.textContent = 'Confirm Booking (Awaiting Payment)';
                submitBtn.style.display = 'block';
            } else {
                submitBtn.style.display = 'none';
            }
        }

        function toggleBillingAddress() {
            const checkbox = document.getElementById('sameAsGuest');
            const fields = document.getElementById('billingFields');
            fields.style.display = checkbox.checked ? 'none' : 'block';
        }

        function applyPromo() {
            const promoCode = document.getElementById('promoInput').value.trim().toUpperCase();
            
            if (!promoCode) {
                alert('Please enter a promo code');
                return;
            }

            // Example promo codes
            const promoCodes = {
                'WELCOME10': 10,
                'LUXURY20': 20,
                'SUMMER50': 50,
                'VIP100': 100
            };

            if (promoCodes[promoCode]) {
                const discount = promoCodes[promoCode];
                bookingData.discount = discount;
                bookingData.total = bookingData.subtotal + bookingData.taxes - discount;
                
                updateSummary();
                alert(`Promo code applied! You saved ${discount}`);
                document.getElementById('promoInput').value = '';
            } else {
                alert('Invalid promo code');
            }
        }

        function processPayment() {
            if (selectedMethod === 'card') {
                // Validate card details
                const cardNumber = document.getElementById('cardNumber').value.trim();
                const cardName = document.getElementById('cardName').value.trim();
                const expiryDate = document.getElementById('expiryDate').value.trim();
                const cvv = document.getElementById('cvv').value.trim();

                if (!cardNumber || !cardName || !expiryDate || !cvv) {
                    alert('Please fill in all card details');
                    return;
                }

                // Validate card number (basic check)
                const cardNumberClean = cardNumber.replace(/\s/g, '');
                if (cardNumberClean.length < 13 || cardNumberClean.length > 19) {
                    alert('Please enter a valid card number');
                    return;
                }

                // Validate expiry date
                const expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
                if (!expiryRegex.test(expiryDate)) {
                    alert('Please enter expiry date in MM/YY format');
                    return;
                }

                // Check if card is expired
                const [month, year] = expiryDate.split('/');
                const expiry = new Date(2000 + parseInt(year), parseInt(month) - 1);
                const now = new Date();
                if (expiry < now) {
                    alert('This card has expired');
                    return;
                }

                // Validate CVV
                if (cvv.length < 3 || cvv.length > 4) {
                    alert('Please enter a valid CVV');
                    return;
                }

                // Show processing
                const submitBtn = document.getElementById('submitPayment');
                submitBtn.textContent = 'Processing Payment...';
                submitBtn.disabled = true;

                // Simulate payment processing
                setTimeout(() => {
                    completeBooking();
                }, 2000);

            } else if (selectedMethod === 'bank') {
                // Bank transfer - just confirm booking
                completeBooking('pending');
            } else if (selectedMethod === 'payathotel') {
                // pay at hotel chosen in-page
                submitPayAtHotelToServer();
            }
        }

        function processPayPal() {
            const submitBtn = event.target;
            submitBtn.textContent = 'Redirecting to PayPal...';
            submitBtn.disabled = true;

            // Simulate PayPal redirect
            setTimeout(() => {
                completeBooking();
            }, 1500);
        }

        // Google Pay and Apple Pay integrations removed — not used in this deployment

        function completeBooking(status = 'confirmed') {
            // Generate confirmation number
            const confirmationNumber = 'CPL' + Date.now().toString().slice(-8);
            
            // Save booking data
            const booking = {
                confirmationNumber,
                status,
                paymentMethod: selectedMethod,
                ...bookingData,
                bookedAt: new Date().toISOString()
            };

            // Store in localStorage
            const bookings = JSON.parse(localStorage.getItem('bookings') || '[]');
            bookings.push(booking);
            localStorage.setItem('bookings', JSON.stringify(bookings));

            // Redirect to confirmation page
            const params = new URLSearchParams({
                confirmation: confirmationNumber,
                status: status
            });
            window.location.href = `confirmation.html?${params.toString()}`;
        }

        function formatCardInputs() {
            // Card number formatting
            const cardNumberInput = document.getElementById('cardNumber');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s/g, '');
                    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                    e.target.value = formattedValue;
                });
            }

            // Expiry date formatting
            const expiryInput = document.getElementById('expiryDate');
            if (expiryInput) {
                expiryInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.slice(0, 2) + '/' + value.slice(2, 4);
                    }
                    e.target.value = value;
                });
            }

            // CVV - numbers only
            const cvvInput = document.getElementById('cvv');
            if (cvvInput) {
                cvvInput.addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/\D/g, '');
                });
            }

            // Card name - letters only
            const cardNameInput = document.getElementById('cardName');
            if (cardNameInput) {
                cardNameInput.addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
                });
            }
        }

        // Reserve now and pay at hotel: ensure pendingBooking exists then navigate
        function goToPayAtHotel() {
            try {
                const raw = localStorage.getItem('pendingBooking');
                if (!raw) {
                    // Build a minimal pendingBooking from current bookingData
                    const pending = {
                        roomName: bookingData.room,
                        roomPrice: bookingData.pricePerNight || bookingData.subtotal || 0,
                        checkIn: bookingData.checkIn,
                        checkOut: bookingData.checkOut,
                        nights: bookingData.nights || 1,
                        total: bookingData.total || bookingData.subtotal || 0,
                        IDPhong: raw ? JSON.parse(raw).roomId : bookingData.roomId || 'P003', // Use from pending or bookingData
                    };
                    localStorage.setItem('pendingBooking', JSON.stringify(pending));
                }
            } catch (e) {
                console.warn('Unable to persist pendingBooking before pay-at-hotel', e);
            }
            // Call API to save booking
            submitPayAtHotelToServer();
        }

        // Submit pay at hotel to server API
        async function submitPayAtHotelToServer() {
            try {
                // Require login: if no userId or email in localStorage, redirect to login and save redirect
                const userId = localStorage.getItem('userId');
                const userEmail = localStorage.getItem('email');
                if (!userId || !userEmail) {
                    // Save current path to return after login
                    localStorage.setItem('redirect_after_login', window.location.pathname + window.location.search);
                    alert('Vui lòng đăng nhập để hoàn tất đặt phòng. Bạn sẽ được chuyển tới trang đăng nhập.');
                    window.location.href = '/login';
                    return;
                }

                // Build payload for API
                const payload = {
                    IDKhachHang: parseInt(userId) || 1,
                    IDPhong: bookingData.roomId ,
                    Email: userEmail || null,
                    NgayNhanPhong: bookingData.checkIn,
                    NgayTraPhong: bookingData.checkOut,
                    GiaPhong: bookingData.pricePerNight,
                    SoDem: bookingData.nights,
                    TongTien: bookingData.total
                };

                showLoading();

                const response = await fetch('/api/datphong', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    // Save to localStorage as backup
                    const booking = {
                        confirmationNumber: result.confirmation,
                        status: 'confirmed',
                        paymentMethod: 'payathotel',
                        ...bookingData,
                        bookedAt: new Date().toISOString()
                    };
                    const bookings = JSON.parse(localStorage.getItem('bookings') || '[]');
                    bookings.push(booking);
                    localStorage.setItem('bookings', JSON.stringify(bookings));

                    // Redirect to confirmation page
                    window.location.href = `confirmation?confirmation=${result.confirmation}`;
                } else {
                    throw new Error(result.message || 'Lỗi khi lưu đặt phòng');
                }
            } catch (error) {
                console.error('API call failed:', error);
                // Fallback: save locally and redirect
                const booking = {
                    confirmationNumber: 'OFFLINE-' + Date.now(),
                    status: 'offline',
                    paymentMethod: 'payathotel',
                    ...bookingData,
                    bookedAt: new Date().toISOString()
                };
                const bookings = JSON.parse(localStorage.getItem('bookings') || '[]');
                bookings.push(booking);
                localStorage.setItem('bookings', JSON.stringify(bookings));
                alert('Không thể lưu lên server, đặt phòng đã được lưu cục bộ. Bạn sẽ nhận được xác nhận khi hệ thống phục hồi.');
                window.location.href = `confirmation?confirmation=OFFLINE-${Date.now()}&offline=true`;
            } finally {
                hideLoading();
            }
        }

        // Show the inline confirmation and update booking steps UI
        function showConfirmation() {
            // mark step 3 as completed and step 4 active
            document.querySelectorAll('.booking-steps .step').forEach((s, idx) => {
                s.classList.remove('active', 'completed');
                const stepIndex = idx + 1;
                if (stepIndex < 4) s.classList.add('completed');
                if (stepIndex === 4) s.classList.add('active');
            });
            // reveal inline confirmation
            const conf = document.getElementById('paymentConfirmation');
            if (conf) conf.style.display = 'block';
            // set confirmation number if available from localStorage bookings last item
            try {
                const bookings = JSON.parse(localStorage.getItem('bookings') || '[]');
                const last = bookings[bookings.length - 1];
                if (last && last.confirmationNumber) {
                    document.getElementById('confNumberInline').textContent = last.confirmationNumber;
                }
            } catch (e) { /* ignore */ }
            // hide the main submit to prevent re-submission
            const submitBtn = document.getElementById('submitPayment');
            if (submitBtn) submitBtn.style.display = 'none';
            // scroll to confirmation
            window.scrollTo({ top: document.getElementById('paymentConfirmation').offsetTop - 60, behavior: 'smooth' });
        }

        // Auto-detect card type
        document.getElementById('cardNumber')?.addEventListener('input', function(e) {
            const value = e.target.value.replace(/\s/g, '');
            const cardBrands = document.querySelectorAll('.card-brand');
            
            // Reset all brands
            cardBrands.forEach(brand => {
                brand.style.opacity = '0.3';
                brand.style.borderColor = '#e0e0e0';
            });

            // Detect card type
            if (value.startsWith('4')) {
                // Visa
                cardBrands[0].style.opacity = '1';
                cardBrands[0].style.borderColor = '#aa8453';
            } else if (value.startsWith('5') || value.startsWith('2')) {
                // Mastercard
                cardBrands[1].style.opacity = '1';
                cardBrands[1].style.borderColor = '#aa8453';
            } else if (value.startsWith('3')) {
                // Amex
                cardBrands[2].style.opacity = '1';
                cardBrands[2].style.borderColor = '#aa8453';
            } else if (value.startsWith('6')) {
                // Discover
                cardBrands[3].style.opacity = '1';
                cardBrands[3].style.borderColor = '#aa8453';
            }
        });

        // Prevent form submission on Enter key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
                e.preventDefault();
            }
        });

        // Add loading animation
        function showLoading() {
            const overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.7);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
            `;
            
            const spinner = document.createElement('div');
            spinner.style.cssText = `
                border: 4px solid #f3f3f3;
                border-top: 4px solid #aa8453;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 1s linear infinite;
            `;
            
            overlay.appendChild(spinner);
            document.body.appendChild(overlay);
        }

        function hideLoading() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) {
                overlay.remove();
            }
        }

        // Add CSS animation for spinner
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>