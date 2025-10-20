<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng nhập</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background: #f8f9fa;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }
      .container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 350px;
      }
      input,
      button {
        width: 100%;
        margin: 8px 0;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
      }
      button {
        background: #007bff;
        color: white;
        border: none;
        cursor: pointer;
      }
      button:hover {
        background: #0056b3;
      }
      #message {
        color: red;
        text-align: center;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <h2>Đăng nhập hệ thống</h2>
      <input id="email" type="email" placeholder="Email" />
      <input id="password" type="password" placeholder="Mật khẩu" />
      <button type="button" onclick="login()">Đăng nhập</button>
      <p style="text-align: center; margin-top: 10px">
        Chưa có tài khoản?
        <a href="<?php echo e(url('/register')); ?>">Đăng ký ngay</a>
      </p>

      <p id="message"></p>
    </div>

    <script>
      const API_URL = "<?php echo e(env('API_URL', 'http://127.0.0.1:8000/api')); ?>";

      async function login() {
        const Email = document.getElementById("email").value.trim();
        const MatKhau = document.getElementById("password").value.trim();
        const msg = document.getElementById("message");

        if (!Email || !MatKhau) {
          msg.innerText = "Vui lòng nhập đầy đủ thông tin!";
          return;
        }

        try {
          const res = await fetch(`${API_URL}/login`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ Email, MatKhau }),
          });

          const data = await res.json();
          console.log("API Response:", data); // Debug: Kiểm tra response
          msg.innerText = data.message || "";

          if (res.ok) {
            // Normalize role to a number in case API returns a string
            const roleNum = Number(data.role);
            localStorage.setItem("userName", data.hoTen);
            localStorage.setItem("role", roleNum);
            localStorage.setItem("email", Email);
            localStorage.setItem("userId", data.user_id);

            console.log("Role (raw):", data.role, "-> normalized:", roleNum); // Debug: Kiểm tra role
            // If a redirect_after_login was set (e.g. booking page saved it), honor it and navigate there.
            const saved = localStorage.getItem('redirect_after_login');
            if (saved) {
              try {
                // Only allow same-origin or root-relative redirects for safety
                const origin = window.location.origin;
                let target = saved;
                if (target.indexOf(origin) === 0) {
                  // full origin provided
                } else if (target.startsWith('/')) {
                  target = origin + target;
                } else {
                  // not safe or unknown format — ignore and fallback to role handling
                  throw new Error('unsafe redirect');
                }
                // Clean up and redirect
                localStorage.removeItem('redirect_after_login');
                window.location.href = target;
                return;
              } catch (e) {
                console.warn('Ignored saved redirect_after_login:', saved, e);
                localStorage.removeItem('redirect_after_login');
              }
            }

            // Fallback behavior: role-based redirects (use normalized number)
            if (roleNum === 2) {
              console.log("Redirecting to /tiennghi");
              window.location.href = "<?php echo e(url('/tiennghi')); ?>"; // Nhân viên
            } else if (roleNum === 1) {
              console.log("Redirecting to /taikhoan");
              // Use relative route path to avoid embedding host/port in the generated URL
              window.location.href = "<?php echo e(route('taikhoan', [], false)); ?>?email=" + encodeURIComponent(Email); // Khách hàng
            } else {
              msg.innerText = "Vai trò không hợp lệ!";
              console.log("Invalid role:", data.role);
            }
          } else {
            msg.innerText = data.message || "Sai thông tin đăng nhập!";
          }
        } catch (err) {
          console.error("Error:", err);
          msg.innerText = "Không thể kết nối tới máy chủ!";
        }
      }
    </script>
  </body>
</html><?php /**PATH I:\Ky_06_2025_2026\php\New folder\Hotel_System\service\resources\views/login_auth/login.blade.php ENDPATH**/ ?>