<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Thêm CSRF Token để bảo mật các yêu cầu API -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng ký tài khoản</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            box-sizing: border-box;
        }
        h2 {
            text-align: center;
            color: #1c1e21;
            margin-bottom: 1.5rem;
        }
        .input-group {
            margin-bottom: 1rem;
        }
        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #dddfe2;
            box-sizing: border-box;
            font-size: 16px;
        }
        input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }
        button {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            background: #007bff;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        button:hover {
            background: #0056b3;
        }
        button:disabled {
            background: #6c757d;
            cursor: not-allowed;
            opacity: 0.7;
        }
        #otp-section {
            display: none;
        }
        #message {
            text-align: center;
            margin-top: 1rem;
            min-height: 20px;
            font-weight: 500;
        }
        .message-success { color: #28a745; }
        .message-error { color: #dc3545; }
        .message-loading { color: #007bff; }
        .email-info {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin: 1rem 0;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Form vẫn giữ nguyên, không cần action vì được xử lý bằng JS -->
        <form id="registration-form" onsubmit="return false;">
            <div id="register-section">
                <h2>Đăng ký tài khoản</h2>
                <div class="input-group">
                    <input id="hoten" type="text" placeholder="Họ và tên" required />
                </div>
                <div class="input-group">
                    <input id="email" type="email" placeholder="Email" required />
                </div>
                <div class="input-group">
                    <input id="password" type="password" placeholder="Mật khẩu (tối thiểu 6 ký tự)" required />
                </div>
                <div class="input-group">
                    <input id="phone" type="tel" placeholder="Số điện thoại (không bắt buộc)" />
                </div>
                <div class="input-group">
                    <input id="dob" type="text" placeholder="Ngày sinh (không bắt buộc)" onfocus="(this.type='date')" onblur="(this.type='text')" />
                </div>
                <button type="button" id="btn-send-otp" onclick="return false;">Gửi mã xác nhận</button>
            </div>

            <div id="otp-section">
                <h2>Xác nhận tài khoản</h2>
                <p class="email-info">
                    Đã gửi mã đến email: <strong id="email-display"></strong>
                </p>
                <div class="input-group">
                    <input id="otp" type="text" placeholder="Nhập mã OTP 6 chữ số" maxlength="6" inputmode="numeric" />
                </div>
                <button type="submit" id="btn-create-account">Tạo tài khoản</button>
            </div>
        </form>

        <p id="message"></p>
    </div>

    <script>
        // Thay đổi 1: Lấy URL API động từ Laravel để dễ dàng thay đổi môi trường
        const API_URL = "{{ url('/api') }}";
        // Lấy CSRF token từ thẻ meta
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.addEventListener("DOMContentLoaded", () => {
            console.log(" phiên bản JS mới nhất đã được tải!");
            const registrationForm = document.getElementById("registration-form");
            const registerSection = document.getElementById("register-section");
            const otpSection = document.getElementById("otp-section");
            const btnSendOtp = document.getElementById("btn-send-otp");
            const btnCreateAccount = document.getElementById("btn-create-account");
            const hotenInput = document.getElementById("hoten");
            const emailInput = document.getElementById("email");
            const passwordInput = document.getElementById("password");
            const phoneInput = document.getElementById("phone");
            const dobInput = document.getElementById("dob");
            const otpInput = document.getElementById("otp");
            const messageEl = document.getElementById("message");
            const emailDisplay = document.getElementById("email-display");

            function showMessage(text, type = 'error') {
                messageEl.innerText = text;
                messageEl.className = `message-${type}`;
            }
            
            btnSendOtp.addEventListener('click', async (event) => {
                event.preventDefault();
                event.stopPropagation();
                console.log("Sự kiện click từ addEventListener đã chạy.");
                
                const data = { HoTen: hotenInput.value.trim(), Email: emailInput.value.trim(), MatKhau: passwordInput.value.trim(), SoDienThoai: phoneInput.value.trim(), NgaySinh: dobInput.value.trim() };

                if (!data.HoTen || !data.Email || !data.MatKhau) {
                    showMessage("Vui lòng điền đầy đủ họ tên, email và mật khẩu.");
                    return;
                }
                if (data.MatKhau.length < 6) {
                    showMessage("Mật khẩu phải có ít nhất 6 ký tự.");
                    return;
                }

                btnSendOtp.disabled = true;
                showMessage("Đang gửi yêu cầu...", "loading");

                try {
                    const response = await fetch(`${API_URL}/register`, { 
                        method: "POST", 
                        headers: { 
                            "Content-Type": "application/json", 
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": CSRF_TOKEN // Thay đổi 2: Gửi kèm CSRF Token
                        }, 
                        body: JSON.stringify(data),
                        // credentials: 'include' // Không cần nữa vì đã có CSRF Token
                    });
                    
                    const result = await response.json();
                    if (!response.ok) throw new Error(result.message || `Lỗi ${response.status}`);
                    
                    showMessage("Mã OTP đã được gửi. Vui lòng kiểm tra email!", "success");
                    registerSection.style.display = "none";
                    otpSection.style.display = "block";
                    emailDisplay.innerText = data.Email;
                    otpInput.focus();
                } catch (error) {
                    console.error("Lỗi khi gửi OTP:", error);
                    showMessage(error.message || "Đã có lỗi xảy ra. Vui lòng thử lại.");
                } finally {
                    btnSendOtp.disabled = false;
                }
            });

            registrationForm.addEventListener('submit', async (event) => {
                event.preventDefault();
                console.log("Form đã được submit và reload đã bị chặn.");
                const Email = emailInput.value.trim();
                const Otp = otpInput.value.trim();

                if (Otp.length !== 6) {
                    showMessage("Mã OTP phải có đúng 6 chữ số.");
                    return;
                }
                
                btnCreateAccount.disabled = true;
                showMessage("Đang xác thực và tạo tài khoản...", "loading");

                try {
                    const response = await fetch(`${API_URL}/verify-otp`, { 
                        method: "POST", 
                        headers: { 
                            "Content-Type": "application/json", 
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": CSRF_TOKEN // Thay đổi 2: Gửi kèm CSRF Token
                        }, 
                        body: JSON.stringify({ Email, Otp }),
                        // credentials: 'include'
                    });
                    const result = await response.json();
                    if (!response.ok) throw new Error(result.message || `Lỗi ${response.status}`);
                    
                    showMessage(result.message, "success");
                    setTimeout(() => {
                        alert("Đăng ký thành công! Đang chuyển đến trang đăng nhập.");
                        window.location.href = "{{ url('/login') }}"; // Thay đổi 3: Dùng helper url
                    }, 2000);
                } catch (error) {
                    console.error("Lỗi khi xác thực OTP:", error);
                    showMessage(error.message || "Lỗi xác thực. Vui lòng thử lại.");
                    btnCreateAccount.disabled = false;
                }
            });
        });
    </script>
</body>
</html>
