document.addEventListener("DOMContentLoaded", function () {
  // Xử lý đăng ký
  const registerForm = document.getElementById("register-form");
  if (registerForm) {
    registerForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const username = document.getElementById("username").value;
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;
      const confirmPassword = document.getElementById("confirm-password").value;

      if (password !== confirmPassword) {
        alert("Mật khẩu không khớp!");
        return;
      }

      alert("Đăng ký thành công!");
      window.location.href = "dangnhap.html";
    });
  }

  // Xử lý đăng nhập
  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const username = document.getElementById("login-username").value;
      const password = document.getElementById("login-password").value;

      alert("Đăng nhập thành công!");
      window.location.href = "index.html";
    });
  }
});
