document.addEventListener("DOMContentLoaded", () => {
  const formTitle = document.getElementById("form-title");
  const username = document.getElementById("username");
  const password = document.getElementById("password");
  const email = document.getElementById("email");
  const submitBtn = document.getElementById("submit-btn");
  const toggleForm = document.getElementById("toggle-form");
  const message = document.getElementById("message");

  let isLogin = true;

  toggleForm.addEventListener("click", () => {
    isLogin = !isLogin;
    formTitle.textContent = isLogin ? "Đăng nhập" : "Đăng ký";
    submitBtn.textContent = isLogin ? "Đăng nhập" : "Đăng ký";
    email.style.display = isLogin ? "none" : "block";
    toggleForm.innerHTML = isLogin
      ? "Chưa có tài khoản? <a href='#'>Đăng ký</a>"
      : "Đã có tài khoản? <a href='#'>Đăng nhập</a>";
  });

  submitBtn.addEventListener("click", async () => {
    const url = isLogin
      ? "http://localhost:888/trangwebtutien/backend/api/login.php"
      : "http://localhost:888/trangwebtutien/backend/api/register.php";
    const data = {
      username: username.value,
      password: password.value,
      email: isLogin ? "" : email.value,
    };

    const response = await fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });

    const result = await response.json();
    message.textContent = result.message;

    if (result.success && isLogin) {
      alert("Chào mừng, " + result.user);
    }
  });
});
