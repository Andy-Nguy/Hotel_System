<h2>Xác nhận mã OTP</h2>
<input id="email" placeholder="Email" />
<input id="otp" placeholder="Mã OTP" />
<button onclick="verify()">Xác nhận</button>

<script>
  function verify() {
    const data = {
      Email: document.getElementById("email").value,
      Otp: document.getElementById("otp").value,
    };

    fetch("http://127.0.0.1:8000/api/verify-otp", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    })
      .then((res) => res.json())
      .then((d) => alert(d.message));
  }
</script>
