<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Xác nhận tài khoản - Khách sạn ABC</title>
    
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
        .verify-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .verify-card {
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
        .info-box {
            background: #e9ecef;
            border-left: 4px solid #007bff;
            padding: 1rem;
            margin-bottom: 1.5rem;
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
    <div class="verify-container">
        <div class="verify-card">
            <h2 class="text-center mb-4">
                <i class="fas fa-user-check me-2"></i>
                Xác nhận tài khoản
            </h2>

            <div class="info-box">
                <i class="fas fa-info-circle me-2"></i>
                Vui lòng nhập email và mã xác nhận đã được gửi đến email của bạn
            </div>

            <!-- Alert Messages -->
            <div class="alert alert-danger" role="alert" id="error-alert" style="display: none">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span id="error-message"></span>
            </div>
            
            <div class="alert alert-success" role="alert" id="success-alert" style="display: none">
                <i class="fas fa-check-circle me-2"></i>
                <span id="success-message"></span>
            </div>

            <!-- Verification Form -->
            <form id="verify-form" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control" id="email" 
                               placeholder="Nhập email của bạn" required>
                        <div class="invalid-feedback">Vui lòng nhập email hợp lệ</div>
                    </div>
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
                    <button type="submit" class="btn btn-primary" id="btn-verify">
                        <i class="fas fa-check me-2"></i>Xác nhận
                    </button>
                    <a href="{{ url('/login') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại đăng nhập
                    </a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const verifyForm = document.getElementById('verify-form');
            const btnVerify = document.getElementById('btn-verify');
            const errorAlert = document.getElementById('error-alert');
            const successAlert = document.getElementById('success-alert');
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');

            function showMessage(message, type = 'error') {
                if (type === 'error') {
                    errorMessage.textContent = message;
                    errorAlert.style.display = 'block';
                    successAlert.style.display = 'none';
                } else {
                    successMessage.textContent = message;
                    successAlert.style.display = 'block';
                    errorAlert.style.display = 'none';
                }
            }

            verifyForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                if (!verifyForm.checkValidity()) {
                    e.stopPropagation();
                    verifyForm.classList.add('was-validated');
                    return;
                }

                const data = {
                    Email: document.getElementById('email').value.trim(),
                    Otp: document.getElementById('otp').value.trim()
                };

                btnVerify.classList.add('loading');
                btnVerify.disabled = true;

                try {
                    const response = await fetch("{{ url('/api/verify-otp') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();
                    
                    if (response.ok) {
                        showMessage(result.message || 'Xác nhận thành công!', 'success');
                        setTimeout(() => {
                            window.location.href = "{{ url('/login') }}";
                        }, 2000);
                    } else {
                        showMessage(result.message || 'Xác nhận thất bại. Vui lòng thử lại.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showMessage('Không thể kết nối tới máy chủ. Vui lòng thử lại sau.');
                } finally {
                    btnVerify.classList.remove('loading');
                    btnVerify.disabled = false;
                }
            });
        });
    </script>
</body>
</html>
