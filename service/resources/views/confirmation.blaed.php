<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Booking Confirmation - The Cappa Luxury Hotel</title>
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
        
        .confirmation-page {
            min-height: 100vh;
            padding: 100px 0 50px;
        }
        
        .confirmation-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .booking-steps {
            display: flex;
            justify-content: center;
            margin: 20px auto 40px;
            position: relative;
            max-width: 900px;
        }
        
        .booking-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 25%;
            right: 25%;
            height: 2px;
            background: #4CAF50;
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
        
        .step.completed .step-label {
            color: #4CAF50;
        }
        
        .success-header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 0.6s;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .success-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 25px;
            background: #4CAF50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            color: white;
            animation: scaleIn 0.5s ease-out;
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }
        
        .success-header h1 {
            font-family: 'Gilda Display', serif;
            font-size: 42px;
            color: #aa8453;
            margin-bottom: 15px;
        }
        
        .success-header p {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .confirmation-number {
            display: inline-block;
            background: #fff;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 24px;
            font-weight: bold;
            color: #aa8453;
            border: 2px dashed #aa8453;
            margin-top: 15px;
        }
        
        .confirmation-content {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            animation: fadeInUp 0.6s;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .section-title {
            font-family: 'Gilda Display', serif;
            font-size: 24px;
            color: #333;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 24px;
            background: #aa8453;
        }
        
        .booking-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .detail-card {
            background: #f8f5f0;
            padding: 20px;
            border-radius: 8px;
        }
        
        .detail-card h3 {
            font-family: 'Barlow', sans-serif;
            font-size: 14px;
            color: #999;
            margin: 0 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .detail-card p {
            font-size: 16px;
            color: #333;
            margin: 5px 0;
            font-weight: 500;
        }
        
        .room-summary {
            display: flex;
            gap: 20px;
            background: #f8f5f0;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .room-summary img {
            width: 150px;
            height: 150px;
            border-radius: 8px;
            object-fit: cover;
        }
        
        .room-summary-info {
            flex: 1;
        }
        
        .room-summary-info h3 {
            font-family: 'Gilda Display', serif;
            font-size: 24px;
            color: #333;
            margin: 0 0 15px 0;
        }
        
        .room-features {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .feature-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            color: #666;
        }
        
        .price-summary {
            background: white;
            border: 2px solid #aa8453;
            border-radius: 8px;
            padding: 20px;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 15px;
        }
        
        .price-row span:first-child {
            color: #666;
        }
        
        .price-row span:last-child {
            color: #333;
            font-weight: 500;
        }
        
        .price-total {
            display: flex;
            justify-content: space-between;
            padding-top: 15px;
            margin-top: 15px;
            border-top: 2px solid #aa8453;
            font-size: 22px;
            font-weight: bold;
            color: #aa8453;
        }
        
        .info-boxes {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-box {
            background: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 4px;
        }
        
        .info-box.success {
            background: #e8f5e9;
            border-color: #4CAF50;
        }
        
        .info-box.info {
            background: #e3f2fd;
            border-color: #2196F3;
        }
        
        .info-box h4 {
            margin: 0 0 10px 0;
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }
        
        .info-box p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            flex: 1;
            padding: 16px 30px;
            border: none;
            border-radius: 8px;
            font-family: 'Barlow', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
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
        
        .btn-secondary {
            background: white;
            color: #aa8453;
            border: 2px solid #aa8453;
        }
        
        .btn-secondary:hover {
            background: #aa8453;
            color: white;
        }
        
        .btn-outline {
            background: transparent;
            color: #666;
            border: 2px solid #ddd;
        }
        
        .btn-outline:hover {
            background: #f8f5f0;
            border-color: #aa8453;
            color: #aa8453;
        }
        
        .next-steps {
            background: linear-gradient(135deg, #aa8453 0%, #8a6a43 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        
        .next-steps h3 {
            font-family: 'Gilda Display', serif;
            font-size: 24px;
            margin: 0 0 20px 0;
        }
        
        .next-steps-list {
            display: grid;
            gap: 15px;
        }
        
        .next-step-item {
            display: flex;
            gap: 15px;
            background: rgba(255,255,255,0.1);
            padding: 15px;
            border-radius: 8px;
        }
        
        .next-step-number {
            width: 35px;
            height: 35px;
            background: white;
            color: #aa8453;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }
        
        .next-step-content h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
        }
        
        .next-step-content p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }
        
        .contact-support {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        }
        
        .contact-support h3 {
            font-family: 'Gilda Display', serif;
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }
        
        .contact-support p {
            color: #666;
            margin-bottom: 20px;
        }
        
        .contact-methods {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        
        .contact-method {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: #f8f5f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .contact-method a {
            color: #aa8453;
            text-decoration: none;
            font-weight: 600;
        }
        
        .contact-method a:hover {
            text-decoration: underline;
        }
        
        @media print {
            .action-buttons,
            .contact-support,
            header {
                display: none !important;
            }
            
            body {
                background: white;
            }
            
            .confirmation-content {
                box-shadow: none;
            }
        }
        
        @media (max-width: 768px) {
            .confirmation-container {
                padding: 0 15px;
            }
            
            .confirmation-content {
                padding: 25px 20px;
            }
            
            .success-header h1 {
                font-size: 32px;
            }
            
            .confirmation-number {
                font-size: 18px;
                padding: 10px 20px;
            }
            
            .booking-details-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .room-summary {
                flex-direction: column;
            }
            
            .room-summary img {
                width: 100%;
                height: 200px;
            }
            
            .info-boxes {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
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
                    <a href="index.html" style="font-family: 'Barlow', sans-serif; color: #aa8453; font-weight: 500;">← Back to Home</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Confirmation Page -->
    <div class="confirmation-page">
        <div class="confirmation-container">
            <!-- Progress Steps -->
            <div class="booking-steps">
                <div class="step completed" data-step="1">
                    <div class="step-number">✓</div>
                    <div class="step-label">Booking Details</div>
                </div>
                <div class="step completed" data-step="2">
                    <div class="step-number">✓</div>
                    <div class="step-label">Guest Information</div>
                </div>
                <div class="step completed" data-step="3">
                    <div class="step-number">✓</div>
                    <div class="step-label">Payment</div>
                </div>
                <div class="step completed" data-step="4">
                    <div class="step-number">✓</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>

            <!-- Success Header -->
            <div class="success-header">
                <div class="success-icon">✓</div>
                <h1>Booking Confirmed!</h1>
                <p>Thank you for choosing The Cappa Luxury Hotel</p>
                <p>Your reservation has been successfully confirmed</p>
                <div class="confirmation-number" id="confirmationNumber">CPL12345678</div>
            </div>

            <!-- Booking Details -->
            <div class="confirmation-content">
                <h2 class="section-title">Booking Details</h2>
                
                <div class="booking-details-grid">
                    <div class="detail-card">
                        <h3>Check-In</h3>
                        <p id="checkInDate">Monday, Dec 20, 2024</p>
                        <p style="font-size: 14px; color: #999; font-weight: normal;">After 3:00 PM</p>
                    </div>
                    
                    <div class="detail-card">
                        <h3>Check-Out</h3>
                        <p id="checkOutDate">Wednesday, Dec 22, 2024</p>
                        <p style="font-size: 14px; color: #999; font-weight: normal;">Before 11:00 AM</p>
                    </div>
                    
                    <div class="detail-card">
                        <h3>Guest Name</h3>
                        <p id="guestName">John Doe</p>
                    </div>
                    
                    <div class="detail-card">
                        <h3>Guests</h3>
                        <p id="guestCount">2 Adults, 0 Children</p>
                    </div>
                </div>

                <div class="room-summary">
                    <img id="roomImage" src="HomePage/img/rooms/1.jpg" alt="Room">
                    <div class="room-summary-info">
                        <h3 id="roomName">Deluxe Room</h3>
                        <div class="room-features">
                            <div class="feature-badge">🛏️ King Size Bed</div>
                            <div class="feature-badge">🛁 Private Bathroom</div>
                            <div class="feature-badge">📶 Free WiFi</div>
                            <div class="feature-badge">🍳 Breakfast Included</div>
                        </div>
                        <div class="price-summary">
                            <div class="price-row">
                                <span>Room Rate</span>
                                <span id="roomRate">$250 × 2 nights</span>
                            </div>
                            <div class="price-row">
                                <span>Subtotal</span>
                                <span id="subtotal">$500</span>
                            </div>
                            <div class="price-row">
                                <span>Taxes & Fees</span>
                                <span id="taxes">$75</span>
                            </div>
                            <div class="price-total">
                                <span>Total Paid</span>
                                <span id="totalPaid">$575</span>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="section-title">Guest Information</h2>
                
                <div class="booking-details-grid">
                    <div class="detail-card">
                        <h3>Email Address</h3>
                        <p id="guestEmail">john.doe@example.com</p>
                    </div>
                    
                    <div class="detail-card">
                        <h3>Phone Number</h3>
                        <p id="guestPhone">+1 (555) 123-4567</p>
                    </div>
                    
                    <div class="detail-card">
                        <h3>Payment Method</h3>
                        <p id="paymentMethod">Credit Card (****1234)</p>
                    </div>
                    
                    <div class="detail-card">
                        <h3>Booking Status</h3>
                        <p id="bookingStatus" style="color: #4CAF50;">Confirmed</p>
                    </div>
                </div>
            </div>

            <!-- Important Information -->
            <div class="info-boxes">
                <div class="info-box success">
                    <h4>✓ Confirmation Email Sent</h4>
                    <p>A confirmation email has been sent to your email address with all the booking details and important information.</p>
                </div>
                
                <div class="info-box info">
                    <h4>ℹ️ Cancellation Policy</h4>
                    <p>Free cancellation up to 24 hours before check-in. Cancel before Dec 19, 2024 to receive a full refund.</p>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="next-steps">
                <h3>What's Next?</h3>
                <div class="next-steps-list">
                    <div class="next-step-item">
                        <div class="next-step-number">1</div>
                        <div class="next-step-content">
                            <h4>Check Your Email</h4>
                            <p>You'll receive a confirmation email with your booking details and a copy of this confirmation.</p>
                        </div>
                    </div>
                    
                    <div class="next-step-item">
                        <div class="next-step-number">2</div>
                        <div class="next-step-content">
                            <h4>Prepare for Your Stay</h4>
                            <p>Review our hotel policies and amenities. Feel free to contact us if you have any special requests.</p>
                        </div>
                    </div>
                    
                    <div class="next-step-item">
                        <div class="next-step-number">3</div>
                        <div class="next-step-content">
                            <h4>Arrive and Enjoy</h4>
                            <p>Check-in starts at 3:00 PM. Present your confirmation number at the front desk.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="window.print()">🖨️ Print Confirmation</button>
                <button class="btn btn-secondary" onclick="downloadPDF()">📄 Download PDF</button>
                <a href="index.html" class="btn btn-outline">🏠 Return to Home</a>
            </div>

            <!-- Contact Support -->
            <div class="contact-support">
                <h3>Need Help?</h3>
                <p>Our customer service team is here to help you 24/7</p>
                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="contact-icon">📞</div>
                        <a href="tel:8551004444">855 100 4444</a>
                    </div>
                    <div class="contact-method">
                        <div class="contact-icon">✉️</div>
                        <a href="mailto:reservations@capphotel.com">reservations@capphotel.com</a>
                    </div>
                    <div class="contact-method">
                        <div class="contact-icon">💬</div>
                        <a href="#" onclick="openLiveChat()">Live Chat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load booking data from localStorage
        document.addEventListener('DOMContentLoaded', function() {
            loadConfirmationData();
        });

        function loadConfirmationData() {
            // Get confirmation number from URL
            const params = new URLSearchParams(window.location.search);
            const confirmationNum = params.get('confirmation');
            const status = params.get('status') || 'confirmed';

            if (confirmationNum) {
                document.getElementById('confirmationNumber').textContent = confirmationNum;
            }

            // Update status
            const statusElement = document.getElementById('bookingStatus');
            if (status === 'pending') {
                statusElement.textContent = 'Pending Payment';
                statusElement.style.color = '#ffc107';
            } else {
                statusElement.textContent = 'Confirmed';
                statusElement.style.color = '#4CAF50';
            }

            // Load booking data from localStorage
            try {
                const bookings = JSON.parse(localStorage.getItem('bookings') || '[]');
                const latestBooking = bookings[bookings.length - 1];

                if (latestBooking) {
                    // Update all fields with booking data
                    if (latestBooking.checkIn) {
                        document.getElementById('checkInDate').textContent = formatDate(latestBooking.checkIn);
                    }
                    if (latestBooking.checkOut) {
                        document.getElementById('checkOutDate').textContent = formatDate(latestBooking.checkOut);
                    }
                    if (latestBooking.room) {
                        document.getElementById('roomName').textContent = latestBooking.room;
                    }
                    if (latestBooking.roomImage) {
                        document.getElementById('roomImage').src = latestBooking.roomImage;
                    }
                    if (latestBooking.pricePerNight && latestBooking.nights) {
                        document.getElementById('roomRate').textContent = `$${latestBooking.pricePerNight} × ${latestBooking.nights} nights`;
                    }
                    if (latestBooking.subtotal) {
                        document.getElementById('subtotal').textContent = `$${latestBooking.subtotal}`;
                    }
                    if (latestBooking.taxes) {
                        document.getElementById('taxes').textContent = `$${latestBooking.taxes}`;
                    }
                    if (latestBooking.total) {
                        document.getElementById('totalPaid').textContent = `$${latestBooking.total}`;
                    }

                    // Payment method
                    if (latestBooking.paymentMethod) {
                        const methodNames = {
                            'card': 'Credit Card',
                            'paypal': 'PayPal',
                            'bank': 'Bank Transfer',
                            'googlepay': 'Google Pay',
                            'applepay': 'Apple Pay'
                        };
                        document.getElementById('paymentMethod').textContent = methodNames[latestBooking.paymentMethod] || 'Credit Card';
                    }
                }

                // Load guest info from pendingBooking if available
                const pendingBooking = JSON.parse(localStorage.getItem('pendingBooking') || '{}');
                if (pendingBooking.guestInfo) {
                    const guest = pendingBooking.guestInfo;
                    if (guest.firstName && guest.lastName) {
                        document.getElementById('guestName').textContent = `${guest.firstName} ${guest.lastName}`;
                    }
                    if (guest.email) {
                        document.getElementById('guestEmail').textContent = guest.email;
                    }
                    if (guest.phone) {
                        document.getElementById('guestPhone').textContent = guest.phone;
                    }
                    if (guest.adults !== undefined && guest.children !== undefined) {
                        document.getElementById('guestCount').textContent = `${guest.adults} Adult(s), ${guest.children} Child(ren)`;
                    }
                }
            } catch (error) {
                console.error('Error loading booking data:', error);
            }
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        function downloadPDF() {
            // In a real implementation, this would generate and download a PDF
            alert('PDF download functionality would be implemented here.\n\nFor now, please use the Print button to save as PDF using your browser\'s print dialog.');
            window.print();
        }

        function openLiveChat() {
            // In a real implementation, this would open a live chat widget
            alert('Live chat would open here. For now, please call us at 855 100 4444 or email reservations@capphotel.com');
        }

        // Auto-send confirmation email (simulation)
        window.addEventListener('load', function() {
            // Simulate sending confirmation email
            console.log('Confirmation email sent to guest');
            
            // Show a subtle notification
            setTimeout(() => {
                const notification = document.createElement('div');
                notification.style.cssText = `
                    position: fixed;
                    bottom: 20px;
                    right: 20px;
                    background: #4CAF50;
                    color: white;
                    padding: 15px 25px;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    z-index: 10000;
                    animation: slideInRight 0.5s;
                `;
                notification.textContent = '✓ Confirmation email sent successfully!';
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.style.animation = 'slideOutRight 0.5s';
                    setTimeout(() => notification.remove(), 500);
                }, 3000);
            }, 1000);
        });

        // Add animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Add confetti effect on page load (optional celebratory animation)
        function createConfetti() {
            const colors = ['#aa8453', '#4CAF50', '#ffc107', '#2196F3'];
            const confettiCount = 50;
            
            for (let i = 0; i < confettiCount; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.style.cssText = `
                        position: fixed;
                        width: 10px;
                        height: 10px;
                        background: ${colors[Math.floor(Math.random() * colors.length)]};
                        top: -10px;
                        left: ${Math.random() * 100}%;
                        opacity: ${Math.random() * 0.7 + 0.3};
                        transform: rotate(${Math.random() * 360}deg);
                        z-index: 9999;
                        pointer-events: none;
                        animation: confettiFall ${Math.random() * 3 + 2}s linear forwards;
                    `;
                    document.body.appendChild(confetti);
                    
                    setTimeout(() => confetti.remove(), 5000);
                }, i * 30);
            }
        }

        // Add confetti animation CSS
        const confettiStyle = document.createElement('style');
        confettiStyle.textContent = `
            @keyframes confettiFall {
                to {
                    transform: translateY(100vh) rotate(720deg);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(confettiStyle);

        // Trigger confetti on page load
        window.addEventListener('load', function() {
            setTimeout(createConfetti, 500);
        });

        // Track page for analytics
        console.log('Booking confirmation page loaded');
        
        // Share booking functionality
        function shareBooking() {
            if (navigator.share) {
                const confirmationNum = document.getElementById('confirmationNumber').textContent;
                const roomName = document.getElementById('roomName').textContent;
                const checkIn = document.getElementById('checkInDate').textContent;
                
                navigator.share({
                    title: 'My Hotel Booking',
                    text: `I just booked ${roomName} at The Cappa Luxury Hotel! Check-in: ${checkIn}. Confirmation: ${confirmationNum}`,
                    url: window.location.href
                }).then(() => {
                    console.log('Booking shared successfully');
                }).catch((error) => {
                    console.log('Error sharing:', error);
                });
            } else {
                alert('Sharing is not supported on this browser');
            }
        }

        // Add calendar event
        function addToCalendar() {
            try {
                const bookings = JSON.parse(localStorage.getItem('bookings') || '[]');
                const latestBooking = bookings[bookings.length - 1];
                
                if (!latestBooking) {
                    alert('Booking information not found');
                    return;
                }

                const checkIn = new Date(latestBooking.checkIn);
                const checkOut = new Date(latestBooking.checkOut);
                
                // Format dates for calendar (YYYYMMDD)
                const formatCalendarDate = (date) => {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}${month}${day}`;
                };

                const title = `Hotel Stay - ${latestBooking.room}`;
                const location = 'The Cappa Luxury Hotel, 1616 Broadway NY, New York 10001';
                const description = `Confirmation: ${latestBooking.confirmationNumber}\\nRoom: ${latestBooking.room}\\nTotal: ${latestBooking.total}`;
                
                // Google Calendar URL
                const googleCalendarUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(title)}&dates=${formatCalendarDate(checkIn)}/${formatCalendarDate(checkOut)}&details=${encodeURIComponent(description)}&location=${encodeURIComponent(location)}`;
                
                window.open(googleCalendarUrl, '_blank');
            } catch (error) {
                console.error('Error creating calendar event:', error);
                alert('Unable to create calendar event. Please add it manually.');
            }
        }

        // Add modify booking button functionality
        function modifyBooking() {
            const confirmationNum = document.getElementById('confirmationNumber').textContent;
            if (confirm(`Do you want to modify booking ${confirmationNum}?\n\nNote: Modifications may be subject to availability and additional charges.`)) {
                // In a real implementation, this would redirect to a modification page
                alert('Booking modification page would open here.\n\nFor now, please contact us at 855 100 4444 to modify your booking.');
            }
        }

        // Add cancel booking button functionality
        function cancelBooking() {
            const confirmationNum = document.getElementById('confirmationNumber').textContent;
            const checkInDate = document.getElementById('checkInDate').textContent;
            
            if (confirm(`Are you sure you want to cancel booking ${confirmationNum}?\n\nCheck-in: ${checkInDate}\n\nFree cancellation is available up to 24 hours before check-in.`)) {
                // In a real implementation, this would process the cancellation
                if (confirm('This action cannot be undone. Proceed with cancellation?')) {
                    alert('Cancellation request received.\n\nYou will receive a confirmation email shortly with refund details.');
                    // Update status
                    document.getElementById('bookingStatus').textContent = 'Cancelled';
                    document.getElementById('bookingStatus').style.color = '#f44336';
                }
            }
        }

        // Print-specific styling
        window.addEventListener('beforeprint', function() {
            document.title = `Booking Confirmation - ${document.getElementById('confirmationNumber').textContent}`;
        });

        // Save booking reference for future use
        function saveBookingReference() {
            const confirmationNum = document.getElementById('confirmationNumber').textContent;
            const checkIn = document.getElementById('checkInDate').textContent;
            const room = document.getElementById('roomName').textContent;
            
            const bookingRef = {
                confirmation: confirmationNum,
                checkIn: checkIn,
                room: room,
                savedAt: new Date().toISOString()
            };
            
            const savedBookings = JSON.parse(localStorage.getItem('savedBookingReferences') || '[]');
            savedBookings.push(bookingRef);
            localStorage.setItem('savedBookingReferences', JSON.stringify(savedBookings));
            
            alert('Booking reference saved for quick access!');
        }

        // Check if user is logged in and associate booking
        function associateBookingWithAccount() {
            const email = localStorage.getItem('email');
            const role = localStorage.getItem('role');
            
            if (email && role) {
                console.log(`Booking associated with account: ${email}`);
                // In a real implementation, this would send the booking to the server
            }
        }

        // Initialize
        associateBookingWithAccount();

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + P for print
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
            // Ctrl/Cmd + S for save/download
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                downloadPDF();
            }
        });

        // Scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.info-box, .next-step-item, .detail-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s, transform 0.5s';
            observer.observe(el);
        });

        // Add social sharing buttons (optional)
        function createSocialShareButtons() {
            const shareContainer = document.createElement('div');
            shareContainer.style.cssText = `
                text-align: center;
                margin-top: 20px;
                padding: 20px;
            `;
            shareContainer.innerHTML = `
                <p style="color: #666; margin-bottom: 15px;">Share your excitement!</p>
                <div style="display: flex; justify-content: center; gap: 15px;">
                    <button onclick="shareToFacebook()" style="padding: 10px 20px; background: #1877f2; color: white; border: none; border-radius: 6px; cursor: pointer;">
                        📘 Facebook
                    </button>
                    <button onclick="shareToTwitter()" style="padding: 10px 20px; background: #1da1f2; color: white; border: none; border-radius: 6px; cursor: pointer;">
                        🐦 Twitter
                    </button>
                    <button onclick="addToCalendar()" style="padding: 10px 20px; background: #34a853; color: white; border: none; border-radius: 6px; cursor: pointer;">
                        📅 Add to Calendar
                    </button>
                </div>
            `;
            
            const actionButtons = document.querySelector('.action-buttons');
            if (actionButtons) {
                actionButtons.parentNode.insertBefore(shareContainer, actionButtons.nextSibling);
            }
        }

        function shareToFacebook() {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
        }

        function shareToTwitter() {
            const text = encodeURIComponent('Just booked my stay at The Cappa Luxury Hotel! 🏨✨');
            const url = encodeURIComponent(window.location.href);
            window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank', 'width=600,height=400');
        }

        // Create social share buttons after page load
        window.addEventListener('load', function() {
            setTimeout(createSocialShareButtons, 1500);
        });

        // Email confirmation preview
        function previewEmailConfirmation() {
            const emailWindow = window.open('', '_blank', 'width=600,height=800');
            emailWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Email Confirmation Preview</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
                        .email-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
                        h1 { color: #aa8453; }
                        .highlight { background: #f8f5f0; padding: 15px; border-radius: 6px; margin: 15px 0; }
                    </style>
                </head>
                <body>
                    <div class="email-container">
                        <h1>Booking Confirmation</h1>
                        <p>Dear ${document.getElementById('guestName').textContent},</p>
                        <p>Thank you for booking with The Cappa Luxury Hotel!</p>
                        <div class="highlight">
                            <strong>Confirmation Number:</strong> ${document.getElementById('confirmationNumber').textContent}<br>
                            <strong>Room:</strong> ${document.getElementById('roomName').textContent}<br>
                            <strong>Check-in:</strong> ${document.getElementById('checkInDate').textContent}<br>
                            <strong>Check-out:</strong> ${document.getElementById('checkOutDate').textContent}<br>
                            <strong>Total:</strong> ${document.getElementById('totalPaid').textContent}
                        </div>
                        <p>We look forward to welcoming you!</p>
                        <p>Best regards,<br>The Cappa Luxury Hotel Team</p>
                    </div>
                </body>
                </html>
            `);
        }
    </script>
</body>
</html>