export function initRegister() {
  const form = document.getElementById("register-form");
  if (!form) return;

  // Lấy mã CAPTCHA khi trang tải
  fetch("/trangwebtutien/admin/veryfi_capcha.php")
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("captcha-display").textContent = data.captcha;
    });

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const full_name = document.getElementById("full_name").value.trim();
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const password = document.getElementById("password").value.trim();
    const confirm_password = document
      .getElementById("confirm_password")
      .value.trim();
    const captcha = document.getElementById("captcha").value.trim();
    const terms = document.querySelector('input[name="terms"]').checked
      ? "agree"
      : "";

    const errors = {
      full_name: document.getElementById("full_name-error"),
      username: document.getElementById("username-error"),
      email: document.getElementById("email-error"),
      phone: document.getElementById("phone-error"),
      password: document.getElementById("password-error"),
      confirm_password: document.getElementById("confirm_password-error"),
      captcha: document.getElementById("captcha-error"),
      terms: document.getElementById("terms-error"),
    };

    Object.values(errors).forEach((err) => (err.textContent = ""));

    fetch("/trangwebtutien/backend/api/register.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        full_name,
        username,
        email,
        phone,
        password,
        confirm_password,
        captcha,
        terms,
      }),
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
