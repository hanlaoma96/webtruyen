export function initLogin() {
  const form = document.getElementById("login-form");
  if (!form) return;

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();
    const captcha = document.getElementById("captcha").value.trim();

    const errors = {
      username: document.getElementById("username-error"),
      password: document.getElementById("password-error"),
      captcha: document.getElementById("captcha-error"),
    };

    Object.values(errors).forEach((err) => (err.textContent = ""));

    fetch("/trangwebtutien/backend/api/login.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ username, password, captcha }),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          alert(data.message);
          setTimeout(() => (window.location.href = data.redirect), 2000);
        } else if (data.errors) {
          Object.entries(data.errors).forEach(([key, value]) => {
            if (errors[key]) errors[key].textContent = value;
          });
        } else {
          alert(data.error || "Đã xảy ra lỗi");
        }

        // Lấy mã CAPTCHA mới sau mỗi lần gửi
        fetch("/trangwebtutien/admin/veryfi_capcha.php")
          .then((res) => res.json())
          .then((data) => {
            document.getElementById("captcha-display").textContent =
              data.captcha;
            document.getElementById("captcha").value = "";
          });
      })
      .catch(() => alert("Lỗi kết nối server"));
  });
}
