<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng nhập - Khách sạn ABC</title>
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
        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .login-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
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
    </style>
</head>

  <body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-hotel me-2"></i>
                Khách sạn            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="login-container">
        <div class="login-card">
            <h2 class="text-center mb-4">Đăng nhập hệ thống</h2>

            <!-- Alert Messages -->
            <div class="alert alert-danger" role="alert" id="error-alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span id="error-message"></span>
            </div>

            <div class="alert alert-success" role="alert" id="success-alert">
                <i class="fas fa-check-circle me-2"></i>
                <span id="success-message"></span>
            </div>

            <!-- Login Form -->
            <form id="login-form" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control" id="email" placeholder="Nhập email của bạn" required>
                    </div>
                    <div class="invalid-feedback">Vui lòng nhập email hợp lệ</div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="invalid-feedback">Vui lòng nhập mật khẩu</div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit" id="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                    </button>
                    <button class="btn btn-secondary" type="button" id="btn-forgot" data-bs-toggle="modal" data-bs-target="#forgot-modal">
                        <i class="fas fa-key me-2"></i>Quên mật khẩu
                    </button>
                </div>

                <div class="text-center mt-3">
                    <p class="mb-0">
                        Chưa có tài khoản?
                        <a href="{{ url('/register') }}" class="text-decoration-none">
                            <i class="fas fa-user-plus me-1"></i>Đăng ký ngay
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgot-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-key me-2"></i>Quên mật khẩu
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="forgot-step-1">
                        <p>Nhập email để nhận mã đặt lại mật khẩu</p>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" id="fp-email" class="form-control" placeholder="Email">
                        </div>
                        <div class="alert alert-danger" role="alert" id="fp-error" style="display: none"></div>
                        <div class="alert alert-success" role="alert" id="fp-success" style="display: none"></div>
                    </div>
                    <div id="forgot-step-2" style="display: none">
                        <p>Nhập mã xác nhận và mật khẩu mới</p>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="fas fa-key"></i>
                            </span>
                            <input type="text" id="fp-token" class="form-control" placeholder="Mã xác nhận">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="fp-new" class="form-control" placeholder="Mật khẩu mới">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('fp-new')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="fp-submit">Gửi mã</button>
                </div>
            </div>
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
        const API_URL = "{{ env('API_URL', 'http://127.0.0.1:8000/api') }}";
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('login-form');
            const btnLogin = document.getElementById('btn-login');
            const errorAlert = document.getElementById('error-alert');
            const successAlert = document.getElementById('success-alert');
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');
            const forgotModal = new bootstrap.Modal(document.getElementById('forgot-modal'));

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

            // Form validation
            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                clearAlerts();

                if (!loginForm.checkValidity()) {
                    e.stopPropagation();
                    loginForm.classList.add('was-validated');
                    return;
                }

                const Email = document.getElementById('email').value.trim();
                const MatKhau = document.getElementById('password').value.trim();

                // Disable the form while processing
                const allInputs = loginForm.querySelectorAll('input, button');
                allInputs.forEach(el => el.disabled = true);
                btnLogin.classList.add('loading');

                try {
                    const res = await fetch(`${API_URL}/login`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        credentials: 'include', // Include cookies
                        body: JSON.stringify({ Email, MatKhau })
                    });

                    const data = await res.json();

                    if (!res.ok) {
                        throw new Error(data.message || 'Sai thông tin đăng nhập!');
                    }

                    // Store user data
                    const roleNum = Number(data.role);
                    if (roleNum !== 1 && roleNum !== 2) {
                        throw new Error('Vai trò không hợp lệ!');
                    }

                    localStorage.setItem('userName', data.hoTen);
                    localStorage.setItem('role', roleNum);
                    localStorage.setItem('email', Email);
                    localStorage.setItem('userId', data.user_id);

                    // Determine redirect URL
                    let redirectUrl;
                    const saved = localStorage.getItem('redirect_after_login');

                    if (saved && (saved.startsWith('/') || saved.startsWith(window.location.origin))) {
                        redirectUrl = saved.startsWith('/') ? window.location.origin + saved : saved;
                        localStorage.removeItem('redirect_after_login');
                    } else {
                        redirectUrl = roleNum === 2
                            ? "{{ url('/admin') }}" // Nhân viên -> trang xác nhận đặt phòng
                            : "{{ route('taikhoan', [], false) }}?email=" + encodeURIComponent(Email); // Khách hàng -> trang tài khoản
                    }

                    // Perform redirect
                    console.log('Redirecting to:', redirectUrl);
                    window.location.replace(redirectUrl);

                } catch (err) {
                    console.error('Login error:', err);
                    showError(err.message || 'Không thể kết nối tới máy chủ!');

                    // Re-enable the form on error
                    allInputs.forEach(el => el.disabled = false);
                    btnLogin.classList.remove('loading');
                }
            });

            // Forgot password flow
            const fpSubmitBtn = document.getElementById('fp-submit');
            let resetEmail = '';

            document.getElementById('btn-forgot').addEventListener('click', function() {
                resetEmail = document.getElementById('email').value.trim();
                document.getElementById('fp-email').value = resetEmail;
                document.getElementById('forgot-step-1').style.display = 'block';
                document.getElementById('forgot-step-2').style.display = 'none';
                fpSubmitBtn.textContent = 'Gửi mã';
                document.getElementById('fp-error').style.display = 'none';
                document.getElementById('fp-success').style.display = 'none';
            });

            fpSubmitBtn.addEventListener('click', async function() {
                const isStep1 = document.getElementById('forgot-step-1').style.display !== 'none';

                if (isStep1) {
                    // Send OTP
                    resetEmail = document.getElementById('fp-email').value.trim();
                    fpSubmitBtn.classList.add('loading');
                    fpSubmitBtn.disabled = true;

                    try {
                        const res = await fetch(`${API_URL}/forgot-password`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN
                            },
                            body: JSON.stringify({ Email: resetEmail })
                        });

                        const data = await res.json();

                        if (res.ok) {
                            document.getElementById('fp-success').textContent = 'Mã xác nhận đã được gửi đến email của bạn';
                            document.getElementById('fp-success').style.display = 'block';
                            document.getElementById('forgot-step-1').style.display = 'none';
                            document.getElementById('forgot-step-2').style.display = 'block';
                            fpSubmitBtn.textContent = 'Đặt lại mật khẩu';
                        } else {
                            document.getElementById('fp-error').textContent = data.message || 'Có lỗi xảy ra';
                            document.getElementById('fp-error').style.display = 'block';
                        }
                    } catch (err) {
                        document.getElementById('fp-error').textContent = 'Không thể kết nối tới máy chủ';
                        document.getElementById('fp-error').style.display = 'block';
                    } finally {
                        fpSubmitBtn.classList.remove('loading');
                        fpSubmitBtn.disabled = false;
                    }
                } else {
                    // Reset password
                    const token = document.getElementById('fp-token').value.trim();
                    const pass = document.getElementById('fp-new').value.trim();

                    if (!token || !pass) {
                        document.getElementById('fp-error').textContent = 'Vui lòng nhập đầy đủ thông tin';
                        document.getElementById('fp-error').style.display = 'block';
                        return;
                    }

                    fpSubmitBtn.classList.add('loading');
                    fpSubmitBtn.disabled = true;

                    try {
                        const res = await fetch(`${API_URL}/reset-password`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN
                            },
                            body: JSON.stringify({
                                Email: resetEmail,
                                Token: token,
                                MatKhauMoi: pass
                            })
                        });

                        const data = await res.json();

                        if (res.ok) {
                            showSuccess('Đặt lại mật khẩu thành công. Vui lòng đăng nhập bằng mật khẩu mới.');
                            forgotModal.hide();
                        } else {
                            document.getElementById('fp-error').textContent = data.message || 'Có lỗi xảy ra';
                            document.getElementById('fp-error').style.display = 'block';
                        }
                    } catch (err) {
                        document.getElementById('fp-error').textContent = 'Không thể kết nối tới máy chủ';
                        document.getElementById('fp-error').style.display = 'block';
                    } finally {
                        fpSubmitBtn.classList.remove('loading');
                        fpSubmitBtn.disabled = false;
                    }
                }
            });

            // Toggle password visibility in forgot password modal
            window.togglePassword = function(inputId) {
                const input = document.getElementById(inputId);
                const icon = input.nextElementSibling.querySelector('i');
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
        });
    </script>
  </body>
</html>
