<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng ký tài khoản - Khách sạn ABC</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .register-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .register-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .alert {
            margin-bottom: 1rem;
            display: none;
        }
        .loading {
            position: relative;
            opacity: 0.8;
            pointer-events: none;
        }
        .loading::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.8) url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAiIGhlaWdodD0iNTAiIHZpZXdCb3g9IjAgMCA1MCA1MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxjaXJjbGUgY3g9IjI1IiBjeT0iMjUiIHI9IjIwIiBmaWxsPSJub25lIiBzdHJva2U9IiMwMDdiZmYiIHN0cm9rZS13aWR0aD0iNSI+CiAgICAgICAgPGFuaW1hdGVUcmFuc2Zvcm0gYXR0cmlidXRlTmFtZT0idHJhbnNmb3JtIiB0eXBlPSJyb3RhdGUiIGR1cj0iMXMiIGZyb209IjAgMjUgMjUiIHRvPSIzNjAgMjUgMjUiIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIi8+CiAgICA8L2NpcmNsZT4KPC9zdmc+') center no-repeat;
        }
        .step-indicator {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: #6c757d;
        }
        .step-indicator .email-highlight {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
  <body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-hotel me-2"></i>
                Khách sạn
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="register-container">
        <div class="register-card">
            <!-- Alert Messages -->
            <div class="alert alert-danger" role="alert" id="error-alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span id="error-message"></span>
            </div>
            
            <div class="alert alert-success" role="alert" id="success-alert">
                <i class="fas fa-check-circle me-2"></i>
                <span id="success-message"></span>
            </div>

            <!-- Registration Form -->
            <form id="registration-form" class="needs-validation" novalidate>
                <!-- Step 1: Registration -->
                <div id="register-section">
                    <h2 class="text-center mb-4">Đăng ký tài khoản</h2>
                    
                    <div class="mb-3">
                        <label for="hoten" class="form-label">Họ và tên *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" id="hoten" placeholder="Nhập họ và tên" required>
                        </div>
                        <div class="invalid-feedback">Vui lòng nhập họ và tên</div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control" id="email" placeholder="Nhập email" required>
                        </div>
                        <div class="invalid-feedback">Vui lòng nhập email hợp lệ</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu *</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" placeholder="Mật khẩu (tối thiểu 6 ký tự)" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">Mật khẩu phải có ít nhất 6 ký tự</div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="tel" class="form-control" id="phone" placeholder="Số điện thoại (không bắt buộc)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="dob" class="form-label">Ngày sinh</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-calendar"></i>
                            </span>
                            <input type="date" class="form-control" id="dob">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="button" id="btn-send-otp">
                            <i class="fas fa-paper-plane me-2"></i>Gửi mã xác nhận
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <p class="mb-0">
                            Đã có tài khoản? 
                            <a href="{{ url('/login') }}" class="text-decoration-none">
                                <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập ngay
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Step 2: OTP Verification -->
                <div id="otp-section" style="display: none;">
                    <h2 class="text-center mb-4">Xác nhận tài khoản</h2>
                    
                    <div class="step-indicator">
                        <i class="fas fa-envelope me-2"></i>
                        Đã gửi mã xác nhận đến: <span class="email-highlight" id="email-display"></span>
                    </div>

                    <div class="mb-3">
                        <label for="otp" class="form-label">Mã xác nhận</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-key"></i>
                            </span>
                            <input type="text" class="form-control" id="otp" placeholder="Nhập mã OTP 6 chữ số" maxlength="6" inputmode="numeric" required>
                        </div>
                        <div class="form-text">Vui lòng kiểm tra email và nhập mã 6 chữ số</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-success" type="submit" id="btn-create-account">
                            <i class="fas fa-user-plus me-2"></i>Tạo tài khoản
                        </button>
                        <button class="btn btn-outline-secondary" type="button" id="btn-back">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 Khách sạn. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const API_URL = "{{ url('/api') }}";
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.addEventListener("DOMContentLoaded", function() {
            const registrationForm = document.getElementById("registration-form");
            const registerSection = document.getElementById("register-section");
            const otpSection = document.getElementById("otp-section");
            const btnSendOtp = document.getElementById("btn-send-otp");
            const btnCreateAccount = document.getElementById("btn-create-account");
            const btnBack = document.getElementById("btn-back");
            const hotenInput = document.getElementById("hoten");
            const emailInput = document.getElementById("email");
            const passwordInput = document.getElementById("password");
            const phoneInput = document.getElementById("phone");
            const dobInput = document.getElementById("dob");
            const otpInput = document.getElementById("otp");
            const emailDisplay = document.getElementById("email-display");
            const errorAlert = document.getElementById('error-alert');
            const successAlert = document.getElementById('success-alert');
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');

            // Toggle password visibility
            document.getElementById('toggle-password').addEventListener('click', function() {
                const passwordInput = document.getElementById('password');
                const icon = this.querySelector('i');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });

            function showError(message) {
                errorMessage.textContent = message;
                errorAlert.style.display = 'block';
                successAlert.style.display = 'none';
            }

            function showSuccess(message) {
                successMessage.textContent = message;
                successAlert.style.display = 'block';
                errorAlert.style.display = 'none';
            }

            function clearAlerts() {
                errorAlert.style.display = 'none';
                successAlert.style.display = 'none';
            }

            function hideAlerts() {
                setTimeout(() => {
                    clearAlerts();
                }, 5000);
            }

            // Back button functionality
            btnBack.addEventListener('click', function() {
                registerSection.style.display = 'block';
                otpSection.style.display = 'none';
                clearAlerts();
            });
            
            btnSendOtp.addEventListener('click', async function(event) {
                event.preventDefault();
                event.stopPropagation();
                clearAlerts();
                
                const hoten = hotenInput.value.trim();
                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();
                const phone = phoneInput.value.trim();
                const dob = dobInput.value.trim();

                // Basic validation
                if (!hoten || !email || !password) {
                    showError("Vui lòng điền đầy đủ họ tên, email và mật khẩu.");
                    return;
                }

                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    showError("Email không hợp lệ.");
                    return;
                }

                // Password validation
                if (password.length < 6) {
                    showError("Mật khẩu phải có ít nhất 6 ký tự.");
                    return;
                }

                // Phone validation
                if (phone && !/^[0-9]{10,11}$/.test(phone)) {
                    showError("Số điện thoại không hợp lệ (10-11 chữ số).");
                    return;
                }

                // Show loading state
                btnSendOtp.disabled = true;
                const originalText = btnSendOtp.innerHTML;
                btnSendOtp.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang gửi...';

                try {
                    const response = await fetch(`${API_URL}/register`, { 
                        method: "POST", 
                        headers: { 
                            "Content-Type": "application/json", 
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": CSRF_TOKEN
                        }, 
                        body: JSON.stringify({
                            HoTen: hoten,
                            Email: email,
                            MatKhau: password,
                            SoDienThoai: phone,
                            NgaySinh: dob
                        })
                    });
                    
                    const result = await response.json();
                    if (!response.ok) throw new Error(result.message || `Lỗi ${response.status}`);
                    
                    showSuccess("Mã OTP đã được gửi. Vui lòng kiểm tra email!");
                    emailDisplay.textContent = email;
                    
                    setTimeout(() => {
                        registerSection.style.display = "none";
                        otpSection.style.display = "block";
                        clearAlerts();
                        otpInput.focus();
                    }, 1500);
                } catch (error) {
                    console.error("Error sending OTP:", error);
                    showError(error.message || "Đã có lỗi xảy ra. Vui lòng thử lại.");
                } finally {
                    btnSendOtp.disabled = false;
                    btnSendOtp.innerHTML = originalText;
                }
            });

            // OTP verification when create account button is clicked
            btnCreateAccount.addEventListener('click', async function(event) {
                event.preventDefault();
                clearAlerts();
                
                const email = emailInput.value.trim();
                const otp = otpInput.value.trim();

                if (otp.length !== 6) {
                    showError("Mã OTP phải có đúng 6 chữ số.");
                    return;
                }
                
                // Show loading state
                btnCreateAccount.disabled = true;
                const originalText = btnCreateAccount.innerHTML;
                btnCreateAccount.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xác thực...';

                try {
                    const response = await fetch(`${API_URL}/verify-otp`, { 
                        method: "POST", 
                        headers: { 
                            "Content-Type": "application/json", 
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": CSRF_TOKEN
                        }, 
                        body: JSON.stringify({ Email: email, Otp: otp })
                    });
                    
                    const result = await response.json();
                    if (!response.ok) throw new Error(result.message || `Lỗi ${response.status}`);
                    
                    showSuccess(result.message || "Đăng ký thành công!");
                    
                    setTimeout(() => {
                        window.location.href = "{{ url('/login') }}";
                    }, 2000);
                } catch (error) {
                    console.error("OTP verification error:", error);
                    showError(error.message || "Lỗi xác thực. Vui lòng thử lại.");
                    btnCreateAccount.disabled = false;
                    btnCreateAccount.innerHTML = originalText;
                }
            });
        });
    </script>
</body>
</html>
