<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng ký tài khoản - Khách sạn ABC</title>
    
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
            max-width: 500px;
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
        #otp-section {
            display: none;
        }
        .otp-info {
            background: #e9ecef;
            border-left: 4px solid #007bff;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 0.25rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-hotel me-2"></i>
                Khách sạn ABC
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="register-container">
        <div class="register-card">
            <form id="registration-form" class="needs-validation" novalidate>
                <!-- Register Section -->
                <div id="register-section">
                    <h2 class="text-center mb-4">Đăng ký tài khoản</h2>
                    
                    <!-- Alert Messages -->
                    <div class="alert alert-danger" role="alert" id="error-alert" style="display: none">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <span id="error-message"></span>
                    </div>
                    
                    <div class="alert alert-success" role="alert" id="success-alert" style="display: none">
                        <i class="fas fa-check-circle me-2"></i>
                        <span id="success-message"></span>
                    </div>

                    <!-- Form Fields -->
                    <div class="mb-3">
                        <label for="hoten" class="form-label">Họ và tên</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" id="hoten" placeholder="Nhập họ và tên" required>
                            <div class="invalid-feedback">Vui lòng nhập họ tên</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control" id="email" placeholder="Nhập email" required>
                            <div class="invalid-feedback">Vui lòng nhập email hợp lệ</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" 
                                   placeholder="Tối thiểu 6 ký tự" required 
                                   pattern=".{6,}">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <div class="invalid-feedback">Mật khẩu phải có ít nhất 6 ký tự</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="tel" class="form-control" id="phone" 
                                   placeholder="Không bắt buộc" 
                                   pattern="[0-9]{10}"
                                   title="Số điện thoại gồm 10 chữ số">
                            <div class="invalid-feedback">Số điện thoại không hợp lệ</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="dob" class="form-label">Ngày sinh</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-calendar"></i>
                            </span>
                            <input type="date" class="form-control" id="dob">
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="button" id="btn-send-otp" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Gửi mã xác nhận
                        </button>
                        <p class="text-center mt-3 mb-0">
                            Đã có tài khoản? 
                            <a href="{{ url('/login') }}" class="text-decoration-none">
                                <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                            </a>
                        </p>
                    </div>
                </div>

                <!-- OTP Verification Section -->
                <div id="otp-section">
                    <h2 class="text-center mb-4">Xác nhận tài khoản</h2>
                    
                    <div class="otp-info">
                        <i class="fas fa-envelope me-2"></i>
                        Đã gửi mã xác nhận đến email:
                        <strong id="email-display" class="d-block mt-1"></strong>
                    </div>

                    <div class="mb-4">
                        <label for="otp" class="form-label">Mã xác nhận</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-key"></i>
                            </span>
                            <input type="text" class="form-control" id="otp" 
                                   placeholder="Nhập mã 6 chữ số" 
                                   maxlength="6" 
                                   inputmode="numeric" 
                                   pattern="[0-9]{6}"
                                   required>
                            <div class="invalid-feedback">Mã xác nhận phải có 6 chữ số</div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" id="btn-create-account" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Tạo tài khoản
                        </button>
                        <button type="button" id="btn-back" class="btn btn-outline-secondary">
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
            <p class="mb-0">&copy; 2025 Khách sạn ABC. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const API_URL = "{{ url('/api') }}";
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.addEventListener("DOMContentLoaded", () => {
            const registrationForm = document.getElementById("registration-form");
            const registerSection = document.getElementById("register-section");
            const otpSection = document.getElementById("otp-section");
            const btnSendOtp = document.getElementById("btn-send-otp");
            const btnCreateAccount = document.getElementById("btn-create-account");
            const btnBack = document.getElementById("btn-back");
            const formElements = {
                hoten: document.getElementById("hoten"),
                email: document.getElementById("email"),
                password: document.getElementById("password"),
                phone: document.getElementById("phone"),
                dob: document.getElementById("dob"),
                otp: document.getElementById("otp"),
                emailDisplay: document.getElementById("email-display")
            };

            const alerts = {
                error: document.getElementById("error-alert"),
                success: document.getElementById("success-alert"),
                errorMessage: document.getElementById("error-message"),
                successMessage: document.getElementById("success-message")
            };

            function showMessage(message, type = 'error') {
                if (type === 'error') {
                    alerts.errorMessage.textContent = message;
                    alerts.error.style.display = 'block';
                    alerts.success.style.display = 'none';
                } else {
                    alerts.successMessage.textContent = message;
                    alerts.success.style.display = 'block';
                    alerts.error.style.display = 'none';
                }
            }

            function clearMessages() {
                alerts.error.style.display = 'none';
                alerts.success.style.display = 'none';
            }

            window.togglePassword = function(inputId) {
                const input = document.getElementById(inputId);
                const button = input.nextElementSibling;
                const icon = button.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            };

            btnSendOtp.addEventListener('click', async () => {
                if (!registrationForm.checkValidity()) {
                    registrationForm.classList.add('was-validated');
                    return;
                }

                clearMessages();
                const data = {
                    HoTen: formElements.hoten.value.trim(),
                    Email: formElements.email.value.trim(),
                    MatKhau: formElements.password.value.trim(),
                    SoDienThoai: formElements.phone.value.trim(),
                    NgaySinh: formElements.dob.value.trim()
                };

                btnSendOtp.classList.add('loading');
                btnSendOtp.disabled = true;

                try {
                    const response = await fetch(`${API_URL}/register`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": CSRF_TOKEN
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();
                    if (!response.ok) throw new Error(result.message || `Lỗi ${response.status}`);

                    showMessage("Mã xác nhận đã được gửi đến email của bạn", "success");
                    registerSection.style.display = "none";
                    otpSection.style.display = "block";
                    formElements.emailDisplay.innerText = data.Email;
                    formElements.otp.focus();
                } catch (error) {
                    console.error("Lỗi khi gửi OTP:", error);
                    showMessage(error.message || "Đã có lỗi xảy ra. Vui lòng thử lại.");
                } finally {
                    btnSendOtp.classList.remove('loading');
                    btnSendOtp.disabled = false;
                }
            });

            btnBack.addEventListener('click', () => {
                clearMessages();
                otpSection.style.display = "none";
                registerSection.style.display = "block";
            });

            registrationForm.addEventListener('submit', async (event) => {
                event.preventDefault();
                if (!registrationForm.checkValidity()) {
                    event.stopPropagation();
                    registrationForm.classList.add('was-validated');
                    return;
                }

                clearMessages();
                const Email = formElements.email.value.trim();
                const Otp = formElements.otp.value.trim();

                btnCreateAccount.classList.add('loading');
                btnCreateAccount.disabled = true;

                try {
                    const response = await fetch(`${API_URL}/verify-otp`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": CSRF_TOKEN
                        },
                        body: JSON.stringify({ Email, Otp })
                    });

                    const result = await response.json();
                    if (!response.ok) throw new Error(result.message || `Lỗi ${response.status}`);

                    showMessage("Đăng ký thành công!", "success");
                    setTimeout(() => {
                        window.location.href = "{{ url('/login') }}";
                    }, 2000);
                } catch (error) {
                    console.error("Lỗi khi xác thực OTP:", error);
                    showMessage(error.message || "Lỗi xác thực. Vui lòng thử lại.");
                    btnCreateAccount.disabled = false;
                } finally {
                    btnCreateAccount.classList.remove('loading');
                }
            });
        });
    </script>
</body>
</html>
